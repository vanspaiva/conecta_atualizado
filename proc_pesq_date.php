<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$data = $_POST['data'];

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM agenda WHERE agdData LIKE '%$data%';";
$resultado_user = mysqli_query($conn, $result_user);
if (($resultado_user) AND ($resultado_user->num_rows != 0 )) {
    $arrayHora = array();
    while ($row_user = mysqli_fetch_assoc($resultado_user)) {
        $horaCadastrada = $row_user['agdCodHora'];

        array_push($arrayHora, $horaCadastrada);    
    }
    $arraySearch = implode("', '", $arrayHora);

    $retHorario = mysqli_query($conn, "SELECT * FROM horasdisponiveisagenda WHERE NOT hrCodigo IN ('$arraySearch'); ");
    while ($rowHorario = mysqli_fetch_array($retHorario)) {
        echo '<span class="col-sm-3 badge bg-secondary mx-1 my-1 datehover" style="font-size: 1rem; color: #fff;" onclick="selectDate(this)" key="' . $rowHorario['hrCodigo'] . '" > ' . $rowHorario['hrHorario'] . '</span>';
    }
} else {
   
    $retHorario = mysqli_query($conn, "SELECT * FROM horasdisponiveisagenda");
    while ($rowHorario = mysqli_fetch_array($retHorario)) {
        echo '<span class="col-sm-3 badge bg-secondary mx-1 my-1 datehover" style="font-size: 1rem; color: #fff;" onclick="selectDate(this)" key="' . $rowHorario['hrCodigo'] . '" > ' . $rowHorario['hrHorario'] . '</span>';
    }
    
}
