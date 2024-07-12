<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    if (!empty($_GET)) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        if (!empty($_GET['deleteplano'])) {
            $id = $_GET['deleteplano'];
            deletePlano($conn, $id);
        }

        if (!empty($_GET['deletepgto'])) {
            $id = $_GET['deletepgto'];
            deletePgto($conn, $id);
        }

        if (!empty($_GET['deletestatus'])) {
            $id = $_GET['deletestatus'];
            deleteStatusFin($conn, $id);
        }
    } else {
        header("location: gerfinanceiro");
        exit();
    }
} else {
    header("location: index");
    exit();
}
