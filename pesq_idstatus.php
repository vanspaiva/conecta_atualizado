<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$id = $_POST['id'];


//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result = "SELECT * 
FROM statuspedido  
WHERE stpedId='$id';";

$resultado = mysqli_query($conn, $result);
if (($resultado) and ($resultado->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $nome  = $row['stpedNome'];
        $indicefluxo  = $row['stpedIndiceFluxo'];
        $value  = $row['stpedValue'];
        $posicao  = $row['stpedPosicao'];
        $andamento  = $row['stpedAndamento'];
        $dtprazo  = $row['stpedCalcularDtPrazo'];
        $corbg  = $row['stpedCorBg'];
        $cortexto  = $row['stpedCorTexto'];
        $id  = $row['stpedId'];
    }

    $result = $id . '|' . $nome . '|' . $indicefluxo . '|' . $value . '|' . $posicao . '|' . $andamento . '|' . $dtprazo . '|' . $corbg . '|' . $cortexto;

    echo $result;
}
