<?php
require_once("DB_config.php"); //資料庫連線

// 資料庫連線
function DB_Connect()
{
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // 建立資料庫連線

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
            exit;
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    return $link;
}

// 帳號密碼確認
function Account_Check(string $_account, string $_password)
{
    $AccountCheckResult = false; // $AccountCheckResult 變數用來做回傳值
    $link = DB_Connect(); // 執行連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "SELECT id, account, password, name, admin FROM users WHERE account = ? AND password = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $param_account, $param_password);

                // 設定參數值
                $param_account = $_account;
                $param_password = $_password;

                if (mysqli_stmt_execute($stmt) == true) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $account, $password, $name, $admin);
                        if (mysqli_stmt_fetch($stmt)) {
                            if ($password == $_password) {
                                $_SESSION["id"] = $id; // id
                                $_SESSION["account"] = $account; // 帳號
                                $_SESSION["password"] = $password; // 密碼
                                $_SESSION["name"] = $name; // 姓名
                                $_SESSION["admin"] = $admin; // 使用權限設定，如果是Y代表為管理者帳號
                                $AccountCheckResult = true; //如果帳號密碼正確，$AccountCheckResult就等於「真」 
                            }
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $AccountCheckResult; // 最終整個函式會丟出去 $AccountCheckResult 變數
}

// 依照使用者的權限分流到不同頁面
function Check_Member_Authority()
{
    if (isset($_SESSION["admin"])) {
        if ($_SESSION["admin"] == "Y") {
            header("refresh:5; url=admin.php"); // 如果SESSION['admin']是Y的，代表使用者有管理者權限
        } else {
            header("refresh:5; url=edit_member.php?id={$_SESSION["id"]}"); // 一般使用者
        }
    }
}

// 查詢所有使用者資料
function Query_All_Members()
{
    $AllMembers = array(); // 用陣列建立所有使用者資料
    $link = DB_Connect(); // 連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "SELECT * FROM users";
            mysqli_query($link, 'SET NAMES utf8');

            // 送出查詢的SQL指令
            if ($result = mysqli_query($link, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $temp = array(
                        "id" => $row["id"],
                        "account" => $row["account"],
                        "password" => $row["password"],
                        "name" => $row["name"],
                        "admin" => $row["admin"]
                    );
                    array_push($AllMembers, $temp); // array_push()可以將特定陣列「加進」另一個既有的陣列中
                }

                mysqli_free_result($result); // 釋放佔用記憶體
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $AllMembers; // 最終整個函式會丟出去 $AllMembers 變數
}

// 查詢單一使用者
function Query_One_Member(string $_id)
{
    $link = DB_Connect(); // 執行連線函式
    $MemberData = array();

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            // SQL查詢指令，請特別注意：SELECT 只抓取五個欄位值 id, account, password, name, admin，這個順序會和以下的查詢結果相對應，別弄混
            $sql = "SELECT id, account, password, name, admin FROM users WHERE id = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_account);

                $param_account = $_id;

                if (mysqli_stmt_execute($stmt) == true) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $account, $password, $name, $admin);
                        if (mysqli_stmt_fetch($stmt)) {
                            $MemberData = array(
                                "id" => $id,
                                "account" => $account,
                                "password" => $password,
                                "name" => $name,
                                "admin" => $admin
                            );
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $MemberData; // 最終整個函式會丟出去 $MemberData 變數
}

// 更新使用者資料
function Update_Member(string $_account, string $_password, string $_name, string $_admin, string $_id)
{
    $link = DB_Connect(); // 執行連線函式
    $UpdateResult = false;

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "UPDATE users SET account = ?,
                                     password = ?,
                                     name = ?,
                                     admin = ?
                    WHERE id = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssss", $param_account, $param_password, $param_name, $param_admin, $param_id);

                $param_id = $_id;
                $param_account = $_account;
                $param_password = $_password;
                $param_name = $_name;
                $param_admin = $_admin;

                if (mysqli_stmt_execute($stmt) == true) {
                    $UpdateResult = true;
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $UpdateResult; // 最終整個函式會丟出去 $UpdateResult 變數
}

// 新增使用者資料
function Add_Member(string $_account, string $_password, string $_name, string $_admin)
{
    $link = DB_Connect(); // 執行連線函式
    $AddResult = false;

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "INSERT INTO users (account, password, name, admin) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $param_account, $param_password, $param_name, $param_admin);

                $param_account = $_account;
                $param_password = $_password;
                $param_name = $_name;
                $param_admin = $_admin;

                if (mysqli_stmt_execute($stmt) == true) {
                    $AddResult = true;
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $AddResult; // 最終整個函式會丟出去 $AddResult 變數
}

// 刪除使用者資料
function Delete_Member(string $_id)
{
    $link = DB_Connect(); // 執行連線函式
    $DeleteResult = false;

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "DELETE FROM users WHERE id = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_id);

                $param_id = $_id;

                if (mysqli_stmt_execute($stmt) == true) {
                    $DeleteResult = true;
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $DeleteResult; // 最終整個函式會丟出去 $DeleteResult 變數
}

// 查詢所有文章標題
function Query_All_Post_Titles()
{
    $AllTitles = array();
    $link = DB_Connect(); // 連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "SELECT posts.*, users.name FROM posts, users WHERE posts.user_id = users.id";

            mysqli_query($link, 'SET NAMES utf8');

            if ($result = mysqli_query($link, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $temp = array(
                        "id" => $row["id"],
                        "user_id" => $row["user_id"],
                        "title" => $row["title"],
                        "datetime" => $row["datetime"],
                        "name" => $row["name"]
                    );
                    array_push($AllTitles, $temp);
                }

                mysqli_free_result($result);
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $AllTitles;
}

// 查詢特定文章的回文
function Query_One_Post_Details(string $_post_id)
{
    $AllPostDetails = array();
    $link = DB_Connect(); // 連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "SELECT post_detail.*, users.name FROM post_detail, users WHERE post_detail.user_id = users.id AND post_detail.post_id = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_post_id);

                $param_post_id = $_post_id;

                if (mysqli_stmt_execute($stmt) == true) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        mysqli_stmt_bind_result($stmt, $id, $post_id, $user_id, $message, $datetime, $name);
                        while (mysqli_stmt_fetch($stmt)) {
                            $temp = array(
                                "id" => $id,
                                "post_id" => $post_id,
                                "user_id" => $user_id,
                                "message" => $message,
                                "datetime" => $datetime,
                                "name" => $name
                            );
                            array_push($AllPostDetails, $temp);     
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        mysqli_close($link);
    }

    return $AllPostDetails; // 最終整個函式會丟出去 $AllPostDetails 變數
}
