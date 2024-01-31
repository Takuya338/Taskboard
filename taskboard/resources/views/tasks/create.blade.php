{{-- resources/views/tasks/create.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('board', $taskboardId)])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>タスク追加</h2></div>
      </div>

      <!--登録フォーム-->
      <div class="row">
        <div class="col-xl-5">
          <form method="post" action="{{ route('tasks.store',$taskboardId) }}">
            @csrf
            <!--タスク内容入力フォーム-->
            <div class="form-group">
              <label for="content">タスク内容</label>
              <textarea
                class="task_content form-control"
                name="content"
                id="content"
                rows="5"
                cols="33"
                maxlength="800"
                placeholder="タスクの内容">
              </textarea>
            </div>

            <!--担当者選択フォーム-->
            @include('form.select', ['label'=>'タスク担当者', 'name'=>'user', 'datas'=>$users])

            <!--登録ボタン-->
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="追加">
            </div>
          </form>
        </div>
      </div>
@endsection
