{{-- resources/views/users/edit.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー編集</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>ユーザー編集</h1>
    <form action="{{ route('users.update', $user->userId) }}" method="post">
        @csrf
        @method('put')
        <div>
            <label for="name">名前</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div>
            <label for="password">新しいパスワード（変更する場合）</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="password_confirmation">新しいパスワード（確認）</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        <button type="submit">更新</button>
    </form>
</body>
</html>
