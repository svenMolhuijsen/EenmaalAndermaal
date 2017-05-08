<?php

function executeQuery($query, $data = [])
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("$query");
        $stmt->execute($data);
        $found = $stmt->fetchAll();
        if (count($found) == 0) {
            return ['status' => 'error', 'code' => 1, 'message' => "No records found"];
        } else {
            return ['status' => 'success', 'code' => 0, 'message' => count($found) . " record(s) found", 'data' => $found];
        }
    } catch (PDOException $e) {
        return ['status' => 'error', 'code' => 2, 'message' => "Could not execute query: " . $query . $e->getMessage()];
    }
}


var_dump(executeQuery("select * FROM landen where land = 'Nederland'"));
?>

