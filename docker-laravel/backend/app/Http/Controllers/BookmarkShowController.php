<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bookmark;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//登録したbookmarkコメントを出力する
class BookmarkShowController extends Controller {

  public function pickUpComments() {
    $showCommnts = [];
    $siteId = 20;
    // $comments = DB::table("bookmarks")->pluck("comment");
    $comments = DB::table("bookmarks")->where("site_id", $siteId)->pluck("comment");
    foreach ($comments as $comment) {
      if(empty($comment)) {
        continue;
      }
      $showCommnts[] = $comment;
    }
    //var_dump($showCommnts);
    return $showCommnts;
  }

  public function show() {
    try {
    $comments = $this->pickUpComments();
    return view("show_comments")->with("comments", $comments);
    } catch(\Exception $e) {
      return view("show_comments",[
        "result" => $e
      ]);
    }
  }
}