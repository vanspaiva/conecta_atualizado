<?php
if (isset($_POST["update"])) {

    $propid = addslashes($_POST["propid"]);
    $dataex = addslashes($_POST["dataex"]);
    $radioCheck = addslashes($_POST["radioCheck"]);

    $arquivos = array();

    if (!empty($_POST["arquivo1"])) {
        $arquivo1 = addslashes($_POST["arquivo1"]);
        array_push($arquivos, $arquivo1);
    } else {
        $arquivo1 = null;
    }

    if (!empty($_POST["arquivo2"])) {
        $arquivo2 = addslashes($_POST["arquivo2"]);
        array_push($arquivos, $arquivo2);
    } else {
        $arquivo2 = null;
    }

    if (!empty($_POST["arquivo3"])) {
        $arquivo3 = addslashes($_POST["arquivo3"]);
        array_push($arquivos, $arquivo3);
    } else {
        $arquivo3 = null;
    }

    if (!empty($_POST["arquivo4"])) {
        $arquivo4 = addslashes($_POST["arquivo4"]);
        array_push($arquivos, $arquivo4);
    } else {
        $arquivo4 = null;
    }


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    atualizarDataExameQualidade($conn, $propid, $dataex);
    notificarFaltaArquivos($conn, $propid, $arquivos);

} else {
    header("location: ../planejamento");
    exit();
}
