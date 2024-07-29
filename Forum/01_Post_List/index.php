<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] != "OK") {
    header("location:login.php"); //直接跳到登入頁面
} else {
    session_start();
    require("functions.php");
    $MemeberLink = "edit_member.php"; // 預設會員管理頁面是一般使用者的
    if ($_SESSION["admin"] == "Y")
        $MemeberLink = "admin.php"; // 如果你是管理員，會員管理頁面是管理者專屬頁面
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
    <h1>簡易討論板 Ver 1.0</h1>
    <p>一個只有會員才能登入，登入後可以看到文章清單的網站</p>
    <hr>
    <p><a href='logout.php'>登出</a> || <a href='#'>發表新主題</a>  || <a href='Member/<?php echo $MemeberLink ?>?id=<?php echo $_SESSION['id'] ?>'>會員資料管理</a> </p>
    <h2>所有討論文章</h2>
    <table border="1">
        <tr>
            <th>文章編號</th>
            <th>主題</th>
            <th>作者</th>
            <th>刊登時間</th>
        </tr>
        <?php
        $temp = Query_All_Post_Titles(); // 取得資料庫中所有發文的清單資料(陣列)

        foreach ($temp as $row) { // 將所有發文的清單資料，依序讀取，然後製作成HTML表格
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td><a href = 'post.php?id={$row['id']}'>{$row['title']}</a></td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['datetime']}</td>";
            echo "</tr>";
        }

        ?>
    </table>


</body>

</html>