<?php

if (isset($_POST["submitcoment"])) {

    $coment = addslashes($_POST["coment"]);
    $nprop = addslashes($_POST["nprop"]);
    $user = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentProp($conn, $coment, $nprop, $user);

    header("location: ../update-proposta?id=" . $nprop . "&error=sent");
    exit();
} else {
    header("location: ../update-proposta?id=" . $nprop);
    exit();
}
