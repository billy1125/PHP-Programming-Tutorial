<?php
session_start();
require("DB_functions.php");

$IsHidden = "hidden";
$ItemName = array(
    "id" => "",
    "name" => "",
    "price" => "",
    "detail" => "",
    "image" => ""
);
$FormAction = "";
$ButtonText = "修改";

// 檢查有沒有登入後的COOKIE
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {

    if (isset($_GET["edit"])) {
        switch ($_GET["edit"]) {
            case 'add':
                $FormAction = "insert";
                $IsHidden = "";
                $ButtonText = "新增";
                break;
            case 'insert':
                Add_One_Item($_POST["name"], $_POST["price"], $_POST["detail"], $_POST["image"]);
                header("location:item_manage.php");
                break;
            case 'update':
                if (isset($_POST["id"])) {
                    Edit_One_Item($_POST["name"], $_POST["price"], $_POST["detail"], $_POST["image"], $_POST["id"]);
                    header("location:item_manage.php?id=" . $_POST["id"]);
                }
                break;
        }
    }

    if (isset($_GET["id"])) {
        $ItemName = Query_One_Item($_GET["id"]);
        $IsHidden = "";
        $FormAction = "update";
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
    <h1>商品管理</h1>
    <hr>
    <p><a href="index.php">回首頁</a> || <a href="item_manage.php?edit=add">新增商品</a></p>
    <table border="1" width='1000'>
        <tr>
            <th>商品編號</th>
            <th>產品</th>
        </tr>
        <?php
        $temp = Query_All_Items(); // 取得所有商品資料

        foreach ($temp as $row) { // 將所有商品的清單資料，依序讀取，然後製作成HTML表格
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td><a href='item_manage.php?id={$row['id']}'>{$row['name']}</a></td>";
            echo "</tr>";
        }

        ?>
    </table>
    <hr>
    <h2>產品資訊</h2>
    <form name="item_manage" method="post" action="item_manage.php?edit=<?php echo $FormAction . '" '; echo $IsHidden ?>>
        <input type="submit" value="<?php echo $ButtonText ?>" /><br /><br />
        產品: <input type="text" name="name" size="100" value="<?php echo $ItemName['name'] ?>"><br />
        價格: <input type="text" name="price" size="15" value="<?php echo $ItemName['price'] ?>" /><br />
        商品說明: <br /><textarea name="detail" rows="10" cols="100" /><?php echo $ItemName['detail'] ?></textarea><br />
        <input type="hidden" name="image" value="<?php echo $ItemName['image'] ?>">
        <input type="hidden" name="id" value="<?php echo $ItemName['id'] ?>">
        <img src="Items/<?php echo $ItemName['image'] ?>"><br />

    </form>
</body>

</html>