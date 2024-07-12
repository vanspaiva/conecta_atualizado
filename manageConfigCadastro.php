<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    if (!empty($_GET)) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        if (!empty($_GET['deleteespec'])) {
            $id = $_GET['deleteespec'];
            deleteEspecialidade($conn, $id);
        }

        if (!empty($_GET['deleteestado'])) {
            $id = $_GET['deleteestado'];
            deleteEstado($conn, $id);
        }

        if (!empty($_GET['deleteconselho'])) {
            $id = $_GET['deleteconselho'];
            deleteConselho($conn, $id);
        }

        if (!empty($_GET['deletecadin'])) {
            $id = $_GET['deletecadin'];
            deleteCadin($conn, $id);
        }

        if (!empty($_GET['deletecadex'])) {
            $id = $_GET['deletecadex'];
            deleteCadex($conn, $id);
        }
    } else {
        header("location: gercadastro");
        exit();
    }
} else {
    header("location: index");
    exit();
}
