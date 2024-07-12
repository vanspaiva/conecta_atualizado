<?php
if (isset($_POST["update"])) {

    $imgprodId = addslashes($_POST["imgprodId"]);
    $categoria = addslashes($_POST["categoria"]);
    $cdg = addslashes($_POST["cdg"]);
    $nome = addslashes($_POST["nome"]);
    $link = addslashes($_POST["link"]);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editImagem($conn, $imgprodId, $categoria, $cdg, $nome, $link);
    
} else {
    header("location: ../imagens-produtos");
    exit();
}
