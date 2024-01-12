{{-- resources/views/taskboards/edit.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('board', $taskboard[0])])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>タスクボード設定変更</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{  route('taskboards.update', $taskboard[0]) }}">
            @csrf
            <!--タスクボード名入力フォーム-->
            @include('form.text', ['name'=>'name', 'label'=>'タスクボード名', 'placeholder'=>'タスクボード名', 'value'=>$taskboard[1]])
            
            <!--利用メンバー-->
            @include('form.checkbox', ['name'=>'list', 'datas'=>$users, 'label'=>'利用するメンバー', 'selected'=>$userList])

            <!--更新ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="更新" />
            </div>
          </form>
        </div>
      </div>
@endsection