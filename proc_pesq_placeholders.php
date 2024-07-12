<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$bd = $_POST['bd'];
$arrayPlaceholders = array();
$retorna = '';

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM placeholdersnotificacao WHERE plntfBd LIKE '%$bd%' ORDER BY  plntfNome;";
$resultado_user = mysqli_query($conn, $result_user);
if (($resultado_user) and ($resultado_user->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado_user)) {
        array_push($arrayPlaceholders, $row['plntfNome']);
    }

    foreach ($arrayPlaceholders as &$ss) {

        $retorna = $retorna . "<span class='badge bg-secondary m-1 p-2 pt-1 text-white clicabletag' style='font-size: 1rem;' onclick='addTag(this)'> " . $ss . "</span>";
    }

    echo $retorna;

}
