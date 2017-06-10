<?php

/**
 * @param String $query String van de query, zet "?" waar data hoort
 * @param array $data Data van de query
 * @return array Geeft het resultaat terug
 */
function executeQuery($query, $data = []){
    global $pdo;
    try {
        //Juiste errormode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Zet de query klaar voor gebruik en kijk of hij werkt
        $stmt = $pdo->prepare("$query");
        //Voer de query uit met de data
        $stmt->execute($data);
        //Splits alle rows op in een array
        $found = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($found) == 0) {
            return ['status' => 'error', 'code' => 1, 'message' => "Geen records gevonden"];
        }
        return ['status' => 'success', 'code' => 0, 'message' => count($found) . " record(s) gevonden", 'data' => $found];
    } catch (PDOException $e) {
        return ['status' => 'error', 'code' => 2, 'message' => "Er ging iets fout bij uitvoeren van query: " . $query . $e->getMessage()];
    }
}

//Hetzelfde als executeQuery, maar dan zonder fetch, zodat het geen resultaten ophaalt
function executeQueryNoFetch($query, $data = []){
    global $pdo;

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("$query");
        $stmt->execute($data);
        return ['status' => 'success', 'query' => $query, 'code' => 0, 'affected' => $stmt->rowCount()];
    } catch (PDOException $e) {
        return ['status' => 'error', 'code' => 2, 'message' => "Er ging iets fout bij uitvoeren van query: " . $query . " data: " . json_encode($data) . " " . $e->getMessage()];
    }
}
?>

