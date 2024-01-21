{{-- resources/views/users/index.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--戻るボタン-->
      @include('parts.backbutton',['url'=>route('taskboards.index')])

      <!--タイトル行-->
      <div class="row">
        <!--タイトル-->
        <div class="col-xl-4 p-3"><h2>ユーザー管理</h2></div>

        <!--ユーザー登録ボタン-->
        <div class="col-xl-2 p-3">
          <a href="{{ route('users.create') }}"
            ><input
              type="button"
              class="btn btn-success"
              value="新規ユーザー登録"
          /></a>
        </div>

        <!--ユーザー削除ボタン-->
        <div class="col-xl-2 p-3">
          <button
            type="button"
            class="btn btn-danger"
            data-toggle="modal"
            data-target="#dialog2">
            選択したユーザーを削除
          </button>
        </div>

        <!--ユーザー検索フォーム-->
        @include('form.search', ['class'=>' p-3', 'placeholder'=>'名前またはメールアドレス'])
      </div>

      <!--ユーザー一覧-->
      <div class="row">
        <div class="col-12 xl-12">
          <table class="table-bordered" width="100%">
            <thead>
              <th class="taskbord" width="1%">
                <input type="checkbox" id="all" />
              </th>
              <th class="taskbord" width="35%">操作</th>
              <th class="taskbord" width="16%">名前</th>
              <th class="taskbord" width="16%">メールアドレス</th>
              <th class="taskbord" width="16%">ユーザータイプ</th>
              <th class="taskbord" width="16%">備考</th>
            </thead>

            <tbody>
              <form id="deletes" method="post" action="{{ route('users.deletes') }}">
              @csrf
              @foreach($datas as $data)
              <tr>
                <td><input id="{{ 'selected-' . $data[0] }}" type="checkbox" name="alls[]" value="{{ $data[0] }}"/></td>
                <td>
                  <a id="{{ 'deleted--' . $data[0] }}"  class="selectObject" href="" data-toggle="modal" data-target="#dialog1">削除</a>
                  &nbsp;
                  <!--空白-->
                  &nbsp;
                  <!--空白-->
                  <a href="{{ route('users.edit', $data[0]) }}">編集</a>
                  &nbsp;
                  <!--空白-->
                  &nbsp;
                  <!--空白-->
                  <a
                    id="{{ 'password-' . $data[0] }}"
                    class="selectObject"
                    href=""
                    data-toggle="modal"
                    data-target="#password_reset_modal"
                    >パスワード再発行</a
                  >
                </td>
                <td>{{ $data[1] }}</td>
                <td>{{ $data[2] }}</td>
                <td>{{ $data[3] }}</td>
                <td>{{ $data[4] }}</td>
              </tr>
              @endforeach
              </form>
            </tbody>
          </table>
        </div>
      </div>

      <!--削除モーダル-->
      <div class="row">
        <div class="col-12">
          <div class="modal fade" id="dialog1">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <h5 class="text-center">選択したユーザーを削除しますか？</h5>
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
                    onclick="user_delete()">
                    はい
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12">
          <div class="modal fade" id="dialog2">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <h5 class="text-center">選択したユーザーを削除しますか？</h5>
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
                    onclick="user_deletes()">
                    はい
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--パスワード再発行モーダル-->
      <div class="row">
        <div class="col-12">
          <div class="modal fade" id="password_reset_modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <h5 class="text-center">パスワードを再発行しますか？</h5>
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
                    onclick="password_change()">
                    はい
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <input type="hidden" id="selectId">

    <script>
        // すべてのリンクを取得
        const links = document.querySelectorAll('.selectObject');

        // 各リンクにイベントリスナーを設定
        links.forEach(link => {
            link.addEventListener('click', function(event) {
                // デフォルトの動作を防ぐ
                event.preventDefault();

                // クリックされたリンクの要素を取得
                const clickedLink = this;

                // テキスト入力フィールドの値を設定
                id = clickedLink.id.slice(9);
                document.getElementById('selectId').value = id;
            });
        });
        // 単一ユーザー削除
        function user_delete() {
            // 削除するユーザーID
            id = document.getElementById('selectId').value;
            // ユーザー削除完了ページへ遷移
            window.location.href = "/users/" + id + "/delete";
        }
        
        // 複数ユーザー削除
        function user_deletes() {
            // フォームを取得して送信
            document.getElementById('deletes').submit();
        }
        
        // パスワードリセット
        function password_change() {
            // 削除するユーザーID
            id = document.getElementById('selectId').value;
            // ユーザー削除完了ページへ遷移
            window.location.href = "users/" + id + "/password/reset";
        }

    </script>
@endsection
