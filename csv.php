<?php
//配列と文字コードを渡してCSV出力
public function csv_gen($data_array,$char_code){
    try {
        //一時ファイルの用意
        $csvFileName = fopen('php://temp/maxmemory:'. (5*1024*1024), 'w');
        if ($csvFileName === FALSE) {
            throw new Exception('ファイルの書き込みに失敗しました。');
        }
        $dataList = $data_array;
        foreach($dataList as $dataInfo) {
            //文字コード変換
            mb_convert_encoding($dataInfo, $char_code,'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN,SJIS');
            fputcsv($csvFileName, $dataInfo);
        }
        $filename = "";
        $filename = date('Y-m-d').'.csv';
        // ハンドル閉じる
        fclose($csvFileName);
        rewind($csvFileName);
        file_put_contents($filename, stream_get_contents($csvFileName));
        fclose($csvFileName);
    } catch(Exception $e) {
        // 例外
        echo $e->getMessage();
    }
    die;
    exit();
}