<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    if (!empty($_GET)) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        if (!empty($_GET['deletestped'])) {
            $id = $_GET['deletestped'];
            deleteStPedido($conn, $id);
        }

        if (!empty($_GET['deletedocs'])) {
            $id = $_GET['deletedocs'];
            deleteDocsFaltantes($conn, $id);
        }

    } else {
        header("location: gerpedido");
        exit();
    }
} else {
    header("location: index");
    exit();
}
