<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    if (!empty($_GET)) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        if (!empty($_GET['deletestatus'])) {
            $id = $_GET['deletestatus'];
            deleteStatusAgenda($conn, $id);
        }

        if (!empty($_GET['deletefeedback'])) {
            $id = $_GET['deletefeedback'];
            deleteFeedbackAgenda($conn, $id);
        }

        if (!empty($_GET['deleteresponsavel'])) {
            $id = $_GET['deleteresponsavel'];
            deleteResponsavelAgenda($conn, $id);
        }

        if (!empty($_GET['deletehorario'])) {
            $id = $_GET['deletehorario'];
            deleteHorario($conn, $id);
        }

        if (!empty($_GET['deleteproduto'])) {
            $id = $_GET['deleteproduto'];
            deleteproduto($conn, $id);
        }
    } else {
        header("location: gerenciamento-agenda");
        exit();
    }
} else {
    header("location: index");
    exit();
}
