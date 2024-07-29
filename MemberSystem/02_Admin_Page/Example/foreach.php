<?php
$class = array("小明", "小花", "大雄");

foreach($class as $value)
    echo $value . "<br>";

$grades = array("小明" => "60",
                "小花" => "100",
                "大雄" => "70");
                
foreach($grades as $key => $value)
    echo "{$key}的成績是：{$value}<br>";
