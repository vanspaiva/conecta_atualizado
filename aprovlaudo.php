<?php ob_start();
include("php/head_index.php");

require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade'))) {

    $id = addslashes($_GET['id']);
    $type = addslashes($_GET['type']);

    aprovlaudo($conn, $id, $type);
    
} else {
    header("location: index");
    exit();
}
