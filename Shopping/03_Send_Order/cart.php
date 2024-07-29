<?php
// 管理購物車的Cookie
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    // 依照不同的GET來判斷要新增或刪除商品？
    switch ($_GET["action"]) {
        case 'add': // 新增商品
            if (isset($_GET["item_id"]) && isset($_GET["numbers"])) {
                $item_id = $_GET["item_id"];
                $numbers = $_GET["numbers"];

                if (isset($_COOKIE["CartItems"][$item_id])) {
                    // 如果已經有某個商品在購物車裡，就要更新數量
                    $temp = (int)$_COOKIE["CartItems"][$item_id];
                    $temp += (int)$numbers;
                    setcookie("CartItems[{$item_id}]", $temp);
                } else {
                    // 如果某個商品還沒有在購物車裡，就直接新增這個商品
                    setcookie("CartItems[{$item_id}]", $numbers);
                }
            }
            break;
        case 'delete': // 刪除商品
            if (isset($_GET["item_id"])) {
                $item_id = $_GET["item_id"];
                setcookie("CartItems[{$item_id}]", "", time() - 3600);
            }
            break;  
    }
    header("location:show_cart.php");
} else {
    header("location:login.php");
}
