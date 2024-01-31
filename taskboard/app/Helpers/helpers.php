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
        $codeType = array_flip(config('code.'. $type));
        $changedCode = $codeType[$code];
        // コード表現の配列を取得
        $codeJp = config('code.' . $type . '_jp');
        return $codeJp[$changedCode];
    }
}

/*
* データベースの日時をYYYY年MM月DD日の形式に変換
* @param datetime 日時
* @retrun YYYY年MM月DD日形式の日付
*/
if(!function_exists('arrangeDate')) {
    function arrangeDate($datetime) {
        // strtotimeを使用してタイムスタンプに変換
        $timestamp = strtotime($datetime);
            
        // タイムスタンプを年月日の形式で出力
        return date("Y年m月d日", $timestamp);
    }
}

if(!function_exists('getUserTypeCodeArray')) {
    function getUserTypeCodeArray() {
        return getCodeArrayJp('user.type');
    }
}

if(!function_exists('getUserStatusCodeArray')) {
    function getUserStatusCodeArray() {
        return getCodeArrayJp('user.status');
    }
}

if(!function_exists('getCodeArrayJp')) {
    function getCodeArrayJp($type) {
        // コードと数値の配列
        $CodeNumberArray = config('code.' . $type);
        // コード表現と数値との配列
        $list = array();
        foreach($CodeNumberArray as $key => $value) {
            $list[] = [$value, config('code.' . $type . '_jp')[$key]];
        }
        return $list;    
    }
    
}

/*
* Eloquentモデルを多次元配列に変換する
* @param  Eloquent
* @return array
*/
if(!function_exists('changeEloquentToArray')) {
    function changeEloquentToArray($arrays) {
        $list = array();
        foreach($arrays as $array)
        {
            $list[] = array_values((array)$array);
        }
        return $list;
    }
}
