<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Site;
use Illuminate\Http\Request;

class HatenaBookmarkController extends Controller
{
  const HATENA_API_URL = "https://b.hatena.ne.jp/entry/json/";
  private function getCURL($url2)
  {
    $url = self::HATENA_API_URL . $url2;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  private function ignoreEmptyComment($response)
  {
    $bookmarks = $response["bookmarks"];
    $comments = [];
    foreach ($bookmarks as $bookmark) {
      $comment = $bookmark["comment"];
      if (empty($comment)) {
        continue;
      }
      $comments[] = $comment;
    }
    return $comments;
  }
  public function show(Request $request)
  {
    $url2 = $request->input('url');
    //$url2 = "http://www.hatena.ne.jp/";
    $response = $this->getCURL($url2);
    $response2 = json_decode($response, true);
    // site:url,title
    // bookmark: comment, user_name
    $site = new Site();
    $site->url = $url2;
    $site->title = $response2['title'];
    $site->save();

    $bookmarks = $response2["bookmarks"];
    $params = [];
    foreach ($bookmarks as $bookmark) {
      $b = new Bookmark();
      $b->comment = $bookmark['comment'];
      $b->user_name = $bookmark['user'];
      $b->site_id = $site->id;
      $params[] = $b->toArray();
    }
    try {
      Bookmark::insert($params);
    } catch (\Exception $e) {
      echo "errorです。";
    }
    return view("hatena_show", [
      "result" => []
    ]);
  }
}
