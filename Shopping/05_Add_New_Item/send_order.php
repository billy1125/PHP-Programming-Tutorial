<?php
// 檢查有沒有登入後的COOKIE
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    require("DB_functions.php");

    if (
        isset($_POST["user_id"]) &&
        isset($_POST["name"]) &&
        isset($_POST["telphone"]) &&
        isset($_POST["email"]) &&
        isset($_POST["address"])
    ) {
        if (Add_Order($_POST["user_id"], $_POST["name"], $_POST["telphone"], $_POST["email"], $_POST["address"]))
            echo "新增訂單成功";
    }

    // 清除所有的購物車Cookie
    foreach ($_COOKIE["CartItems"] as $key => $value) {
        setcookie("CartItems[{$key}]", "", time() - 3600);
    }
    header("refresh:5; url=index.php");
} else {
    header("location:login.php");
}
