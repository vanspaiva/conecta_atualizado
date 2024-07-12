<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {

    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    if (!empty($_GET['deleteemail'])) {
        $id = addslashes($_GET['deleteemail']);
        deleteEmailNotification($conn, $id);
    }

    if (!empty($_GET['deletewpp'])) {
        $id = addslashes($_GET['deletewpp']);
        deleteWppNotification($conn, $id);
    }

    if (!empty($_GET['deletebd'])) {
        $id = addslashes($_GET['deletebd']);
        deleteBDNotificacao($conn, $id);
    }

    if (!empty($_GET['deletemarcador'])) {
        $id = addslashes($_GET['deletemarcador']);
        deleteMarcadorNotificacao($conn, $id);
    }
} else {
    header("location: index");
    exit();
}
