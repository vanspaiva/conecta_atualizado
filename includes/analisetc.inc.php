<?php
if (isset($_POST["submit"])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $user = addslashes($_POST['user']);
    $numprop = addslashes($_POST['numprop']);
    $checklist = addslashes($_POST['checklist']);
    $resultado = addslashes($_POST['resultado']);

    if (empty($_POST["resultado"])) {
        $resultado = "Reprovado";
    } else {
        $resultado = addslashes($_POST['resultado']);
    }

    if (empty($_POST["declaracao"])) {
        $declaracao = null;
    } else {
        $declaracao = addslashes($_POST['declaracao']);
    }

    if (empty($_POST["comentario"])) {
        $comentario = null;
    } else {
        $comentario = addslashes($_POST['comentario']);
    }


    $data = array(
        'user' => $user,
        'numprop' => $numprop,
        'checklist' => $checklist,
        'resultado' => $resultado,
        'declaracao' => $declaracao,
        'comentario' => $comentario
    );


    createAnaliseTC($conn, $data);
} else if (isset($_POST["salvar"])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $user = addslashes($_POST['user']);
    $numprop = addslashes($_POST['numprop']);
    $checklist = addslashes($_POST['checklist']);
    $resultado = addslashes($_POST['resultado']);

    if (empty($_POST["resultado"])) {
        $resultado = "Reprovado";
    } else {
        $resultado = addslashes($_POST['resultado']);
    }

    if (empty($_POST["declaracao"])) {
        $declaracao = null;
    } else {
        $declaracao = addslashes($_POST['declaracao']);
    }

    if (empty($_POST["comentario"])) {
        $comentario = null;
    } else {
        $comentario = addslashes($_POST['comentario']);
    }


    $data = array(
        'user' => $user,
        'numprop' => $numprop,
        'checklist' => $checklist,
        'resultado' => $resultado,
        'declaracao' => $declaracao,
        'comentario' => $comentario
    );


    createAnaliseTCCN($conn, $data);
} else {
    header("location: ../solicitacoes");
    exit();
}
