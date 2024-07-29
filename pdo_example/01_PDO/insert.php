<?php
require_once("functions.php");

$Results = false;

if (isset($_POST['name']) && isset($_POST['gender']))
    $Results = Insert_One_Student($_POST['name'], $_POST['gender']);


if ($Results == true)
    echo "新增成功，5秒後回到首頁";
else
    echo "新增失敗，5秒後回到首頁";

header("Refresh:5; url=index.php");
