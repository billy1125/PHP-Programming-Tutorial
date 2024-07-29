<?php
require_once("functions.php");
$temp = Query_All_Students(); // 取得所有學生資料

?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO 範例</title>
</head>

<body>
    <h1>PDO 存取資料庫範例</h1>
    <p>顯示學生清單</p>
    <hr>
    <p><a href="insert_form.php">新增資料</a></p>
    <table border="1" width='1000'>
        <tr>
            <th>編號</th>
            <th>刪除</th>
            <th>姓名</th>
            <th>性別</th>
            <!-- <th>是否刪除</th> -->
        </tr>
        <?php


        foreach ($temp as $row) { // 將所有學生資料，依序讀取，然後製作成HTML表格
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td><a href='delete.php?id={$row['id']}'>刪</a></td>";
            echo "<td><a href='update_form.php?id={$row['id']}'>{$row['name']}</a></td>";
            // echo "<td>{$row['name']}</td>";
            echo "<td>{$row['gender']}</td>";
            // echo "<td>{$row['del']}</td>";
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>