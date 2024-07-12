<?php

if (isset($_POST["enviarform"])) {

    // print_r($_POST);
    // exit();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $id = addslashes($_POST['post_clienteId']);
    $email = addslashes($_POST['post_emailempresa']);

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
    }

    $data = array(
        "id" => $ID,
        "empresa" => $empresa,
        "nomeUsuario" => $nomeUsuario,
        "cnpj" => $cnpj,
        "uid" => $uid,
        "email" => $email,
        "telefone" => $telefone,
        "celular" => $celular,
        "uf" => $uf,
        "representante" => $representante,
        "permisao" => $permisao
    );





    $existeCNPJ = existeCNPJ($conn, $data["cnpj"]);

    if ($existeCNPJ) {
        atualizarDataEnvioForm($conn, $data);
        $item = $data["cnpj"];
        $itemname = "cnpj";
        $table = "qualificacao";
        $idQualificacao = getItemFromTable($conn, $item, $itemname, $table);
    } else {
        adicionarEmpresaQualificação($conn, $data);
        $itemname = 'id';
        $table = "qualificacao";
        $idQualificacao = getLastItemFromTable($conn, $itemname, $table);
        
    }

    enviarNotificacaoDeQualificacao($conn, $data, $idQualificacao);

} else if (isset($_POST["update"])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $id = addslashes($_POST["id"]);
    $cnpj = addslashes($_POST["cnpj"]);
    $situacao = addslashes($_POST["situacao"]);
    $cartadistribuicao = addslashes($_POST["cartadistribuicao"]);
    $dataenvioformqualificacao = addslashes($_POST["dataenvioformqualificacao"]);
    $licencafuncionamento = addslashes($_POST["licencafuncionamento"]);
    $licencasanitaria = addslashes($_POST["licencasanitaria"]);
    $crt = addslashes($_POST["crt"]);
    $afe = addslashes($_POST["afe"]);
    $cbpfcbpad = addslashes($_POST["cbpfcbpad"]);

    atualizarQualificacao($conn, $id, $cnpj, $situacao, $cartadistribuicao, $dataenvioformqualificacao, $licencafuncionamento, $licencasanitaria, $crt, $afe, $cbpfcbpad);


    $hashId = hashItemNatural($id);
    header("location: ../editqualificacao?id=" . $hashId . "&error=updated");
    exit();
} else if (isset($_POST["submitcoment"])) {

    $coment = addslashes($_POST["coment"]);
    $idref = addslashes($_POST["idref"]);
    $user = addslashes($_POST["user"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addComentQualificacao($conn, $coment, $idref, $user);

    $hashId = hashItemNatural($idref);
    header("location: ../editqualificacao?id=" . $hashId . "&error=sent");
    exit();
} else if (!empty($_GET['dltqualificacao'])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $id = $_GET['dltqualificacao'];
    $empr = $_GET['empr'];
    deleteQualificacao($conn, $id);
    header("location: ../qualificacaocliente?error=excluded&empr=" . $empr);
} else {
    header("location: ../index");
    exit();
}
