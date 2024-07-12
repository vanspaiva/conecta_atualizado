<?php

if (isset($_POST["update"])) {

    $user = addslashes($_POST["user"]);
    $nped = addslashes($_POST["nped"]);
    $isstored = addslashes($_POST["isstored11"]);
    $filename = addslashes($_POST["filename11"]);
    $filesize = addslashes($_POST["filesize11"]);
    $fileuuid = addslashes($_POST["fileuuid11"]);
    $cdnurl = addslashes($_POST["cdnurl"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';



    sendArquivoUpload($conn, $user, $nped, $filename, $fileuuid, $cdnurl);
} else {
    header("location: ../unit");
    exit();
}
