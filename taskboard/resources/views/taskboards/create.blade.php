{{-- resources/views/taskboards/create.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスクボード新規作成</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>タスクボード新規作成</h1>
    <form action="{{ route('taskboards.store') }}" method="post">
        @csrf
        <div>
            <label for="name">タスクボード名</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label>利用者選択</label>
            <select name="users[]" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->userId }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">作成</button>
    </form>
</body>
</html>
