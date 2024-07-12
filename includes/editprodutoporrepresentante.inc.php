<?php

if (isset($_POST["submit"])) {

    $tipoProd = addslashes($_POST["tipoProd"]);
    $idproposta = addslashes($_POST["idproposta"]);
    $userSolicitante = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createSolicitacaoTrocaProduto($conn, $tipoProd, $idproposta, $userSolicitante);
    
} else {
    header("location: ../dados_proposta?id=". $idproposta);
    exit();
}
