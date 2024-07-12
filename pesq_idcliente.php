<?php
//Incluir a conexão com banco de dados
require_once 'includes/dbh.inc.php';

$id = $_POST['id'];


//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result = "SELECT u.*,
r.repNome AS Representante,
t.tpcadexNome AS Permissao
FROM users u
LEFT JOIN representantes r ON r.repUF = u.usersUf
LEFT JOIN tipocadastroexterno t ON t.tpcadexCodCadastro = u.usersPerm
WHERE u.usersId = '$id';";

$resultado = mysqli_query($conn, $result);
if (($resultado) and ($resultado->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $ID  = $row['usersId'];
        $empresa  = $row['usersEmpr'];
        $nomeUsuario = $row['usersName'];
        $cnpj = $row['usersCnpj'];
        $uid = $row['usersUid'];
        $email = strtolower($row['usersEmailEmpresa']);
        $telefone = $row['usersFone'];
        $celular = $row['usersCel'];
        $uf = $row['usersUf'];
        $representante = $row['Representante'];
        $permisao = $row['Permissao'];
    }

    $result = $ID . ',' . $empresa . ',' . $nomeUsuario . ',' . $cnpj . ',' . $uid . ',' . $email . ',' . $telefone . ',' . $celular . ',' . $uf . ',' . $representante . ',' . $permisao;

    echo $result;
}
