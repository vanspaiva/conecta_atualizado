<?php
if (isset($_POST["edit"])) {
    $oldnumber = addslashes($_POST["oldnumber"]);
    $newnumber = addslashes($_POST["newnumber"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editPedNumber($conn, $oldnumber, $newnumber);

} else {
    header("location: ../mudarpedido");
    exit();
}
