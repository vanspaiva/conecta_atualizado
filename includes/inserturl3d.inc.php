<?php

if (isset($_POST["update"])) {

    $url3d = addslashes($_POST["url3d"]);
    $url3d2 = addslashes($_POST["url3d2"]);
    $nped = addslashes($_POST["nped"]);
    $user = addslashes($_POST["user"]);
    $isstored1 = addslashes($_POST['isstored1']);
    $filename1 = addslashes($_POST['filename1']);
    $filesize1 = addslashes($_POST['filesize1']);
    $fileuuid1 = addslashes($_POST['fileuuid1']);
    $urlvideo = addslashes($_POST['cdnurl1']);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editUrl3d($conn, $url3d, $nped, $user, $url3d2, $urlvideo);
} else {
    header("location: ../unit");
    exit();
}
