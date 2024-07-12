<?php
session_start();
if (isset($_GET["confirm"])) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Marketing'))) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $confirm = addslashes($_GET["confirm"]);
        if (!empty($_GET["confirm"])) {
            deleteListaAlunos($conn);
        } else {
            header("location: certificados");
            exit();
        }
    } else {
        header("location: certificados");
        exit();
    }
} else {
    header("location: certificados");
    exit();
}
