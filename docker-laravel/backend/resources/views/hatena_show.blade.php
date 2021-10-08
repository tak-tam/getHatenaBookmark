<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bookmarkを取得するフォーム</title>
  </head>
  <body>
    <h1>Bookmarkを取得する</h1>
    <form action="/hatena-show" method="POST">
      url:<br>
      @csrf
      <input type="text" name="url"><br>
      <input type="submit" name="submit" value="送信">
    </form>
  </body>
</html>