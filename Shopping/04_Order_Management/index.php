<?php
session_start();
require("DB_functions.php");

$MemeberLink = "";
$LoginLink = "<a href='login.php'>會員登入</a>"; // 預設的會員登入連結
$UserName = "";

// 檢查有沒有登入後的COOKIE，有的話，就根據使用者姓名與身份改變網頁內容，如果沒有，就單純顯示商品清單
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    $LoginLink = "<a href='logout.php'>登出</a>";
    if (isset($_SESSION["name"]))
        $UserName = $_SESSION["name"]; // 用來顯示使用者姓名
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == "Y") {
        $MemeberLink = "<a href='Member/admin.php'>會員資料管理</a> || <a href='order_manage.php'>訂單管理</a> "; // 如果使用者是管理員，顯示會員資料管理連結
    } else {
        $MemeberLink = "<a href='Member/edit_member.php?id=" . $_SESSION["id"] . "'>會員資料管理</a> || <a href='order_manage.php?id=" . $_SESSION["id"] . "'>訂單管理</a> ";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>筆電小站</title>
</head>

<body>
    <h1>線上購物 Ver 4.0</h1>
    <p>訂單管理功能</p>
    <hr>
    <p><?php echo $LoginLink ?> || <a href='cart.php'>購物車(<?php echo Count_Cart_Items() ?>)</a> || <?php echo $MemeberLink ?></p>
    <h2><?php echo $UserName . " " ?>你好！以下是我們商店裡面所有的商品，歡迎你的選購！</h2>
    <table border="1" width='1000'>
        <tr>
            <th>商品編號</th>
            <th>產品</th>
            <th>價格</th>
            <th>圖片</th>
        </tr>
        <?php
        $temp = Query_All_Items(); // 取得所有商品資料

        foreach ($temp as $row) { // 將所有商品的清單資料，依序讀取，然後製作成HTML表格
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td><a href='show_item.php?id={$row['id']}'>{$row['name']}</a></td>";
            echo "<td>{$row['price']}</td>";
            echo "<td><img src='Items/{$row['image']}' width='300'></td>";
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>