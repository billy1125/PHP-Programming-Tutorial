<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] != "OK") {
    header("location:login.php"); //直接跳到登入頁面
} else {
    session_start();
    require("functions.php");
    $MemeberLink = "edit_member.php";
    if ($_SESSION["admin"] == "Y")
        $MemeberLink = "admin.php";
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易討論板</title>
</head>

<body>
    <h1>簡易討論板 Ver 3.0</h1>
    <p>讓使用者可以回文</p>
    <hr>
    <p><a href='logout.php'>登出</a> || <a href='#'>發表新主題</a>  || <a href='<?php echo $MemeberLink ?>?id=<?php echo $_SESSION['id'] ?>'>會員資料管理</a> </p>
    <h2>所有討論文章</h2>
    <table border="1">
        <tr>
            <th>文章編號</th>
            <th>主題</th>
            <th>作者</th>
            <th>刊登時間</th>
        </tr>
        <?php
        $temp = Query_All_Post_Titles(); // 取得資料庫中所有發文的清單資料

        foreach ($temp as $row) { // 將所有發文的清單資料，依序讀取，然後製作成HTML表格
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td><a href = 'post_detail.php?post_id={$row['id']}'>{$row['title']}</a></td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['datetime']}</td>";
            echo "</tr>";
        }

        ?>
    </table>


</body>

</html>