{{-- resources/views/auth/login.blade.php --}}
@extends('base.baseCenter')
@section('content')

			<!--タイトル-->
			<div class="form-group">			
				<label>タスクボード管理</label>
			</div>

			<form method="post" action="{{ route('login') }}">
				<!--メールアドレス入力フォーム-->
				<div class="form-group">
					<label for="email">メールアドレス</label>
					<input type="email" class="form-control" name="email" id="email" size="50" placeholder="メールアドレス">
				</div>

				<!--パスワード入力フォーム-->
				<div class="form-group">
					<label for="password">パスワード</label>
					<input type="password" class="form-control" name="password" id="password" size="50" placeholder="パスワード">
				</div>
				
				@if($errors->has('login') || $errors->has('email') || $errors->has('password'))
				    <p class="text-danger">メールアドレスとパスワードが一致していません</p>
				@endif
				
				<!--送信ボタン-->
				<div class="form-group text-right">
					<!--本番用ボタン-->
					<input type="submit" class="btn btn-primary" value="ログイン">
					<!--デモ用ボタン-->
					<!--<a href="taskboardlist.html"><input type="button" class="btn btn-primary" value="ログイン"></a>-->
				</div>
				
			</form>

@endsection
