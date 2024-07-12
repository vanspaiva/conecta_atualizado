<?php
if (isset($_POST["newlink"])) {
    $type = addslashes($_POST["type"]);
    $id = addslashes($_POST["id"]);
    $link = addslashes($_POST["link"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // print_r($type);
    // exit();
    switch ($type) {
        case "Qualidade":
            editLinkAdmQualidade($conn, $id, $link);
            break;
        case "Planejamento":
            editLinkAdm($conn, $id, $link);
            break;
        default:
            exit();
    }
} else {
    header("location: ../mudarsenha");
    exit();
}
