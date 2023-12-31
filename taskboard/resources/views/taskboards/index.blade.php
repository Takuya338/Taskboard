{{-- resources/views/taskboards/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスクボード一覧</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>タスクボード一覧</h1>
    <a href="{{ route('taskboards.create') }}">新規作成</a>
    <ul>
        @foreach ($taskboards as $taskboard)
            <li>{{ $taskboard->name }} 
                <a href="{{ route('taskboards.edit', $taskboard->id) }}">編集</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
