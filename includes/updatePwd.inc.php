<?php
if (isset($_POST["newpwd"])) {

    $pwd = addslashes($_POST["pwd"]);
    $confirmpwd = addslashes($_POST["confirmpwd"]);
    $user = addslashes($_POST["user"]);
    

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editPwd($conn, $user, $pwd, $confirmpwd);
} else {
    header("location: ../index");
    exit();
}
