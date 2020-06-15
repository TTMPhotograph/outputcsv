<?php
//配列と文字コードを渡してCSV出力
function createCSVFromArray($data_array, $char_code)
{

   try{
    //一時ファイルの用意
    $fileHandle = fopen('php://temp', 'w') or die('Can\'t create .csv file, try again later.');
    $dataList = $data_array;
        foreach($dataList as $dataInfo) {
            //文字コード変換
            mb_convert_encoding($dataInfo,$char_code, "ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN,SJIS");
            fputcsv($fileHandle, $dataInfo);
        }
        $fname = date('Y-m-d').".csv";
        // ハンドル閉じる
        rewind($fileHandle);
        file_put_contents($fname, stream_get_contents($fileHandle));
        fclose($fileHandle);
        //ダウンロード
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$fname);
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($fname));
        readfile($fname);
        unlink($fname);
    } catch(Exception $e) {
        // 例外
        echo $e->getMessage();
    }
    die;
    exit();
}
if (isset($_POST['submit_btn'])) {
    $data_array = [['赤', '青', '白']];
    $char_code = 'UTF-8';
    createCSVFromArray($data_array, $char_code);
}
?>
<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>配列から文字コードを指定してCSVを作成する</title>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- BUTTER CAKE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/buttercake@4.0.0/dist/css/butterCake.min.css">

</head>

<body class="py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="" method="post">
                    <button type="submit" name="submit_btn" class="btn dark rounded">CSV出力する</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Butter Cake JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/buttercake@4.0.0/dist/js/butterCake.min.js"></script>

</body>

</html>