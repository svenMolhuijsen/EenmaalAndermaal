<?php
require 'DBConnector.php';

function voegRecordToe($query, $data){
    global $pdo;

    try{
        $stmt = $pdo->prepare("$query");
        $stmt->execute($data);

    }
    catch (PDOException $e) {
        echo "Could not execute query: ".$query.$e->getMessage();
    }
}

function selectRecords($query){
    global $pdo;
    try {
        $data = $pdo->query("$query");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $data;
    }
    catch (PDOException $e) {
        echo "Could not execute query: ".$query.$e->getMessage();
    }
}
?>