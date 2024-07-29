<?php
session_start();
require("DB_functions.php");

$UserID = "";
$UserName = "";
$LoginLink = "";
$CartItems = "";

// 檢查有沒有登入後的COOKIE
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    $LoginLink = "<a href='logout.php'>登出</a>";
    if (isset($_SESSION["name"]))
        $UserName = $_SESSION["name"];
    if (isset($_SESSION["id"]))
        $UserID = $_SESSION["id"];
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
    <h1>購物車</h1>
    <p><?php echo $UserName ?> 您好，以下是您的購物車內容，您的購物車共有 <?php echo Count_Cart_Items() ?> 項物件</p>
    <hr>
    <p><a href='index.php'>回上頁</a></p>
    <form name="login" method="post" action="order.php">
        <input type="hidden" name="item_id" value="<?php echo $ItemDetail["id"] ?>">
        <table border="1" width='1000'>
            <tr>
                <th>刪除</th>
                <th>商品代碼</th>
                <th>商品名稱</th>
                <th>價格</th>
                <th>訂購數量</th>
                <th>小計</th>
            </tr>
            <?php
            $Total = 0;
            if (isset($_COOKIE["CartItems"])) {
                $CookieItems = $_COOKIE["CartItems"];
                $temp = Query_All_Items(); // 取得所有商品資料

                foreach ($temp as $row) { // 將所有商品的清單資料，依序讀取，然後製作成HTML表格
                    if (isset($CookieItems[$row['id']])) {
                        echo "<tr>";
                        echo "<td><a href='cart.php?action=delete&item_id={$row['id']}'>刪除</td>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td><a href='show_item.php?id={$row['id']}'>{$row['name']}</a></td>";
                        echo "<td>" . number_format($row['price']) . "</td>";
                        echo "<td>{$CookieItems[$row['id']]}</td>";
                        $subtotal = (int)$CookieItems[$row['id']] * (int)$row['price'];
                        $Total += $subtotal;
                        echo "<td>" . number_format($subtotal) . "</td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
            <tr>
                <td colspan="5"></td>
                <td><?php echo number_format($Total) ?></td>
            </tr>
        </table>
        <input type="submit" value="結帳" />
    </form>
</body>

</html>