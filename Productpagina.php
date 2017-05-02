<?php
require 'php/include/DBControl.php';
require 'php/include/DBConnector.php';
require 'php/include/Validator.php';

if(true){
    $productId = stripInput($_POST["productId"]);
    if(checkForEmpty($_POST["productId"])){
        connectToDatabase();

        $product = selectRecords("SELECT * FROM veiling WHERE veilingId = $productId")->fetch();
    }
}
?>