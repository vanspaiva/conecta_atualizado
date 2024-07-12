<?php


if (isset($_POST["novaaba"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addAbaMidias($conn, $nome);

} else if (isset($_POST["novasessao"])) {

    $nome = addslashes($_POST['nome']);
    $aba = addslashes($_POST['aba']);
    $icon = addslashes($_POST['icon']);
   

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addSessaoMidias($conn, $nome, $aba, $icon);

} else{
    header("location: ../gerenciamento-agenda");
    exit();
} 

