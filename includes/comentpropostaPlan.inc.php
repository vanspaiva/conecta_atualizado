<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';


//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

if ($_POST['coment'] != "") {

    $coment = addslashes($_POST["coment"]);
    $nprop = addslashes($_POST["nprop"]);
    $user = addslashes($_POST["user"]);
    $permission = addslashes($_POST['permission']);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentProp($conn, $coment, $nprop, $user);

    if(isset($_POST['fotofile'])){

        $arquivo = $_POST['fotofile'];
        $numeroProp = $_POST['nprop'];
        $permission = addslashes($_POST['permission']);
        
        if ($_POST['coment'] != "") {
    
            $nprop = addslashes($_POST["nprop"]);
    
            $sql = "SELECT * FROM `comentariosproposta` WHERE comentVisNumProp = $nprop ORDER BY comentVisHorario DESC LIMIT 1;";
    
            if($result = mysqli_query($conn, $sql)){
    
                $row = mysqli_fetch_assoc($result);
    
                $numeroComentario = $row['comentVisId'];
                $dataComentario = $row['comentVisHorario'];

    
                //echo "NUMERO DO COMENTARIO: $numeroComentario";
                //exit();
            }
    
        }
        
        enviarArquivo($numeroProp, $arquivo, $user, $permission, $dataComentario, $numeroComentario);
    }
    
    header("location: ../update-plan?id=" . $nprop . "&error=sent");
    exit();
} else {

    $nprop = addslashes($_POST["nprop"]);
    $user = addslashes($_POST["user"]);
    $permission = addslashes($_POST['permission']);

    if($_POST['fotofile']){

        $arquivo = $_POST['fotofile'];
        $numeroProp = $_POST['nprop'];
        
        if ($_POST['coment'] != "") {
    
            $nprop = addslashes($_POST["nprop"]);
    
            $sql = "SELECT * FROM `comentariosproposta` WHERE comentVisNumProp = $nprop ORDER BY comentVisHorario DESC LIMIT 1;";
    
            if($result = mysqli_query($conn, $sql)){
    
                $row = mysqli_fetch_assoc($result);
    
                $numeroComentario = $row['comentVisId'];
                $dataComentario = $row['comentVisHorario'];


            }
            enviarArquivo($numeroProp, $arquivo, $user, $permission,$dataComentario, $numeroComentario);
        }
        else{

            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = (new DateTime())->format('d/m/Y H:i:s');
            enviarArquivo($numeroProp, $arquivo, $user,$permission, $dataAtual);
        }
    }

    header("location: ../update-plan?id=" . $nprop);
    exit();
}



