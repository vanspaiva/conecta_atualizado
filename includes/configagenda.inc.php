<?php


if (isset($_POST["novostatus"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addStatusAgenda($conn, $nome);

} else if (isset($_POST["novofeedback"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addFeedbackAgenda($conn, $nome);

}else if (isset($_POST["novoresponsavel"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addResponsavelAgenda($conn, $nome);

} else if (isset($_POST["novohorario"])) {

    $cdg = addslashes($_POST['cdg']);
    $horario = addslashes($_POST['horario']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addHorario($conn, $cdg, $horario);

}else if (isset($_POST["novoproduto"])) {

    $nome = addslashes($_POST['nome']);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addProdutoAgenda($conn, $nome);

} else{
    header("location: ../gerenciamento-agenda");
    exit();
} 

