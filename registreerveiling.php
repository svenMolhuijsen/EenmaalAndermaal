<?php
include ("php/core.php");
/**
 * Created by PhpStorm.
 * User: Lukev
 * Date: 16-5-2017
 * Time: 13:27
 */

$titel = $_POST["titel"];
$beschrijving = $_POST["beschrijving"];
$startprijs =$_POST["startprijs"];
$einddatum = $_POST["einddatum"];
$provincie=$_POST["provincie"];
$postcode=$_POST["postcode"];
$plaatsnaam = $_POST["plaatsnaam"];
$straatnaam = $_POST["straat"];
$huisnummer=$_POST["huisnummer"];
$uberquery = executeQuery("INSERT INTO veiling(titel,beschrijving,startPrijs,eindDatum,provincie,postcode,plaatsnaam,straatnaam,huisnummer) VALUES(?,?,?,?,?,?,?,?,?)", [$titel,$beschrijving,$startprijs,$einddatum,$provincie,$postcode,$plaatsnaam,$straatnaam,$huisnummer]);
var_dump($uberquery);