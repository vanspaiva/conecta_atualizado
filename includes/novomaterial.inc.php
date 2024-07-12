<?php

if (isset($_POST["submit"])) {
    
    $abaMaterial = addslashes($_POST["abaMaterial"]);
    $sessaoMaterial = addslashes($_POST["sessaoMaterial"]);
    $titulo = addslashes($_POST["titulo"]);
    $descricao = addslashes($_POST["descricao"]);
    $link = addslashes($_POST["link"]);
    $relevancia = addslashes($_POST["relevancia"]);

    $relevancia = intval($relevancia);
    
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addMaterialMidia($conn, $abaMaterial, $sessaoMaterial, $titulo, $descricao, $link, $relevancia);

} else if (isset($_POST["update"])) {

    $id = addslashes($_POST["idMaterial"]);
    $abaMaterial = addslashes($_POST["abaMaterialUpd"]);
    $sessaoMaterial = addslashes($_POST["sessaoMaterialUpd"]);
    $titulo = addslashes($_POST["tituloUpd"]);
    $descricao = addslashes($_POST["descricaoUpd"]);
    $link = addslashes($_POST["linkUpd"]);
    $relevancia = addslashes($_POST["relevanciaUpd"]);

    $relevancia = intval($relevancia);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    updateMaterialMidia($conn, $id, $abaMaterial, $sessaoMaterial, $titulo, $descricao, $link, $relevancia);
} else {
    header("location: ../cadastromidias");
    exit();
}
