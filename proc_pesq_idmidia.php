<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$id = $_POST['id'];


//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result = "SELECT * FROM materiaismidias WHERE mtmId='$id';";
$resultado = mysqli_query($conn, $result);
if (($resultado) and ($resultado->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $idMaterial = $row['mtmId'];
        $aba = $row['mtmAba'];
        $sessao = $row['mtmSessao'];
        $titulo = $row['mtmTitulo'];
        $descricao = $row['mtmDescricao'];
        $link = $row['mtmLink'];
        $relevancia = $row['mtmRelevancia'];
    }

    $result = $idMaterial . ',' . $aba . ',' . $sessao . ',' . $titulo . ',' . $descricao . ',' . $link . ',' . $relevancia;

    echo $result;
}
