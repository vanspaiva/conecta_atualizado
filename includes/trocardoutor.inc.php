<?php

if (isset($_POST["submit"])) {

    $propid = addslashes($_POST["propid"]);
    $doutoruid = addslashes($_POST["doutoruid"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    changeDoutor($conn, $propid, $doutoruid);
} else {
    header("location: ../update-proposta?id=" . $propid);
    exit();
}
