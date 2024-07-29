<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    header("location:vip.php"); //直接跳到會員頁面
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入系統</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="login.css" rel="stylesheet">
</head>

<body class="text-center">    
    <main class="form-signin">
    <form name="login" method="post" action="login.php">
        <h1 class="h1 mb-3 fw-normal">登入系統</h1>
        <p>Ver 11.0 經過美化後的版本</p>
        <div class="form-floating">
            <input type="text" class="form-control" name="Account" placeholder="你的帳號">
            <label for="floatingInput">你的帳號</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="Password" placeholder=" 密碼">
            <label for="floatingPassword"> 密碼</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="YesRememberMe"> 記住我
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">登入</button>
    </form>
    </main>
</body>

</html>