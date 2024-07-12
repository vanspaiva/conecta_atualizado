<?php


if (isset($_POST["novostcom"])) {

    $nome = addslashes($_POST['nome']);
    $indexFluxo = addslashes($_POST['indexFluxo']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addstatuscomercial($conn, $nome, $indexFluxo);

}if (isset($_POST["novostplan"])) {

    $nome = addslashes($_POST['nome']);
    $indexFluxo = addslashes($_POST['indexFluxo']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addstatusPlanejamento($conn, $nome, $indexFluxo);

} if (isset($_POST["novoproduto"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addProdProp($conn, $nome);

} if (isset($_POST["novoadiant"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addStAdiantamento($conn, $nome);

} if (isset($_POST["novofluxo"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addStFluxo($conn, $nome);

} if (isset($_POST["novostrep"])) {

    $nome = addslashes($_POST['nome']);
    $indexFluxo = addslashes($_POST['indexFluxo']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addstatusrepresentante($conn, $nome, $indexFluxo);

} else{
    header("location: ../gercomercial");
    exit();
} 

