{{-- resources/views/taskboards/taskboard.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton', ['url'=>route('taskboards.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>{{ $taskboard[1] }}</h2></div>

        <!--タスク追加ボタン-->
        <div class="col-xl-2 p-3">
          <a href="{{ route('tasks.create', $taskboard[0]) }}"
            ><input type="button" class="btn btn-success" value="タスク追加"
          /></a>
        </div>

        <!--設定ボタン-->
        <div class="col-xl-2 p-3">
          <a href="{{ route('taskboards.edit', $taskboard[0]) }}">
            <input type="button" class="btn btn-info" value="設定変更" />
          </a>
        </div>

        <!--削除ボタン-->
        <div class="col-xl-2 p-3">
          <a href="" data-toggle="modal" data-target="#dialog1">
            <input type="button" class="btn btn-danger" value="削除" />
          </a>
        </div>
      </div>

      <!--タスクボード利用者-->
      <div class="row">
        <div class="col-xl-12 p-3">
          <p>{{ 'メンバー：' . $userName }}</p>
        </div>
      </div>

      <!--タスクボード-->
      <div class="row">
        <div class="col-12 xl-12">
          <table class="table-bordered" width="100%">
            <thead>
              <th class="taskbord" width="8%"></th>
              @foreach(config('code.taskboard.status_jp') as $status)
                <th class="taskboard" width="23%">{{ $status }}</th> 
              @endforeach
            </thead>

            <tbody>
              @foreach($userArray as $user)
                <tr>
                  <td id="{{ 'user-' . $user[0] }}">{{ $user[1] }}</td>
                  @foreach(config('code.taskboard.status_jp') as $key => $value)
                    <td id="{{ 't' . $user[0] . '-' . config('code.taskboard.status')[$key] }}" class="connectedSortable">
                      @foreach($tasks as $task)
                        @if($user[0] == $task[2] && config('code.taskboard.status')[$key] == $task[5])
                          <div id="{{ 'task' . $task[0] }}" class="card p-10 bg-info" draggable="true">
                            <div class="card-body">
                              <p>{{ $task[1] }}</p>
                            </div>
                            <div class="card-footer">
                              <small>更新日:{{ arrangeDate($task[4]) }}</small><br />
                              <small>更新者:{{ $task[3] }}</small>
                            </div>
                          </div>
                        @endif
                      @endforeach
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <script>
       document.addEventListener('DOMContentLoaded', function() {
          // ドラッグ可能なカードを全て取得
          var cards = document.querySelectorAll('.card');

          // 各カードにドラッグイベントを設定
          cards.forEach(function(card) {
            card.addEventListener('dragstart', function(e) {
              e.dataTransfer.setData('text/plain', card.id);
            });
          });

          // ドロップゾーン（.connectedSortable）を全て取得
          var dropzones = document.querySelectorAll('.connectedSortable');

          // 各ドロップゾーンにイベントリスナーを設定
          dropzones.forEach(function(zone) {
            zone.addEventListener('dragover', function(e) {
              e.preventDefault(); // デフォルトの処理をキャンセル
          });

          zone.addEventListener('drop', function(e) {
            e.preventDefault();
              var cardId = e.dataTransfer.getData('text/plain');
              var card = document.getElementById(cardId);
              zone.appendChild(card); // カードを新しい位置に移動
              // タスクボードID
              var taskboardId = {{ $taskboard[0] }};
              
              // タスクID
              var taskId = cardId.slice(4);
              
              var line   = zone.id.split("-");
              // ユーザーID
              var userId = line[0].slice(1);
              // タスク状態
              var taskStatus = line[1];
              
              alert('移動したカード: ' + taskStatus);
              
              // タスク状態変更
              window.location.href = taskboardId + "/user/" + userId + "/tasks/" +  taskId + "/status/" + taskStatus;
            });
          });
       });
      </script>

    </div>

    <!--削除モーダル-->
    <div class="row">
      <div class="col-12">
        <div class="modal fade" id="dialog1">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <h5 class="text-center">このタスクボードを削除しますか？</h5>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-danger"
                  data-dismiss="modal">
                  いいえ
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  onclick="taskboard_delete({{$taskboard[0]}})">
                  はい
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection