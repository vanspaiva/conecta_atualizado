<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$uid = $_POST['uid'];
$userCriador = $_POST['userCriador'];

$ret1 = mysqli_query($conn, "SELECT * FROM users WHERE usersUid = '" . $userCriador . "';");
while ($row1 = mysqli_fetch_array($ret1)) {
    $cnpj = $row1['usersCnpj'];
}

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM caddoutoresdistribuidores WHERE drUidDr LIKE '%$uid%' AND drDistCNPJ = '" . $cnpj . "';";
$resultado_user = mysqli_query($conn, $result_user);
if (($resultado_user) and ($resultado_user->num_rows != 0)) {
    while ($row_user = mysqli_fetch_assoc($resultado_user)) {
        $user = $row_user['drUidDr'];

        $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid = '" . $user . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $nome = $row['usersName'];
            $email = $row['usersEmail'];
            $fone = $row['usersFone'];
            $druid = $row['usersUid'];
        }
    }
    echo $nome . '/' . $email . '/' . $fone . '/' . $druid;
} else {
    echo '';
}
