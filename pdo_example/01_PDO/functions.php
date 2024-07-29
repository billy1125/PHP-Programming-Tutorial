<?php
// 資料庫連線，使用PDO的方式存取資料庫，更好懂，但建議你傳統的寫法別忘掉
function DB_Connect()
{
    // 資料庫連線基本設定
    $dbms = 'mysql';     //資料庫類型
    $host = 'localhost'; //資料庫位址
    $dbName = 'pdo_example'; //預設資料庫
    $user = 'root';      //帳號
    $pass = '';          //密碼
    $dsn = "$dbms:host=$host;dbname=$dbName";

    try {
        $pdo = new PDO($dsn, $user, $pass); // 建立資料庫連線
        $pdo->exec('SET CHARACTER SET utf8mb4');

        if ($pdo === false) {
            die("發生錯誤無法連線");
            exit;
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    return $pdo;
}

// 查詢所有學生
function Query_All_Students()
{
    $AllStudents = array(); // 由於學生資料可能不只一筆，所以我們用一個陣列來儲存
    $pdo = DB_Connect();    // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $sql = "SELECT id, name, gender FROM students";
            $statement = $pdo->query($sql); // 查詢Query的結果

            // PDO::FETCH_ASSOC 能夠把查詢的結果，依照欄位來取值
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                array_push($AllStudents, $row); // 透過迴圈將每一筆學生資料逐一放到 $AllStudents 陣列裡面
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO); // 關閉資料庫
    }

    return $AllStudents;
}

// 查詢特定學生的細節資料(使用參數綁定)
function Query_One_Student(string $_id)
{
    $Student = array();
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_id]; // 用一個簡單的陣列來綁定參數，有沒有比較簡單呢？
            $sql = "SELECT id, name, gender FROM students WHERE id = ?";
            $statement = $pdo->prepare($sql);

            // 判斷查詢指令有沒有成功
            if ($statement->execute($data)) {
                $Student = $statement->fetch(PDO::FETCH_ASSOC); // 將查詢結果存到 $Student
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $Student;
}

// 更新一個學生資料
function Update_One_Student(string $_name, string $_gender, string $_id)
{
    $UpdateResults = false;
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_name, $_gender, $_id];
            $sql = "UPDATE students SET name = ?, gender = ? WHERE id = ?";
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                $UpdateResults = true;
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $UpdateResults;
}

// 新增一個學生資料
function Insert_One_Student(string $_name, string $_gender)
{
    $InsertResults = false;
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_name, $_gender];
            $sql = "INSERT INTO students (name, gender) VALUE (?, ?)";
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                $InsertResults = true;
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $InsertResults;
}

// 刪除一個學生資料
function Delete_One_Student(string $_id)
{
    $DeleteResults = false;
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_id];
            $sql = "DELETE FROM students WHERE id = ?";
            // $sql = "UPDATE students SET del = 1 WHERE id = ?"; // 以欄位來標註是否刪除?
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                $DeleteResults = true;
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $DeleteResults;
}
