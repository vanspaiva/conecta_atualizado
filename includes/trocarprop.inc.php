<?php

if (isset($_POST["submituser"])) {

    $propid = addslashes($_POST["propid"]);
    $novousuario = addslashes($_POST["novousuario"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    changeAuthor($conn, $propid, $novousuario);
    
} else {
    header("location: ../update-proposta?id=" . $propid);
    exit();
}
