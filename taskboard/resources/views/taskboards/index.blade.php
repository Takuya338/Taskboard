{{-- resources/views/taskboards/index.blade.php --}}
@extends('base.baseTemplete')
@section('content')

      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4"><h2>タスクボード一覧</h2></div>

        <!--新規タスクボード作成ボタン-->
        <div class="col-xl-4">
          <a href="{{ route('taskboards.create') }}"
            ><input
              type="button"
              class="btn btn-success"
              value="タスクボード新規作成"
          /></a>
        </div>

        <!--タスクボード検索フォーム-->
        @include('form.search', ["placeholder" => "タスクボード名または日付"])
        
      </div>

      <!--タスクボード-->
      <div class="row">
        
        @foreach($taskboards as $taskboard)
        <div class="col-md-2 p-3 taskboardlist">
          <a href="{{ route('board', $taskboard[0]) }}">
            <div class="card">
              <div class="card-body">
                <div class="text-center"><h4>{{ $taskboard[1] }}</h4></div>
              </div>
              <div class="card-footer">
                <small>更新日:{{ arrangeDate($taskboard[3]) }}</small><br />
                <small>更新者:{{ $taskboard[2] }}</small>
              </div>
            </div>
          </a>
        </div>
        @endforeach

      </div>
@endsection