<?php
if (isset($_POST["novoplano"])) {

    $nome = addslashes($_POST['nome']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addPlano($conn, $nome);

} else if (isset($_POST["novopgto"])) {

    $nome = addslashes($_POST['nome']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addPgto($conn, $nome);

} else if (isset($_POST["novostatus"])) {

    $nome = addslashes($_POST['nome']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addStatusFin($conn, $nome);

} else {
    header("location: ../gerfinanceiro");
    exit();
}
