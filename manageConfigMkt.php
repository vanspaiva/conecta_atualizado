<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    if (!empty($_GET)) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        if (!empty($_GET['deleteaba'])) {
            $id = $_GET['deleteaba'];
            deleteAbaMidias($conn, $id);
        }

        if (!empty($_GET['deletesessao'])) {
            $id = $_GET['deletesessao'];
            deleteSessaoMidias($conn, $id);
        }

        if (!empty($_GET['deletematerial'])) {
            $id = $_GET['deletematerial'];
            deleteMaterialMidias($conn, $id);
        }
    } else {
        header("location: cadastromidias");
        exit();
    }
} else {
    header("location: index");
    exit();
}
