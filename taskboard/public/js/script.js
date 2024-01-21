///////////////////////////////////////////////////
//
//  画面用Javascript関数
//
//　create:2023-08-18 T.Goto
//
//  update:
//
////////////////////////////////////////////////////

///////////////////////////////////////////////////
//
//  チェックボックスで全選択をする
//
//  引数：なし
//
//  戻り値：なし
//
//
////////////////////////////////////////////////////
$(function () {
    // 「全選択」する
    $("#all").on("click", function () {
        $("input[name='alls[]']").prop("checked", this.checked);
    });

    // 「全選択」以外のチェックボックスがクリックされたら、
    $("input[name='alls[]']").on("click", function () {
        var checkbox_count = 0; // チェックボックスの数
        var checkedbox_count = 0; // チェックされたボックスの数

        // チェックボックスの数を取得
        $("input[name='alls[]']").each(function () {
            checkbox_count++;
        });

        // チェックされたチェックボックス数を取得する
        $("input[name='alls[]']:checked").each(function () {
            checkedbox_count++;
        });

        if (checkbox_count == checkedbox_count) {
            // 全てのチェックボックスにチェックが入っていたら、「全選択」 = checked
            $("#all").prop("checked", true);
        } else {
            // 1つでもチェックが外れたら、「全選択」 = non_checked
            $("#all").prop("checked", false);
        }
    });
});

///////////////////////////////////////////////////
//
//  パスワード再発行処理
//
//  引数：なし
//
//  戻り値：なし
//
//
////////////////////////////////////////////////////
function password_change() {
    // パスワードを再発行する
    window.location.href = "user_password_change_done.html";
}

///////////////////////////////////////////////////
//
//  タスクボード削除処理
//
//  引数：id タスクボードのID
//
//  戻り値：なし
//
//
////////////////////////////////////////////////////
function taskboard_delete(id) {
    // タスクボード削除完了ページへ遷移
    //window.location.href = "taskboard_delete_done.html";
    window.location.href = "/taskboards/" + id + "/delete";
}