<?php

if (isset($_POST["submit"])) {

    $nome = addslashes($_POST['nome']);
    $user = addslashes($_POST['user']);
    $tipoConta = addslashes($_POST['tipoConta']);
    $setor = addslashes($_POST['setor']);
    $status = "Em Análise";
    $assunto = addslashes($_POST['assunto']);
    $tipoTexto = "Melhoria";
    $texto = addslashes($_POST['textomelhoria']);

   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createForum($conn, $user, $tipoConta, $setor, $status, $assunto, $tipoTexto, $texto);

} else{
    header("location: ../sacconecta");
    exit();
} 