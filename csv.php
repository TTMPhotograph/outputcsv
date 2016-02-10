<?php
//毎回忘れる
public function csv_gen($data_array,$user_id){
    try {
        //一時ファイルの用意
        $csvFileName = '/tmp/' . time() . rand() . '.csv';
        $res = fopen($csvFileName, 'w');
        if ($res === FALSE) {
            throw new Exception('ファイルの書き込みに失敗しました。');
        }
        $dataList = $data_array;
        foreach($dataList as $dataInfo) {
            //文字コード変換
            mb_convert_variables('SJIS', 'UTF-8', $dataInfo);
            fputcsv($res, $dataInfo);
        }
        $fname = date('Y-m-d').'-'.'myname';
        // ハンドル閉じる
        fclose($res);
        //ダウンロード
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$fname.'.csv');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($csvFileName));
        readfile($csvFileName);
    } catch(Exception $e) {
        // 例外
        echo $e->getMessage();
    }
    die;
    exit();
}