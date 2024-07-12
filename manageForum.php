<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    ob_start();

    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $id = addslashes($_GET['id']);
    if (addslashes($_GET['action']) == 'delete') {// delete
        deleteForum($conn, $id);
    } else if (addslashes($_GET['action']) == 'respondido') {// respondido
        respondidoForum($conn, $id);
    } else if (addslashes($_GET['action']) == 'resolvido') {// resolvido
        resolvidoForum($conn, $id);
    } else if (addslashes($_GET['action']) == 'fazer') {// fazer
        fazerForum($conn, $id);
    }  

} else {
    header("location: index");
    exit();
}
