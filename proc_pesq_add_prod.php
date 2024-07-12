<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$cdg = $_POST['cdg'];
$idprop = $_POST['idprop'];

//insere os itens na lista e na proposta

$searchProd = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $cdg . "';");

while ($rowProd = mysqli_fetch_array($searchProd)) {

    $itemCdg =  $rowProd['prodCodCallisto'];
    $itemValor = $rowProd['prodPreco'];
    $itemAnvisa = $rowProd['prodAnvisa'];
    $itemQtd = 1;
    $itemNome = $rowProd['prodDescricao'];
    $imposto = $rowProd['prodImposto'];

    if (empty($rowProd['prodParafuso'])) {
        $itemQtdParafuso = null;
    } else {
        $itemQtdParafuso = $rowProd['prodParafuso'];
    }


    registrarItensProp($conn, $itemCdg, $itemValor, $itemAnvisa, $itemQtd, $itemNome, $idprop, $imposto);
}

$searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idprop . "';");
while ($rowProp = mysqli_fetch_array($searchProp)) {
    $listaitens =  $rowProp['propListaItens'];
}

$listaitens = $listaitens . ',' . $cdg;

$sql = "UPDATE propostas SET propListaItens='$listaitens' WHERE propId ='$idprop'";

if (mysqli_query($conn, $sql)) {
    header("location: ../update-proposta?id=" . $idprop);
} else {
    header("location: ../update-proposta?id=" . $idprop . "?error=stmfailed");
}

mysqli_close($conn);
header("location: ../update-proposta?id=" . $idprop);
