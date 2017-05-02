<?php
require 'php/include/DBControl.php';
require 'php/include/DBConnection.php';
require 'php/include/formValidator.php';

if(true){
    $productId = stripInput($_POST["productId"]);
    if(checkForEmpty($_POST["productId"])){
        connectToDatabase();

        $product = selectRecords("SELECT * FROM veiling WHERE veilingId = $productId")->fetch();
    }
}
?>