<?php
/*
* File cadeChange.php
* @takuya goto
*/
if(!function_exists('getUserType')) {
    function getUserType($status) {
        return getCodeJp($status, 'user.type');
    }
}

if(!function_exists('getUserStatus')) {
    function getUserStatus($status) {
        return getCodeJp($status, 'user.status');
    }
}

if(!function_exists('getTaskboardStatus')) {
    function getTaskboardStatus($status) {
        return getCodeJp($status, 'taskboard.status');
    }
}

if(!function_exists('getCodeJp')) {
    function getCodeJp($code, $type) {
        // コード表現の配列の値からキーを取得
        $codeType = array_flip(config('code.'.$type));
        $changedCode = $codeType[$code];
        // コード表現の配列を取得
        $codeJp = config('code.'.$type.'_jp');
        return $codeJp[$changedCode];
    }
}
