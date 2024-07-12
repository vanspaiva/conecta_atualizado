<?php


if (isset($_POST["novaespecialidade"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addEspecialidade($conn, $nome);

} else if (isset($_POST["novoestado"])) {

    $nome = addslashes($_POST['nome']);
    $abrev = addslashes($_POST['abrev']);

   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addEstado($conn, $nome, $abrev);

}else if (isset($_POST["novoconselho"])) {

    $nome = addslashes($_POST['nome']);
    $abrev = addslashes($_POST['abrev']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addConselho($conn, $nome, $abrev);

} else if (isset($_POST["novocadin"])) {

    $nome = addslashes($_POST['nome']);
    $codigo = addslashes($_POST['codigo']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addCadin($conn, $nome, $codigo);

} else if (isset($_POST["novocadex"])) {

    $nome = addslashes($_POST['nome']);
    $codigo = addslashes($_POST['codigo']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addCadex($conn, $nome, $codigo);

} else{
    header("location: ../gercadastro");
    exit();
} 

