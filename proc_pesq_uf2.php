<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$uf = $_POST['uf'];

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM estados WHERE ufAbreviacao LIKE '%$uf%';";
$resultado_user = mysqli_query($conn, $result_user);
if (($resultado_user) and ($resultado_user->num_rows != 0)) {
    while ($row_user = mysqli_fetch_assoc($resultado_user)) {
        $nome = $row_user['ufNomeExtenso'];
        $regiao = $row_user['ufRegiao'];
    }

    $retNomeRep = mysqli_query($conn, "SELECT * FROM representantes WHERE repUF='$uf';");
    if (($retNomeRep) and ($retNomeRep->num_rows != 0)) {
        while ($rowNomeRep = mysqli_fetch_array($retNomeRep)) {
            $representante = $rowNomeRep['repUid'];
        }
    }


    echo $nome . '/' . $regiao . '/' . $representante;
    // echo $nome . '/' . $regiao;
}
