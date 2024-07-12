<?php ob_start();
if (isset($_POST["submit"])) {

    $txtcoment = addslashes($_POST['txtcoment']);
    $idprop = addslashes($_POST['idprop']);
    // $newdata = addslashes($_POST['newdata']);
    // $newdataanvdr = addslashes($_POST['newdataanvdr']);
    // $newdataanvpac = addslashes($_POST['newdataanvpac']);
    $ntransacao = addslashes($_POST['ntransacao']);
    $nexpedicao = addslashes($_POST['nexpedicao']);
    $status = addslashes($_POST['status']);

    // print_r($_POST);
    // exit;

    if (empty($_POST["txtcoment"])) {
        $txtcoment = null;
    } else {
        $txtcoment = addslashes($_POST["txtcoment"]);
    }

    if (empty($_POST["newdata"])) {
        $newdata = null;
    } else {
        $newdata = addslashes($_POST["newdata"]);
    }

    if (empty($_POST["newdataanvdr"])) {
        $newdataanvdr = null;
    } else {
        $newdataanvdr = addslashes($_POST["newdataanvdr"]);
    }

    if (empty($_POST["newdataanvpac"])) {
        $newdataanvpac = null;
    } else {
        $newdataanvpac = addslashes($_POST["newdataanvpac"]);
    }

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    newCommentLaudo($conn, $idprop, $txtcoment, $newdata, $newdataanvdr, $newdataanvpac, $ntransacao, $nexpedicao, $status);
} else {
    header("location: ../laudos");
    exit();
}
