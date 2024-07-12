<?php


if (isset($_POST["submit"])) {
    $categoria = addslashes($_POST['categoria']);
    $nomeimg = addslashes($_POST['nomeimg']);
    $cdg = addslashes($_POST['cdg']);
    $link = addslashes($_POST['link']);
    

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addImgProduto($conn, $categoria, $nomeimg, $cdg, $link);

} else if (isset($_POST["update"])) {
    
    

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // editProduto($conn, $categoria, $cdg, $descricao, $parafusos, $anvisa, $preco, $codPropPadrao, $kitdr, $txtCotacao, $txtAcompanha, $id);

} else{
    header("location: ../imagens-produtos");
    exit();
} 