<?php
session_start();
if (isset($_GET['id'])) {

    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Financeiro'))) {
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $id = addslashes($_GET['id']);
        $type = addslashes($_GET['type']);

        aceiteProp($conn, $id, $type);
    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}
