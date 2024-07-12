<?php
if (isset($_POST["new"])) {

    // $usersid = addslashes($_POST["usersid"]);
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $telefone = addslashes($_POST["telefone"]);
    $aprov = addslashes($_POST["aprov"]);
    $perm = addslashes($_POST["perm"]);    
    $pwd = addslashes($_POST["pwd"]);    

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createNewUserAdm($conn, $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $pwd);
} else {
    header("location: ../users");
    exit();
}
