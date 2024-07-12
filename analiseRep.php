<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Representante'))) {

    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);
    $statustc = addslashes($_GET['tc']);

    changestatustc($conn, $id, $statustc);
    header("location: dados_proposta?id=" . $id);
} else {
    header("location: index");
    exit();
}
