<?php

if (isset($_POST["submit"])) {

    $coment = addslashes($_POST["coment-txt"]);
    $nped = addslashes($_POST["nped"]);
    $user = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentVisualizer($conn, $coment, $nped, $user);
} else {
    header("location: ../unit?id=".$nped);
    exit();
}
