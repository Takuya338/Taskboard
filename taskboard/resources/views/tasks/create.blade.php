{{-- resources/views/tasks/create.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク追加</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>タスク追加</h1>
    <form action="{{ route('tasks.store', $taskboard->id) }}" method="post">
        @csrf
        <div>
            <label for="title">タスク名</label>
            <input type="text" id="title" name="title" required>
        </div>
        {{-- 他のタスク属性をここに追加 --}}
        <button type="submit">追加</button>
    </form>
</body>
</html>
