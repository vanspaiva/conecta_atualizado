<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$arquivo = $_FILES['file'];
echo '<pre>';
print_r($arquivo);
echo '</pre>';

echo '<pre>';
print_r($_POST);
echo '</pre>';


if ($_POST['coment'] != "") {

    $coment = addslashes($_POST["coment"]);
    $nprop = addslashes($_POST["nprop"]);
    $user = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentProp($conn, $coment, $nprop, $user);

    if($_FILES['file']['size'] > 0){

        $arquivo = $_FILES['file'];
        $numeroProp = $_POST['nprop'];
        
        if ($_POST['coment'] != "") {
    
            $nprop = addslashes($_POST["nprop"]);
    
            $sql = "SELECT * FROM `comentariosproposta` WHERE comentVisNumProp = $nprop ORDER BY comentVisHorario DESC LIMIT 1;";
    
            if($result = mysqli_query($conn, $sql)){
    
                $row = mysqli_fetch_assoc($result);
    
                $numeroComentario = $row['comentVisId'];
    
                //echo "NUMERO DO COMENTARIO: $numeroComentario";
                //exit();
            }
    
        }
        
        enviarArquivo($numeroProp, $arquivo['error'], $arquivo['name'], $arquivo['tmp_name'], $user, 0 , $numeroComentario);
    }
    
    header("location: ../update-plan?id=" . $nprop . "&error=sent");
    exit();
} else {

    $nprop = addslashes($_POST["nprop"]);
    $user = addslashes($_POST["user"]);

    if($_FILES['file']['size'] > 0){

        $arquivo = $_FILES['file'];
        $numeroProp = $_POST['nprop'];
        
        if ($_POST['coment'] != "") {
    
            $nprop = addslashes($_POST["nprop"]);
    
            $sql = "SELECT * FROM `comentariosproposta` WHERE comentVisNumProp = $nprop ORDER BY comentVisHorario DESC LIMIT 1;";
    
            if($result = mysqli_query($conn, $sql)){
    
                $row = mysqli_fetch_assoc($result);
    
                $numeroComentario = $row['comentVisId'];

            }
            enviarArquivo($numeroProp, $arquivo['error'], $arquivo['name'], $arquivo['tmp_name'],$user, 0 , $numeroComentario);
        }
        else{
            enviarArquivo($numeroProp, $arquivo['error'], $arquivo['name'], $arquivo['tmp_name'],$user);
            exit();
        }
    }

    header("location: ../update-plan?id=" . $nprop);
    exit();
}



