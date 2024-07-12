<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$nome = $_POST['nome'];
$items = array();

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result = "SELECT * FROM sessaomidias WHERE ssmAba LIKE '%$nome%';";
$resultado = mysqli_query($conn, $result);
if (($resultado) and ($resultado->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        array_push($items, $row['ssmNome']);
    }

    $var = '';

    foreach ($items as &$item) {
        $var = $var . ',' . $item;
    }
    
    $var = substr($var, 1);

    echo $var;
}
