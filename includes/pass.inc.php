<?php

if(isset($_POST["submit"]))
{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';



    if (empty($_POST['email']))
    {
        header("location: ../password.php?error=emptyinput");
        exit();
    }

    $email = addslashes($_POST["email"]);

    newPassword($conn, $email);

}
else
{
    header("location: ../login");
    exit();
}

