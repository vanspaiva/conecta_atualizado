<?php
if (isset($_POST["update"])) {

    $agdId = addslashes($_POST['agdId']);
    

    if (empty($_POST["status"])) {
        $status = null;
    } else { 
        $status = addslashes($_POST['status']);
    }

    if (empty($_POST["feedback"])) {
        $feedback = null;
    } else { 
        $feedback = addslashes($_POST['feedback']);
    }

    if (empty($_POST["responsavel"])) {
        $responsavel = null;
    } else { 
        $responsavel = addslashes($_POST['responsavel']);
    }
    


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    updateAgendaFromGer($conn, $agdId, $status, $feedback, $responsavel);
    
} else {
    header("location: ../lista-casos");
    exit();
}
