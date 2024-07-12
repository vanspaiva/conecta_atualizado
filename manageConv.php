<?php
session_start();
if (isset($_GET['id']) &&  isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);

    deleteConv($conn, $id);
} else {
    header("location: index");
    exit();
}
