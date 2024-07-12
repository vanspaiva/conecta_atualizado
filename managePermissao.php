<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {

    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);

    excluirPermissoesExtras($conn, $id);
    header("location: gerusuarios");

} else if (isset($_POST["salvarnovo"])) {

    // print_r($_POST);

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $user = addslashes($_POST['usuario']);
    $codigo = addslashes($_POST['codigo']);
    $descricao = addslashes($_POST['descricao']);

    adicionarPermissoesExtras($conn, $user, $codigo, $descricao);
    header("location: gerusuarios");

} else if (isset($_POST["update"])) {

    // print_r($_POST);
    // exit();

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $user = addslashes($_POST['usuario']);
    $codigo = addslashes($_POST['codigo']);
    $descricao = addslashes($_POST['descricao']);
    $id = addslashes($_POST['id']);

    atualizarPermissoesExtras($conn, $user, $codigo, $descricao, $id);

    header("location: gerusuarios");

} else {

    header("location: index");
    exit();

}
