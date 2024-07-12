<?php


if (isset($_POST["submit"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createSetor($conn, $nome);

} else if (isset($_POST["update"])) {
    
    $id = addslashes($_POST["setId"]);
    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editSetor($conn, $id, $nome);

} else{
    header("location: ../convenios");
    exit();
} 