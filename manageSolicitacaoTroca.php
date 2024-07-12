<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $atvd = addslashes($_GET["atvd"]);
    $idprop = addslashes($_GET["numprop"]);
    $tipoProd = addslashes($_GET["produto"]);

    if ($atvd == "aceitar") {
        aceitarTrocaProduto($conn, $tipoProd, $idprop);
    } else if ($atvd == "recusar") {
        recusarTrocaProduto($conn, $tipoProd, $idprop);
    }
} else {
    header("location: index");
    exit();
}
