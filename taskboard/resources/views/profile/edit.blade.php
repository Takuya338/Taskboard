{{-- resources/views/profile/edit.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>プロファイル編集</title>
    {{-- ここにスタイルシートのリンクを追加 --}}
</head>
<body>
    <div class="container">
        <h1>プロファイル編集</h1>

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

        {{-- プロファイル編集フォーム --}}
        <form action="{{ route('profile.update') }}" method="post">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="name">名前</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            {{-- 他のプロファイルフィールドをここに追加 --}}

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
</body>
</html>
