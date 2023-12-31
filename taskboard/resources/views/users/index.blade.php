{{-- resources/views/users/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー一覧</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>ユーザー一覧</h1>
    <a href="{{ route('users.create') }}">新規作成</a>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} 
                <a href="{{ route('users.edit', $user->id) }}">編集</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
