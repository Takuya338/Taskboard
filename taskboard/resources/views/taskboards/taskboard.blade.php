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
          <a href="{{ route('', $taskboard[0]) }}"
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
              <th class="taskbord" width="23%">実行前</th>
              <th class="taskbord" width="23%">実行中</th>
              <th class="taskbord" width="23%">完了</th>
              <th class="taskbord" width="23%">中止</th>
            </thead>

            <tbody>
              <tr>
                <td>タスク一郎</td>
                <td class="connectedSortable">

                  <div class="card p-10 bg-info" draggable="true">
                    <div class="card-body">
                      <p>〇〇を実行</p>
                    </div>
                    <div class="card-footer">
                      <small>更新日:0000年00月00日</small><br />
                      <small>更新者:タスク一郎</small>
                    </div>
                  </div>

                  <div class="card p-10 bg-info" draggable="true">  
                    <div class="card-body">
                      <p>〇〇を実行</p>
                    </div>
                    <div class="card-footer">
                      <small>更新日:0000年00月00日</small><br />
                      <small>更新者:タスク一郎</small>
                    </div>
                  </div>

                </td>
                <td class="connectedSortable" dropzone="move"></td>
                <td class="connectedSortable" dropzone="move"></td>
                <td class="connectedSortable" dropzone="move"></td>
              </tr>

              <tr>
                <td class="connectedSortable">タスク二郎</td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
              </tr>

              <tr>
                <td class="connectedSortable">タスク三郎</td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
              </tr>

              <tr>
                <td class="connectedSortable">タスク四郎</td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
                <td class="connectedSortable"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
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