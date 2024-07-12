<?php
ob_start();

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';


    $propid = addslashes($_POST["propid"]);
    $useruid = addslashes($_POST["useruid"]);
    $datacriacao = addslashes($_POST["datacriacao"]);

    $isstored1 = addslashes($_POST["isstored11"]);
    $filename1 = addslashes($_POST["filename11"]);
    $filesize1 = addslashes($_POST["filesize11"]);
    $fileuuid1 = addslashes($_POST["fileuuid11"]);
    $cdnurl1 = addslashes($_POST["cdnurl11"]);
    if (empty($_POST['filename11'])) {
        $envioTC = "false";
    } else {
        $envioTC = "true";
    }

    $isstored2 = addslashes($_POST["isstored22"]);
    $filename2 = addslashes($_POST["filename22"]);
    $filesize2 = addslashes($_POST["filesize22"]);
    $fileuuid2 = addslashes($_POST["fileuuid22"]);
    $cdnurl2 = addslashes($_POST["cdnurl22"]);
    if (empty($_POST['filename22'])) {
        $envioRelatorio = "false";
    } else {
        $envioRelatorio = "true";
    }

    $isstored3 = addslashes($_POST["isstored3"]);
    $filename3 = addslashes($_POST["filename3"]);
    $filesize3 = addslashes($_POST["filesize3"]);
    $fileuuid3 = addslashes($_POST["fileuuid3"]);
    $cdnurl3 = addslashes($_POST["cdnurl3"]);

    $isstored4 = addslashes($_POST["isstored4"]);
    $filename4 = addslashes($_POST["filename4"]);
    $filesize4 = addslashes($_POST["filesize4"]);
    $fileuuid4 = addslashes($_POST["fileuuid4"]);
    $cdnurl4 = addslashes($_POST["cdnurl4"]);

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // echo "Envio TC: ";
    // print_r($envioTC);
    // echo "<br>";
    // echo "Envio Relatorio: ";
    // print_r($envioRelatorio);
    // echo "</pre>";

    // exit();

    newReenvioTc($conn, $propid, $useruid, $datacriacao, $isstored1, $filename1, $filesize1, $fileuuid1, $cdnurl1, $isstored2, $filename2, $filesize2, $fileuuid2, $cdnurl2, $isstored3, $filename3, $filesize3, $fileuuid3, $cdnurl3, $isstored4, $filename4, $filesize4, $fileuuid4, $cdnurl4, $envioTC, $envioRelatorio);
} else {
    header("location: ../reenviotc");
    exit();
}
