<?php
$hostname = "localhost"; 	            //Naam van de Server
$dbname = "EenmaalAndermaal";           //Naam van de Database
$username = "EenmaalAndermaalLogin";    //Inlognaam
$pw = "P@ssword1";                      //Password

$pdo = new PDO("sqlsrv:Server=$hostname;Database=$dbname;ConnectionPooling=0", "$username", "$pw");
?>
