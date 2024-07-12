<?php


if (isset($_POST["submit"])) {
    $categoria = addslashes($_POST["categoria"]);
    $cdg = addslashes($_POST["cdg"]);
    $descricao = addslashes($_POST["descricao"]);
    $descricaoAnvisa = addslashes($_POST["descricaoAnvisa"]);
    $parafusos = addslashes($_POST["parafusos"]);
    $anvisa = addslashes($_POST["anvisa"]);
    $preco = addslashes($_POST["preco"]);
    $codPropPadrao = addslashes($_POST["codPropPadrao"]);
    $kitdr = addslashes($_POST["kitdr"]);
    $txtOP = addslashes($_POST["txtOP"]);
    $txtAcompanha = addslashes($_POST["txtAcompanha"]);

    if (empty($_POST['imposto'])) {
        $imposto = null;
    } else {
        $imposto = addslashes($_POST["imposto"]);
    }

    $kitdr = htmlspecialchars($kitdr);
    $txtOP = htmlspecialchars($txtOP);
    $txtAcompanha = htmlspecialchars($txtAcompanha);




    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createProduto($conn, $categoria, $cdg, $descricao, $parafusos, $anvisa, $preco, $codPropPadrao, $kitdr, $txtOP, $txtAcompanha, $imposto, $descricaoAnvisa);
} else if (isset($_POST["update"])) {
    $categoria = addslashes($_POST["categoria"]);
    $cdg = addslashes($_POST["cdg"]);
    $descricao = addslashes($_POST["descricao"]);
    $descricaoAnvisa = addslashes($_POST["descricaoAnvisa"]);
    $parafusos = addslashes($_POST["parafusos"]);
    $anvisa = addslashes($_POST["anvisa"]);
    $preco = addslashes($_POST["preco"]);
    $codPropPadrao = addslashes($_POST["codPropPadrao"]);
    $kitdr = addslashes($_POST["kitdr"]);
    $txtOP = addslashes($_POST["txtOP"]);
    $txtAcompanha = addslashes($_POST["txtAcompanha"]);
    $id = addslashes($_POST["prodid"]);
    if (empty($_POST['imposto'])) {
        $imposto = null;
    } else {
        $imposto = addslashes($_POST["imposto"]);
    }

    $kitdr = htmlspecialchars($kitdr);
    $txtOP = htmlspecialchars($txtOP);
    $txtAcompanha = htmlspecialchars($txtAcompanha);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editProduto($conn, $categoria, $cdg, $descricao, $parafusos, $anvisa, $preco, $codPropPadrao, $kitdr, $txtOP, $txtAcompanha, $id, $imposto, $descricaoAnvisa);
} else {
    header("location: ../produtos");
    exit();
}
