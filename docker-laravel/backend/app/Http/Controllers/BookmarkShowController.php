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
    $comments = DB::table("bookmarks")->pluck("comment", "site_id");
    foreach ($comments as $site_id => $comment) {
      $showCommnts[] = $comment;
      return $showCommnts;
    }
  }
}