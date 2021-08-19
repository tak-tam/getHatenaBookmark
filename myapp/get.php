<?php
define("HATENA_API_URL", "https://b.hatena.ne.jp/entry/json/");
function getCURL($url2){
  $url = HATENA_API_URL . $url2;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch); 
  curl_close($ch);
  return $response;
}

function ignoreEmptyComment($response){
  $result2 = json_decode($response, true);
  $bookmarks = $result2["bookmarks"];
  $comments = [];
  foreach($bookmarks as $bookmark){
    $comment = $bookmark["comment"];
    if(empty($comment)){
      continue;
    }
    $comments[] = $comment;
  }
  return $comments;
}

function getHatenaBookmarkComments($url2){
  $response = getCURL($url2);
  return ignoreEmptyComment($response);
}

$url2 = "http://www.hatena.ne.jp/";
var_dump(getHatenaBookmarkComments($url2));