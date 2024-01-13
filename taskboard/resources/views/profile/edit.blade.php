{{-- resources/views/profile/edit.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('taskboards.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>ログイン情報変更</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{  route('profile.update') }}">
            @csrf
            <!--名前入力-->
            @include('form.name', ['value' => $name])
            
            <!--メールアドレス入力-->
            @include('form.email', ['value'=> $email])

            <!--登録ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="更新" />
            </div>
            
          </form>
        </div>
      </div>
@endsection