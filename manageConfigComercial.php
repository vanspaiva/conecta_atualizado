<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    if (!empty($_GET)) {
        ob_start();
        include("php/head_index.php");

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        if (!empty($_GET['deletestcom'])) {
            $id = $_GET['deletestcom'];
            deleteComercial($conn, $id);
        }

        if (!empty($_GET['deletestplan'])) {
            $id = $_GET['deletestplan'];
            deletePlanejamento($conn, $id);
        }

        if (!empty($_GET['deleteprod'])) {
            $id = $_GET['deleteprod'];
            deleteProdProp($conn, $id);
        }

        if (!empty($_GET['deleteadiant'])) {
            $id = $_GET['deleteadiant'];
            deleteAdiant($conn, $id);
        }

        if (!empty($_GET['deletefluxo'])) {
            $id = $_GET['deletefluxo'];
            deleteFluxo($conn, $id);
        }
        
        if (!empty($_GET['deletestrep'])) {
            $id = $_GET['deletestrep'];
            deleteStRepresentante($conn, $id);
        }
    } else {
        header("location: gercomercial");
        exit();
    }
} else {
    header("location: index");
    exit();
}
