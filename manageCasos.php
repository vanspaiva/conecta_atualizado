<?php
session_start();
if (isset($_GET['id']) && isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);

    deleteCasos($conn, $id);
} else {
    header("location: casos");
    exit();
}
