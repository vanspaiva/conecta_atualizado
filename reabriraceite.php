<?php
 session_start();
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

//print_r($_GET['id']);

$id = addslashes($_GET['id']);

reabrirtc($conn, $id);

$pedId = getIdFromPed($conn, $id);
header("location: update-caso?id=" . $pedId . "&error=aceiteaberto");
exit();