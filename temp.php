<?php
include 'config.php';
$ido = $_GET['ido'];

    $sql = "UPDATE orders SET ispaid = '1' WHERE ido = '$ido'";
    $dbh->exec($sql);

?>