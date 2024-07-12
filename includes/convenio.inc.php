<?php


if (isset($_POST["submit"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createConvenio($conn, $nome);

} else if (isset($_POST["update"])) {
    
    $id = addslashes($_POST["convId"]);
    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editConvenio($conn, $id, $nome);

} else{
    header("location: ../convenios");
    exit();
} 