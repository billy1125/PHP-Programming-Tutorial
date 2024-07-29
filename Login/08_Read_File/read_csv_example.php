<?php

$row = 1; //用來記錄目前讀到第幾行？
$handle = fopen("account.csv","r"); //將CSV檔案讀取，存進資料流的變數

// fgetcsv() 可以用來解析CSV格式檔案，需要三個參數，1.讀取CSV檔案後的資料流，2.每一行可讀取的最長長度，3.資料間格符號（多半是逗點）

//while迴圈會將檔案「一行一行」讀取，每一次迴圈，都是讀取一行資料（重點）
while ($data = fgetcsv($handle, 1000, ",")) {
    $num = count($data); //以逗點分隔後，取得這一行有多少組資料
    echo "<p> 第 $row 行資料中有 $num 組資料，分別是: <br>\n";
    $row++;
    for ($i = 0; $i < $num; $i++) {
        echo $data[$i] . "<br>\n";
    }
}

fclose($handle); //資料流使用完後，務必，關閉檔案！
