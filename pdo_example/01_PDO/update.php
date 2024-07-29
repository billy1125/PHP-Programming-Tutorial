<?php
require_once("functions.php");

$Results = false;

if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['id']))
    $Results = Update_One_Student($_POST['name'], $_POST['gender'], $_POST['id']);


if ($Results == true)
    echo "更新成功，5秒後回到首頁";
else
    echo "更新失敗，5秒後回到首頁";

header("Refresh:5; url=index.php");
