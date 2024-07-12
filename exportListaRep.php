<?php

require_once 'includes/dbh.inc.php';



$user = addslashes($_GET["user"]);

$retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $user . "';");
while ($rowUser = mysqli_fetch_array($retUser)) {
    $nomeCompletoBD = $rowUser['usersName'];
}


$primeiroNome = explode(" ", $nomeCompletoBD);
$rep = $primeiroNome[0];

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=Clientes_Conecta_" . $rep . ".csv");
header("Pragma: no-cache");
header("Expires: 0");



$ufArray = array();
$retNomeRep = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='$user';");
if (($retNomeRep) and ($retNomeRep->num_rows != 0)) {
    while ($rowNomeRep = mysqli_fetch_array($retNomeRep)) {
        array_push($ufArray, $rowNomeRep['repUF']);
    }
}

$ufArray = implode("','", $ufArray);
$ufArray = "('" . $ufArray . "')";

$tipoArray = "('5CLN','9DTC','4DTB','3DTR','8PAC')";


$output = "UF,Nome,Tipo,Empresa,E-mail,Telefone,Aprovacao\n";

if (empty($_GET["user"])) {
    $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersPerm IN $tipoArray ORDER BY usersUf ASC;");
} else {
    $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUf IN $ufArray AND usersPerm IN $tipoArray ORDER BY usersUf ASC;");
}
while ($row = mysqli_fetch_array($ret)) {

    $uf = $row['usersUf'];
    $nome = $row['usersName'];
    $email = $row['usersEmail'];

    $tipoUsuario1 = '';
    $tipoUsuario2 = '';
    $userPerm = $row['usersPerm'];

    $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $userPerm . "';");
    while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
        $tipoUsuario1 = $rowPerm1['tpcadexNome'];
    }

    $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $userPerm . "';");
    while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
        $tipoUsuario2 = $rowPerm2['tpcadinNome'];
    }

    $userPerm = $tipoUsuario1 . $tipoUsuario2;


    if ($row['usersAprov'] == 'AGRDD') {
        $aprovacao = 'Aguardando';
    } else if ($row['usersAprov'] == 'APROV') {
        $aprovacao = 'Aprovado';
    } else if ($row['usersAprov'] == 'BLOQD') {
        $aprovacao = 'Bloqueado';
    }

    $celular = $row['usersCel'];

    //resumir numero celular
    $celular = implode('', explode(' ', $celular));
    $celular = implode('', explode('-', $celular));
    $celular = implode('', explode('(', $celular));
    $celular = implode('', explode(')', $celular));


    if (empty($row['usersEmpr']) || $row['usersEmpr'] == null || $row['usersEmpr'] == " ") {
        $empresa = "-";
    } else {
        $empresa = $row['usersEmpr'];
    }

    $output .= $uf . "," . $nome . "," . $userPerm . "," . $empresa . "," . $email . "," . $celular . "," . $aprovacao . "\n";
}


echo $output;
