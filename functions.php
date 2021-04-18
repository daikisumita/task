<?php

require_once __DIR__ . '/config.php';

function connectDb()
{
    try{
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    }catch (PDOException $e){
        echo $e->getMessage();
        exit;
    }
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


function insertTask($title)
{
    $dbh = connectDb();

    $sql = <<<EOM
    INSERT INTO
tasks
(title)
VALUES
(:title);
EOM;

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->execute();
}
function findTaskByStatus($status)
{
    $dbh = connectDb();

    $sql = <<<EOM
SELECT * FROM tasks WHERE status = :status;
EOM;

//プリペアドステータスのじゅんび
$stmt =$dbh->prepare($sql);

//バインドするパラメータの準備
$status = 'notyet';

$stmt->bindParam(':status', $status, PDO::PARAM_STR);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}