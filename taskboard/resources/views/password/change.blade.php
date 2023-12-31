{{-- resources/views/password/change.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード変更</title>
    {{-- ここにスタイルシートのリンクを追加 --}}
</head>
<body>
    <div class="container">
        <h1>パスワード変更</h1>

        {{-- エラーメッセージの表示 --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- パスワード変更フォーム --}}
        <form action="{{ route('password.update') }}" method="post">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="current_password">現在のパスワード</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">新しいパスワード</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">新しいパスワード（確認）</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">変更</button>
        </form>
    </div>
</body>
</html>
