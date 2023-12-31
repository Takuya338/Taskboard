{{-- resources/views/emails/password_reset.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>パスワード再発行</title>
</head>
<body>
    <p>あなたの新しいパスワード: {{ $newPassword }}</p>
    <p>このパスワードを使用してログインしてください。</p>
</body>
</html>
