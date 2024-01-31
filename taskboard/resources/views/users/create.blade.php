{{-- resources/views/users/create.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('users.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>ユーザー登録</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{  route('users.store') }}">
            @csrf
            <!--名前入力フォーム-->
            @include('form.name', ['value'=>''])
            
            <!--メールアドレス入力フォーム-->
            @include('form.email', ['value'=>''])
            
            <!--ユーザータイプ選択フォーム-->
            @include('form.select', ['datas'=>$userTypes,'label'=>'ユーザータイプ','name'=>'userType'])
            
            <!--利用タスクボード選択フォーム-->
            @include('form.checkbox', ['name'=>'taskboardUsers', 'datas'=>$taskboards, 'label'=>'利用するタスクボード', 'selected'=>[]])

            <!--登録ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="登録" />
            </div>
          </form>
        </div>
      </div>
@endsection
