<?php

if (isset($_POST["add"])) {

    $rep = addslashes($_POST['rep']);
    $user = addslashes($_POST['user']);
    $email = addslashes($_POST['email']);
    $fone = addslashes($_POST['fone']);
    $uf = addslashes($_POST['uf']);
    $estado = addslashes($_POST['estado']);
    $regiao = addslashes($_POST['regiao']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addUfRep($conn, $rep, $user, $email, $fone, $uf, $estado, $regiao);
} else {
    header("location: ../representantes");
    exit();
}
