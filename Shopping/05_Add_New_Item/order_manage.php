<?php
session_start();
require("DB_functions.php");

$MemeberLink = "";
$UserName = ""; // 用來顯示使用者姓名
$UserId = "";   // 使用者的ID
$IsAdmin = "";  // 是否為管理者
$OrderId = "";  // 取得訂單編號的GET

if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    $LoginLink = "<a href='logout.php'>登出</a>";
    if (isset($_SESSION["name"]))
        $UserName = $_SESSION["name"]; 
    if (isset($_SESSION["id"]))
        $UserId = $_SESSION["id"];     
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] == "Y")
        $IsAdmin = "Y";  // 如果是管理員，IsAdmin變數設定為Y
    if (isset($_GET["orderid"]))
        $OrderId = $_GET["orderid"];
} else {
    header("location:login.php");
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
    <h1>訂單管理</h1>
    <hr>
    <p><a href='index.php'>回上頁</a></p>
    <h2><?php echo $UserName . " " ?>你好！以下是你目前的訂單紀錄！</h2>
    <table border="1" width='1000'>
        <tr>
            <th>訂單編號</th>
            <th>下單人</th>
            <th>電話</th>
            <th>電子郵件</th>
            <th>地址</th>
            <th>訂購日期時間</th>
        </tr>
        <?php
        $temp = Query_Orders($UserId, $IsAdmin); // 取得會員的歷史訂單資料，如果是管理員，則是取得系統中所有訂單資料

        foreach ($temp as $row) { // 將所有歷史訂單資料，依序讀取，然後製作成HTML表格
            echo "<tr>";
            echo "<td><a href='order_manage.php?orderid={$row['id']}'>訂單細節</a></td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['telephone']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['datetime']}</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <h2>訂單編號的細項</h2>
    <hr>
    <table border="1" width='750'>
        <tr>
            <th>商品名稱</th>
            <th>訂購數量</th>
            <th>單價</th>
            <th>總價</th>
        </tr>
        <?php
        if ($OrderId != "") {
            $temp = Query_Orders_Detail($OrderId); // 取得特定訂單的細項資料
            $Total = 0;

            foreach ($temp as $row) { // 將特定訂單的細項資料，依序讀取，然後製作成HTML表格
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['numbers']}</td>";
                echo "<td>" . number_format($row['price']) . "</td>";
                echo "<td>" . number_format($row['subtotal']) . "</td>";
                $Total += (int)$row['subtotal'];
                echo "</tr>";
            }
            echo "<tr><td colspan='3'><td>" . number_format($Total) . "</td></td></tr>"; // 計算訂單總共多少錢？
        }
        ?>
    </table>
</body>

</html>