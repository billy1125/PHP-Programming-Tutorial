<?php
// 先檢查有沒有產品的ID的GET，沒有的話就帶回到首頁（沒有GET就沒辦法查詢特定產品）
if (isset($_GET["id"])) {
    session_start();
    require("DB_functions.php");

    $UserID = "";
    $LoginLink = "";

    // 檢查有沒有登入後的COOKIE
    if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
        $LoginLink = "<p><a href='logout.php'>登出</a></p>";
        if (isset($_SESSION["id"]))
            $UserID = $_SESSION["id"];
    }

    $ItemDetail = Query_One_Item($_GET["id"]); // 查詢特定產品資訊
} else {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>筆電小站</title>

    <style>
        td {
            white-space: pre-line;
        }
    </style>
</head>

<body>
    <h1>線上購物 Ver 1.0</h1>
    <p>顯示商品細節</p>
    <hr>
    <?php echo $LoginLink ?>
    <p><a href='index.php'>回上頁</a> || <a href='show_cart.php'>購物車</a></p>
    <form name="login" method="GET" action="cart.php">
        <input type="hidden" name="item_id" value="<?php echo $ItemDetail["id"] ?>">
        <input type="hidden" name="action" value="add">
        <table border="1" width='1000'>
            <tr>
                <td>商品名稱</td>
                <td><?php echo $ItemDetail["name"] ?></td>
            </tr>
            <tr>
                <td>價格</td>
                <td><?php echo $ItemDetail["price"] ?></td>
            </tr>
            <tr>
                <td>圖片</td>
                <td><img src='Items/<?php echo $ItemDetail["image"] ?>' width="300"></td>
            </tr>
            <tr>
                <td>商品介紹</td>
                <td><?php echo $ItemDetail["detail"] ?></td>
            </tr>
        </table>
        <label for="numbers">請選擇數量:</label>
        <select name="numbers" id="numbers">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <input type="submit" value="加入到購物車" />
    </form>

</body>

</html>