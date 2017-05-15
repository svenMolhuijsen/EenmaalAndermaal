<?php

function executeQuery($query, $data = []){
    global $pdo;

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("$query");
        $stmt->execute($data);
        $found = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($found) == 0) {
            return ['status' => 'error', 'code' => 1, 'message' => "Geen records gevonden"];
        } else {
            return ['status' => 'success', 'code' => 0, 'message' => count($found) . " record(s) gevonden", 'data' => $found];
        }
    } catch (PDOException $e) {
        return ['status' => 'error', 'code' => 2, 'message' => "Er ging iets fout bij uitvoeren van query: " . $query . $e->getMessage()];
    }
}
?>

