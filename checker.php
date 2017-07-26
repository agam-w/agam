<?php
require("init.php");
if(empty($_SESSION['user']))
{
    header("Location: login.php");
    die("Redirecting to login.php");
} else{
	$sql="SELECT count(*) as count FROM orders";
    $tutu = $db->query($sql);
    $data  = $tutu->fetch(PDO::FETCH_ASSOC);
	echo $data['count'];
}