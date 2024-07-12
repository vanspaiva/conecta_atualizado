<?php

if (isset($_POST["novostped"])) {

    $nome = addslashes($_POST["nome"]);
    $indexFluxo = addslashes($_POST["indexFluxo"]);
    $value = addslashes($_POST["value"]);
    $posicao = addslashes($_POST['posicao']);
    $andamento = addslashes($_POST['andamento']);
    $calcdtprazo = addslashes($_POST['calcdtprazo']);
    $corbg = addslashes($_POST['corbg']);
    $cortxt = addslashes($_POST['cortxt']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addStPedido($conn, $nome, $indexFluxo, $value, $posicao, $andamento, $calcdtprazo, $corbg, $cortxt);
} else if (isset($_POST["editstped"])) {

    $id = addslashes($_POST["editid"]);
    $nome = addslashes($_POST["editnome"]);
    $indexFluxo = addslashes($_POST["editindexFluxo"]);
    $value = addslashes($_POST["editvalue"]);
    $posicao = addslashes($_POST['editposicao']);
    $andamento = addslashes($_POST['editandamento']);
    $calcdtprazo = addslashes($_POST['editcalcdtprazo']);
    $corbg = addslashes($_POST['editcorbg']);
    $cortxt = addslashes($_POST['editcortxt']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editStPedido($conn, $nome, $indexFluxo, $value, $posicao, $andamento, $calcdtprazo, $corbg, $cortxt, $id);
} else if (isset($_POST["novodocs"])) {

    $nome = addslashes($_POST["nome"]);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addDocsFaltantes($conn, $nome);
} else {
    header("location: ../gerpedido");
    exit();
}
