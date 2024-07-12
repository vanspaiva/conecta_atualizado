<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Adm Comercial'))) {

    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);
    
    deleteEstadoRep($conn, $id);
} else {
    header("location: representantes");
    exit();
}
