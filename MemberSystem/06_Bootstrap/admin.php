<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
session_start();
if ((!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] !== "OK") &&
    (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== "Y")
) {
    echo "<h1>這是一個秘密網頁，你不是管理員，不能進來</h1>";
    echo "<a href='index.php'>回到登入首頁！</a>";

    exit;
} else {
    require("functions.php"); // require() 引用別的PHP檔案
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者頁面</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="login.css" rel="stylesheet">
</head>

<div class="col-lg-8 mx-auto p-3 py-md-5">
    <h1 class="h1"><?php echo $_SESSION["name"]; ?> 你好！這是管理者頁面！</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">刪除連結</th>
                <th scope="col">ID</th>
                <th scope="col">帳號</th>
                <th scope="col">密碼</th>
                <th scope="col">姓名</th>
                <th scope="col">權限</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $temp = Query_All_Members();

        foreach ($temp as $row) { // 依序讀取每一行
            echo "<tr>";
            foreach ($row as $key => $value) { // 在每一行依序讀取每一個欄位
                if ($key == "id") // 如果這個欄位是id，要建立有超連結的資料
                {
                    echo "<td><a href = 'delete_member.php?id={$value}'>刪除</a></td>";
                    echo "<td><a href = 'edit_member.php?id={$value}'>{$value}</a></td>";
                } else
                    echo "<td>{$value}</td>";
            }
            echo "</tr>";
        }        
        ?>
        </tbody>
    </table>

    <a href='add_member.php'>新增使用者</a> || <a href='logout.php'>登出</a>
</div>

</html>