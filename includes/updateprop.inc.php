<?php
ob_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST["update"])) {

    $id = addslashes($_POST["propid"]);
    // $empresa = addslashes($_POST["empresa"]);
    $status = addslashes($_POST["status"]);
    $nomedr = addslashes($_POST["nomedr"]);
    $crm = addslashes($_POST["crm"]);
    $telefone = addslashes($_POST["telefone"]);
    $emaildr = addslashes($_POST["emaildr"]);
    $emailenvio = addslashes($_POST["emailenvio"]);
    $nomepac = addslashes($_POST["nomepac"]);
    $convenio = addslashes($_POST["convenio"]);
    $tipoProd = addslashes($_POST["tipoProd"]);
    $validade = addslashes($_POST["validade"]);
    $ufProp = addslashes($_POST["ufProp"]);
    $representante = addslashes($_POST["representante"]);
    $usercriacao = addslashes($_POST['userCriador']);

    if (empty($_POST["empresa"])) {
        $empresa = null;
    } else {
        $empresa = addslashes($_POST["empresa"]);
    }

    if (empty($_POST["pedido"])) {
        $pedido = null;
    } else {
        $pedido = addslashes($_POST["pedido"]);
    }


    if (empty($_POST["listaIdsItens"])) {
        $listaIdsItens = null;
    } else {
        $listaIdsItens = addslashes($_POST["listaIdsItens"]);
    }

    if (empty($_POST["listaItens"])) {
        $listaItens = null;
    } else {
        $listaItens = addslashes($_POST["listaItens"]);
    }

    if (empty($_POST["listaValoresItens"])) {
        $listaValoresItens = null;
    } else {
        $listaValoresItens = addslashes($_POST["listaValoresItens"]);
    }

    if (empty($_POST["planovendas"])) {
        $planovendas = null;
    } else {
        $planovendas = addslashes($_POST["planovendas"]);
    }

    if (empty($_POST["listaQtdsItens"])) {
        $listaQtdsItens = null;
    } else {
        $listaQtdsItens = addslashes($_POST["listaQtdsItens"]);
    }

    if (empty($_POST["valorTotalItens"])) {
        $valorTotalItens = null;
    } else {
        $valorTotalItens = addslashes($_POST["valorTotalItens"]);
    }

    //removido valor parafuso

    if (empty($_POST["valorTotal"])) {
        $valorTotal = null;
    } else {
        $valorTotal = addslashes($_POST["valorTotal"]);
    }

    if (empty($_POST["valorDesconto"])) {
        $valorDesconto = null;
    } else {
        $valorDesconto = addslashes($_POST["valorDesconto"]);
    }

    if (empty($_POST["valorTotalPosDesconto"])) {
        $valorTotalPosDesconto = null;
    } else {
        $valorTotalPosDesconto = addslashes($_POST["valorTotalPosDesconto"]);
    }

    editProp($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $tipoProd, $validade, $ufProp, $representante, $pedido, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens, $planovendas, $valorTotalItens, $valorTotal, $valorDesconto, $valorTotalPosDesconto);
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
