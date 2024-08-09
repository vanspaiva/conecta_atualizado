<?php
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

if (isset($_POST["submit"])) {




    if($_POST['fotofile'] != "" && $_POST["coment"] != ""){

        $coment = addslashes($_POST["coment"]);
        $nped = addslashes($_POST["nped"]);
        $user = addslashes($_POST["user"]);
        $arquivo = addslashes($_POST['fotofile']);
        $permission = addslashes($_POST['permission']);
    
        addComentCaso($conn, $coment, $nped, $user);
    
        $sql = "SELECT comentVisId, comentVisHorario FROM `comentariosvisualizador` WHERE comentVisNumPed = $nped ORDER BY comentVisId DESC LIMIT 1;";
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_assoc($result);
            $numeroComentario = $row['comentVisId'];
            $data = $row['comentVisHorario'];
        }

        enviarArquivoChatDoutor($nped, $arquivo, $user, $permission, $data, $numeroComentario);
    
        $hashedPED = hashItemNatural($nped);
    
        header("location: ../unit?id=" . $hashedPED . "&error=sentcoment");
        exit();

    }
    elseif($_POST['fotofile'] != "" && $_POST["coment"] == ""){
        
        date_default_timezone_set('America/Sao_Paulo');
        $data = new DateTime();
        $dataAtual = $data->format('Y-m-d H:i:s');
        $nped = addslashes($_POST["nped"]);
        $user = addslashes($_POST["user"]);
        $arquivo = addslashes($_POST['fotofile']);
        $permission = addslashes($_POST['permission']);

        enviarArquivoChatDoutor($nped, $arquivo, $user, $permission, $dataAtual, null);
    
        $hashedPED = hashItemNatural($nped);
    
        header("location: ../unit?id=" . $hashedPED . "&error=sentcoment");
        exit();

    }
    
    else{
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $coment = addslashes($_POST["coment"]);
        $nped = addslashes($_POST["nped"]);
        $user = addslashes($_POST["user"]);
    
        addComentCaso($conn, $coment, $nped, $user);
        $hashedPED = hashItemNatural($nped);
        header("location: ../unit?id=" . $hashedPED . "&error=sentcoment");
    }

} else {
    header("location: ../unit?id=" . $hashedPED . "&error=errorcoment");
    exit();
}
