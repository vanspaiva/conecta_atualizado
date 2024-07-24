<?php

/* echo "<pre>";
print_r($_POST);
echo "</pre>";
exit(); */

if (isset($_POST["update"])) {

    $statustc = addslashes($_POST['statustc']);
    $id = addslashes($_POST['propid']);

    if (empty($_POST["textReprov"])) {
        $textReprov = null;
    } else {
        $textReprov = addslashes($_POST['textReprov']);
    }

    if (empty($_POST["projetista"])) {
        $projetista = null;
    } else {
        $projetista = addslashes($_POST['projetista']);
    }

    $filename1 = addslashes($_POST["filename1"]);
    $cdnurl1 = addslashes($_POST["cdnurl1"]);

    $filename2 = addslashes($_POST["filename2"]);
    $cdnurl2 = addslashes($_POST["cdnurl2"]);

    $arquivos = array();

    if (!empty($_POST["tcCheck"])) {
        $tcCheck = addslashes($_POST["tcCheck"]);
        array_push($arquivos, $tcCheck);
    } else {
        $tcCheck = null;
    }

    if (!empty($_POST["laudoCheck"])) {
        $laudoCheck = addslashes($_POST["laudoCheck"]);
        array_push($arquivos, $laudoCheck);
    } else {
        $laudoCheck = null;
    }

    if (!empty($_POST["modeloCheck"])) {
        $modeloCheck = addslashes($_POST["modeloCheck"]);
        array_push($arquivos, $modeloCheck);
    } else {
        $modeloCheck = null;
    }

    if (!empty($_POST["imagemCheck"])) {
        $imagemCheck = addslashes($_POST["imagemCheck"]);
        array_push($arquivos, $imagemCheck);
    } else {
        $imagemCheck = null;
    }


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if($textReprov != null){

        $nprop = addslashes($_POST["nprop2"]);
        $user = addslashes($_POST["user2"]);
        addComentProp($conn, $textReprov, $nprop, $user);

    }

    //uploadArquivoRefTC($conn, $tnameA, $pnameA, $tnameB, $pnameB, $id);

    editPropPlan($conn, $id, $statustc, $textReprov, $projetista, $filename1, $cdnurl1, $filename2, $cdnurl2, $arquivos);
} else {
    header("location: ../planejamento");
    exit();
}
