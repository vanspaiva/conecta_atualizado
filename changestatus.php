<?php
session_start();
if (isset($_SESSION["useruid"]) && isset($_GET["id"])) {
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);
    $type = addslashes($_GET['st']);
    $user = $_SESSION["useruid"];

    if ($type == 'aprov') {
        aprovPedidoAntecipacao($conn, $id, $user);
    }
    if ($type == 'reprov') {
        reprovPedidoAntecipacao($conn, $id, $user);
    }
} else {
    header("location: index");
    exit();
}
