<?php
session_start();
if (isset($_POST["submit"])) {

    $coment = addslashes($_POST["coment"]);
    $nped = addslashes($_POST["nped"]);
    $user = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentCaso($conn, $coment, $nped, $user);

    $hashedPED = hashItemNatural($nped);

    header("location: ../unit?id=" . $hashedPED . "&error=sentcoment");
    exit();
} else {
    header("location: ../unit?id=" . $hashedPED . "&error=errorcoment");
    exit();
}
