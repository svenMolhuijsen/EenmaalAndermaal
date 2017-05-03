<?php

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

function selectRecords($query, $data){
    global $pdo;

    try{
        $stmt = $pdo->prepare("$query");
        $stmt->execute($data);
        return $stmt;

    }
    catch (PDOException $e) {
        echo "Could not execute query: ".$query.$e->getMessage();
    }
}
?>