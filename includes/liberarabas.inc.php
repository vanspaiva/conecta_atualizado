<?php
session_start();

if (isset($_POST["liberaraba"])) {

    $casoId = addslashes($_POST['casoId']);
    $ped = addslashes($_POST['ped']);

    if (empty($_POST["documentos2"])) {
        $documentos = 'fechado';
    } else {
        $documentos = addslashes($_POST['documentos2']);
    }

    if (empty($_POST["agenda2"])) {
        $agenda = 'fechado';
    } else {
        $agenda = addslashes($_POST['agenda2']);
    }

    if (empty($_POST["aceite2"])) {
        $aceite = 'fechado';
    } else {
        $aceite = addslashes($_POST['aceite2']);
    }

    if (empty($_POST["relatorio2"])) {
        $relatorio = 'fechado';
    } else {
        $relatorio = addslashes($_POST['relatorio2']);
    }

    if (empty($_POST["visualizacao2"])) {
        $visualizacao = 'fechado';
    } else {
        $visualizacao = addslashes($_POST['visualizacao2']);
    }


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $abas = array(
        'casoId' => $casoId,
        'numped' => $ped,
        'documentos' => $documentos,
        'agendar' => $agenda,
        'aceite' => $aceite,
        'relatorios' => $relatorio,
        'visualizacao' => $visualizacao
    );

    liberarAbas($conn, $abas);

    header("location: ../update-caso?id=" . $casoId);
} else {
    header("location: ../update-caso?id=" . $_POST['casoId']);
    exit();
}
