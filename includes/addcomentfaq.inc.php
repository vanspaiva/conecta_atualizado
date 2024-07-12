<?php

if (isset($_POST["submit"])) {

    $coment = addslashes($_POST["coment-txt"]);
    $nfaq = addslashes($_POST["nfaq"]);
    $user = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentForum($conn, $coment, $nfaq, $user);
} else {
    header("location: ../q?id=".$nfaq);
    exit();
}
