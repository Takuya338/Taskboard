{{-- resources/views/password/change.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('taskboards.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>パスワード変更</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{  route('password.update') }}">
            @csrf
            <!--新パスワード入力-->
            @include('form.password', ['name'=>'password', 'label'=>'パスワード', 'placeholder'=>'新しいパスワード'])
            
            <!--新パスワード入力確認-->
            @include('form.password', ['name'=>'password2', 'label'=>'パスワード(再入力)', 'placeholder'=>'新しいパスワード'])

            <!--登録ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="更新" />
            </div>
            
          </form>
        </div>
      </div>
@endsection