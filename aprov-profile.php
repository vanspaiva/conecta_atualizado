<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial')) {
    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);
    $nome = addslashes($_GET['nome']);
    $uid = addslashes($_GET['uid']);
    $email = addslashes($_GET['email']);
    $celular = addslashes($_GET['celular']);

    aprovUser($conn, $id, $nome, $uid, $email, $celular);
} else {
    header("location: index");
    exit();
}
