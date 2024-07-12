<?php
session_start();
if (isset($_POST["update"])) {

    $casoId = addslashes($_POST['casoId']);
    $numped = addslashes($_POST['numped']);
    $nomedr = addslashes($_POST['nomedr']);
    $nomepac = addslashes($_POST['nomepac']);
    $tipoproduto = addslashes($_POST['tipoproduto']);
    $tecnico = addslashes($_POST['tecnico']);
    $loteop = addslashes($_POST["loteop"]);

    if (empty($_POST["especificacao"])) {
        $especificacao = NULL;
    } else {
        $especificacao = addslashes($_POST['especificacao']);
    }

    if (empty($_POST["observacao"])) {
        $observacao = null;
    } else {
        $observacao = addslashes($_POST['observacao']);
    }


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    $data = array(
        'pedido' => $numped
    );

    $caso = array(
        'casoId' => $casoId,
        'numped' => $numped,
        'nomedr' => $nomedr,
        'nomepac' => $nomepac,
        'tipoproduto' => $tipoproduto,
        'tecnico' => $tecnico,
        'especificacao' => $especificacao,
        'observacao' => $observacao,
        'loteop' => $loteop
    );

    editCaso($conn, $caso);
} else if (isset($_POST["mudarstatus"])) {

    $casoId = addslashes($_POST['casoId']);
    $ped = addslashes($_POST['ped']);
    $status = addslashes($_POST['status']);

    if (empty($_POST["documentos"])) {
        $documentos = 'fechado';
    } else {
        $documentos = addslashes($_POST['documentos']);
    }

    if (empty($_POST["agenda"])) {
        $agenda = 'fechado';
    } else {
        $agenda = addslashes($_POST['agenda']);
    }

    if (empty($_POST["aceite"])) {
        $aceite = 'fechado';
    } else {
        $aceite = addslashes($_POST['aceite']);
    }

    if (empty($_POST["relatorio"])) {
        $relatorio = 'fechado';
    } else {
        $relatorio = addslashes($_POST['relatorio']);
    }

    if (empty($_POST["visualizacao"])) {
        $visualizacao = 'fechado';
    } else {
        $visualizacao = addslashes($_POST['visualizacao']);
    }

    if (empty($_POST["andamento"])) {
        $andamento = 'ABERTO';
    } else {
        $andamento = addslashes($_POST['andamento']);
    }

    if (empty($_POST["docsfaltantes"])) {
        $docsfaltantes = null;
    } else {
        $docsfaltantes = addslashes($_POST['docsfaltantes']);
    }

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $dataStatus = array(
        'casoId' => $casoId,
        'numped' => $ped,
        'status' => $status,
        'documentos' => $documentos,
        'agenda' => $agenda,
        'aceite' => $aceite,
        'relatorio' => $relatorio,
        'visualizacao' => $visualizacao,
        'andamento' => $andamento,
        'docsfaltantes' => $docsfaltantes
    );

    editStatusCaso($conn, $dataStatus);
} else {
    header("location: ../lista-casos");
    exit();
}
