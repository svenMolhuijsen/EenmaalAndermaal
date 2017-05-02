<?php
$hostname = "localhost"; 	    //Naam van de Server
$dbname = "EenmaalAndermaal";   //Naam van de Database
$username = "sa";      			//Inlognaam
$pw = "123";      			    //Password


function connectToDatabase(){
    global $pdo;
    $pdo = new PDO ("sqlsrv:Server=$hostname;Database=$dbname", "$username", "$pw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
