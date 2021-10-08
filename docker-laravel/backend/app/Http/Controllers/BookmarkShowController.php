<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bookmark;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//登録したbookmarkコメントを出力する
class BookmarkShowController extends Controller {

  //site_idでdbからコメントを取得
  public function pickUpComments($url) {
    $siteId = DB::table("sites")->where("url", $url)->value("id");
    $comments = DB::table("bookmarks")->where("site_id", $siteId)->pluck("comment");
    $showCommnts = [];
    foreach ($comments as $comment) {
      if(empty($comment)) {
        continue;
      }
      $showCommnts[] = $comment;
    }
    //var_dump($showCommnts);
    return $showCommnts;
  }

  public function show(Request $request) {
    $url = $request->input("url");
    // $url = "http://www.hatena.ne.jp/";
    try {
    $comments = $this->pickUpComments($url);
    return view("show_comments")->with("comments", $comments);
    } catch(\Exception $e) {
      return view("show_comments",[
        "result" => $e
      ]);
    }
  }
}