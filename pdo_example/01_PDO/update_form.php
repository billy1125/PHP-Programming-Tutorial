<?php
require_once("functions.php");

if (isset($_GET["id"]))
    $student = Query_One_Student($_GET["id"]);
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO 範例</title>
</head>

<body>
    <h1>PDO 存取資料庫範例</h1>
    <p>更新學生</p>
    <hr>
    <form name="form" method="post" action="update.php">
        姓名: <input type="text" name="name" size="20" value="<?php echo $student['name'] ?>"><br />
        性別: <input type="text" name="gender" size="20" value="<?php echo $student['gender'] ?>"><br />
        <input type="hidden" name="id" value="<?php echo $student['id'] ?>">
        <input type="submit" value="修改" />
    </form>
</body>

</html>