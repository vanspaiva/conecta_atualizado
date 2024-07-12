<?php


if (isset($_POST["add"])) {

    $druid = addslashes($_POST['druid']);
    $user = addslashes($_POST['user']);


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addDrCadDist($conn, $druid, $user);

} else{
    header("location: ../meusdoutores");
    exit();
} 

