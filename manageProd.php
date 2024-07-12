<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    
    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);

    deleteProd($conn, $id);
} else {
    header("location: index");
    exit();
}
