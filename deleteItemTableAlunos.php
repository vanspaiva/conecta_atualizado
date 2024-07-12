<?php
session_start();
if (isset($_GET["id"])) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Marketing'))) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $id = addslashes($_GET["id"]);

        deleteItemListaAlunos($conn, $id);
    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: certificados");
    exit();
}
