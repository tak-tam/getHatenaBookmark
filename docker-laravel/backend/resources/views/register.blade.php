<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ユーザー登録</title>
  </head>
  <body>
    <h1>ユーザー登録フォーム</h1>
    <form action="auth/register" method="POST">
      {{ csrf_field() }}
      名前<br>
      <input type="text" name="name"/><span>{{ $errors->first("name") }}</span><br>
      メールアドレス<br>
      <input type="text" name="email"/><span>{{ $errors->first("email") }}</span><br>
      パスワード<br>
      <input type="password" name="password"/><span>{{ $errors->first("password") }}</span><br>
      パスワード確認用<br>
      <input type="password" name="password_confirmation"/><span>{{ $errors->first("password_confirmation") }}</span><br>
      <button type="submit" name="send" value="send">送信</button>
    </form>
  </body>
</html>