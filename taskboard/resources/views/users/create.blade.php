{{-- resources/views/users/create.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー新規作成</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>ユーザー新規作成</h1>
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        <div>
            <label for="name">名前</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">パスワード（確認）</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">作成</button>
    </form>
</body>
</html>
