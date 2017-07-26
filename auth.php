<?php
include("config.php");
$norfid = $_GET['noplat'];
//$norfid = $_GET['norfid'];
$mysqli = new mysqli('localhost','root','','send');
$hasil = $mysqli->query("
		SELECT noplat, ispaid, ido, volume FROM orders, tanki, owners WHERE orders.tanki_id = tanki.id AND orders.owner_id = owners.id AND orders.ispaid = '0' AND tanki.uid = '$norfid'"
	);
//var_dump($hasil); die();
if ($row = mysqli_fetch_array($hasil))
{
	echo "@".$row ['noplat']; 
	echo "@".$row['ispaid'];
	echo "@".$row['ido'];
	echo "@".$row['volume'];
	//print_r($row);
}
else {
	echo "@"."0";
	echo "@"."0";
	echo "@"."0";
	echo "@"."0";
}
?>