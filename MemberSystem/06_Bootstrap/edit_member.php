<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] !== "OK") {
    echo "<h1>這是一個秘密網頁，你不是會員，不能進來</h1>";
    echo "<a href='index.php'>回到登入首頁！</a>";

    exit;
} else {
    session_start();
    require("functions.php"); // require() 引用別的PHP檔案
    $alertMessage = "";

    if (isset($_GET["id"])) {
        //檢查有沒有來自edit_member.php的POST，如果有，才更新使用者資料
        if (isset($_POST["Account"]) && isset($_POST["Password"]) && isset($_POST["Name"])) {
            // 更新使用者資料
            $UpdateResult = Update_Member(
                $_POST["Account"],
                $_POST["Password"],
                $_POST["Name"],
                isset($_POST["Admin"]) ? $_POST["Admin"] : "",
                $_GET["id"]
            );

            if ($UpdateResult == true) {
                $alertMessage = "{$_POST["Name"]}帳號更新成功！";
            } else {
                $alertMessage = "{$_POST["Name"]}帳號更新失敗！";
            }
        }

        $Member = Query_One_Member($_GET["id"]); // 查詢特定使用者ID的資料

        $id = $Member['id'];
        $account = $Member['account'];
        $password = $Member['password'];
        $name = $Member['name'];
        $admin = $Member['admin'];
    }
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改會員資料頁面</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="login.css" rel="stylesheet">

    <script language="javascript">
        var message = "<?php echo $alertMessage ?>";
        if (message != "")
            alert(message);
    </script>
</head>

<div class="col-lg-8 mx-auto p-3 py-md-5">
    <h1 class="h1">使用者：<?php echo $name ?></h1>
    <form name="login" method="post" action="edit_member.php?id=<?php echo $id ?>">
        <div class="form-floating">
            <input class="form-control" type="text" name="Account" size="15" value="<?php echo $account ?>" placeholder="帳號" /><br />
            <label for="floatingInput">帳號</label>
        </div>
        <div class="form-floating">
            <input class="form-control" type="text" name="Password" size="15" value="<?php echo $password ?>" placeholder="密碼" /><br />
            <label for="floatingInput">密碼</label>
        </div>
        姓名: <input class="form-control" type="text" name="Name" size="15" value="<?php echo $name ?>" /><br />
        是否為管理員：<input type="checkbox" name="Admin" value="Y" <?php echo ($admin == "Y") ? "checked" : "" ?> <?php echo ($_SESSION['admin'] == "Y") ? "" : "disabled" ?> /><br />
        <input type="hidden" name="Id" value="<?php echo $id ?>">
        <button class="w-100 btn btn-lg btn-primary" type="submit">修改</button>

</form>
<?php
if ($_SESSION['admin'] == "Y")
    echo "<a href='admin.php'>回到管理頁面</a>";
else
    echo "<a href='logout.php'>登出</a>";
?>
</div>

</html>