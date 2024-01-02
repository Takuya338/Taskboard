{{-- resources/views/taskboards/edit.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスクボード編集</title>
    {{-- スタイルシート等のリンク --}}
</head>
<body>
    <h1>タスクボード編集</h1>
    <form action="{{ route('taskboards.update', $taskboard->taskboardId) }}" method="post">
        @csrf
        @method('put')
        <div>
            <label for="name">タスクボード名</label>
            <input type="text" id="name" name="name" value="{{ $taskboard->taskboardName }}" required>
        </div>
        <div>
            <label>利用者選択</label>
            <select name="users[]" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->userId }}" {{ in_array($user->userId, $userList, false) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit">更新</button>
    </form>
</body>
</html>
