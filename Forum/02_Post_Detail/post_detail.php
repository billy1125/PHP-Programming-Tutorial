<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] != "OK") {
    header("location:login.php"); //直接跳到登入頁面
} else {
    session_start();
    require("functions.php");

    // 檢查有沒有post_id的GET，這要用來查詢特定的回文清單
    if (isset($_GET["post_id"]))
        $post_id = $_GET['post_id'];
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易討論板</title>
    <style>
        /* 這個CSS樣式用來讓資料庫的換行符號能在HTML頁面中轉成<br>換行符號 */
        td {
            white-space: pre-line; 
        }
    </style>
</head>

<body>
    <h1>簡易討論板 Ver 2.0</h1>
    <p>點選文章標題，顯示別人的回文</p>
    <hr>
    <p><a href='index.php'>回文章列表</a> </p>
    <h2>所有討論文章</h2>
    <table border="1">
        <tr>
            <th>編號</th>
            <th>回文</th>
            <th>作者</th>
            <th>刊登時間</th>
        </tr>
        <?php
        $temp =  Query_One_Post_Details($post_id); // 查詢所有特定文章標題的回文清單

        foreach ($temp as $row) { // 依序讀取每一行
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['message']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['datetime']}</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <h3>快速回文</h3>
    <form name="login" method="post" action="">
        <textarea cols="100" rows="15" name="RelayText" value="" /></textarea>
        <input type="submit" value="回文" />
    </form>

</body>

</html>