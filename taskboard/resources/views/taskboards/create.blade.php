{{-- resources/views/taskboards/create.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('taskboards.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>タスクボード新規作成</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{  route('taskboards.store') }}">
            @csrf
            <!--タスクボード名入力フォーム-->
            @include('form.text', ['name'=>'name', 'label'=>'タスクボード名', 'placeholder'=>'タスクボード名', 'value'=>''])
            
            <!--利用メンバー-->
            @include('form.checkbox', ['name'=>'list', 'datas'=>$users, 'label'=>'利用するメンバー', 'selected'=>[]])

            <!--登録ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="登録" />
            </div>
          </form>
        </div>
      </div>
@endsection
