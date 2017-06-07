<?php
function valideerForm(){
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        return true;
    }
    return false;
}

function stripInput($input)
{
    for ($i = 0; $i < count($input); $i++) {
        $input[$i] = trim($input[$i]);
        $input[$i] = stripslashes($input[$i]);
        $input[$i] = htmlspecialchars($input[$i]);
    }
    return $input;
}

function checkCharacters($input){
    for ($i = 0; $i < count($input); $i++) {
        if (!preg_match("/^[a-zA-Z ]*$/", $input)) {
            return false;
        }
    }
    return true;
}

function checkForEmpty($toCheck){
    for ($i = 0; $i < count($toCheck); $i++){
        if (empty($toCheck[$i])){
            return false;
        }
    }
    return true;
}
?>