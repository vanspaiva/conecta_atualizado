<?php

/* echo "<pre>";
print_r($_POST);
echo "</pre>";


exit(); */


if (isset($_POST["submit"])) {



    if($_POST['fotofile'] != "" && $_POST["coment"] != ""){

        $coment = addslashes($_POST["coment"]);
        $nped = addslashes($_POST["nped"]);
        $user = addslashes($_POST["user"]);
        $arquivo = addslashes($_POST['fotofile']);
        $permission = addslashes($_POST['permission']);
    
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';
    
        addComentCaso($conn, $coment, $nped, $user);
    
        $sql = "SELECT * FROM `comentariosvisualizador` WHERE comentVisNumPed = $nped ORDER BY comentVisId desc LIMIT 1;";
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_assoc($result);
            $numeroComentario = $row['comentVisId'];
        }

        enviarArquivoChatDoutor($nped, $arquivo, $user, $permission, $numeroComentario);
    
        $hashedPED = hashItemNatural($nped);
    
        header("location: ../unit?id=" . $hashedPED . "&error=sentcoment");
        exit();

    }
    else{
        
    }
    
} else {
    header("location: ../unit?id=" . $hashedPED . "&error=errorcoment");
    exit();
}
