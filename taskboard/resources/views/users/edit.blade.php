{{-- resources/views/users/edit.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('users.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>ユーザー更新</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{  route('users.update', $userId) }}">
            @csrf
            @method('PUT')
            <!--名前入力フォーム-->
            @include('form.name', ['value'=> $name])
            
            <!--メールアドレス入力フォーム-->
            @include('form.email', ['value'=> $email])
            
            <!--ユーザータイプ選択フォーム-->
            @include('form.select', ['datas'=>$userTypes,'label'=>'ユーザータイプ','name'=>'userType','selected'=> $Type])
            
            <!--利用タスクボード選択フォーム-->
            @include('form.checkbox', ['name'=>'taskboardUsers', 'datas'=>$taskboards, 'label'=>'利用するタスクボード', 'selected'=>$taskboardUsers])

            <!--登録ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="更新" />
            </div>
          </form>
        </div>
      </div>
@endsection