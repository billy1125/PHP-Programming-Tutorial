<?php
require_once("functions.php");

$Results = false;

if (isset($_GET["id"]))
    $Results = Delete_One_Student($_GET["id"]);


if ($Results == true)
    echo "刪除成功，5秒後回到首頁";
else
    echo "刪除失敗，5秒後回到首頁";

header("Refresh:5; url=index.php");
