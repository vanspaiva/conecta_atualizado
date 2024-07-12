<?php
if (isset($_POST["new"])) {

    
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $telefone = addslashes($_POST["telefone"]);
    $cnpj = addslashes($_POST["cnpj"]);
    $empresa = addslashes($_POST["empresa"]);    
    $pwd = addslashes($_POST["pwd"]);    

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createNewUserComercial($conn, $nome, $uf, $email, $uid, $celular, $telefone, $cnpj, $empresa, $pwd);
} else {
    header("location: ../users");
    exit();
}
