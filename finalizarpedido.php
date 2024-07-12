<?php 
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Fábrica'))) {
    ob_start();

    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);
    $user = $_SESSION["useruid"];
    $dataAtual = hoje();

    finalizarPedido($conn, $id, $user, $dataAtual);
} else {
    header("location: index");
    exit();
}
