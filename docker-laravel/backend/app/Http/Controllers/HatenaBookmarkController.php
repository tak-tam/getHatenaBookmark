<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Carbon\Carbon;
use App\Models\Site;
use Illuminate\Http\Request;
use Prophecy\Call\Call;
use Illuminate\Support\Facades\DB;

class HatenaBookmarkController extends Controller
{
  public function index() {
    return view("hatena_show");
  }
  const HATENA_API_URL = "https://b.hatena.ne.jp/entry/json/";  //json形式でデータを取得
  private function getCURL($url2)
  {
    $url = self::HATENA_API_URL . $url2;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response; //取得したjsonデータStringを返す
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
    try{
      $url2 = $request->input('url');
      //$url2 = "http://www.hatena.ne.jp/";
      $bookmarkExistsCheck = DB::table("sites")->where("url", $url2)->exists();
      if($bookmarkExistsCheck) {
        return view("result_success", [
          "result" => "取得済みです"
        ]);
      }
      $response = $this->getCURL($url2);
      $response2 = json_decode($response, true);  //json形式のデータを連想配列形式で返す（trueだから)
      // site:url,title
      // bookmark: comment, user_name
      //titleパラメータがnullの場合がある(配列にnullでアクセスしようとする)とエラー
      $site = new Site();
      $site->url = $url2;
      $site->title = $response2['title'];
      $site->save();

      $bookmarks = $response2["bookmarks"];
      $params = [];
      $now = Carbon::now();
      foreach ($bookmarks as $bookmark) {
        $params[] = [
          "comment" => $bookmark['comment'],
          "user_name" => $bookmark['user'],
          "site_id" => $site->id,
          "CREATED_AT" => $now,
          "UPDATED_AT" => $now,
        ];
      }
        BOOKMARK::INSERT($params);
    }catch(\Exception $e) {
      return view("result_failure", [
        "result" => "失敗しました。".$e->getMessage()
      ]);
    }
    return view("result_success", [
      "result" => "ブックマークの取得に成功しました。",
    ]);
  }
}
