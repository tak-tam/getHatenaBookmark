<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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
    $result2 = json_decode($response, true);
    $bookmarks = $result2["bookmarks"];
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
  public function show()
  {
    $url2 = "http://www.hatena.ne.jp/";
    $response = $this->getCURL($url2);
    $result = $this->ignoreEmptyComment($response);
    return view("hatena_show", [
      "result" => $result
    ]);
  }
}
