<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$nome = $_POST['nome'];

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM users WHERE usersName LIKE '%$nome%';";
$resultado_user = mysqli_query($conn, $result_user);
if (($resultado_user) AND ($resultado_user->num_rows != 0 )) {
    while ($row_user = mysqli_fetch_assoc($resultado_user)) {
        $email = $row_user['usersEmail'];
        $fone = $row_user['usersFone'];
        $user = $row_user['usersUid'];

    }
    echo $email.'/'.$fone.'/'.$user;
} 

