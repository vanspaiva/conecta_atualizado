<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat, $telefone, $uf)
{
    $result = true;

    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat) || empty($telefone) || empty($uf)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function invalidUid($username)
{
    $result = true;

    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function invalidEmail($email)
{
    $result = true;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function pwdMatch($pwd, $pwdrepeat)
{
    $result = true;

    if ($pwd !== $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function uidExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

//inicio log
function createUser($conn, $name, $username, $email, $celular, $telefone, $uf, $crm, $especialidade, $cnpj, $cpf, $empresa, $emailempresa, $responsavel, $ufdr, $paiscidade, $pwd, $permission, $aprovacao)
{
    $name = formatarNomeDr($name);
    $empresa = formatarNome($empresa);

    if ($permission == 'doutor') {
        $perm = '3DTR';
    } else if ($permission == 'paciente') {
        $perm = '8PAC';
    } else if ($permission == 'distribuidor') {
        $perm = '4DTB';

        //pesquisar se cnpj já existe no banco e mudar tipo de permissão
        $result_user = "SELECT * FROM users WHERE usersCnpj LIKE '%$cnpj%';";
        $resultado_user = mysqli_query($conn, $result_user);
        if (($resultado_user) and ($resultado_user->num_rows != 0)) {
            $perm = '9DTC';

            while ($row_user = mysqli_fetch_assoc($resultado_user)) {
                $emailempresa = $row_user['usersEmailEmpresa'];
                $empresa = $row_user['usersEmpr'];
            }
        }
    } else if ($permission == 'comercial') {
        $perm = '9DTC';
    }


    $sql = "INSERT INTO users (usersName, usersUid, usersEmail, usersCel, usersFone, usersUf, usersCrm, usersEspec, usersCpf, usersEmpr, usersCnpj, usersEmailEmpresa, usersNmResp, usersUfDr, usersPaisCidade, usersPwd, usersPerm, usersAprov) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=stmtfailed");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=stmtfailed");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=stmtfailed");
        }
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssssssssssssssss", $name, $username, $email, $celular, $telefone, $uf, $crm, $especialidade, $cpf, $empresa, $cnpj, $emailempresa, $responsavel, $ufdr, $paiscidade, $hashedPwd, $perm, $aprovacao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $content = 'Olá, ' . $name . '! Bem vindo ao Portal Conecta. Aqui você vai encontrar tudo que você precisa para sua experiência na CPMH ser excelente. Seu cadastro está sendo avaliado por um dos nossos colaboradores e em breve você receberá mais detalhes para seu 1º acesso. Fique ligado! Nos vemos em breve!';
    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;
    // sendNotification($notificationCelular, $content);
    sendEmailNotificationCreate($email, $name);

    //log
    $atividade = 'Novo usuário cadastrado';
    logAtividade($conn, $username, $atividade);

    if ($permission == 'doutor') {
        header("location: ../cadastro?tipo=Doutor(a)&error=none");
    } else if ($permission == 'paciente') {
        header("location: ../cadastro?tipo=Paciente&error=none");
    } else if ($permission == 'distribuidor') {
        header("location: ../cadastro?tipo=Distribuidor(a)&error=none");
    }

    $searchRepUid = mysqli_query($conn, "SELECT * FROM representantes WHERE repUF='" . $uf . "';");
    while ($resRepUid = mysqli_fetch_array($searchRepUid)) {
        $repUid = $resRepUid['repUid'];
    }


    //Link live API
    // $url = 'https://hooks.zapier.com/hooks/catch/8414821/bicxhnj?';
    $url = 'https://webhooks.integrately.com/a/webhooks/24b8d2266322496c807ebf08172dab4e?';

    //Link localhost API
    $data = array(
        'nome' => $name,
        'username' => $username,
        'uf' => $uf,
        'representante' => $repUid

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }


    exit();
}

function createNewUserAdm($conn, $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $pwd)
{
    $nome = formatarNome($nome);

    $sql = "INSERT INTO users (usersName, usersUf, usersEmail, usersUid, usersCel, usersFone, usersAprov, usersPerm, usersPwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssssss", $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $content = '*Olá, ' . $nome . '!* Bem Vindo(a)! Sua conta no Portal Conecta acaba de ser criada. Aqui você vai encontrar tudo que você precisa para sua experiência na CPMH ser excelente. Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site https://conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*.';

    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;
    // sendNotification($notificationCelular, $content);

    //log
    $atividade = 'Novo usuário criado por adm';
    logAtividade($conn, $uid, $atividade);


    header("location: ../users?error=created");
    exit();
}

function createNewUserComercial($conn, $nome, $uf, $email, $uid, $celular, $telefone, $cnpj, $empresa, $pwd)
{
    $nome = formatarNomeDr($nome);
    $empresa = formatarNome($empresa);

    $sql = "INSERT INTO users (usersName, usersUf, usersEmail, usersUid, usersCel, usersFone, usersAprov, usersPerm, usersCnpj, usersEmpr, usersPwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../novousuario?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $aprov = "APROV";
    $perm = "9DTC";

    mysqli_stmt_bind_param($stmt, "sssssssssss", $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $cnpj, $empresa, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $content = '*Olá, ' . $nome . '!* Bem Vindo(a)! Sua conta no Portal Conecta acaba de ser criada. Aqui você vai encontrar tudo que você precisa para sua experiência na CPMH ser excelente. Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site https://conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*.';

    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;
    // sendNotification($notificationCelular, $content);

    //log
    $atividade = 'Novo usuário criado por comercial';
    logAtividade($conn, $uid, $atividade);

    header("location: ../meususuarios?error=created");
    exit();
}

function editUserComercial($conn, $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $emailempresa, $cnpj, $empresa, $crm, $cpf, $especialidade, $nmdrresp, $ufdr, $paiscidade, $usersid)
{
    $sql = "UPDATE users SET usersName='$nome', usersUf='$uf', usersEmail='$email', usersUid='$uid', usersCel='$celular', usersFone='$telefone', usersAprov='$aprov', usersPerm='$perm', usersEmailEmpresa='$emailempresa', usersCnpj='$cnpj', usersEmpr='$empresa', usersCrm='$crm', usersCpf='$cpf', usersEspec='$especialidade', usersNmResp='$nmdrresp', usersUfDr='$ufdr', usersPaisCidade='$paiscidade'  WHERE usersId='$usersid'";


    if (mysqli_query($conn, $sql)) {
        header("location: ../meususuarios?error=none");
    } else {
        header("location: ../meususuarios?error=stmfailed");
    }
    mysqli_close($conn);

    if ($aprov == "APROV") {
        $content = '*Olá, ' . $nome . '!* Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*. Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';
    }

    if ($aprov == "BLOQD") {
        $content = '*Olá, ' . $nome . '!* Sentimos muito mas detectamos algumas atividades suspeitas vindas do seu usuário. Por esse motivo sua conta foi _temporariamente bloqueada_. Caso entenda que isso tenha sido um engano, entre em contato com o nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';
    }

    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;

    // sendNotification($notificationCelular, $content);

    //log
    $atividade = 'Usuário editado por comercial';
    logAtividade($conn, $uid, $atividade);

    exit();
}

function editUser($conn, $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $emailempresa, $cnpj, $empresa, $crm, $cpf, $especialidade, $nmdrresp, $ufdr, $paiscidade, $usersid)
{
    $sql = "UPDATE users SET usersName='$nome', usersUf='$uf', usersEmail='$email', usersUid='$uid', usersCel='$celular', usersFone='$telefone', usersAprov='$aprov', usersPerm='$perm', usersEmailEmpresa='$emailempresa', usersCnpj='$cnpj', usersEmpr='$empresa', usersCrm='$crm', usersCpf='$cpf', usersEspec='$especialidade', usersNmResp='$nmdrresp', usersUfDr='$ufdr', usersPaisCidade='$paiscidade'  WHERE usersId='$usersid'";


    if (mysqli_query($conn, $sql)) {
        header("location: ../users?error=none");
    } else {
        header("location: ../users?error=stmfailed");
    }
    mysqli_close($conn);

    if ($aprov == "APROV") {
        $content = '*Olá, ' . $nome . '!* Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*. Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';
    }

    if ($aprov == "BLOQD") {
        $content = '*Olá, ' . $nome . '!* Sentimos muito mas detectamos algumas atividades suspeitas vindas do seu usuário. Por esse motivo sua conta foi _temporariamente bloqueada_. Caso entenda que isso tenha sido um engano, entre em contato com o nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';
    }

    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;

    //log
    $atividade = 'Usuário editado por adm';
    logAtividade($conn, $uid, $atividade);

    // sendNotification($notificationCelular, $content);

    exit();
}

function aprovUser($conn, $id, $nome, $uid, $email, $celular)
{
    $aprov = "APROV";

    $sql = "UPDATE users SET usersAprov='$aprov' WHERE usersId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: users");
    } else {
        header("location: users?error=stmfailed");
    }
    mysqli_close($conn);

    //notificar

    $content = '*PORTAL CONECTA*

    *Olá, ' . $nome . '!* Já está tudo pronto para seu 1º acesso no Portal Conecta. 
    Por favor, entre no site conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*. 
    Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';


    // $cel = implode('', explode(' ', $celular));
    // $cel = implode('', explode('-', $cel));
    // $cel = implode('', explode('(', $cel));
    // $cel = implode('', explode(')', $cel));
    // $notificationCelular = '+55' . $cel;


    sendEmailNotificationCadastroAprovado($email, $nome, $uid);

    // sendNotification($celular, $content);

    //log
    $atividade = 'Usuário aprovado por adm';
    logAtividade($conn, $uid, $atividade);
}
//parou aqui o log
function aprovUserComercial($conn, $id, $nome, $uid, $email, $celular)
{
    $aprov = "APROV";

    $sql = "UPDATE users SET usersAprov='$aprov' WHERE usersId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: meususuarios");
    } else {
        header("location: meususuarios?error=stmfailed");
    }
    mysqli_close($conn);

    //notificar

    $content = '*PORTAL CONECTA*

    *Olá, ' . $nome . '!* Já está tudo pronto para seu 1º acesso no Portal Conecta. 
    Por favor, entre no site conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*. 
    Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';


    // $cel = implode('', explode(' ', $celular));
    // $cel = implode('', explode('-', $cel));
    // $cel = implode('', explode('(', $cel));
    // $cel = implode('', explode(')', $cel));
    // $notificationCelular = '+55' . $cel;


    sendEmailNotificationCadastroAprovado($email, $nome, $uid);

    // sendNotification($celular, $content);
}

function editUserFromUser($conn, $nome, $uf, $email, $uid, $celular, $telefone, $emailempresa, $cnpj, $empresa, $crm, $cpf, $especialidade, $nmdrresp, $ufdr, $paiscidade, $usersid)
{

    if (empty($nome) || empty($uf) || empty($email) || empty($uid) || empty($celular) || empty($telefone)) {
        header("location: ../perfil?usuario=" . $uid . "&error=emptyerror");
        exit();
    } else {
        $sql = "UPDATE users SET usersName='$nome', usersUf='$uf', usersCel='$celular', usersFone='$telefone', usersEmailEmpresa='$emailempresa', usersCnpj='$cnpj', usersEmpr='$empresa', usersCrm='$crm', usersCpf='$cpf', usersEspec='$especialidade', usersNmResp='$nmdrresp', usersUfDr='$ufdr', usersPaisCidade='$paiscidade'  WHERE usersUid='$uid'";
    }

    if (mysqli_query($conn, $sql)) {
        header("location: ../perfil?usuario=" . $uid . "&error=edit");
    } else {
        header("location: ../perfil?usuario=" . $uid . "&error=stmfailed");
    }
    mysqli_close($conn);
}

function deleteUser($conn, $id)
{
    $sql = "DELETE FROM users WHERE usersId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: users?error=deleted");
    } else {
        header("location: users?error=stmtfailed");
    }
    mysqli_close($conn);
}

function editPwd($conn, $user, $pwd, $confirmpwd)
{

    if (pwdMatch($pwd, $confirmpwd)) {
        header("location: ../perfil?usuario=" . $user . "&error=pwderror");
        exit();
    } else {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE usersUid='$user'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../perfil?usuario=" . $user . "&error=none");
    } else {
        header("location: ../perfil?usuario=" . $user . "&error=stmfailed");
    }
    mysqli_close($conn);
}

function emptyInputLogin($username, $pwd)
{
    $result = true;

    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function loginUser($conn, $username, $pwd)
{
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists == false) {
        header("location: ../login?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $_SESSION["useraprovacao"] = getAprov($uidExists);

    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login?error=wronglogin");
        exit();
    } else if ($_SESSION["useraprovacao"] === 'Aguardando') {
        header("location: ../login?error=waitaprov");
        exit();
    } else if ($_SESSION["useraprovacao"] === 'Bloqueado') {
        header("location: ../login?error=bloquser");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["userperm"]  = getPermission($conn, $uidExists);
        $_SESSION["userpermcod"]  = getPermissionCode($conn, $uidExists);
        $_SESSION["userfirstname"] = getNameUser($uidExists);
        $_SESSION["usercpf"] = $uidExists["usersCpf"];
        $_SESSION["usercnpj"] = $uidExists["usersCnpj"];

        header("location: ../index");
        exit();
    }
}

function getPermission($conn, $uidExists)
{

    $userPerm = $uidExists["usersPerm"];
    $tipoUsuario1 = "";
    $tipoUsuario2 = "";

    $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $userPerm . "';");
    while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
        $tipoUsuario1 = $rowPerm1['tpcadexNome'];
    }

    $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $userPerm . "';");
    while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
        $tipoUsuario2 = $rowPerm2['tpcadinNome'];
    }

    $userPerm = $tipoUsuario1 . $tipoUsuario2;

    return $userPerm;
}

function getPermissionCode($conn, $uidExists)
{

    $userPerm = $uidExists["usersPerm"];
    $tipoUsuario1 = "";
    $tipoUsuario2 = "";

    $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $userPerm . "';");
    while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
        $tipoUsuario1 = $rowPerm1['tpcadexCodCadastro'];
    }

    $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $userPerm . "';");
    while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
        $tipoUsuario2 = $rowPerm2['tpcadinCodCadastro'];
    }

    $cod = $tipoUsuario1 . $tipoUsuario2;

    return $cod;
}

function getPermissionNome($conn, $codigo)
{
    $tipoUsuario1 = "";
    $tipoUsuario2 = "";

    $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $codigo . "';");
    while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
        $tipoUsuario1 = $rowPerm1['tpcadexNome'];
    }

    $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $codigo . "';");
    while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
        $tipoUsuario2 = $rowPerm2['tpcadinNome'];
    }

    $nome = $tipoUsuario1 . $tipoUsuario2;

    return $nome;
}

function getNameUser($uidExists)
{
    $nomeCompleto = $uidExists["usersName"];
    $nomeCompleto = explode(" ", $uidExists["usersName"]);

    return $nomeCompleto[0];
}

function getAprov($uidExists)
{
    if ($uidExists["usersAprov"] == 'AGRDD') {
        return 'Aguardando';
    } else if ($uidExists["usersAprov"] == 'APROV') {
        return 'Aprovado';
    } else if ($uidExists["usersAprov"] == 'BLOQD') {
        return 'Bloqueado';
    }
}

function createProduto($conn, $categoria, $cdg, $descricao, $parafusos, $anvisa, $preco, $codPropPadrao, $kitdr, $txtOP, $txtAcompanha, $imposto, $descricaoAnvisa)
{

    $sql = "INSERT INTO produtos (prodCategoria, prodCodCallisto, prodDescricao, prodParafuso, prodAnvisa, prodPreco, prodCodPropPadrao, prodKitDr, prodTxtOp, prodTxtAcompanha, prodImposto, prodDescricaoAnvisa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../produtos?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssss", $categoria, $cdg, $descricao, $parafusos, $anvisa, $preco, $codPropPadrao, $kitdr, $txtOP, $txtAcompanha, $imposto, $descricaoAnvisa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../produtos?error=none");
    exit();
}

function editProduto($conn, $categoria, $cdg, $descricao, $parafusos, $anvisa, $preco, $codPropPadrao, $kitdr, $txtOP, $txtAcompanha, $id, $imposto, $descricaoAnvisa)
{
    $sql = "UPDATE produtos SET prodCategoria='$categoria', prodCodCallisto='$cdg', prodDescricao='$descricao', prodParafuso='$parafusos', prodAnvisa='$anvisa', prodPreco='$preco', prodCodPropPadrao='$codPropPadrao', prodKitDr='$kitdr', prodTxtOp='$txtOP', prodTxtAcompanha='$txtAcompanha', prodImposto='$imposto', prodDescricaoAnvisa='$descricaoAnvisa' WHERE prodId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../produtos?error=edit");
    } else {
        header("location: ../produtos?error=stmtfailed");
    }
    mysqli_close($conn);
}


function deleteProd($conn, $id)
{
    $sql = "DELETE FROM produtos WHERE prodId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: produtos?error=deleted");
    } else {
        header("location: produtos?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteProp($conn, $id)
{
    $sql = "DELETE FROM propostas WHERE propId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: comercial?error=deleted");
    } else {
        header("location: comercial?error=stmtfailed");
    }
    mysqli_close($conn);
}

function registrarItensProp($conn, $itemCdg, $itemValor, $itemAnvisa, $itemQtd, $itemNome, $idprop, $imposto)
{
    $sqlProd = "INSERT INTO itensproposta (itemCdg, itemNome, itemAnvisa, itemQtd, itemValor, itemValorBase, itemPropRef) VALUES (?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }

    $valorQtdxUnd = floatval($itemValor) * intval($itemQtd);
    // $valorQtdxUnd = $itemValor * $itemQtd;

    if ($imposto != null) {
        $imp = intval($imposto) / 100;
        $valorQtdxUnd = $valorQtdxUnd + $valorQtdxUnd * $imp;
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $itemCdg, $itemNome, $itemAnvisa, $itemQtd, $valorQtdxUnd, $itemValor, $idprop);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}



function createProposta($conn, $idprop, $nomecriador, $emailcriacao, $dtcriacao, $statuscaso, $propStatusTC, $empresa, $nomedr, $crm, $emaildr, $teldr, $nomepaciente, $convenio, $emailEnvio, $tipoGeral, $itensJson, $listaItens, $listaQtdItens, $espessurasmartmold, $radioTaxa, $userdr, $cnpjcpf, $isstored1, $filename1, $filesize1, $fileuuid1, $cdnurl1, $isstored2, $filename2, $filesize2, $fileuuid2, $cdnurl2, $isstored3, $filename3, $filesize3, $fileuuid3, $cdnurl3, $isstored4, $filename4, $filesize4, $fileuuid4, $cdnurl4, $datalaudo, $nomeenvio, $telenvio, $thisHour, $thisData, $comentarioproduto, $envioTC, $envioRelatorio)
{
    $nomedr = formatarNomeDr($nomedr);

    $empresa = formatarNome($empresa);
    $nomeenvio = formatarNome($nomeenvio);
    $nomepaciente = implode("", explode(" ", strtoupper($nomepaciente)));
    $validade = 30;
    $desconto = 0;
    $valorDesconto = 0;
    $valorPosDesconto = 0;
    $valorTotal = 0;

    //Pesquisa usuário criador no banco de dados, cria REPRESENTANTE e pega UF 
    $repUid = '';
    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $nomecriador . "';");
    while ($rowUser = mysqli_fetch_array($searchUser)) {
        $ufUser = $rowUser['usersUf'];

        $searchRepUid = mysqli_query($conn, "SELECT * FROM representantes WHERE repUF='" . $ufUser . "';");
        while ($resRepUid = mysqli_fetch_array($searchRepUid)) {
            $repUid = $resRepUid['repUid'];
        }

        $celular = $rowUser['usersCel'];
        $nomeCompleto = $rowUser['usersName'];
        $sNomeCompleto = $nomeCompleto;
        $nomeCompleto = explode(" ", $nomeCompleto);
        $nome = $nomeCompleto[0];
    }

    $searchRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $repUid . "';");
    while ($rowRep = mysqli_fetch_array($searchRep)) {
        $foneRep = $rowRep['usersFone'];
        $RepNomeCompleto = $rowRep['usersName'];
        $RepNomeCompleto = explode(" ", $RepNomeCompleto);
        $nomeRep = $RepNomeCompleto[0];
    }

    //Registra nova proposta
    $sql = "INSERT INTO propostas (propUserCriacao, propEmailCriacao, propDataCriacao, propStatus, propStatusTC, propEmpresa, propNomeDr, propNConselhoDr, propEmailDr, propTelefoneDr, propNomePac, propConvenio, propEmailEnvio, propTipoProd, propLongListaItens, propListaItens, propEspessura, propUf, propRepresentante, propValidade, propValorSomaTotal, propDesconto, propoValorDesconto, propValorPosDesconto, propTaxaExtra, propPlanoVenda, propDrUid, propCnpjCpf, propNomeEnvio, propTelEnvio, propData, propHora, propComentarioProduto, propEnvioTC, propEnvioRelatorio) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    $dataBruta = hoje();
    $horaBruta = agora();

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssssssssssss", $nomecriador, $emailcriacao, $dtcriacao, $statuscaso, $propStatusTC, $empresa, $nomedr, $crm, $emaildr, $teldr, $nomepaciente, $convenio, $emailEnvio, $tipoGeral, $itensJson, $listaItens, $espessurasmartmold, $ufUser, $repUid, $validade, $valorTotal, $desconto, $valorDesconto, $valorPosDesconto, $radioTaxa, $planovenda, $userdr, $cnpjcpf, $nomeenvio, $telenvio, $dataBruta, $horaBruta, $comentarioproduto, $envioTC, $envioRelatorio);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    $getProp = mysqli_query($conn, "SELECT * FROM propostas ORDER BY propId DESC LIMIT 1;");
    $rowProp = mysqli_fetch_array($getProp);
    $idprop = $rowProp['propId'];

    $listaItensArray = explode(",", $listaItens);
    $listaQtdArray = explode(",", $listaQtdItens);

    // pesquisarProduto($conn, $listaItensArray, $idprop);
    $tamListaItens = sizeof($listaItensArray);

    for ($i = 0; $i < $tamListaItens; $i++) {

        $searchProd = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $listaItensArray[$i] . "';");

        while ($rowProd = mysqli_fetch_array($searchProd)) {

            $itemCdg =  $listaItensArray[$i];
            $itemValor = $rowProd['prodPreco'];
            $itemAnvisa = $rowProd['prodAnvisa'];
            $itemQtd = $listaQtdArray[$i];
            $itemNome = $rowProd['prodDescricao'];
            $imposto = $rowProd['prodImposto'];

            registrarItensProp($conn, $itemCdg, $itemValor, $itemAnvisa, $itemQtd, $itemNome, $idprop, $imposto);

            $itemValor = floatval($itemValor);
            $valorTotal = $valorTotal + $itemValor;
        }
    }

    //Pesquisa lista de itens da proposta
    $listaItensBD = array();
    $serachListaItens = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $idprop . "';");

    while ($rowListaItens = mysqli_fetch_array($serachListaItens)) {
        array_push($listaItensBD, $rowListaItens['itemId']);
    }

    $listaItensBD = implode(',', $listaItensBD);

    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;


    $celRep = implode('', explode(' ', $foneRep));
    $celRep = implode('', explode('-', $celRep));
    $celRep = implode('', explode('(', $celRep));
    $celRep = implode('', explode(')', $celRep));
    $celularRep = '+55' . $celRep;


    //Criar BD de Laudo Tomografico
    //Registra nova proposta
    $sql = "INSERT INTO laudostomograficos (laudoNumProp, laudoStatus, laudoDataDocumento) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }
    $statuslaudo = 'Pendente';

    mysqli_stmt_bind_param($stmt, "sss", $idprop, $statuslaudo, $datalaudo);
    mysqli_stmt_execute($stmt);


    $planovenda = 'Entrada Antecipado 20% + 30 e 60 dias';

    //envio de webhook
    // $dtcriacao
    // $nomedr
    // $nomepaciente

    // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
    $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $idhashed = openssl_encrypt($idprop, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
    $idhashed = $idhashed . ':' . base64_encode($iv);
    $idhashed = urlencode($idhashed);

    //Link live API
    $url = 'https://hooks.zapier.com/hooks/catch/8414821/brksu6l?';
    //Link localhost API
    // $url = 'https://hooks.zapier.com/hooks/catch/8414821/b8961qn?';
    // $url = 'https://webhooks.integrately.com/a/webhooks/ad18327b0f96455fa7fbca9130e3d41f?';
    $data = array(
        'data' => $dtcriacao,
        'idprop' => $idprop,
        'uf' => $ufUser,
        'doutor' => $nomedr,
        'paciente' => $nomepaciente,
        'uploaduuid1' => $fileuuid1,
        'url1' => $cdnurl1,
        'nomearquivo1' => "tc_pac-" . $nomepaciente,
        'uploaduuid2' => $fileuuid2,
        'url2' => $cdnurl2,
        'nomearquivo2' => "laudo_pac-" . $nomepaciente,
        'uploaduuid3' => $fileuuid3,
        'url3' => $cdnurl3,
        'nomearquivo3' => "modelo_pac-" . $nomepaciente,
        'uploaduuid4' => $fileuuid4,
        'url4' => $cdnurl4,
        'nomearquivo4' => "fotos_pac-" . $nomepaciente,
        'idhashed' => $idhashed,
        'representante' => $nomeRep,
        'produto' => $tipoGeral,
        'empresa' => $empresa
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    // var_dump($result);

    //Envio E-mail para user criador
    $tipoNotificacao = 'email';
    $idMsg = 4;
    $itemEnvio = intval($idprop);

    //descomentar
    // sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Envio E-mail para user comercial
    $tipoNotificacao = 'email';
    $idMsg = 5;
    $itemEnvio = intval($idprop);

    //descomentar
    // sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Envio Wpp para user criador
    $tipoNotificacao = 'wpp';
    $idMsg = 2;
    $itemEnvio = intval($idprop);

    //descomentar
    // sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Atualiza a nova proposta
    $sql = "UPDATE propostas SET propUserCriacao = ?, propEmailCriacao = ?, propDataCriacao = ?, propStatus = ?, propStatusTC = ?, propEmpresa = ?, propNomeDr = ?, propNConselhoDr = ?, propEmailDr = ?, propTelefoneDr = ?, propNomePac = ?, propConvenio = ?, propEmailEnvio = ?, propTipoProd = ?, propLongListaItens = ?, propListaItens = ?, propEspessura = ?, propUf = ?, propRepresentante = ?, propValidade = ?, propValorSomaTotal = ?, propDesconto = ?, propoValorDesconto = ?, propValorPosDesconto = ?, propListaItensBD = ?, propTaxaExtra = ?, propPlanoVenda = ?, propDrUid = ?, propCnpjCpf = ?, propNomeEnvio = ?, propTelEnvio = ? WHERE propId ='$idprop'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssssssss", $nomecriador, $emailcriacao, $dtcriacao, $statuscaso, $propStatusTC, $empresa, $nomedr, $crm, $emaildr, $teldr, $nomepaciente, $convenio, $emailEnvio, $tipoGeral, $itensJson, $listaItens, $espessurasmartmold, $ufUser, $repUid, $validade, $valorTotal, $desconto, $valorDesconto, $valorPosDesconto, $listaItensBD, $radioTaxa, $planovenda, $userdr, $cnpjcpf, $nomeenvio, $telenvio);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    //Armazenar arquivo
    // createFileUpload($conn, $idprop, $pname, $tname);

    // saveFileUpload($conn, $idprop, $fileuuid1, $filename1, $isstored1, $filesize1, $cdnurl1);
    // saveFileUpload($conn, $idprop, $fileuuid2, $filename2, $isstored2, $filesize2, $cdnurl2);
    // saveFileUpload($conn, $idprop, $fileuuid3, $filename3, $isstored3, $filesize3, $cdnurl3);
    // saveFileUpload($conn, $idprop, $fileuuid4, $filename4, $isstored4, $filesize4, $cdnurl4);
    saveFileId($conn, $idprop);
    saveFileIdLaudo($conn, $idprop);
    // saveFileUploadLaudo($conn, $idprop, $fileuuid2, $filename2, $isstored2, $filesize2, $cdnurl2);


    $contentRep = '*Olá, ' . $nomeRep . '!* Recebemos uma nova solicitação de proposta de ' . $tipoGeral . ' feita por ' . $sNomeCompleto . ', da Empresa:' . $empresa . ' - ' . $ufUser . ', Dr: ' . $nomedr . ', Paciente: ' . $nomepaciente . '. Entre na plataforma Conecta no link https://conecta.cpmhdigital.com.br/solicitacoes.php e acompanhe seu pedido.';
    $content = '*PORTAL CONECTA*

    *Olá, ' . $nome . '!* Recebemos sua solicitação de proposta de ' . $tipoGeral . '. Em breve, nossos especialistas entrarão em contato. 
    *ATENÇÃO!!!* Exclusividade de projetos é concedida para o 1º cliente que solicitou com o UPLOAD da TC (tomografia) no portal com os dados completos no portal.';

    // sendNotification($celularRep, $contentRep);
    //descomentar
    // sendNotification($notificationCelular, $content);

    // sendEmailNotificationCreateProposta($conn, $idprop, $nomecriador);

    header("location: ../minhassolicitacoes?error=none");

    exit();
}

function formatarNomeDr($nomedr)
{
    $nomedr = str_replace("Dr(a).", "", $nomedr);
    $nomedr = str_replace("Dra.", "", $nomedr);
    $nomedr = str_replace("Dr.", "", $nomedr);
    $nomedr = str_replace("Dr(a)", "", $nomedr);
    $nomedr = str_replace("Dra", "", $nomedr);
    $nomedr = str_replace("Dr", "", $nomedr);

    $nomedr = formatarNome($nomedr);

    return $nomedr;
}

function formatarNome($nome)
{
    return ucwords(strtolower($nome));
}

// function newReenvioTc($conn, $idprop, $nomecriador, $dtcriacao, $isstored1, $filename1, $filesize1, $fileuuid1, $cdnurl1, $isstored2, $filename2, $filesize2, $fileuuid2, $cdnurl2, $isstored3, $filename3, $filesize3, $fileuuid3, $cdnurl3, $isstored4, $filename4, $filesize4, $fileuuid4, $cdnurl4)
// {
//     // $newStatusTC = 'REENVIADA ';

//     // $sql = "UPDATE propostas SET propStatusTC='$newStatusTC' WHERE propId ='$idprop'";
//     // mysqli_query($conn, $sql);

//     setStatusReenviadaTC($conn, $idprop);

//     //pegar nome paciente
//     $searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idprop . "';");
//     while ($rowProp = mysqli_fetch_array($searchProp)) {
//         $dataProp = $rowProp['propDataCriacao'];
//         $ufProp = $rowProp['propUf'];
//         $nomedoutor = $rowProp['propNomeDr'];
//         $nomepaciente = $rowProp['propNomePac'];
//     }

//     //pegar link da pasta planejamento
//     $searchFolder = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef='" . $idprop . "';");
//     while ($rowFolder = mysqli_fetch_array($searchFolder)) {
//         $linkPasta = $rowFolder['fileCdnUrl'];
//     }

//     //pegar link da pasta qualidade
//     $searchFolderQuali = mysqli_query($conn, "SELECT * FROM filedownloadlaudo WHERE fileNumPropRef='" . $idprop . "';");
//     while ($rowFolderQuali = mysqli_fetch_array($searchFolderQuali)) {
//         $linkPastaQuali = $rowFolderQuali['fileCdnUrl'];
//     }

//     // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
//     // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
//     // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
//     // $idhashed = openssl_encrypt($idprop, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
//     // $idhashed = $idhashed . ':' . base64_encode($iv);
//     // $idhashed = urlencode($idhashed);

//     $idhashed = urlencode($idprop);

//     $idPastaPlan = explode("folders/", $linkPasta);
//     $idPastaPlan = $idPastaPlan[1];

//     $idPastaQuali = explode("folders/", $linkPastaQuali);
//     $idPastaQuali = $idPastaQuali[1];


//     //Link live API
//     // $url = 'https://webhooks.integrately.com/a/webhooks/d73866dfb7df48e483db777fac00f697?';
//     //segunda tentattiva
//     $url = "https://webhooks.integrately.com/a/webhooks/c4da94d21bbc49cdb841de1fb0f3ec06?";

//     //Link localhost API
//     // $url = 'https://hooks.zapier.com/hooks/catch/8414821/bi2bdzd?';
//     $data = array(
//         'datacriacao' => $dtcriacao,
//         'idprop' => $idprop,
//         'dataprop' => $dataProp,
//         'ufprop' => $ufProp,
//         'nomedr' => $nomedoutor,
//         'nomepac' => $nomepaciente,
//         'linkpastaplanejamento' => $linkPasta,
//         'linkpastaqualidade' => $linkPastaQuali,
//         'idpastaplanejamento' => $idPastaPlan,
//         'idpastaqualidade' => $idPastaQuali,
//         'uploaduuid1' => $fileuuid1,
//         'url1' => $cdnurl1,
//         'nomearquivo1' => "reenvio - tc_pac-" . $nomepaciente,
//         'uploaduuid2' => $fileuuid2,
//         'url2' => $cdnurl2,
//         'nomearquivo2' => "reenvio - laudo_pac-" . $nomepaciente,
//         'uploaduuid3' => $fileuuid3,
//         'url3' => $cdnurl3,
//         'nomearquivo3' => "reenvio - modelo_pac-" . $nomepaciente,
//         'uploaduuid4' => $fileuuid4,
//         'url4' => $cdnurl4,
//         'nomearquivo4' => "reenvio - fotos_pac-" . $nomepaciente,
//         'idhashed' => $idhashed
//     );

//     // use key 'http' even if you send the request to https://...
//     $options = array(
//         'http' => array(
//             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//             'method'  => 'POST',
//             'content' => http_build_query($data)
//         )
//     );
//     $context  = stream_context_create($options);
//     $result = file_get_contents($url, false, $context);
//     if ($result === FALSE) { /* Handle error */
//     }

//     //Armazenar BD reenvio
//     /*
//     -id
//     -usercriador
//     -data
//     -numprop
//     -url1
//     -url2
//     -url3
//     -url4
//     -linkpasta
//     */

//     header("location: ../minhassolicitacoes?error=sent");
// }

function newReenvioTc($conn, $idprop, $nomecriador, $dtcriacao, $isstored1, $filename1, $filesize1, $fileuuid1, $cdnurl1, $isstored2, $filename2, $filesize2, $fileuuid2, $cdnurl2, $isstored3, $filename3, $filesize3, $fileuuid3, $cdnurl3, $isstored4, $filename4, $filesize4, $fileuuid4, $cdnurl4, $envioTC, $envioRelatorio)
{
    $newStatusTC = 'REENVIADA ';

//get atual status de envioTC e envioRelatorio
    $prop = getAllDataFromProp($conn, $idprop);

    $atualEnvioTC = $prop["propEnvioTC"];
    $atualEnvioRelatorio = $prop["propEnvioRelatorio"];

    //verificar se precisa trocar status de Envio
    if ($atualEnvioTC == "false") {
        if ($envioTC == "true") {
            //trocar
            $sql = "UPDATE propostas SET propEnvioTC='$envioTC' WHERE propId ='$idprop'";
            mysqli_query($conn, $sql);
        }
    }

    if ($atualEnvioRelatorio == "false") {
        if ($envioRelatorio == "true") {
            //trocar
            $sql = "UPDATE propostas SET propEnvioRelatorio='$envioRelatorio' WHERE propId ='$idprop'";
            mysqli_query($conn, $sql);
        }
    }



    $sql = "UPDATE propostas SET propStatusTC='$newStatusTC' WHERE propId ='$idprop'";
    mysqli_query($conn, $sql);

    //pegar nome paciente
    $searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idprop . "';");
    while ($rowProp = mysqli_fetch_array($searchProp)) {
        $dataProp = $rowProp['propDataCriacao'];
        $ufProp = $rowProp['propUf'];
        $nomedoutor = $rowProp['propNomeDr'];
        $nomepaciente = $rowProp['propNomePac'];
    }

    //pegar link da pasta planejamento
    $searchFolder = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef='" . $idprop . "';");
    while ($rowFolder = mysqli_fetch_array($searchFolder)) {
        $linkPasta = $rowFolder['fileCdnUrl'];
    }

    //pegar link da pasta qualidade
    $searchFolderQuali = mysqli_query($conn, "SELECT * FROM filedownloadlaudo WHERE fileNumPropRef='" . $idprop . "';");
    while ($rowFolderQuali = mysqli_fetch_array($searchFolderQuali)) {
        $linkPastaQuali = $rowFolderQuali['fileCdnUrl'];
    }

    // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
    $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $idhashed = openssl_encrypt($idprop, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
    $idhashed = $idhashed . ':' . base64_encode($iv);
    $idhashed = urlencode($idhashed);

    $idPastaPlan = explode("folders/", $linkPasta);
    $idPastaPlan = $idPastaPlan[1];

    $idPastaQuali = explode("folders/", $linkPastaQuali);
    $idPastaQuali = $idPastaQuali[1];


    //Link live API
    // $url = 'https://webhooks.integrately.com/a/webhooks/d73866dfb7df48e483db777fac00f697?';
    //segunda tentattiva
    // $url = "https://webhooks.integrately.com/a/webhooks/c4da94d21bbc49cdb841de1fb0f3ec06?";

    //Link localhost API
    $url = 'https://hooks.zapier.com/hooks/catch/8414821/biw8van?';
    $data = array(
        'datacriacao' => $dtcriacao,
        'idprop' => $idprop,
        'dataprop' => $dataProp,
        'ufprop' => $ufProp,
        'nomedr' => $nomedoutor,
        'nomepac' => $nomepaciente,
        'linkpastaplanejamento' => $linkPasta,
        'linkpastaqualidade' => $linkPastaQuali,
        'idpastaplanejamento' => $idPastaPlan,
        'idpastaqualidade' => $idPastaQuali,
        'uploaduuid1' => $fileuuid1,
        'url1' => $cdnurl1,
        'nomearquivo1' => "reenvio - tc_pac-" . $nomepaciente,
        'uploaduuid2' => $fileuuid2,
        'url2' => $cdnurl2,
        'nomearquivo2' => "reenvio - laudo_pac-" . $nomepaciente,
        'uploaduuid3' => $fileuuid3,
        'url3' => $cdnurl3,
        'nomearquivo3' => "reenvio - modelo_pac-" . $nomepaciente,
        'uploaduuid4' => $fileuuid4,
        'url4' => $cdnurl4,
        'nomearquivo4' => "reenvio - fotos_pac-" . $nomepaciente,
        'idhashed' => $idhashed
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    //Armazenar BD reenvio
    /*
    -id
    -usercriador
    -data
    -numprop
    -url1
    -url2
    -url3
    -url4
    -linkpasta
    */

    header("location: ../minhassolicitacoes?error=sent");
}

function setStatusReenviadaTC($conn, $id)
{
    $newStatusTC = 'REENVIADA ';

    $sql = "UPDATE propostas SET propStatusTC='$newStatusTC' WHERE propId ='$id'";
    mysqli_query($conn, $sql);
}

function sendNotificationToRep($conn, $id)
{

    // 1 - Encontrar uid Representante
    $representanteUid = getRepFromProp($conn, $id);

    // 1.1 - Encontrar dados da proposta (Data Envio, Tipo Produto, Nome Dr, Nome Paciente, Empresa)
    $proposta = getAllDataFromProp($conn, $id);

    $dataEnvioProp = $proposta["propDataCriacao"];
    $tipoProdutoProp = $proposta["propTipoProd"];
    $nomeDrProp = $proposta["propNomeDr"];
    $nomePacProp = $proposta["propNomePac"];
    $empresaProp = $proposta["propEmpresa"];

    // 2 - Encontrar telefone Representante
    // 3 - Encontrar id slack Representante
    $representante = getAllDataFromRep($conn, $representanteUid);
    $celularRep = $representante["usersCel"];
    $emailSlackRep = $representante["usersEmail"];

    $celularRep = formatCelularForWpp($celularRep);

    // 3.1 - Definir texto 

    $textoWpp = "Caro Representante, a proposta *Nº " . $id . "* precisa de atenção. Por favor revise os dados e/ou entre em contato com o seu cliente para dar continuidade ao fluxo.

_*Dados da Proposta*_
*Dt:* " . $dataEnvioProp . "
*Produto:* " . $tipoProdutoProp . "
*Dr(a):* " . $nomeDrProp . " / *Pac:* " . $nomePacProp . "
*Empresa:* " . $empresaProp;

    $textoSlack = "Caro Representante, a proposta Nº " . $id . " precisa de atenção. Por favor revise os dados e/ou entre em contato com o seu cliente para dar continuidade ao fluxo.

    Dados da Proposta

    Dt: " . $dataEnvioProp . "
    Produto: " . $tipoProdutoProp . "
    Dr(a): " . $nomeDrProp . "
    Pac: " . $nomePacProp . "
    Empresa: " . $empresaProp . "
    ";

    // 4 - Enviar Wpp p/ Representante
    // sendNotification($celularRep, $textoWpp);

    // 5 - Enviar Slack p/ Representante
    $url = 'https://webhooks.integrately.com/a/webhooks/0ccbbb90a803419c93d2ab9900102c19?';

    //Link localhost API
    $data = array(
        'emailSlackRep' => $emailSlackRep,
        'textoSlack' => $textoSlack
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function saveFileUpload($conn, $idprop, $fileuuid, $filename, $isstored, $filesize, $cdnurl)
{
    //Registra nova arquivo
    $sql = "INSERT INTO filedownload (fileNumPropRef, fileUuid, fileRealName, fileIsStored, fileSize, fileCdnUrl) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $idprop, $fileuuid, $filename, $isstored, $filesize, $cdnurl);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("location: ../minhassolicitacoes?error=none");

    exit();
}

function saveFileUploadLaudo($conn, $idprop, $fileuuid, $filename, $isstored, $filesize, $cdnurl)
{
    //Registra nova arquivo
    $sql = "INSERT INTO filedownloadlaudo (fileNumPropRef, fileUuid, fileRealName, fileIsStored, fileSize, fileCdnUrl) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $idprop, $fileuuid, $filename, $isstored, $filesize, $cdnurl);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("location: ../minhassolicitacoes?error=none");

    exit();
}

function saveFileId($conn, $idprop)
{
    //Registra nova arquivo
    $sql = "INSERT INTO filedownload (fileNumPropRef) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $idprop);
    mysqli_stmt_execute($stmt);
}


function saveFileIdLaudo($conn, $idprop)
{
    //Registra nova arquivo
    $sql = "INSERT INTO filedownloadlaudo (fileNumPropRef) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $idprop);
    mysqli_stmt_execute($stmt);
}

function createFileUpload($conn, $idprop, $pname, $tname)
{
    // #upload directory path
    $uploads_dir = '../arquivos/proposta/TC/' . $idprop;

    if (!file_exists('../arquivos/proposta/TC/' . $idprop)) {
        mkdir('../arquivos/proposta/TC/' . $idprop, 0777, true);
    }

    //Registra nova arquivo
    $sql = "INSERT INTO filedownload (fileRealName, filePropRef, filePath) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $pname, $idprop, $uploads_dir);
    mysqli_stmt_execute($stmt);
    move_uploaded_file($tname, $uploads_dir . '/' . $pname);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);

    header("location: ../minhassolicitacoes?error=none");

    exit();
}

// function editProp($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $tipoProd, $validade, $ufProp, $representante, $pedido, $listaIdsItens, $listaItens, $listaValoresItens, $listaQtdsItens, $planovendas, $valorTotalItens, $valorTotal, $valorDesconto, $valorTotalPosDesconto)
// {
//     $sql = "UPDATE propostas SET propEmpresa='$empresa', propStatus='$status', propNomeDr='$nomedr', propNConselhoDr='$crm', propTelefoneDr='$telefone', propEmailDr='$emaildr', propEmailEnvio='$emailenvio', propNomePac='$nomepac', propConvenio='$convenio', propTipoProd='$tipoProd', propValidade='$validade', propUf='$ufProp', propRepresentante='$representante', propPedido='$pedido', propValorSomaItens='$valorTotalItens', propValorSomaTotal='$valorTotal', propDesconto='$valorDesconto', propValorPosDesconto='$valorTotalPosDesconto', propPlanoVenda='$planovendas'  WHERE propId ='$id'";

//     if (mysqli_query($conn, $sql)) {
//         header("location: ../comercial?error=edit");
//     } else {
//         header("location: ../comercial?error=stmfailed");
//     }


//     if ($status == 'PEDIDO') {
//         // createModuloII($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante, $pedido);
//         createModuloII($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante, $pedido, $drrespuid, $cnpj);
//     }


//     $itensId = explode('/', $listaIdsItens);
//     $itens = explode('/', $listaItens);
//     $itensValores = explode('/', $listaValoresItens);
//     $qtds = explode('/', $listaQtdsItens);

//     for ($i = 0; $i <= sizeof($itens); $i++) {
//         $itenid = $itensId[$i];
//         $item = $itens[$i];
//         $valor = $itensValores[$i];
//         $qtd = $qtds[$i];

//         $sqlitens = "UPDATE itensproposta SET itemValor='$valor', itemQtd='$qtd' WHERE itemId='$itenid';";
//         mysqli_query($conn, $sqlitens);
//     }

//     mysqli_close($conn);
//     //verifyStatusProp($conn, $id);
// }

function editPropPlan($conn, $id, $statustc, $textReprov, $projetista, $filename1, $cdnurl1, $filename2, $cdnurl2, $arquivos)
{

    $sql = "UPDATE propostas SET propStatusTC='$statustc', propTxtReprov='$textReprov', propProjetistas='$projetista' WHERE propId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../planejamento?error=edit");
    } else {
        header("location: ../planejamento?error=stmfailed");
    }

    uploadArquivoRefTCB($conn, $filename2, $cdnurl2, $id);
    uploadArquivoRefTCA($conn, $filename1, $cdnurl1, $id);

    verifyStatusTC($conn, $id);
    mysqli_close($conn);
}

function userAceiteProp($conn, $id, $nomeusuario, $data, $ip, $pgto, $tname, $pname, $ext, $meiotransporte, $observacao)
{
    $propId = $id;

    $sql = "UPDATE propostas SET propStatus='APROVADO' WHERE propId ='$propId'";
    mysqli_query($conn, $sql);

    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$propId';");
    while ($row = mysqli_fetch_array($ret)) {
        $cpfcnpj = $row['propCnpjCpf'];
    }
    $status = 'Em Análise';


    //Registra novo aceite de proposta
    $sqlAceite = "INSERT INTO aceiteproposta (apropNumProp, apropNomeUsuario, apropData, apropIp, apropCPFCNPJ, apropFormaPgto, apropStatus, apropExtensionFile, meiotransporte, observacao) VALUES (?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlAceite)) {
        header("location: ../minhassolicitacoes?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssss", $propId, $nomeusuario, $data, $ip, $cpfcnpj, $pgto, $status, $ext, $meiotransporte, $observacao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    //verifyStatusProp($conn, $propId);

    $getAceiteId = mysqli_query($conn, "SELECT * FROM aceiteproposta ORDER BY apropId DESC LIMIT 1;");
    $rowAceiteId = mysqli_fetch_array($getAceiteId);
    $AceiteId = $rowAceiteId['apropId'];

    uploadArquivoFinanceiro($conn, $tname, $pname, $AceiteId, $propId);

    //Envio E-mail para user comercial
    $tipoNotificacao = 'email';
    $idMsg = 8;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Envio E-mail para user financeiro
    $tipoNotificacao = 'email';
    $idMsg = 10;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    notifySlackFinanceiro($propId, $nomeusuario, $data, $ip, $cpfcnpj, $pgto, $status, $ext);
}

function notifySlackFinanceiro($propId, $nomeusuario, $data, $ip, $cpfcnpj, $pgto, $status, $ext)
{
    //Link live API
    // $url = 'https://hooks.zapier.com/hooks/catch/8414821/bsojvi3?';
    $url = 'https://webhooks.integrately.com/a/webhooks/136a82df938c461f9dc557547ef7b97f?';

    //Link localhost API
    $data = array(
        'idprop' => $propId,
        'nomeusuario' => $nomeusuario,
        'data' => $data,
        'ip' => $ip,
        'cpfcnpj' => $cpfcnpj,
        'pgto' => $pgto,
        'status' => $status,
        'ext' => $ext
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function uploadArquivoFinanceiro($conn, $tname, $pname, $AceiteId, $propId)
{

    #upload directory path
    $uploads_dir = '../arquivos/fincanceiro/' . $propId;

    if (!file_exists('../arquivos/fincanceiro/' . $propId)) {
        mkdir('../arquivos/fincanceiro/' . $propId, 0777, true);
    }

    //Registra nova arquivo
    $sql = "INSERT INTO filefinanceiro (filefinRealName, filefinPropId, filefinPath) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../minhassolicitacoes?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $pname, $propId, $uploads_dir);
    mysqli_stmt_execute($stmt);
    move_uploaded_file($tname, $uploads_dir . '/' . $pname);
    mysqli_stmt_close($stmt);

    $sqlPath = "UPDATE aceiteproposta SET apropCaminhoArquivo='$uploads_dir' WHERE apropId ='$AceiteId'";
    mysqli_query($conn, $sqlPath);

    // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // $encrypted = openssl_encrypt($propId, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
    // $encrypted = $encrypted . ':' . base64_encode($iv);
    // $encrypted = urlencode($encrypted);

    $encrypted = hashItem($propId);

    mysqli_query($conn, $sql);
    header("location: ../minhassolicitacoes");

    // if (mysqli_query($conn, $sql)) {
    //     header("location: ../minhaproposta?id=" . $encrypted);
    // } else {
    //     header("location: ../minhassolicitacoes?error=stmfailed");
    // }

    mysqli_close($conn);
}

function deleteAceiteFin($conn, $id)
{
    $sql = "DELETE FROM aceiteproposta WHERE apropId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: aceitesfinanceiros?error=none");
    } else {
        header("location: aceitesfinanceiros?error=stmtfailed");
    }
    mysqli_close($conn);
}

function UpdateUserAceiteProp($conn, $id, $nomeusuario, $data, $ip, $tname, $pname, $ext)
{
    $newStatus = 'Em Análise';

    $sql = "UPDATE aceiteproposta SET apropNomeUsuario='$nomeusuario', apropData='$data', apropIp='$ip', apropStatus='$newStatus', apropExtensionFile='$ext' WHERE apropId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../financeiro?error=edit");
    } else {
        header("location: ../financeiro?error=stmfailed");
    }

    $getPropId = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropId ='$id';");
    $rowPropId = mysqli_fetch_array($getPropId);
    $propId = $rowPropId['apropNumProp'];

    updateUploadArquivoFinanceiro($conn, $tname, $pname, $id, $propId);
}

function updateUploadArquivoFinanceiro($conn, $tname, $pname, $AceiteId, $propId)
{
    #upload directory path
    $uploads_dir = '../arquivos/fincanceiro/' . $propId;

    if (!file_exists('../arquivos/fincanceiro/' . $propId)) {
        mkdir('../arquivos/fincanceiro/' . $propId, 0777, true);
    }

    //Atualiza arquivo
    $sql = "UPDATE filefinanceiro SET filefinRealName='$pname' WHERE filefinPropId ='$propId'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../financeiro?error=edit");
    } else {
        header("location: ../financeiro?error=stmfailed");
    }

    move_uploaded_file($tname, $uploads_dir . '/' . $pname);


    $sqlPath = "UPDATE aceiteproposta SET apropCaminhoArquivo='$uploads_dir' WHERE apropId ='$AceiteId'";
    mysqli_query($conn, $sqlPath);


    mysqli_query($conn, $sql);
    header("location: ../financeiro");


    mysqli_close($conn);
}

function aceiteProp($conn, $id, $type)
{
    if ($type == 'aprov') {
        $status = 'Aprovado';
        $aprov = true;
    } else if ($type == 'reprov') {
        $status = 'Reprovado';
        $aprov = false;
    } else {
        $status = 'Em Análise';
    }

    $sql = "UPDATE aceiteproposta SET apropStatus='$status' WHERE apropId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: aceitesfinanceiros");
    } else {
        header("location: aceitesfinanceiros?error=stmfailed");
    }

    $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropId='" . $id . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $propId = $row['apropNumProp'];
    }

    if ($aprov) {
        $msg = 'Olá! O setor financeiro avaliou seu envio e já está tudo certo para dar início ao seu projeto.';
    } else {
        $msg = 'Olá! Sentimos informar, mas seu comprovante de pagamento da proposta ' . $propId . ' não está conforme os padrões. Pedimos para que reenvie seu comprovante na plataforma, para darmos continuidade ao seu processo.';
    }

    //sendNotifWpp
    //sendNotifEmail

    //Envio E-mail para user comercial
    $tipoNotificacao = 'email';
    $idMsg = 11;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Envio E-mail para user user criador
    $tipoNotificacao = 'email';
    $idMsg = 12;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Envio E-mail para user user financeiro
    $tipoNotificacao = 'email';
    $idMsg = 20;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);
}

function aprovlaudo($conn, $id, $type)
{
    if ($type == 'aprov') {
        $status = 'Aprovado';
        $aprov = true;
    } else if ($type == 'reprov') {
        $status = 'Reprovado';
        $aprov = false;
    } else {
        $status = 'Pendente';
    }

    $sql = "UPDATE laudostomograficos SET laudoStatus='$status' WHERE laudoId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: laudos");
    } else {
        header("location: laudos?error=stmfailed");
    }

    $ret = mysqli_query($conn, "SELECT * FROM laudostomograficos WHERE laudoId='" . $id . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $propId = $row['laudoNumProp'];
    }


    //sendNotifWpp
    //sendNotifEmail

    //Envio E-mail para user comercial
    $tipoNotificacao = 'email';
    $idMsg = 18;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Envio E-mail para user user criador
    $tipoNotificacao = 'email';
    $idMsg = 19;
    $itemEnvio = intval($propId);

    sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);
}

function newCommentLaudo($conn, $idprop, $txtcoment, $newdata, $newdataanvdr, $newdataanvpac, $ntransacao, $nexpedicao, $status)
{
    $sql = "UPDATE propostas SET propTxtLaudo='$txtcoment' WHERE propId ='$idprop'";

    if (!mysqli_query($conn, $sql)) {
        header("location: laudos?error=stmtfailed");
    }

    changeDatasLaudo($conn, $newdata, $newdataanvdr, $newdataanvpac, $ntransacao, $nexpedicao, $idprop, $status);

    header("location: ../laudos");
    mysqli_close($conn);
}

function changeDatasLaudo($conn, $newdata, $newdataanvdr, $newdataanvpac, $ntransacao, $nexpedicao, $idprop, $status)
{

    // if ($newdata != null) {
    //     $newdata = explode("-", $newdata);
    //     $newdata = $newdata[2] . "/" . $newdata[1] . "/" . $newdata[0];
    // }

    // if ($newdataanvdr != null) {
    //     $newdataanvdr = explode("-", $newdataanvdr);
    //     $newdataanvdr = $newdataanvdr[2] . "/" . $newdataanvdr[1] . "/" . $newdataanvdr[0];
    // }

    // if ($newdataanvpac != null) {
    //     $newdataanvpac = explode("-", $newdataanvpac);
    //     $newdataanvpac = $newdataanvpac[2] . "/" . $newdataanvpac[1] . "/" . $newdataanvpac[0];
    // }

    $sql = "UPDATE laudostomograficos SET DataLaudoTC='$newdata', DataAnvisaDr='$newdataanvdr', DataAnvisaPac='$newdataanvpac', NTransacao='$ntransacao', NExpedicao='$nexpedicao', laudoStatus='$status'  WHERE laudoNumProp ='$idprop'";

    if (!mysqli_query($conn, $sql)) {
        header("location: laudos?error=stmtfailed2");
    }
}

function atualizarDataExameQualidade($conn, $propid, $dataex)
{
    if ($dataex != null) {
        $dataex = explode("-", $dataex);
        $dataex = $dataex[2] . "/" . $dataex[1] . "/" . $dataex[0];
    }

    $sql = "UPDATE laudostomograficos SET laudoDataExame='$dataex' WHERE laudoNumProp ='$propid'";

    if (!mysqli_query($conn, $sql)) {
        header("location: planejamento?error=stmtfaileddtex");
    }
}

function notificarFaltaArquivos($conn, $propid, $arquivos)
{

    if (in_array("laudo", $arquivos)) {
        $textoQualidade = "Atenção! Proposta nº " . $propid . " esta sem Laudo Tomográfico.";

        $url = 'https://hooks.zapier.com/hooks/catch/8414821/b85uypl?';
        $data = array(
            'texto' => $textoQualidade,
        );

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
        }
    }

    $docs = "";
    foreach ($arquivos as $value) {
        $docs = $docs . ", " . $value;
    }

    $textoQualidade = "Atenção! Proposta nº " . $propid . " esta sem Laudo Tomográfico.";

    //notificar cliente
    //criar e-mail

    header("location: new-update-plan?id=" . $propid);
}

function deleteItem($conn, $id, $item)
{

    deleteItemFromItensProposta($conn, $id, $item);

    //Pesquisa lista de itens da proposta
    $listaItens = array();
    $listaItensID = array();

    $sql = "SELECT * FROM itensproposta WHERE itemPropRef='$id'";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {

        if ($row['itemId'] != $item) {
            array_push($listaItens, $row['itemCdg']);
            array_push($listaItensID, $row['itemId']);
        }
    }

    $listaItens = implode(',', $listaItens);
    $listaItensID = implode(',', $listaItensID);

    updateListaItensBD($conn, $id, $listaItensID, $listaItens);
}

function deleteItemFromItensProposta($conn, $id, $item)
{
    $sql = "DELETE FROM itensproposta WHERE itemId='$item' AND itemPropRef='$id'";

    mysqli_query($conn, $sql);
}

function updateListaItensBD($conn, $id, $listaItensBD, $listaItens)
{
    $sql = "UPDATE propostas SET propListaItensBD='$listaItensBD', propListaItens='$listaItens' WHERE propId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: update-proposta?id=" . $id);
    } else {
        header("location: update-proposta?error=stmtfailed");
    }
    mysqli_close($conn);
}

function verifyStatusProp($conn, $id)
{

    $content = '';

    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId=$id");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row['propStatus'];
        $propUser = $row['propUserCriacao'];
        $rep = $row['propRepresentante'];


        $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid=$propUser");
        while ($rowUser = mysqli_fetch_array($retUser)) {
            $celular = $rowUser['usersCel'];
            $nomeCompleto = $rowUser['usersName'];
            $nomeCompleto = explode(" ", $nomeCompleto);
            $nome = $nomeCompleto[0];
        }
    }

    $searchRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $rep . "';");
    while ($rowRep = mysqli_fetch_array($searchRep)) {
        $foneRep = $rowRep['usersFone'];
        $RepNomeCompleto = $rowRep['usersName'];
        $RepNomeCompleto = explode(" ", $RepNomeCompleto);
        $nomeRep = $RepNomeCompleto[0];
    }

    $celRep = implode('', explode(' ', $foneRep));
    $celRep = implode('', explode('-', $celRep));
    $celRep = implode('', explode('(', $celRep));
    $celRep = implode('', explode(')', $celRep));
    $celularRep = '+55' . $celRep;



    // if ($status  == "EM ANÁLISE") {
    //     $content = '*Olá, ' . $nome . '!* Sua solicitaçao de proposta Nº ' . $id . ' encontra-se em análise. Em breve receberá mais informações no número cadastrado.';
    //     $contentRep = '*Olá, ' . $nomeRep . '!* A solicitaçao de proposta Nº ' . $id . ' encontra-se em análise.';
    // }

    // if ($status  == "LIBERADO") {
    //     $content = '*Olá, ' . $nome . '!* Liberada a proposta Nº ' . $id . '. Acesse o Portal Conecta pelo _LINK: https://conecta.cpmhdigital.com.br/minhassolicitacoes.php_. Para ter acesso é necessário que esteja logado na sua conta. Verifique se a proposta está conforme sua solicitação. Para maior agilidade você poderá fazer o aceite da proposta pelo portal.';
    //     $contentRep = '*Olá, ' . $nomeRep . '!* A proposta Nº ' . $id . ' já foi liberada para o cliente.';
    // }

    // if ($status  == "APROVADO") {
    //     $content = '*Olá, ' . $nome . '!* Já recebemos sua aprovação da proposta Nº ' . $id . '. Em breve receberá mais informações no número cadastrado.';
    //     $contentRep = '*Olá, ' . $nomeRep . '!* A proposta Nº ' . $id . ' já foi aprovada pelo cliente.';
    // }

    // if ($status  == "PEDIDO") {
    //     $content = '*Olá, ' . $nome . '!* Sua proposta Nº ' . $id . ' acaba de virar pedido. Acompanhe na plataforma o andamento do seu pedido. Em breve você receberá mais informações no número cadastrado.';
    //     $contentRep = '*Olá, ' . $nomeRep . '!* A proposta Nº ' . $id . ' acaba de virar pedido.';
    // }

    // //Adicionar notificação para Status = Pedido


    // $cel = implode('', explode(' ', $celular));
    // $cel = implode('', explode('-', $cel));
    // $cel = implode('', explode('(', $cel));
    // $cel = implode('', explode(')', $cel));
    // $notificationCelular = '+55' . $cel;

    // sendNotification($notificationCelular, $content);
    // sendNotification($celularRep, $contentRep);
    exit();
}

function verifyStatusTC($conn, $id)
{

    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId=$id");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row['propStatusTC'];
        $propUser = $row['propUserCriacao'];
        $rep = $row['propRepresentante'];
        $empresa = $row['propEmpresa'];
        $dr = $row['propNomeDr'];
        $pac = $row['propNomePac'];
        $uf = $row['propUf'];
        $rep = $row['propRepresentante'];
        $textoReprov = $row['propTxtReprov'];
    }

    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $propUser . "';");
    while ($rowUser = mysqli_fetch_array($searchUser)) {
        $celular = $rowUser['usersCel'];
        $nomeCompleto = $rowUser['usersName'];
        $nomeCompleto = explode(" ", $nomeCompleto);
        $nome = $nomeCompleto[0];
        $email = $rowUser["usersEmail"];
    }

    $celRep = implode('', explode(' ', $celular));
    $celRep = implode('', explode('-', $celRep));
    $celRep = implode('', explode('(', $celRep));
    $celRep = implode('', explode(')', $celRep));
    $celFinal = '+55' . $celRep;

    if (strpos($status, 'APROVADA')) {
        //Notificação TC Aprovada
        $texto = "";
    } else {
        //Notificação TC Reprovada
        $texto = "Entre na plataforma conecta para reenviar seus arquivos.";
    }

    $content = '*PORTAL CONECTA*
    
    Olá ' . $nome . '! Analisamos os seus arquivos enviados pela proposta nº ' . $id . '.
     ' . $status . '
     Obs.: ' . $textoReprov . '.
     Nº Proposta: ' . $id . '.
     Empresa:' . $empresa . '.
     UF:' . $uf . '.
     Dr(a): ' . $dr . '.
     Pac: ' . $pac . '.
     ' . $texto;

    // sendNotification($celFinal, $content);

    //Link live API
    // $url = 'https://hooks.zapier.com/hooks/catch/8414821/bicr8zd?';
    $url = 'https://webhooks.integrately.com/a/webhooks/a0915e9f34ea44d28bade784fc3c33cb?';

    //Link localhost API
    // $url = 'https://hooks.zapier.com/hooks/catch/8414821/bi2bdzd?';
    $data = array(
        'idprop' => $id,
        'status' => $status,
        'propUser' => $propUser,
        'rep' => $rep,
        'empresa' => $empresa,
        'dr' => $dr,
        'pac' => $pac,
        'uf' => $uf,
        'textoReprov' => $textoReprov,
        'texto' => $texto,
        'email' => $email
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    exit();
}


//Financeiro
function addPlano($conn, $nome)
{
    $sql = "INSERT INTO planosfinanceiros (finModalidade) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerfinanceiro?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerfinanceiro?error=none");
    exit();
}

function addPgto($conn, $nome)
{
    $sql = "INSERT INTO formapagamento (pgtoNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerfinanceiro?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerfinanceiro?error=none");
    exit();
}

function addStatusFin($conn, $nome)
{
    $sql = "INSERT INTO statusfinanceiro (stFinName) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerfinanceiro?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerfinanceiro?error=none");
    exit();
}

function deletePlano($conn, $id)
{
    $sql = "DELETE FROM planosfinanceiros WHERE finId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gerfinanceiro?error=deleted");
    } else {
        header("location: gerfinanceiro?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deletePgto($conn, $id)
{
    $sql = "DELETE FROM formapagamento WHERE pgtoId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gerfinanceiro?error=deleted");
    } else {
        header("location: gerfinanceiro?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteStatusFin($conn, $id)
{
    $sql = "DELETE FROM statusfinanceiro WHERE stfinId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gerfinanceiro?error=deleted");
    } else {
        header("location: gerfinanceiro?error=stmtfailed");
    }
    mysqli_close($conn);
}


//NOVA SENHA
function newPassword($conn, $email)
{

    $uidExists = uidExists($conn, $email, $email);

    if ($uidExists == false) {
        header("location: ../senha?error=wrongemail");
        exit();
    }

    $uid = $uidExists["usersUid"];
    $userEmail = $uidExists["usersEmail"];
    $celular = $uidExists["usersCel"];
    $nomeCompleto = $uidExists["usersName"];
    $nomeCompleto = explode(" ", $uidExists["usersName"]);
    $nome = $nomeCompleto[0];

    $pwd = generatePwd();
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    editPwdFromRecover($conn, $uid, $hashedPwd, $userEmail, $nome, $pwd, $celular);
}

function generatePwd()
{
    $upper = implode('', range('A', 'Z')); // ABCDEFGHIJKLMNOPQRSTUVWXYZ
    $lower = implode('', range('a', 'z')); // abcdefghijklmnopqrstuvwxyzy
    $nums = implode('', range(0, 9)); // 0123456789

    $alphaNumeric = $upper . $lower . $nums; // ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789
    $string = '';
    $len = 7; // numero de chars
    for ($i = 0; $i < $len; $i++) {
        $string .= $alphaNumeric[rand(0, strlen($alphaNumeric) - 1)];
    }
    return $string; // ex: q02TAq3

}

function editPwdFromRecover($conn, $user, $hashedPwd, $userEmail, $nome, $pwd, $celular)
{
    $content = '*PORTAL CONECTA*
    Olá ' . $nome . '! Você solicitou a *redefinição de senha do Portal Conecta*. Siga as instruções para retomar seu acesso.';
    $content .= '1º Entre no Portal Conecta pelo link https://conecta.cpmhdigital.com.br. [usuário: *_' . $user . '_* / senha: *_' . $pwd . '_*].';
    $content .= '2º Entre no seu perfil e atualize a senha para a que você desejar.';


    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE usersUid='$user'";

    if (mysqli_query($conn, $sql)) {

        sendEmailNotification($userEmail, $nome, $pwd, $user);
        $cel = implode('', explode(' ', $celular));
        $cel = implode('', explode('-', $cel));
        $cel = implode('', explode('(', $cel));
        $cel = implode('', explode(')', $cel));
        $notificationCelular = '+55' . $cel;

        // sendNotification($notificationCelular, $content);
    } else {
        header("location: ../senha?error=wrongemail");
    }
    mysqli_close($conn);
}

//Notif Wpp
function formatCelularForWpp($phone)
{
    $celRep = implode('', explode(' ', $phone));
    $celRep = implode('', explode('-', $celRep));
    $celRep = implode('', explode('(', $celRep));
    $celRep = implode('', explode(')', $celRep));
    $formated = '+55' . $celRep;

    return $formated;
}

function sendNotification($phone, $content)
{

    $data = [
        'phone' => $phone, // Receivers phone
        'body' => $content, // Message
    ];

    $json = json_encode($data); // Encode data to JSON

    // URL for request POST /message
    $url = 'https://api.chat-api.com/instance271590/sendMessage?token=2agtk9erjtmgh0f5';

    // Make a POST request
    $options = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]
    ]);

    // Send a request
    $result = file_get_contents($url, false, $options);
    // print_r($result);
    // exit();
}

//Notif Recuperação Senha
function sendEmailNotification($userEmail, $nome, $pwd, $user)
{
    $thisYear = date("Y");
    // Campo E-mail
    $arquivo = '
        <html>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
        <style>
            .box{
                background-color: #373342;
                padding: 10px 10px;
                display: flex;
                justify-content: center;
            }

            .box-middle{
                background-color: #e9e9e9;
                padding: 5px 5px;
                display: flex;
                justify-content: center;
            }

            h1{
                color: #fff;
                font-weight: 500px;
                font-family: "Montserrat", sans-serif;
                display: block;
            }

            h3{
                font-family: "Montserrat", sans-serif;
            }

            li{
                font-family: "Montserrat", sans-serif;
            }

            ul{
                list-style-type: none;
                text-align: center;
            }

            p{
                font-weight: 300px;
                font-family: "Montserrat", sans-serif;
            }

            .font-text{
                font-family: "Montserrat", sans-serif;	
            }

            .d-block{
                display: flex;
                flex-direction: column;
            }

            
        </style>

        <body>
            <div class="logo">
                
            </div>
            <div class="box">
                <h1>Alteração de Senha</h1>
            </div>
            <div class="d-block">
                <div class="box-middle">
                    <h3>Olá ' . $nome . '!</h3>
                </div>
                <div class="box-middle">
                    <p>Você solicitou a <b>redefinição de senha do Portal Conecta</b>. Siga as instruções abaixo para retomar seu acesso.</p>
                </div>
            </div>
            <div class="d-block">
                <div class="box-middle">
                    <ul>
                        <li>1º Entre no <a href="https://conecta.cpmhdigital.com.br">Portal Conecta</a>.</li>
                        <li>usuário: <b>' . $user . '</b> </li>
                        <li>senha: <b>' . $pwd . '</b></li>
                        <li>2º Entre no seu perfil e atualize a senha para a que você desejar.</li>
                    </ul>
                </div>
                <div class="box-middle" style="padding-top: 30px;">
                    <small class="font-text" style="color: gray; text-align: center;">Caso você não tenha solicitado a alteração de senha, mude sua senha na plataforma para sua segurança.</small>
                </div>
            </div>

            <div class="box-middle" style="padding-bottom: : 40px;">
                <small class="font-text" style="color: gray;">&copy; Portal Conecta ' . $thisYear . '</small>
            </div>

            <div class="box-middle" style="padding-bottom: : 40px;"></div>
        </body>

        </html>

    ';

    $destino = $userEmail;
    $assunto = "Recuperar Senha - Portal Conecta";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: notificacao@conecta.cpmhdigital.com.br';
    //$headers .= "Bcc: $EmailPadrao\r\n";

    $enviaremail = mail($destino, $assunto, $arquivo, $headers);
    if ($enviaremail) {
        header("location: ../senha?error=none");
    }
    // else {
    //     header("location: ../password.php?error=wrongemail");
    // }
}

//Notif Novo Cadastro
function sendEmailNotificationCreate($userEmail, $nome)
{
     $thisYear = date("Y");
     
    // Campo E-mail
    $arquivo = '
    <html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
    <style>
        .box{
            background-color: #373342;
            padding: 10px 10px;
            display: flex;
            justify-content: center;
        }

        .box-middle{
            background-color: #e9e9e9;
            padding: 5px 5px;
            display: flex;
            justify-content: center;
        }

        h1{
            color: #fff;
            font-weight: 500px;
            font-family: "Montserrat", sans-serif;
            display: block;
        }

        h3{
            font-family: "Montserrat", sans-serif;
        }

        li{
            font-family: "Montserrat", sans-serif;
        }

        ul{
            list-style-type: none;
            text-align: center;
        }

        p{
            font-weight: 300px;
            font-family: "Montserrat", sans-serif;
        }

        .font-text{
            font-family: "Montserrat", sans-serif;	
        }

        .d-block{
            display: flex;
            flex-direction: column;
        }

        
    </style>

    <body>
        <div class="logo">
            
        </div>
        <div class="d-block">
            <div class="box-middle">
                <h3>Bem vindo(a) ' . $nome . '!</h3>
            </div>
            <div class="box-middle">
            <p>Bem vindo(a) ao Portal Conecta. Aqui você vai encontrar tudo que você precisa para sua experiência na CPMH ser excelente.</p>
            <p>Seu cadastro está sendo avaliado por um dos nossos colaboradores e em breve você receberá mais detalhes para seu 1º acesso. Fique ligado! Nos vemos em breve!</p>
            </div>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;">
            <small class="font-text" style="color: gray;">&copy; Portal Conecta ' . $thisYear . '</small>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;"></div>
    </body>

    </html>

    ';

    $destino = $userEmail;
    $assunto = "Bem Vindo(a) - Portal Conecta";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: notificacao@conecta.cpmhdigital.com.br';

    mail($destino, $assunto, $arquivo, $headers);
}

//Notif Cadastro Aprovado
function sendEmailNotificationCadastroAprovado($emailEnvio, $nomeEnvio, $usuarioEnvio)
{
    $thisYear = date("Y");
    
    // Campo E-mail
    $arquivo = '
    <html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
    <style>
        .box{
            
            padding: 10px 10px;
            display: flex;
            justify-content: center;
        }

        .box-middle{
            
            padding: 5px 5px;
            display: flex;
            justify-content: center;
        }

        h1{
            
            font-weight: 500px;
            font-family: "Montserrat", sans-serif;
            display: block;
        }

        h3{
            font-family: "Montserrat", sans-serif;
        }

        li{
            font-family: "Montserrat", sans-serif;
        }

        ul{
            list-style-type: none;
            text-align: center;
        }

        p{
            font-weight: 300px;
            font-family: "Montserrat", sans-serif;
        }

        .font-text{
            font-family: "Montserrat", sans-serif;	
        }

        .d-block{
            display: flex;
            flex-direction: column;
        }

        
    </style>
    
    <body>
        <div class="logo">
            
        </div>
        <div class="box">
            <h1>Cadastro Aprovado</h1>
        </div>
        <div class="d-block">
            <div class="box-middle">
                <h3>Olá ' . $nomeEnvio . '!</h3>
            </div>
            <div class="box-middle">
                <p>BEM VINDO AO PORTAL CONECTA!</p>
                <p>Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site conecta.cpmhdigital.com.br e efetue o login com seu usuário
                 <b>' . $usuarioEnvio . ' e a senha criada no momento do cadastro.</b></p>
                
                <p>Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.</p>
            </div>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;">
            <small class="font-text" style="color: gray;">&copy; Portal Conecta ' . $thisYear . '</small>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;"></div>
    </body>

    </html>

    ';

    $destino = $emailEnvio;
    $assunto = "Cadastro Aprovado - CONECTA";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: notificacao@conecta.cpmhdigital.com.br';


    mail($destino, $assunto, $arquivo, $headers);
}

//Notif Proposta Criada
function sendEmailNotificationCreateProposta($conn, $id, $usercriacao)
{

    //Pesquisa proposta
    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $id . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $email = $row['propEmailEnvio'];
        $produto = $row['propTipoProd'];
        $empresa = $row['propEmpresa'];
        $nomedr = $row['propNomeDr'];
        $nomepac = $row['propNomePac'];
        $conv = $row['propConvenio'];
        $uf = $row['propUf'];
        $representante = $row['propRepresentante'];
    }

    $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $usercriacao . "';");
    while ($rowUser = mysqli_fetch_array($retUser)) {
        $nomeCompletoBD = $rowUser['usersName'];
    }

    $primeiroNome = explode(" ", $nomeCompletoBD);
    $primeiroNome = $primeiroNome[0];


    // Campo E-mail
    $arquivo = '
    <html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <style>
        html,
        body,
        .container-fluid {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;

        }
    </style>

    <body>
        <div class="container-fluid box mb-1">
            <div class="container py-2">

                <div class="row d-flex justify-content-center">
                    <h1 class="p-2" style="font-weight: 500px; font-family:  Montserrat, sans-serif;"><b>Nova Solicitação
                            de Proposta</b></h1>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="d-block ">
                        <h3 class="p-2" style="font-weight: 300px; font-family:  Montserrat, sans-serif;"><b>Olá ' .
        $primeiroNome . '!</b></h3>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <p class="text-center p-1" style="font-weight: 300px; font-family:  Montserrat, sans-serif;">Sua nova
                        proposta foi criada com sucesso! </p>
                    <p class="text-center p-1" style="font-weight: 300px; font-family:  Montserrat, sans-serif;">Agora seu
                        pedido será analisado e, em breve, nossos especialistas entrarão em contato.
                        ATENÇÃO!!! Exclusividade de projetos é concedida para o 1º cliente que solicitou com o UPLOAD da TC (tomografia) no portal e com os dados completos.</p>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            <table class="table table-striped" style="width: 300px; text-align: center;">
                                <tbody>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">Produto: </td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' . $produto .
        '</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">Empresa: </td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' . $empresa .
        '</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">Dr(a): </td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' . $nomedr . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">Pac: </td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' . $nomepac .
        '</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">Convênio:</td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' . $conv . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">UF: </td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' . $uf . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start; font-family: Montserrat, sans-serif;">Representante:
                                        </td>
                                        <td style="text-align: center; font-family: Montserrat, sans-serif;">' .
        $representante . '</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="d-block d-flex justify-content-center">
                            <small style="font-family: Montserrat, sans-serif; color: gray; text-align: center;">Caso você
                                não tenha solicitado essa proposta, mude sua senha na plataforma para sua segurança e nos
                                notifique para verificação de segurança do uso do seu cadastro.</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid my-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="d-block">
                        <small style="font-family: Montserrat, sans-serif; color: gray; text-align: center;">&copy; Portal
                            Conecta 2024</small>
                    </div>
                </div>
            </div>
        </div>



    </body>


    </html>

    ';

    //enviar

    // emails para quem será enviado o formulário
    // $emailenviar = $email;
    $destino = $email;
    $assunto = "Nova Proposta - Conecta";

    // É necessário indicar que o formato do e-mail é html
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: notificacao@conecta.cpmhdigital.com.br';
    //$headers .= "Bcc: $EmailPadrao\r\n";

    mail($destino, $assunto, $arquivo, $headers);
    // if ($enviaremail) {
    //     // echo "<script>alert('Seu email foi enviado com sucesso!'); </script>";
    //     header("Location: ../comercial?error=sent");
    // } else {
    //     header("Location: ../comercial?error=senteerror");
    // }
}

//Mudar o proprietário da Proposta
function changeAuthor($conn, $propid, $novousuario)
{
    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $novousuario . "';");
    while ($rowUser = mysqli_fetch_array($searchUser)) {
        $cnpj = trim($rowUser['usersCnpj']);
        $cpf = trim($rowUser['usersCpf']);
        $email = trim($rowUser["usersEmail"]);
        $empresa = trim($rowUser["usersEmpr"]);
    }

    $cpfcnpj = $cnpj . $cpf;

    //Atualiza a nova proposta
    $sql = "UPDATE propostas SET propUserCriacao = ?, propEmailCriacao = ?, propEmailEnvio = ?, propEmpresa = ?, propCnpjCpf = ? WHERE propId ='$propid'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../update-proposta?id=" . $propid);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $novousuario, $email, $email, $empresa, $cpfcnpj);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../update-proposta?id=" . $propid);
    exit();
}

// function changeDoutor($conn, $propid, $doutoruid)
// {
//     $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $doutoruid . "';");
//     while ($rowUser = mysqli_fetch_array($searchUser)) {
//         $nomedr = trim($rowUser['usersName']);
//         $crm = trim($rowUser['usersCrm']);
//         $telefone = trim($rowUser["usersFone"]);
//         $emaildr = trim($rowUser["usersEmail"]);
//     }

//     //Atualiza a nova proposta
//     $sql = "UPDATE propostas SET propNomeDr = ?, propNConselhoDr = ?, propEmailDr = ?, propTelefoneDr = ?, propDrUid = ? WHERE propId ='$propid'";
//     $stmt = mysqli_stmt_init($conn);


//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../update-proposta?id=" . $propid);
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "sssss", $nomedr, $crm, $emaildr, $telefone, $doutoruid);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);

//     header("location: ../update-proposta?id=" . $propid);
//     exit();
// }

function changeDoutor($conn, $propid, $doutoruid)
{
    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $doutoruid . "';");
    while ($rowUser = mysqli_fetch_array($searchUser)) {
        $nomedr = trim($rowUser['usersName']);
        $crm = trim($rowUser['usersCrm']);
        $telefone = trim($rowUser["usersFone"]);
        $emaildr = trim($rowUser["usersEmail"]);
    }


    //pegar dados da proposta
    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId ='$propid'");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row["propStatus"];
        $pedido = $row["propPedido"];
    }

    if ($status == "PEDIDO") {

        //Atualiza a nova proposta
        $sql = "UPDATE propostas SET propNomeDr = ?, propNConselhoDr = ?, propEmailDr = ?, propTelefoneDr = ?, propDrUid = ? WHERE propId ='$propid'";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../update-proposta?id=" . $propid . "&error=proponaoatualizada");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $nomedr, $crm, $emaildr, $telefone, $doutoruid);
        mysqli_stmt_execute($stmt);

        //Atualiza a nova pedido
        $sql = "UPDATE pedido SET pedUserCriador = ? WHERE pedNumPedido ='$pedido'";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../update-proposta?id=" . $propid . "&error=pednaoatualizada");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $doutoruid);
        mysqli_stmt_execute($stmt);
    } else {
        //Atualiza a nova proposta
        $sql = "UPDATE propostas SET propNomeDr = ?, propNConselhoDr = ?, propEmailDr = ?, propTelefoneDr = ?, propDrUid = ? WHERE propId ='$propid'";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../update-proposta?id=" . $propid);
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $nomedr, $crm, $emaildr, $telefone, $doutoruid);
        mysqli_stmt_execute($stmt);
    }


    mysqli_stmt_close($stmt);

    header("location: ../update-proposta?id=" . $propid);
    exit();
}

//Functions CASOS
function deleteCasos($conn, $id)
{
    $sql = "DELETE FROM pedido WHERE pedId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: casos?error=deleted");
    } else {
        header("location: casos?error=stmtfailed");
    }
    
    
    //registra Log
    $ped = getPedFromId($conn, $id);

    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $ped["pedNumPedido"],
        'atividade' => "Pedido deletado"
    );

    logAtividadePedProp($conn, $dados);

    
    mysqli_close($conn);
}

function editCaso($conn, $caso)
{

    $sql = "UPDATE pedido SET pedNumPedido=?, pedNomeDr=?, pedNomePac=? , pedTipoProduto=? , pedProduto=?, pedTecnico=?, pedObservacao=?, loteop=?  WHERE pedId=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../update-caso?id=" . $caso["casoId"] . "&error=pednaoatualizado");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssss", $caso["numped"], $caso["nomedr"], $caso["nomepac"], $caso["tipoproduto"], $caso["especificacao"], $caso["tecnico"], $caso["observacao"], $caso["loteop"], $caso["casoId"]);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);

    //registra Log
    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $caso["numped"],
        'atividade' => "Informações do Pedido editadas"
    );

    logAtividadePedProp($conn, $dados);


    header("location: ../update-caso?id=" . $caso["casoId"] . "&error=pedatualizado");
    exit();

}

function editStatusCaso($conn, $dataStatus)
{
    $codStatus = $dataStatus["status"];

    $ret = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$codStatus'");
    while ($row = mysqli_fetch_array($ret)) {
        $posicao = $row["stpedPosicao"];
        $andamentoPed = $row["stpedAndamento"];
    }

    $sql = "UPDATE pedido SET pedStatus=?, pedAbaDocumentos=?, pedAbaAgenda=? , pedAbaAceite=? , pedAbaRelatorio=?, pedAbaVisualizacao=?, pedAndamento=?, pedPosicaoFluxo=?, pedDocsFaltantes=?  WHERE pedId=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../update-caso?id=" . $dataStatus["casoId"] . "&error=statusnaoatualizado");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssss", $dataStatus["status"], $dataStatus["documentos"], $dataStatus["agenda"], $dataStatus["aceite"], $dataStatus["relatorio"], $dataStatus["visualizacao"], $andamentoPed, $posicao, $dataStatus["docsfaltantes"], $dataStatus["casoId"]);

    mysqli_stmt_execute($stmt);

    if ($codStatus == 'Avaliar Projeto') {
        sendNotificacaoAvaliarProjeto($conn, $dataStatus);
    }


    $data = array(
        'pedido' => $dataStatus["numped"]
    );

    criarPrazoModuloII($conn, $data, $codStatus);

    //registra Log
    $atividade = "Status Pedido Alterado para <b>" . getFullNomeFluxoPed($conn, $codStatus) . "</b>";


    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $dataStatus["numped"],
        'atividade' => $atividade
    );

    logAtividadePedProp($conn, $dados);

    mysqli_stmt_close($stmt);

    // header("location: ../update-caso?id=" . $dataStatus["casoId"] . "&error=statusatualizado");

    if ($_SESSION["userperm"] == 'Planej. Ortognática') {
        header("location: ../casos2?error=statusatualizado");
    } else {
        header("location: ../casos?error=statusatualizado");
    }

    //se for produção mandar pro sistemas fabrica
    if ($codStatus == 'PROD') {
        enviarPedidoSistemaFabrica($conn, $dataStatus["numped"]);
    }


    exit();
}

function enviarPedidoSistemaFabrica($conn, $numped)
{
    $dataPed = getAllDataFromPed($conn, $numped);
    //data do aceite
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    // $url = 'http://localhost/fabrica/api/pedido';
    $url = 'http://fabrica.cpmh.com.br/api/pedido';

    $data = array(
        'projetista' => $dataPed['pedTecnico'],
        'dr' => $dataPed['pedNomeDr'],
        'pac' => $dataPed['pedNomePac'],
        'rep' => $dataPed['pedRep'],
        'pedido' => $dataPed['pedNumPedido'],
        'dt' => $dataAtual,
        'produto' => $dataPed['pedTipoProduto'],
        'dataEntrega' => $dataPed['pedDtEntrega']
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function sendNotificacaoAvaliarProjeto($conn, $dataStatus)
{
    $numPed = $dataStatus['numped'];
    $dataPed = getAllDataFromPed($conn, $numPed);
    //data do aceite
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    $url = 'https://webhooks.integrately.com/a/webhooks/163b2f78516c4b28b29ac31d37506bac?';

    $data = array(
        'projetista' => $dataPed['pedTecnico'],
        'dr' => $dataPed['pedNomeDr'],
        'pac' => $dataPed['pedNomePac'],
        'rep' => $dataPed['pedRep'],
        'pedido' => $dataPed['pedNumPedido'],
        'dt' => $dataAtual,
        'produto' => $dataPed['pedTipoProduto']
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    // exit();

    //     Olá, Revisor! Um projeto requer sua revisão e aprovação. 

    // Projetista: (nome)
    // Dr(a): (nome)
    // Paciente: (iniciais)
    // Representante: (nome)
    // Pedido: (número)
    // Data envio : (data e horário)
    // Produto: (nome do produto)

    // Clique aqui (link) para acessá-lo

}

function sendNotificacaoSolicitadoAlteracao($conn, $dataStatus)
{
    $numPed = $dataStatus['numped'];
    $dataPed = getAllDataFromPed($conn, $numPed);
    //data do aceite
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    $url = 'https://webhooks.integrately.com/a/webhooks/ab997ab2aa664896ba19f19ebfeaed9d?';

    $data = array(
        'projetista' => $dataPed['pedTecnico'],
        'dr' => $dataPed['pedNomeDr'],
        'pac' => $dataPed['pedNomePac'],
        'rep' => $dataPed['pedRep'],
        'pedido' => $dataPed['pedNumPedido'],
        'dt' => $dataAtual,
        'produto' => $dataPed['pedTipoProduto'],
        'comentario' => $dataStatus['comentario'],
        'revisor' => $dataStatus['revisor']
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    // exit();

    //     Olá, Revisor! Um projeto requer sua revisão e aprovação. 

    // Projetista: (nome)
    // Dr(a): (nome)
    // Paciente: (iniciais)
    // Representante: (nome)
    // Pedido: (número)
    // Data envio : (data e horário)
    // Produto: (nome do produto)

    // Clique aqui (link) para acessá-lo

}

function sendNotificacaoProjetoLiberado($conn, $dataStatus){
    $numPed = $dataStatus['numped'];
    $dataPed = getAllDataFromPed($conn, $numPed);
    //data do aceite
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    $url = 'https://webhooks.integrately.com/a/webhooks/4b80484a574c41d1ab7f7be11ac68445?';
    

    $data = array(
        'projetista' => $dataPed['pedTecnico'],
        'dr' => $dataPed['pedNomeDr'],
        'pac' => $dataPed['pedNomePac'],
        'rep' => $dataPed['pedRep'],
        'pedido' => $dataPed['pedNumPedido'],
        'dt' => $dataAtual,
        'produto' => $dataPed['pedTipoProduto'],
        'comentario' => $dataStatus['comentario'],
        'revisor' => $dataStatus['revisor']
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    // exit();

    //     Olá, Revisor! Um projeto requer sua revisão e aprovação. 

    // Projetista: (nome)
    // Dr(a): (nome)
    // Paciente: (iniciais)
    // Representante: (nome)
    // Pedido: (número)
    // Data envio : (data e horário)
    // Produto: (nome do produto)

    // Clique aqui (link) para acessá-lo
}

function editUrl3d($conn, $url3d, $nped, $user, $url3d2, $urlvideo)
{
    //editar na tabela visualizador
    $sql = "UPDATE visualizador SET visUrl3D='$url3d', visUrl3D2='$url3d2', visUrlVideo='$urlvideo', visUser='$user' WHERE visNumPed='$nped'";

    $encrypted = hashItemNatural($nped);

    if (mysqli_query($conn, $sql)) {
        header("location: ../unit?id=" . $encrypted . "&error=none");
    } else {
        header("location: ../unit?id=" . $encrypted . "&error=stmfailed");
    }
    mysqli_close($conn);

    exit();
}

function addComentVisualizer($conn, $coment, $nped, $user)
{
    $sql = "INSERT INTO comentariosvisualizador (comentVisUser, comentVisNumPed, comentVisText) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    $encrypted = hashItemNatural($nped);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../unit?id=" . $encrypted . "&error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $user, $nped, $coment);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../unit?id=" . $encrypted . "&error=sent");
    exit();
}

//Banco de Imagens
function addImgProduto($conn, $categoria, $nomeimg, $cdg, $link)
{
    $sql = "INSERT INTO imagensprodutos (imgprodCategoria, imgprodNome, imgprodCodCallisto, imgprodLink) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../imagens-produtos?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $categoria, $nomeimg, $cdg, $link);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../imagens-produtos?error=add");
    exit();
}

function editImagem($conn, $imgprodId, $categoria, $cdg, $nome, $link)
{
    $sql = "UPDATE imagensprodutos SET imgprodCategoria='$categoria', imgprodCodCallisto ='$cdg', imgprodNome='$nome', imgprodLink ='$link' WHERE imgprodId='$imgprodId'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../imagens-produtos?error=none");
    } else {
        header("location: ../imagens-produtos?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteImagem($conn, $id)
{
    $sql = "DELETE FROM imagensprodutos WHERE imgprodId='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: imagens-produtos?error=deleted");
    } else {
        header("location: imagens-produtos?error=stmtfailed");
    }

    mysqli_close($conn);
    exit();
}

//Convênios
function createConvenio($conn, $nome)
{
    $sql = "INSERT INTO convenios (convName) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../convenios?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../convenios?error=add");
    exit();
}

function editConvenio($conn, $id, $nome)
{
    $sql = "UPDATE convenios SET convName='$nome' WHERE convId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../convenios?error=edit");
    } else {
        header("location: ../convenios?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteConv($conn, $id)
{
    $sql = "DELETE FROM convenios WHERE convId='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: convenios?error=deleted");
    } else {
        header("location: convenios?error=stmtfailed");
    }

    mysqli_close($conn);
    exit();
}

//Setores
function createSetor($conn, $nome)
{
    $sql = "INSERT INTO setores (setNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../setores?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../setores?error=add");
    exit();
}

function editSetor($conn, $id, $nome)
{
    $sql = "UPDATE setores SET setNome='$nome' WHERE setId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../setores?error=edit");
    } else {
        header("location: ../setores?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteSetor($conn, $id)
{
    $sql = "DELETE FROM setores WHERE setId='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: setores?error=deleted");
    } else {
        header("location: setores?error=stmtfailed");
    }

    mysqli_close($conn);
    exit();
}

//FÓRUM
function createForum($conn, $user, $tipoConta, $setor, $status, $assunto, $tipoTexto, $texto)
{

    //Criar nova pergunta fórum
    $sql = "INSERT INTO forum (faqUserCriador, faqTipoConta, faqSetor, faqStatus, faqAssuntoPrincipal, faqTipoTexto, faqTexto) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sacconecta?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $user, $tipoConta, $setor, $status, $assunto, $tipoTexto, $texto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($tipoTexto == "Dúvida") {
        header("location: ../sacconecta?error=noned");
        exit();
    } else {
        header("location: ../sacconecta?error=nones");
        exit();
    }
}

function addComentForum($conn, $coment, $nfaq, $user)
{
    $sql = "INSERT INTO comentariosforum (faqcomentUserCriador, faqcomentFaqId, faqcomentTexto) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../q?id=" . $nfaq . "&error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $user, $nfaq, $coment);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../q?id=" . $nfaq . "&error=sent");
    exit();
}

function deleteForum($conn, $id)
{
    $sql = "DELETE FROM forum WHERE faqId='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: gersuporte?error=deleted");
    } else {
        header("location: gersuporte?error=stmtfailed");
    }

    deleteComentFromFaqComents($conn, $id);

    mysqli_close($conn);
    exit();
}

function deleteComentFromFaqComents($conn, $id)
{
    $sql = "DELETE FROM comentariosforum WHERE faqcomentFaqId='$id';";

    mysqli_query($conn, $sql);
}

function respondidoForum($conn, $id)
{
    $newStatus = 'Respondido';
    $sql = "UPDATE forum SET faqStatus='$newStatus' WHERE faqId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gersuporte?error=edit");
    } else {
        header("location: gersuporte?error=stmtfailed");
    }
    mysqli_close($conn);
}

function resolvidoForum($conn, $id)
{
    $newStatus = 'Resolvido';
    $sql = "UPDATE forum SET faqStatus='$newStatus' WHERE faqId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gersuporte?error=edit");
    } else {
        header("location: gersuporte?error=stmtfailed");
    }
    mysqli_close($conn);
}

function fazerForum($conn, $id)
{
    $newStatus = 'A Fazer';
    $sql = "UPDATE forum SET faqStatus='$newStatus' WHERE faqId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gersuporte?error=edit");
    } else {
        header("location: gersuporte?error=stmtfailed");
    }
    mysqli_close($conn);
}


//Agenda
function addStatusAgenda($conn, $nome)
{
    $sql = "INSERT INTO statusagenda (statusagendaNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerenciamento-agenda?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerenciamento-agenda");
    exit();
}

function deleteStatusAgenda($conn, $id)
{
    $sql = "DELETE FROM statusagenda WHERE statusagendaId='$id';";

    mysqli_query($conn, $sql);
    header("location: gerenciamento-agenda");
    exit();
}

function addFeedbackAgenda($conn, $nome)
{
    $sql = "INSERT INTO feedbackagenda (feedbackagendaNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerenciamento-agenda?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerenciamento-agenda");
    exit();
}

function deleteFeedbackAgenda($conn, $id)
{
    $sql = "DELETE FROM feedbackagenda WHERE feedbackagendaId='$id';";

    mysqli_query($conn, $sql);
    header("location: gerenciamento-agenda");
    exit();
}

function addResponsavelAgenda($conn, $nome)
{
    $sql = "INSERT INTO responsavelagenda (responsavelagendaNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerenciamento-agenda?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../tecnicos");
    exit();
}

function deleteResponsavelAgenda($conn, $id)
{
    $sql = "DELETE FROM responsavelagenda WHERE responsavelagendaId='$id';";

    mysqli_query($conn, $sql);
    header("location: tecnicos");
    exit();
}

function addProdutoAgenda($conn, $nome)
{
    $sql = "INSERT INTO produtoagenda (produtoagendaNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerenciamento-agenda?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerenciamento-agenda");
    exit();
}

function deleteproduto($conn, $id)
{
    $sql = "DELETE FROM produtoagenda WHERE produtoagendaId='$id';";

    mysqli_query($conn, $sql);
    header("location: gerenciamento-agenda");
    exit();
}

function addHorario($conn, $cdg, $horario)
{
    $sql = "INSERT INTO horasdisponiveisagenda (hrCodigo, hrHorario) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerenciamento-agenda?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $cdg, $horario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerenciamento-agenda");
    exit();
}

function deleteHorario($conn, $id)
{
    $sql = "DELETE FROM horasdisponiveisagenda WHERE hrId='$id';";

    mysqli_query($conn, $sql);
    header("location: gerenciamento-agenda");
    exit();
}

function updateAgenda($conn, $opvideo, $user, $projeto, $doutor, $pac, $produto, $truedate, $truetime, $cdghora)
{
    $status = 'MARCADO';
    $statusVideo = 'A Fazer';

    $sql = "UPDATE agenda SET agdUserCriador='$user', agdNomeDr='$doutor', agdNomPac='$pac', agdProd='$produto', agdStatus='$status', agdStatusVideo='$statusVideo', agdTipo='$opvideo', agdData='$truedate', agdHora='$truetime', agdCodHora='$cdghora' WHERE agdNumPedRef='$projeto'";

    $encrypted = hashItemNatural($projeto);

    if (mysqli_query($conn, $sql)) {
        header("location:  ../unit?id=" . $encrypted);
    } else {
        header("location:  ../unit?id=" . $encrypted . "?error=stmtfailed");
    }

    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/51fe9428bc47481cae53def81109205b?';
    // $url = 'https://webhooks.integrately.com/a/webhooks/47a4e83e248c4e83862f637dd2cd7df5?';

    $data = array(
        'usercriador' => $user,
        'tipovideo' => $opvideo,
        'projeto' => $projeto,
        'doutor' => $doutor,
        'pac' => $pac,
        'produto' => $produto,
        'data' => $truedate,
        'hora' => $truetime,
        'cdghora' => $cdghora
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }


    mysqli_close($conn);
    // exit();
}

function saveAgenda($conn, $tipovideo, $user, $projeto, $doutor, $paciente, $produto, $data, $hora, $duracao)
{
    //Mudar status e adicionar video ao conecta
    $status = 'MARCADO';
    $statusVideo = 'A Fazer';
    $encrypted = hashItemNatural($projeto);

    $sql = "UPDATE agenda SET agdUserCriador='$user', agdNomeDr='$doutor', agdNomPac='$paciente', agdProd='$produto', agdStatus='$status', agdStatusVideo='$statusVideo', agdTipo='$tipovideo', agdData='$data', agdHora='$hora', agdCodHora='$duracao' WHERE agdNumPedRef='$projeto'";
    mysqli_query($conn, $sql);
    
    // if (mysqli_query($conn, $sql)) {
    //     header("location:  ../unit?id=" . $projeto);
    // } else {
    //     header("location:  ../unit?id=" . $projeto . "?error=stmtfailed");
    // }

    //criar hash do nº do pedido
    $hashProjeto = hashItem($projeto);

    //mandar wpp com link da vídeo

    //mandar e-mail com detalhes

    //send webhook to add to google agenda

    //retornar a página do projeto

    //exit and close connection

    //pegar dados da proposta
    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propPedido ='$projeto'");
    while ($row = mysqli_fetch_array($ret)) {
        $representanteUid = $row["propRepresentante"];
        $emaildr = $row["propEmailDr"];
    }

    $representante = getNomeRep($conn, $representanteUid);

    
    //Link live API
     $url = 'https://webhooks.integrately.com/a/webhooks/47a4e83e248c4e83862f637dd2cd7df5?';

    $data = array(
        'usercriador' => $user,
        'tipovideo' => $tipovideo,
        'projeto' => $projeto,
        'doutor' => $doutor,
        'pac' => $paciente,
        'produto' => $produto,
        'data' => $data,
        'hora' => $hora,
        'duracao' => $duracao,
        'rep' => $representante,
        'emaildr' =>$emaildr
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

header("location:  /unit?id=" . $encrypted);
    // exit();

    // mysqli_close($conn);
}

function updateAgendaFromGer($conn, $agdId, $status, $feedback, $responsavel)
{
    $sql = "UPDATE agenda SET agdStatusVideo='$status', agdResponsavel='$responsavel', agdFeedback='$feedback' WHERE agdId='$agdId'";

    if (mysqli_query($conn, $sql)) {
        header("location:  ../gerenciamento-agenda");
    } else {
        header("location:  ../gerenciamento-agenda");
    }
    mysqli_close($conn);
}

function updateAgendaTecnica($conn, $tipo, $user, $doutor, $pac, $produto, $truedate, $truetime, $cdghora, $email, $obs)
{

    $status = 'MARCADO';
    $statusVideo = 'A Fazer';

    $sql = "INSERT INTO agenda (agdUserCriador, agdNomeDr, agdNomPac, agdProd, agdStatus, agdStatusVideo, agdTipo, agdData, agdHora, agdCodHora, agdObs) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../agendartecnicacir?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssss", $user, $doutor, $pac, $produto, $status, $statusVideo, $tipo, $truedate, $truetime, $cdghora, $obs);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../agendartecnicacir?error=none");

    // $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $user . "';");
    // while ($rowUser = mysqli_fetch_array($searchUser)) {
    //     $celular = $rowUser['usersCel'];
    //     $nomeCompleto = $rowUser['usersName'];
    //     $nomeCompleto = explode(" ", $nomeCompleto);
    //     $nome = $nomeCompleto[0];
    //     $email = $rowUser["usersEmail"];
    // }

    $timer = explode(" - ", $truetime);
    $start = $timer[0];
    $end = $timer[1];
    $color = "#373342";
    $emailuser = $email;

    //Link live API
    $url = 'https://hooks.zapier.com/hooks/catch/8414821/bixxxri?';

    $data = array(
        'usercriador' => $user,
        'doutor' => $doutor,
        'pac' => $pac,
        'produto' => $produto,
        'tipo' => $tipo,
        'data' => $truedate,
        'cor' => $color,
        'emailuser' => $emailuser,
        'obs' => $obs,
        'horainicio' => $start,
        'horafim' => $end
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    exit();
}

//Aceite


function updateAceite($conn, $projeto, $respAceite, $coment)
{
    //novo status do aceite
    $status = 'ENVIADO';
    $novostatus = $respAceite;

    //data do aceite
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    //update do aceite
    $sql = "UPDATE aceite SET aceiteDeAcordo='$respAceite', aceiteObs='$coment', aceiteStatus='$status' WHERE aceiteNumPed='$projeto'";
    changeStatusPedidoAcaoUsuário($conn, $projeto, $novostatus);

    $data = array(
        'pedido' => $projeto
    );

    // criarPrazoModuloII($conn, $data, $novostatus);

    //pegar dados da proposta
    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propPedido ='$projeto'");
    while ($row = mysqli_fetch_array($ret)) {
        $representanteUid = $row["propRepresentante"];
        $pac = $row["propNomePac"];
        $doutor = $row["propNomeDr"];
        $produto = $row["propTipoProd"];
    }

    // criarPrazoModuloII($conn, $dataAtual, $respAceite);
    criarPrazoPedido($conn, $projeto, $respAceite);

    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/2128b628665d4e6b8a2305d2f5432cf7?';

    $data = array(
        'idprojeto' => $projeto,
        'doutor' => $doutor,
        'pac' => $pac,
        'produto' => $produto,
        'respAceite' => $respAceite,
        'data' => $dataAtual,
        'observacao' => $coment,
        'representante' => $representanteUid
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }

    $encrypted = hashItemNatural($projeto);

    if (mysqli_query($conn, $sql)) {
        header("location:  ../unit?id=" . $encrypted);
    } else {
        header("location:  ../unit?id=" . $encrypted . "?error=stmtfailed");
    }

    mysqli_close($conn);
}

function updateAvaliacao($conn, $projeto, $resposta, $coment)
{
    $status = 'ENVIADO';

    $sql = "UPDATE feedbackaceite SET fdaceiteResposta='$resposta', fdaceiteComentario='$coment', fdaceiteStatus='$status' WHERE fdaceiteNumPed='$projeto'";

    $encrypted = hashItemNatural($projeto);

    if (mysqli_query($conn, $sql)) {
        header("location:  ../unit?id=" . $encrypted);
    } else {
        header("location:  ../unit?id=" . $encrypted . "?error=stmtfailed");
    }
    mysqli_close($conn);
}

//Relatório
function sendArquivoUpload($conn, $user, $nped, $filename, $fileuuid, $cdnurl)
{
    $status = 'ENVIADO';

    $sql = "UPDATE relatorios SET relPath='$cdnurl', relFileName='$filename', relUserCriacao='$user', relStatus='$status' WHERE relNumPedRef='$nped'";
    $encrypted = hashItemNatural($nped);
    if (mysqli_query($conn, $sql)) {
        header("location:  ../unit?id=" . $encrypted);
    } else {
        header("location:  ../unit?id=" . $encrypted . "?error=stmtfailed");
    }

    mysqli_close($conn);
}
function createFileUploadRelatorio($conn, $nped, $path, $fileName, $fileTmpName)
{
    //Registra nova arquivo
    $sql = "INSERT INTO relatorioupload (fileNumPed, filePath, fileRealName) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    $encrypted = hashItemNatural($nped);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:  ../unit?id=" . $encrypted . "?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $nped, $path, $fileName);
    mysqli_stmt_execute($stmt);
    move_uploaded_file($fileTmpName, $path);
    mysqli_stmt_close($stmt);
}

function changeStatusPedidoAcaoUsuário($conn, $pedido, $status)
{

    $ret = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$status'");
    while ($row = mysqli_fetch_array($ret)) {
        $posicao = $row["stpedPosicao"];
        $andamentoPed = $row["stpedAndamento"];
    }

    //Atualiza a nova pedido
    $sql = "UPDATE pedido SET pedStatus = ?, pedAndamento = ?, pedPosicaoFluxo = ? WHERE pedNumPedido ='$pedido'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../update-proposta?id=" . $propid . "&error=pednaoatualizada");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $status, $andamentoPed, $posicao);
    mysqli_stmt_execute($stmt);

    //registra Log
    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $pedido,
        'atividade' => "Pedido atualizado"
    );

    logAtividadePedProp($conn, $dados);
}


//Configurações de Cadastro
function addEspecialidade($conn, $nome)
{
    $sql = "INSERT INTO especialidades (especNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteEspecialidade($conn, $id)
{
    $sql = "DELETE FROM especialidades WHERE especId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addEstado($conn, $nome, $abrev)
{
    $sql = "INSERT INTO estados (ufNomeExtenso, ufAbreviacao) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $abrev);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteEstado($conn, $id)
{
    $sql = "DELETE FROM estados WHERE ufId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addConselho($conn, $nome, $abrev)
{
    $sql = "INSERT INTO conselhosprofissionais (consNomeExtenso, consAbreviacao) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $abrev);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteConselho($conn, $id)
{
    $sql = "DELETE FROM conselhosprofissionais WHERE consId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addCadin($conn, $nome, $codigo)
{
    $sql = "INSERT INTO tipocadastrointerno (tpcadinNome, tpcadinCodCadastro) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $codigo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteCadin($conn, $id)
{
    $sql = "DELETE FROM tipocadastrointerno WHERE tpcadinId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addCadex($conn, $nome, $codigo)
{
    $sql = "INSERT INTO tipocadastroexterno (tpcadexNome, tpcadexCodCadastro) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $codigo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteCadex($conn, $id)
{
    $sql = "DELETE FROM tipocadastroexterno WHERE tpcadexId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

//Representante
function addUfRep($conn, $rep, $user, $email, $fone, $uf, $estado, $regiao)
{
    $sql = "INSERT INTO representantes (repNome, repUid, repFone, repEmail, repUF, repNomeUF, repRegião) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../representantes?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $rep, $user, $fone, $email, $uf, $estado, $regiao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../representantes");
    exit();
}

function deleteEstadoRep($conn, $id)
{
    $sql = "DELETE FROM representantes WHERE repID='$id';";

    mysqli_query($conn, $sql);
    header("location: representantes");
    exit();
}

function createSolicitacaoTrocaProduto($conn, $tipoProd, $idproposta, $userSolicitante)
{
    $sql = "INSERT INTO solicitacaotrocaproduto (solProd, solNumProp, solStatus, solUserSolicitante) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacoes?error=stmfailed");
        exit();
    }

    $status = "Pendente";

    mysqli_stmt_bind_param($stmt, "ssss", $tipoProd, $idproposta, $status, $userSolicitante);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    header("location: ../dados_proposta?id=" . $idproposta . "&error=solicitado");
    exit();
}

function aceitarTrocaProduto($conn, $tipoProd, $idprop)
{

    $status = "Aceito";
    $sql = "UPDATE solicitacaotrocaproduto SET solStatus = ? WHERE solNumProp ='$idprop';";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $status);
    mysqli_stmt_execute($stmt);



    $sql = "UPDATE propostas SET propTipoProd = ? WHERE propId ='$idprop'";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $tipoProd);
    mysqli_stmt_execute($stmt);

    header("location: update-proposta?id=" . $idprop);

    mysqli_stmt_close($stmt);
}

function recusarTrocaProduto($conn, $tipoProd, $idprop)
{

    $status = "Recusado";
    $sql = "UPDATE solicitacaotrocaproduto SET solStatus = ? WHERE solNumProp ='$idprop';";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $status);
    mysqli_stmt_execute($stmt);

    header("location: update-proposta?id=" . $idprop);

    mysqli_stmt_close($stmt);
}

//Configurações de Edição Proposta
function addstatuscomercial($conn, $nome, $indexFluxo)
{
    $sql = "INSERT INTO statuscomercial (stcomNome, stcomIndiceFluxo) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $indexFluxo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deleteComercial($conn, $id)
{
    $sql = "DELETE FROM statuscomercial WHERE stcomId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}

function addstatusPlanejamento($conn, $nome, $indexFluxo)
{
    $sql = "INSERT INTO statusplanejamento (stplanNome, stplanIndiceFluxo) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $indexFluxo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deletePlanejamento($conn, $id)
{
    $sql = "DELETE FROM statusplanejamento WHERE stplanId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}

function addstatusrepresentante($conn, $nome, $indexFluxo)
{
    $sql = "INSERT INTO statusrepresentante (stplanNome, stplanIndiceFluxo) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $indexFluxo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deleteStRepresentante($conn, $id)
{
    $sql = "DELETE FROM statusrepresentante WHERE stplanId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}

function addProdProp($conn, $nome)
{
    $sql = "INSERT INTO produtosproposta (prodpropNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deleteProdProp($conn, $id)
{
    $sql = "DELETE FROM produtosproposta WHERE prodpropId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}

function addStAdiantamento($conn, $nome)
{
    $sql = "INSERT INTO statusadiantamento (stadiantNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deleteAdiant($conn, $id)
{
    $sql = "DELETE FROM statusadiantamento WHERE stadiantId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}

function addStFluxo($conn, $nome)
{
    $sql = "INSERT INTO fluxopedido (flxNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deleteFluxo($conn, $id)
{
    $sql = "DELETE FROM fluxopedido WHERE flxId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}



//Cadastro Doutores Distribuidores
function addDrCadDist($conn, $druid, $user)
{
    //pesquisar se doutor já existe no banco e 
    $result_user = "SELECT * FROM users WHERE usersUid LIKE '%$druid%';";
    $resultado_user = mysqli_query($conn, $result_user);
    if (($resultado_user) and ($resultado_user->num_rows != 0)) {
        $exist = true;
    } else {
        $exist = false;
    }

    if ($exist) {

        $retCNPJ = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $user . "';");
        while ($rowCNPJ = mysqli_fetch_array($retCNPJ)) {
            $cnpj = $rowCNPJ['usersCnpj'];
        }

        $sql = "INSERT INTO caddoutoresdistribuidores (drUidDr, drUidDistribuidor, drDistCNPJ) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../meusdoutores?error=stmfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $druid, $user, $cnpj);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../meusdoutores");
        exit();
    } else {
        header("location: ../meusdoutores?error=notexist");
        exit();
    }
}


//MÓDULO II
// function createModuloII($conn, $id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante, $pedido, $drrespuid, $cnpj)
// {
//     //Criar BD Pedido
//     $valueAbasFechado = "fechado";
//     $valueAbasLiberado = "liberado";
//     $pedAndamento = 'ABERTO';
//     $statusPedInicial = "CRIADO";
//     criarpedido2($conn, $pedido, $id, $drrespuid, $representante, $nomedr, $nomepac, $crm, $listaItens, $tipoProd, $statusPedInicial, $valueAbasFechado, $valueAbasLiberado, $pedAndamento, $cnpj);

//     //Criar BD Agendar
//     $statusAgendaInicial = "VAZIO";
//     criaragenda($conn, $pedido, $nomedr, $nomepac, $tipoProd, $statusAgendaInicial);

//     //Criar BD Visualização de Projeto
//     $statusVisualizacaoInicial = "BLOQUEADO";
//     criarvisualizacao($conn, $pedido, $statusVisualizacaoInicial);

//     //Criar BD Aceite
//     $statusAceiteInicial = "VAZIO";
//     criaraceite($conn, $pedido, $statusAceiteInicial);

//     //Criar BD Feedback Aceite
//     $statusFeedbackAceiteInicial = "VAZIO";
//     criarfeedbackaceite($conn, $pedido, $statusFeedbackAceiteInicial);

//     //Criar BD Docs Anvisa
//     //Tabela anexo i dr qualidade
//     $statusAnexoIdr = "VAZIO";
//     criaranexoidr($conn, $statusAnexoIdr, $pedido);

//     //Tabela anexo i pac qualidade
//     $statusAnexoIPac = "VAZIO";
//     criaranexoipac($conn, $statusAnexoIPac, $pedido);

//     //Tabela anexo ii qualidade
//     $statusAnexoII = "VAZIO";
//     criaranexoii($conn, $statusAnexoII, $pedido);

//     //Tabela anexo iii dr qualidade
//     $statusAnexoIIIDr = "VAZIO";
//     criaranexoiiidr($conn, $statusAnexoIIIDr, $pedido);

//     //Tabela anexo iii pac qualidade
//     $statusAnexoIIIPac = "VAZIO";
//     criaranexoiiipac($conn, $statusAnexoIIIPac, $pedido);

//     //Criar BD Relatórios
//     $statusRelatoriosInicial = "VAZIO";
//     criarrelatorio($conn, $pedido, $statusRelatoriosInicial);

//     //Criar BD Prazo
//     $statusPrazoInicial = "CRIADO";
//     //criarprazo($conn, $pedido, $statusPrazoInicial);

//     // mysqli_stmt_close($stmt);
//     header("location: comercial?error=none");
//     exit();
// }

// function criarpedido2($conn, $pedido, $id, $drrespuid, $representante, $nomedr, $nomepac, $crm, $listaItens, $tipoProd, $statusPedInicial, $valueAbasFechado, $valueAbasLiberado, $pedAndamento, $cnpj){
//     //Criar BD Pedido
//     $sql = "INSERT INTO pedido (pedNumPedido, pedPropRef, pedUserCriador, pedRep, pedNomeDr, pedNomePac, pedCrmDr, pedProduto, pedTipoProduto, pedStatus, pedAbaAgenda, pedAbaVisualizacao, pedAbaAceite, pedAbaRelatorio, pedAbaDocumentos, pedAndamento, pedCpfCnpj) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailedPED");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "sssssssssssssssss", $pedido, $id, $drrespuid, $representante, $nomedr, $nomepac, $crm, $listaItens, $tipoProd, $statusPedInicial, $valueAbasFechado, $valueAbasFechado, $valueAbasFechado, $valueAbasFechado, $valueAbasLiberado, $pedAndamento, $cnpj);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criaragenda($conn, $pedido, $nomedr, $nomepac, $tipoProd, $statusAgendaInicial){
//     //Criar BD Agendar
//     $sql = "INSERT INTO agenda (agdNumPedRef, agdNomeDr, agdNomPac, agdProd, agdStatus) VALUES (?,?,?,?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedAGD");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "sssss", $pedido, $nomedr, $nomepac, $tipoProd, $statusAgendaInicial);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criarvisualizacao($conn, $pedido, $statusVisualizacaoInicial){
//     //Criar BD Visualização de Projeto
//     $sql = "INSERT INTO visualizador (visNumPed, visStatus) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedVIS");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $pedido, $statusVisualizacaoInicial);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criaraceite($conn, $pedido, $statusAceiteInicial){
//     //Criar BD Aceite
//     $sql = "INSERT INTO aceite (aceiteNumPed, aceiteStatus) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedACE");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $pedido, $statusAceiteInicial);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criarfeedbackaceite($conn, $pedido, $statusFeedbackAceiteInicial){
//     //Criar BD Feedback Aceite
//     $sql = "INSERT INTO feedbackaceite (fdaceiteNumPed, fdaceiteStatus) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedACE");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $pedido, $statusFeedbackAceiteInicial);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criaranexoidr($conn, $statusAnexoIdr, $pedido){
//     //Criar BD Docs Anvisa
//     //Tabela anexo i dr qualidade
//     $sql = "INSERT INTO qualianexoidr (xidrStatusEnvio, xidrIdProjeto) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedQUAIDR");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIdr, $pedido);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criaranexoipac($conn, $statusAnexoIPac, $pedido){
//     //Tabela anexo i pac qualidade
//     $sql = "INSERT INTO qualianexoipac (xipacStatusEnvio, xipacIdProjeto) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedQUAIPAC");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIPac, $pedido);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criaranexoii($conn, $statusAnexoII, $pedido){
//     //Tabela anexo ii qualidade
//     $sql = "INSERT INTO qualianexoii (xiiStatusEnvio, xiiIdProjeto) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedQUAII");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $statusAnexoII, $pedido);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);

//     //Tabela upload tc anexo ii dr qualidade
// }

// function criaranexoiiidr($conn, $statusAnexoIIIDr, $pedido){
//     //Tabela anexo iii dr qualidade
//     $sql = "INSERT INTO qualianexoiiidr (xiiidrStatusEnvio, xiiidrIdProjeto) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedQUAIIIDR");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIIIDr, $pedido);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criaranexoiiipac($conn, $statusAnexoIIIPac, $pedido){
//     //Tabela anexo iii pac qualidade
//     $sql = "INSERT INTO qualianexoiiipac (xiiipacStatusEnvio, xiiipacIdProjeto) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         // header("location: ../comercial?error=stmtfailedQUAIIIPAC");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $statusAnexoIIIPac, $pedido);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criarrelatorio($conn, $pedido, $statusRelatoriosInicial){
//     //Criar BD Relatórios
//     $sql = "INSERT INTO relatorios (relNumPedRef, relStatus) VALUES (?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "ss", $pedido, $statusRelatoriosInicial);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

// function criarprazo($conn, $data){
//     //Criar BD Prazo
//     $dataAtual = hoje();

//     $sql = "INSERT INTO prazoproposta (przNumProposta, przData, przStatus) VALUES (?,?,?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../comercial?error=stmtfailed");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "sss", $numPedido, $dataAtual ,$status);
//     mysqli_stmt_execute($stmt);
//     // mysqli_stmt_close($stmt);
// }

//Log De Atividades
function logAtividade($conn, $user, $atividade)
{
    $sql = "INSERT INTO logdeatividades (logUser, logAtividade) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {

        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $user, $atividade);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//Antecipação
function newAntecipacao($conn, $user, $nped, $produto)
{
    $sql = "INSERT INTO adiantamentos (adiantUser, adiantNPed, adiantProduto, adiantStatus) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    $status = 'Em Análise';

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../antecipacao?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $user, $nped, $produto, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../antecipacao?error=sent");
    exit();
}

function aprovPedidoAntecipacao($conn, $id, $user)
{
    $status = "Aprovado";

    $sql = "UPDATE adiantamentos SET adiantStatus='$status' WHERE adiantId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: pedidosantecipacao");
    } else {
        header("location: pedidosantecipacao?error=stmfailed");
    }

    mysqli_close($conn);
}

function reprovPedidoAntecipacao($conn, $id, $user)
{
    $status = "Reprovado";

    $sql = "UPDATE adiantamentos SET adiantStatus='$status' WHERE adiantId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: pedidosantecipacao");
    } else {
        header("location: pedidosantecipacao?error=stmfailed");
    }

    mysqli_close($conn);
}


//Midias MKT
function addAbaMidias($conn, $nome)
{
    $sql = "INSERT INTO abasmidias (abmNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastromidias?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../cadastromidias");
    exit();
}

function deleteAbaMidias($conn, $id)
{
    $sql = "DELETE FROM abasmidias WHERE abmId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: cadastromidias?error=deleted");
    } else {
        header("location: cadastromidias?error=stmtfailed");
    }
    mysqli_close($conn);
}

function addSessaoMidias($conn, $nome, $aba, $icon)
{
    $sql = "INSERT INTO sessaomidias (ssmAba, ssmNome, ssmIcon) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastromidias?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $aba, $nome, $icon);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../cadastromidias");
    exit();
}

function deleteSessaoMidias($conn, $id)
{
    $sql = "DELETE FROM sessaomidias WHERE ssmId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: cadastromidias?error=deleted");
    } else {
        header("location: cadastromidias?error=stmtfailed");
    }
    mysqli_close($conn);
}

function addMaterialMidia($conn, $abaMaterial, $sessaoMaterial, $titulo, $descricao, $link, $relevancia)
{
    $sql = "INSERT INTO materiaismidias (mtmAba, mtmSessao, mtmTitulo, mtmDescricao, mtmLink, mtmRelevancia) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastromidias?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $abaMaterial, $sessaoMaterial, $titulo, $descricao, $link, $relevancia);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../cadastromidias");
    exit();
}

function updateMaterialMidia($conn, $id, $abaMaterial, $sessaoMaterial, $titulo, $descricao, $link, $relevancia)
{
    $sql = "UPDATE materiaismidias SET mtmAba='$abaMaterial', mtmSessao='$sessaoMaterial', mtmTitulo='$titulo', mtmDescricao='$descricao', mtmLink='$link', mtmRelevancia='$relevancia' WHERE mtmId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../cadastromidias");
    } else {
        header("location: ../cadastromidias?error=stmfailed");
    }

    mysqli_close($conn);
}

function deleteMaterialMidias($conn, $id)
{
    $sql = "DELETE FROM materiaismidias WHERE mtmId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: cadastromidias?error=deleted");
    } else {
        header("location: cadastromidias?error=stmtfailed");
    }
    mysqli_close($conn);
}

function addNotificacaoEmail($conn, $bd, $template, $titulo, $texto, $destinatario, $data, $user)
{
    $sql = "INSERT INTO notificacoesexternasemail (ntfEmailBDRef, ntfEmailNomeTemplate, ntfEmailAssuntoEmail, ntfEmailTexto, ntfEmailDestinatario, ntfEmailDtCriacao, ntfEmailUserCriacao) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: gernotificacoes?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $bd, $template, $titulo, $texto, $destinatario, $user, $data);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: gernotificacoes?error=none");
    exit();
}

function addNotificacaoWpp($conn, $bd, $template, $titulo, $texto, $destinatario, $data, $user)
{
    $sql = "INSERT INTO notificacoesexternaswpp (ntfWppBDRef, ntfWppNomeTemplate, ntfWppTitulo, ntfWppTexto, ntfWppDestinatario, ntfWppDtCriacao, ntfWppUserCriacao) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: gernotificacoes?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $bd, $template, $titulo, $texto, $destinatario, $user, $data);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: gernotificacoes?error=none");
    exit();
}

function updateNotificacaoEmail($conn, $id, $template, $titulo, $destinatario, $texto, $data, $user)
{

    $sql = "UPDATE notificacoesexternasemail SET ntfEmailNomeTemplate='$template', ntfEmailAssuntoEmail='$titulo', ntfEmailTexto='$texto', ntfEmailDestinatario='$destinatario', ntfEmailDtUpdate='$data', ntfEmailUserUpdate='$user' WHERE ntfEmailId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../gernotificacoes?error=edited");
    } else {
        header("location: ../gernotificacoes?error=stmfailed");
    }

    mysqli_close($conn);
}

function updateNotificacaoWpp($conn, $id, $template, $titulo, $destinatario, $texto, $data, $user)
{
    $sql = "UPDATE notificacoesexternaswpp SET ntfWppNomeTemplate='$template', ntfWppTitulo='$titulo', ntfWppTexto='$texto', ntfWppDestinatario='$destinatario', ntfWppDtUpdate='$data', ntfWppUserUpdate='$user' WHERE ntfWppId ='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../gernotificacoes?error=edited");
    } else {
        header("location: ../gernotificacoes?error=stmfailed");
    }

    mysqli_close($conn);
}

function deleteEmailNotification($conn, $id)
{
    $sql = "DELETE FROM notificacoesexternasemail WHERE ntfEmailId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gernotificacoes?error=deleted");
    } else {
        header("location: gernotificacoes?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteWppNotification($conn, $id)
{
    $sql = "DELETE FROM notificacoesexternaswpp WHERE ntfWppId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gernotificacoes?error=deleted");
    } else {
        header("location: gernotificacoes?error=stmtfailed");
    }
    mysqli_close($conn);
}

function addBancoNotificacao($conn, $nome)
{
    $sql = "INSERT INTO bancosdadosnotificacoes (bdntfNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../configNotificacao?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../configNotificacao");
    exit();
}

function deleteBDNotificacao($conn, $id)
{
    $sql = "DELETE FROM bancosdadosnotificacoes WHERE bdntfId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: configNotificacao");
    } else {
        header("location: configNotificacao?error=stmtfailed");
    }
    mysqli_close($conn);
}

function addMarcadorNotificacao($conn, $banco, $nome, $variavel)
{
    $sql = "INSERT INTO placeholdersnotificacao (plntfBd, plntfNome, plntfVariavel) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../configNotificacao?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $banco, $nome, $variavel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../configNotificacao");
    exit();
}

function deleteMarcadorNotificacao($conn, $id)
{
    $sql = "DELETE FROM placeholdersnotificacao WHERE plntfId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: configNotificacao");
    } else {
        header("location: configNotificacao?error=stmtfailed");
    }
    mysqli_close($conn);
}


//INICIO COMBO - Envio de Notificações --------//
function sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio)
{
    //VARIÁVEIS-----------------------------------------
    //tipoNotificacao: email ou whatsapp
    //idMsg: id da msg no banco de dados de notificações
    //itemEnvio: id proposta ou id pedido
    //--------------------------------------------------


    //1-Encontrar banco de dados para pesquisa pelo 'tipoNotificacao'//OK
    if ($tipoNotificacao == 'email') {
        $bdNotificacao = 'notificacoesexternasemail';

        $Id = 'ntfEmailId';
        $BDRef = 'ntfEmailBDRef';
        $NomeTemplate = 'ntfEmailNomeTemplate';
        $Titulo = 'ntfEmailAssuntoEmail';
        $Texto = 'ntfEmailTexto';
        $Destinatario = 'ntfEmailDestinatario';
    } else {
        $bdNotificacao = 'notificacoesexternaswpp';

        $Id = 'ntfWppId';
        $BDRef = 'ntfWppBDRef';
        $NomeTemplate = 'ntfWppNomeTemplate';
        $Titulo = 'ntfWppTitulo';
        $Texto = 'ntfWppTexto';
        $Destinatario = 'ntfWppDestinatario';
    }


    //2-Pesquisar Msg por 'idMsg' //OK

    $queryMsg = 'SELECT * FROM ' . $bdNotificacao . ' WHERE ' . $Id . ' = ' . $idMsg . ' ;';
    $retMsg = mysqli_query($conn, $queryMsg);

    //3-armazenar em variáveis //OK
    //banco referencia
    //assunto
    //texto
    //destinatario

    while ($rowMsg = mysqli_fetch_array($retMsg)) {
        $bancoReferencia = $rowMsg[$BDRef];
        $assunto = $rowMsg[$Titulo];
        $nomeTemplate = $rowMsg[$NomeTemplate];
        $texto = htmlspecialchars_decode($rowMsg[$Texto]);
        $destinatario = $rowMsg[$Destinatario];
    }


    //4-pesquisar no texto os placeholders e guardar em um array de placeholders //OK
    $listplaceholders = findplaceholders($conn, $texto, $bancoReferencia);

    //5-pesquisar no array de placeholders os nomes das colunas //OK
    $listNomeColunas = findcolumnsname($conn, $listplaceholders, $bancoReferencia);

    //6-pesquisar cada coluna do array em 'banco referencia' onde id='itemEnvio' e armazenar em um array //OK
    $resultadosPlaceholders = findresultplaceholders($conn, $listNomeColunas, $itemEnvio, $bancoReferencia);

    //7-substituir placeholders por valores reais //OK
    $novotexto = str_replace($listplaceholders, $resultadosPlaceholders, $texto);

    //8-verifica tipo de notificacao//OK

    if ($tipoNotificacao == 'email') {

        //9-Se email, //OK
        // - Definir se destinatario tem a string 'nome' ou 'sistema'
        // - Se tiver sistema, variável destino = plntfVariavel //OK
        // - Se tive nome, variavel user = plntfVariavel //OK
        // - pesquisa email do user //OK
        // - Enviar e-mail  //OK
        $emailDest = findemailDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia);

        enviarEmail($emailDest, $assunto, $novotexto);
    } else {

        //10-Se wpp, //OK
        // - Definir se destinatario tem a string 'nome' ou 'sistema'
        // - Se tiver sistema, variável destino = plntfVariavel //OK
        // - Se tive nome, variavel user = plntfVariavel //OK
        // - pesquisa celular do user //OK
        // - converter para celular wpp //OK
        // - Enviar wpp //OK
        $celularDest = findcelularDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia);

        enviarWpp($celularDest, $novotexto);
        // echo "1";
    }
}

function findplaceholders($conn, $texto, $bancoReferencia)
{
    $placehoders = array();
    $listaColunasBancoPlaceholders = array();
    $queryPlc = mysqli_query($conn, "SELECT * FROM placeholdersnotificacao WHERE plntfBd LIKE '%$bancoReferencia%'");

    if (mysqli_num_rows($queryPlc) > 0) {
        while ($row = mysqli_fetch_assoc($queryPlc)) {
            array_push($listaColunasBancoPlaceholders, $row['plntfNome']);
        }
    }

    foreach ($listaColunasBancoPlaceholders as &$item) {
        if (strstr($texto, $item)) {
            array_push($placehoders, $item);
        }
    }

    return $placehoders;
}

function findcolumnsname($conn, $listplaceholders, $bancoReferencia)
{
    $listNomeColunas = array();
    foreach ($listplaceholders as &$plc) {
        $queryPlc = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$plc%' AND plntfBd LIKE '%$bancoReferencia%';";
        $retPlc = mysqli_query($conn, $queryPlc);
        while ($rowPlc = mysqli_fetch_array($retPlc)) {
            array_push($listNomeColunas, $rowPlc['plntfVariavel']);
        }
    }

    return $listNomeColunas;
}

function findresultplaceholders($conn, $listNomeColunas, $itemEnvio, $bancoReferencia)
{

    $listaColunasBancoReferencia = array();
    $resultscolumns = array();
    $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);

    if (mysqli_num_rows($queryDest) > 0) {
        while ($row = mysqli_fetch_assoc($queryDest)) {
            array_push($listaColunasBancoReferencia, $row['Field']);
        }
    }

    if ($bancoReferencia == 'pedido') {
        $needle = 'PropRef';
    } else {
        $needle = 'Id';
    }

    foreach ($listaColunasBancoReferencia as &$coluna) {
        if (strstr($coluna, $needle)) {
            $resultId = $coluna;
        }
    }


    foreach ($listNomeColunas as $nomecoluna) {
        $queryItem = "SELECT * FROM " . $bancoReferencia . " WHERE " . $resultId . " LIKE '%$itemEnvio%';";

        $retItem = mysqli_query($conn, $queryItem);
        while ($rowItem = mysqli_fetch_array($retItem)) {
            //armazenar cada resultado em um array
            array_push($resultscolumns, $rowItem[$nomecoluna]);
        }
    }

    return $resultscolumns;
}

function findemailDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia)
{
    $param = 'nome';
    if (strstr($destinatario, $param)) {

        $tipo = explode('_', $destinatario);
        $tipo = $tipo[1];
        $tipo = rtrim($tipo, "]");

        $listaColunasBancoReferencia = array();
        $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);

        if (mysqli_num_rows($queryDest) > 0) {
            while ($row = mysqli_fetch_assoc($queryDest)) {
                array_push($listaColunasBancoReferencia, $row['Field']);
            }
        }

        $needle = 'Id';
        foreach ($listaColunasBancoReferencia as &$coluna) {
            if (strstr($coluna, $needle)) {
                $resultId = $coluna;
            }
        }

        switch ($tipo) {
            case 'criador':
                $needle = 'UserCriacao';
                break;

            case 'representante':
                $needle = 'Representante';
                break;
        }

        foreach ($listaColunasBancoReferencia as &$coluna) {
            if (strstr($coluna, $needle)) {
                $resultEmail = $coluna;
            }
        }

        $queryDest = 'SELECT * FROM ' . $bancoReferencia . ' WHERE ' . $resultId . ' = ' . $itemEnvio . ' ;';
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $emailDest = $rowDest[$resultEmail];
        }

        $queryDest = "SELECT * FROM users WHERE usersUid='$emailDest' ;";
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $emailDest = $rowDest['usersEmail'];
        }
    } else {
        $queryDest = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$destinatario%' AND  plntfBd LIKE '%$bancoReferencia%';";
        $retDest = mysqli_query($conn, $queryDest);
        while ($rowDest = mysqli_fetch_array($retDest)) {
            $emailDest = $rowDest['plntfVariavel'];
        }
    }


    return $emailDest;
}

function findcelularDestinatario($conn, $destinatario, $itemEnvio, $bancoReferencia)
{
    if ($bancoReferencia == 'proposta') {
        $param = 'nome';
        if (strstr($destinatario, $param)) {

            $tipo = explode('_', $destinatario);
            $tipo = $tipo[1];
            $tipo = rtrim($tipo, "]");

            $listaColunasBancoReferencia = array();
            $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);


            if (mysqli_num_rows($queryDest) > 0) {
                while ($row = mysqli_fetch_assoc($queryDest)) {
                    array_push($listaColunasBancoReferencia, $row['Field']);
                }
            }

            $needle = 'Id';
            foreach ($listaColunasBancoReferencia as &$coluna) {
                if (strstr($coluna, $needle)) {
                    $resultId = $coluna;
                }
            }

            switch ($tipo) {
                case 'criador':
                    $needle = 'UserCriacao';
                    break;

                case 'representante':
                    $needle = 'Representante';
                    break;
            }

            foreach ($listaColunasBancoReferencia as &$coluna) {
                if (strstr($coluna, $needle)) {
                    $resultEmail = $coluna;
                }
            }

            $queryDest = 'SELECT * FROM ' . $bancoReferencia . ' WHERE ' . $resultId . ' = ' . $itemEnvio . ' ;';
            $retDest = mysqli_query($conn, $queryDest);
            while ($rowDest = mysqli_fetch_array($retDest)) {

                $celDest = $rowDest[$resultEmail];
            }

            $queryDest = "SELECT * FROM users WHERE usersUid='$celDest' ;";
            $retDest = mysqli_query($conn, $queryDest);
            while ($rowDest = mysqli_fetch_array($retDest)) {
                $celDest = $rowDest['usersCel'];
            }

            $cel = implode('', explode(' ', $celDest));
            $cel = implode('', explode('-', $cel));
            $cel = implode('', explode('(', $cel));
            $cel = implode('', explode(')', $cel));
            $celDest = '+55' . $cel;
        } else {
            $queryDest = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$destinatario%' AND  plntfBd LIKE '%$bancoReferencia%';";
            $retDest = mysqli_query($conn, $queryDest);
            while ($rowDest = mysqli_fetch_array($retDest)) {
                $celDest = $rowDest['plntfVariavel'];
            }

            $celDest = '+' . $celDest;
        }
    } else {
        $param = 'nome';
        if (strstr($destinatario, $param)) {

            $tipo = explode('_', $destinatario);
            $tipo = $tipo[1];
            $tipo = rtrim($tipo, "]");

            $listaColunasBancoReferencia = array();
            $queryDest = mysqli_query($conn, "SHOW COLUMNS FROM " . $bancoReferencia);


            if (mysqli_num_rows($queryDest) > 0) {
                while ($row = mysqli_fetch_assoc($queryDest)) {
                    array_push($listaColunasBancoReferencia, $row['Field']);
                }
            }

            $needle = 'PropRef';
            foreach ($listaColunasBancoReferencia as &$coluna) {
                if (strstr($coluna, $needle)) {
                    $resultId = $coluna;
                }
            }

            switch ($tipo) {
                case 'criador':
                    $needle = 'UserCriador';
                    break;

                case 'representante':
                    $needle = 'Rep';
                    break;
            }

            foreach ($listaColunasBancoReferencia as &$coluna) {
                if (strstr($coluna, $needle)) {
                    $resultEmail = $coluna;
                }
            }

            $queryDest = 'SELECT * FROM ' . $bancoReferencia . ' WHERE ' . $resultId . ' = ' . $itemEnvio . ' ;';

            $retDest = mysqli_query($conn, $queryDest);
            while ($rowDest = mysqli_fetch_array($retDest)) {

                $celDest = $rowDest[$resultEmail];
            }

            $queryDest = "SELECT * FROM users WHERE usersUid='$celDest' ;";
            $retDest = mysqli_query($conn, $queryDest);
            while ($rowDest = mysqli_fetch_array($retDest)) {
                $celDest = $rowDest['usersCel'];
            }

            $cel = implode('', explode(' ', $celDest));
            $cel = implode('', explode('-', $cel));
            $cel = implode('', explode('(', $cel));
            $cel = implode('', explode(')', $cel));
            $celDest = '+55' . $cel;
        } else {
            $queryDest = "SELECT * FROM placeholdersnotificacao WHERE plntfNome LIKE '%$destinatario%' AND  plntfBd LIKE '%$bancoReferencia%';";
            $retDest = mysqli_query($conn, $queryDest);
            while ($rowDest = mysqli_fetch_array($retDest)) {
                $celDest = $rowDest['plntfVariavel'];
            }

            $celDest = '+' . $celDest;
        }
    }





    return $celDest;
}

function enviarWpp($celular, $msg)
{
    print_r($celular);
    print_r($msg);

    $msg = strip_tags($msg);

    // sendNotification($celular, $msg);
}

function enviarEmail($para_email, $assunto, $html)
{

    enviarHook($para_email, $assunto, $html);
    // $destino = $para_email;


    // $headers  = 'MIME-Version: 1.0' . "\r\n";
    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    // $enviaremail = mail($destino, $assunto, $html, $headers);
    // if ($enviaremail) {
    //     echo "<script>alert('Seu email foi enviado com sucesso!'); </script>";
    //     // header("Location: comercial?error=sent");
    //     header("location:javascript://history.go(-1)");
    // } else {
    //     echo "<script>alert('Seu email não foi enviado.'); </script>";
    //     // header("Location: comercial?error=senteerror");
    //     header("location:javascript://history.go(-1)");
    // }
}

function enviarHook($para_email, $assunto, $html)
{
    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/06c144f68b064605bf7167924559e2de?';

    $data = array(
        'para_email' => $para_email,
        'assunto' => $assunto,
        'html' => $html
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

//FIM COMBO - Envio de Notificações --------//

function editPwdAdm($conn, $user, $pwd)
{
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE usersUid='$user'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../mudarsenha?error=none");
    } else {
        header("location: ../mudarsenha?error=stmfailed");
    }
    mysqli_close($conn);
}

function editLinkAdm($conn, $id, $link)
{

    $sql = "UPDATE filedownload SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../adicionarlink?error=none");
    } else {
        header("location: ../adicionarlink?error=stmfailed");
    }
    mysqli_close($conn);
}

function editLinkAdmQualidade($conn, $id, $link)
{

    $sql = "UPDATE filedownloadlaudo SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../adicionarlink?error=none");
    } else {
        header("location: ../adicionarlink?error=stmfailed");
    }
    mysqli_close($conn);
}

function editLinkPlan($conn, $id, $link)
{
    $sql = "UPDATE filedownload SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";
    // mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {

        return true;
    } else {
        return false;
    }
}

function editLinkQuali($conn, $id, $link)
{
    $sql = "UPDATE filedownloadlaudo SET fileCdnUrl='$link' WHERE fileNumPropRef='$id'";
    // mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {

        return true;
    } else {
        return false;
    }
}

function uploadArquivoRefTCA($conn, $name, $path, $propId)
{

    $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplana WHERE imgplanNumProp='" . $propId . "';");
    if (($retPic) && ($retPic->num_rows != 0)) {
        $sql = "UPDATE imagemreferenciaplana SET imgplanNomeImg='$name', imgplanPathImg='$path' WHERE imgplanNumProp='$propId'";

        if (!mysqli_query($conn, $sql)) {
            header("location: ../planejamento?error=stmfailed");
        }
        mysqli_close($conn);
    } else {

        //Registra nova arquivo
        $sql = "INSERT INTO imagemreferenciaplana (imgplanNomeImg, imgplanPathImg, imgplanNumProp) VALUES (?,?,?);";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../planejamento?error=stmfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $name, $path, $propId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function uploadArquivoRefTCB($conn, $name, $path, $propId)
{

    $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $propId . "';");
    if (($retPic) && ($retPic->num_rows != 0)) {
        $sql = "UPDATE imagemreferenciaplanb SET imgplanNomeImg='$name', imgplanPathImg='$path' WHERE imgplanNumProp='$propId'";

        if (!mysqli_query($conn, $sql)) {
            header("location: ../planejamento?error=stmfailed");
        }
        mysqli_close($conn);
    } else {

        //Registra nova arquivo
        $sql = "INSERT INTO imagemreferenciaplanb (imgplanNomeImg, imgplanPathImg, imgplanNumProp) VALUES (?,?,?);";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../planejamento?error=stmfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $name, $path, $propId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function sendPropCliente($id, $usercriacao, $empresa, $status, $nomedr, $crm, $telefone, $emaildr, $emailenvio, $nomepac, $convenio, $listaItens, $tipoProd, $validade, $ufProp, $representante)
{
    // //Envio E-mail para user criador
    // $tipoNotificacao = 'email';
    // $idMsg = 7;
    // $itemEnvio = intval($id);

    // sendEmailFromNotificationBD($conn, $tipoNotificacao, $idMsg, $itemEnvio);

    //Link live API
    // $url = 'https://hooks.zapier.com/hooks/catch/8414821/bij0552?';
    $url = 'https://webhooks.integrately.com/a/webhooks/286e2c41f5ff4383874e223360432f7c?';

    $data = array(
        'idprop' => $id,
        'usercriacao' => $usercriacao,
        'empresa' => $empresa,
        'status' => $status,
        'nomedr' => $nomedr,
        'crm' => $crm,
        'telefone' => $telefone,
        'emaildr' => $emaildr,
        'emailenvio' => $emailenvio,
        'nomepac' => $nomepac,
        'convenio' => $convenio,
        'listaItens' => $listaItens,
        'tipoProd' => $tipoProd,
        'validade' => $validade,
        'ufProp' => $ufProp,
        'representante' => $representante

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}
function adicionarComentarioPropostaRepresentante($conn, $id, $comentario)
{
    //Atualiza comentario do representante na proposta
    $sql = "UPDATE propostas SET propTxtRepresentante = ? WHERE propId ='$id'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacoes?error=commenterror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $comentario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId ='$id'");
    while ($row = mysqli_fetch_array($ret)) {
        $representanteUid = $row["propRepresentante"];
        $doutor = $row["propNomeDr"];
        $produto = $row["propTipoProd"];
    }

    $representante = getNomeRep($conn, $representanteUid);


    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/b06b9553152947d0a7ce523723f72cda?';


    //Link localhost API
    $data = array(
        'NumProposta' => $id,
        'Representante' => $representante,
        'Comentario' => $comentario,
        'Doutor' => $doutor,
        'Produto' => $produto

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }


    header("location: ../solicitacoes?error=commentesent");
    exit();
}

function addComentProp($conn, $coment, $nprop, $user)
{
    $sql = "INSERT INTO comentariosproposta (comentVisUser, comentVisNumProp, comentVisText, comentVisHorario, comentVisTipoUser) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../update-proposta?id=" . $nprop . "&error=stmfailed");
        exit();
    }

    $usuario = getAllDataFromRep($conn, $user);
    $tipoUserRAW = $usuario["usersPerm"];
    $tipoUser = getPermissionNome($conn, $tipoUserRAW);

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    mysqli_stmt_bind_param($stmt, "sssss", $user, $nprop, $coment, $dataAtual, $tipoUser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    $propData = getAllDataFromProp($conn, $nprop);
    // $repData = getRepFromProp($conn, $propData['propRepresentante']);
    $nomeUser = getNomeRep($conn, $user);
    $nomeRep = getNomeRep($conn, $propData['propRepresentante']);

    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/984d4fb974b5417bbb85fdd0cebd9903?';
    

    $data = array(
        'NumProposta' => $nprop,
        'Doutor' => $propData['propNomeDr'],
        'Pac' => $propData['propNomePac'],
        'Produto' => $propData['propTipoProd'],
        'Representante' => $nomeRep,
        'Sender Usuário' => $nomeUser,
        'Comentário' => $coment

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function addComentCaso($conn, $coment, $nped, $user)
{
    $sql = "INSERT INTO comentariosvisualizador (comentVisUser, comentVisNumPed, comentVisText, comentVisHorario, comentVisTipoUser) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../update-proposta?id=" . $nprop . "&error=stmfailed");
        exit();
    }

    $usuario = getAllDataFromRep($conn, $user);
    $tipoUserRAW = $usuario["usersPerm"];
    $tipoUser = getPermissionNome($conn, $tipoUserRAW);

    
    $dataAtual = hoje() . " " . agora();

    mysqli_stmt_bind_param($stmt, "sssss", $user, $nped, $coment, $dataAtual, $tipoUser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    $pedData = getAllDataFromPed($conn, $nped);
    // $repData = getRepFromProp($conn, $propData['propRepresentante']);
    $nomeUser = getNomeRep($conn, $user);
    $nomeRep = getNomeRep($conn, $pedData['pedRep']);

    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/ca885d82fd54408abf93ab8fa1eb0f9c?';

    $data = array(
        'NumPedido' => $nped,
        'Doutor' => $pedData['pedNomeDr'],
        'Pac' => $pedData['pedNomePac'],
        'Produto' => $pedData['pedTipoProduto'],
        'Representante' => $nomeRep,
        'Sender Usuário' => $nomeUser,
        'Comentário' => $coment

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}
function getNomeRep($conn, $repUid)
{
    $searchRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $repUid . "';");
    while ($rowRep = mysqli_fetch_array($searchRep)) {
        // $foneRep = $rowRep['usersFone'];
        $RepNomeCompleto = $rowRep['usersName'];
        $RepNomeCompleto = explode(" ", $RepNomeCompleto);
        $nomeRep = $RepNomeCompleto[0];
    }

    return $nomeRep;
}

function getNomeEmpresa($conn, $user)
{
    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $user . "';");
    while ($rowUser = mysqli_fetch_array($searchUser)) {
        $empresa = $rowUser['usersEmpr'];
    }

    return $empresa;
}

function getNomeEmpresa2($conn, $cnpj)
{
    $searchUser = mysqli_query($conn, "SELECT * FROM users WHERE usersCnpj='" . $cnpj . "';");
    while ($rowUser = mysqli_fetch_array($searchUser)) {
        $empresa = $rowUser['usersEmpr'];
    }

    return $empresa;
}


function getIniciais($nomeCompleto)
{

    $arr = explode(" ", $nomeCompleto);

    $iniciais = '';
    foreach ($arr as $s) {
        $iniciais .= substr($s, 0, 1);
    }

    // $iniciais = getIniciais($iniciais);

    return $iniciais;
}

//Qualificação Cliente
function criarQualificacaoCliente($conn, $data)
{
    $status = "Enviado";

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data_chegada = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");


    //Criar BD Qualificação Cliente
    $sql = "INSERT INTO qualificacaocliente (qualiDtChegada, qualiUsuario, qualiStatus) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $data_chegada, $data['usercriacao'], $status);
    mysqli_stmt_execute($stmt);

    // mysqli_stmt_close($stmt);

    //Notificar Slack Qualidade
    $null = null;
    criarRegistroEnvioQualificacao($conn, $data['usercriacao']);
    notificarQualificacaoClienteSlack($conn, $data['usercriacao'], $data['id'], $status, $null);
}

function criarRegistroEnvioQualificacao($conn, $usuario)
{
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    $sql = "INSERT INTO registroenvioqualificacao (regEnvUsuario, regEnvData) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../produtos?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $usuario, $data);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
}

function criarRegistroPreenchimentoQualificacao($conn, $usuario, $idForm, $nome)
{
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    $sql = "INSERT INTO registropreenchimentoqualificacao (regPreUsuario, regPreData, regPreIdForm, regPreNome) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../produtos?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $usuario, $data, $idForm, $nome);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
}

function changeQualificacaoCliente($conn, $id, $data)
{
    $status = "Analisar";
    $user = getUserFromProp($conn, $id);

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $data_chegada = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");
    $data = array_merge($data, array("dataPreenchimento" => $data_chegada));

    //Atualiza Qualificação Cliente
    $sql = "UPDATE qualificacaocliente SET qualiStatus = ?, qualiRazaoSocial=?, qualiPreenchidoPor=?, qualiFuncao=?, qualiUF=?, qualiCNPJ=?, qualiIDForm=?, qualiDtPreenchimento=?  WHERE qualiUsuario ='$user'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //Notificar Slack Qualidade
        $status = 'NConecta';
        notificarQualificacaoClienteSlack($conn, $user, $id, $status, $data);
        header("location: ../agradecimentoqualificacao");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssss", $status, $data['razaosocial'], $data['nome2'], $data['funcao'], $data['uf'], $data['cnpj121'], $data['submission_id'], $data['dataPreenchimento']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);


    //Notificar Slack Qualidade
    notificarQualificacaoClienteSlack($conn, $user, $id, $status, $data);

    criarRegistroPreenchimentoQualificacao($conn, $user, $data['submission_id'], $data['nome2']);
}

function editQualificacao($conn, $id, $comentario, $status)
{
    //Atualiza Qualificação Cliente
    $sql = "UPDATE qualificacaocliente SET qualiStatus = ?, qualiMsg=? WHERE qualiId ='$id'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../qualificacaocliente?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $status, $comentario);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
}

function getAllDataQualificacao($conn, $id)
{
    $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiId='" . $id . "';");
    $row = mysqli_fetch_array($ret);

    return $row;
}

function notificarQualificacaoClienteSlack($conn, $cnpj, $id, $status, $dadosPreenchimento)
{
    switch ($status) {
        case 'Enviado':
            //Notificar Qualidade            
            $texto = 'Formulário enviado ao cliente.';
            break;
        case 'Analisar':
            //Notificar Qualidade         
            $texto = 'Formulário preenchido pelo cliente.';
            break;
        case 'Qualificado':
            //Notificar Comercial          
            $texto = 'Cliente qualificado.';
            break;
        case 'Recusado':
            //Notificar Comercial 
            $texto = 'Cliente não qualificado';
            break;

        case 'NConecta':
            //Notificar Comercial 
            $texto = 'Formulário preenchido pelo cliente. Cliente não veio do conecta';
            break;
        default:
            //Notificar Comercial 
            $texto = 'Formulário preenchido pelo cliente. Cliente não veio do conecta';
            break;
    }

    $empresa = getNomeEmpresa2($conn, $cnpj);

    $url = 'https://webhooks.integrately.com/a/webhooks/ad657532d4624c41815ef96a38fb2600?';

    $texto2 = '';
    if ($dadosPreenchimento != null) {
        $empresa = $dadosPreenchimento['razaosocial'];
        $preenchidoPor = $dadosPreenchimento['nome2'];
        $funcao = $dadosPreenchimento['funcao'];
        $uf = $dadosPreenchimento['uf'];
        $cnpj = $dadosPreenchimento['cnpj121'];
        $idForm = $dadosPreenchimento['submission_id'];
        $datPreenchimento = $dadosPreenchimento['dataPreenchimento'];

        $texto2 = 'Preenchido Por: ' . $preenchidoPor . '
Função: ' . $funcao . '
UF: ' . $uf . '
CNPJ: ' . $cnpj . '
ID Form: ' . $idForm . '
Data Preenchimento: ' . $datPreenchimento;
    }


    //Link localhost API
    $data = array(
        'NumProposta' => $id,
        'CNPJ' => $cnpj,
        'Empresa' => $empresa,
        'Texto' => $texto,
        'Complemento' => $texto2

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function getUserFromProp($conn, $id)
{
    $searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $id . "';");
    while ($rowProp = mysqli_fetch_array($searchProp)) {
        $user = $rowProp['propUserCriacao'];
    }

    return $user;
}

function getPropFromUser($conn, $user)
{
    $searchProp = mysqli_query($conn, "SELECT propId FROM propostas WHERE propUserCriacao='" . $user . "' LIMIT 1;");
    while ($rowProp = mysqli_fetch_array($searchProp)) {
        $prop = $rowProp['propId'];
    }

    return $prop;
}

function getRepFromProp($conn, $id)
{
    $searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $id . "';");
    while ($rowProp = mysqli_fetch_array($searchProp)) {
        $rep = $rowProp['propRepresentante'];
    }

    return $rep;
}

function getAllDataFromRep($conn, $uid)
{
    $searchRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $uid . "';");
    $data = mysqli_fetch_array($searchRep);
    return $data;
}

function getAllDataFromProp($conn, $id)
{
    $searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $id . "';");
    $data = mysqli_fetch_array($searchProp);
    return $data;
}

function getAllDataFromPed($conn, $id)
{
    $searchProp = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='" . $id . "';");
    $data = mysqli_fetch_array($searchProp);
    return $data;
}

function getIdFromPed($conn, $id)
{
    $searchPed = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='" . $id . "';");
    while ($rowPed = mysqli_fetch_array($searchPed)) {
        $pedId = $rowPed['pedId'];
    }

    return $pedId;
}

function getPedFromId($conn, $id)
{
    $searchPed = mysqli_query($conn, "SELECT * FROM pedido WHERE pedId='" . $id . "';");
    $data = mysqli_fetch_array($searchPed);
    return $data;
}

function  editPropostaFromQualificacao($conn, $data)
{
    $user = $data["qualiUsuario"];
    $arrayPropId = array();
    $statusnovo = "CLIENTE QUALIFICADO";

    $searchProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propUserCriacao='" . $user . "' AND propStatus ='AGUARD. QUALIFICAÇÃO';");
    while ($rowProp = mysqli_fetch_array($searchProp)) {
        array_push($arrayPropId, $rowProp["propId"]);
    }

    foreach ($arrayPropId as &$id) {

        //Atualiza Propostas Cliente
        $sql = "UPDATE propostas SET propStatus = ? WHERE propId ='$id'";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // header("location: ../qualificacaocliente?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $statusnovo);
        mysqli_stmt_execute($stmt);
    }
}


//Certificados e Lista Alunos

function deleteItemListaAlunos($conn, $id)
{
    $sql = "DELETE FROM aluno WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: certificados?error=deleted");
    } else {
        header("location: certificados?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteListaAlunos($conn)
{
    $sql = "DELETE FROM aluno;";

    if (mysqli_query($conn, $sql)) {
        header("location: certificados?error=deletedLista");
    } else {
        header("location: certificados?error=stmtfailed");
    }
    mysqli_close($conn);
}


    function hashItem($id)
    {
        // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
        $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $idhashed = openssl_encrypt($id, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
        $idhashed = $idhashed . ':' . base64_encode($iv);
        return urlencode($idhashed);
    }

function deshashItem($hash)
{
    // decrypt to get again $plaintext
    $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    $parts = explode(':', addslashes($hash));
    $id = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

    return $id;
}

function hashItemNatural($id)
{
    $id = intval($id);
    $random = rand() * 2;
    $idhashed = $id * $random / 2;
    return $idhashed . "s" . $random;
}

function deshashItemNatural($hash)
{
    $exploded = explode("s", $hash);
    $hash = $exploded[0];
    $encryption_key = $exploded[1];
    $id = $hash * 2 / $encryption_key;
    return $id;
}

//Pegar última proposta de acordo com o CPF ou CNPJ
function get_last_prop($conn, $identificador)
{

    $identificador = clean_identificador($identificador);
    $identificadorFormated = format_identificador($identificador);

    $getProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propCnpjCpf ='$identificadorFormated' ORDER BY propId DESC LIMIT 1;");
    $rowProp = mysqli_fetch_array($getProp);
    $idprop = $rowProp['propId'];

    return $idprop;
}

//remove os caracteres especiais
function clean_identificador($identificador)
{

    $identificador = implode('', explode('-', $identificador));
    $identificador = implode('', explode('.', $identificador));

    return $identificador;
}

//formata identificador no modo necessario
function format_identificador($identificador)
{

    $identificador = explode('', $identificador);
    $identificador = $identificador[0] . $identificador[1] . $identificador[2] . "." . $identificador[3] . $identificador[4] . $identificador[5] . "." . $identificador[6] . $identificador[7] . $identificador[8] . "-" . $identificador[9] . $identificador[10];

    return $identificador;
}

//Pegar último pedido de acordo com o CPF ou CNPJ
function get_last_ped($conn, $identificador)
{

    $getProp = mysqli_query($conn, "SELECT * FROM pedido WHERE propCnpjCpf ='$identificador' ORDER BY propId DESC LIMIT 1;");
    $rowProp = mysqli_fetch_array($getProp);
    $idprop = $rowProp['propId'];

    return $idprop;
}


//Função criar registro de Status Proposta
function registerstatusproposta($conn, $status, $numprop, $user, $date)
{
    $sql = "INSERT INTO `registrostatusproposta`(`regStatus`, `regNumProp`, `regUser`, `regDate`) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../xxx&error=stmtfailed");
        // exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $status, $numprop, $user, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


function soma_geral_valores_propostas($conn)
{
    $thisMonth = date('m');
    $thisYear = date('Y');
    $lastYear = $thisYear - 1;
    // $thisYear = "2022";
    $thisDay = date('d');

    $DaysInCurrentMonth = date('t');

    $dataInicio = $thisYear . "-01-01";
    // $dataFim = $thisYear . "-" . $thisMonth . "-" . $DaysInCurrentMonth;
    $dataFim = $thisYear . "-12-31";

    // BETWEEN '2022-01-01' AND '2023-12-31';

    $ret = mysqli_query($conn, "SELECT propValorPosDesconto FROM propostas WHERE propData BETWEEN '$dataInicio' AND '$dataFim';");
    $total = 0;
    while ($row = mysqli_fetch_array($ret)) {
        $valor = floatval($row['propValorPosDesconto']);
        $total += $valor;
    }

    return $total;
}
function soma_geral_valores_pedidos($conn)
{
    $thisMonth = date('m');
    $thisYear = date('Y');
    $lastYear = $thisYear - 1;
    // $thisYear = "2022";
    $thisDay = date('d');

    $DaysInCurrentMonth = date('t');

    $dataInicio = $thisYear . "-01-01";
    // $dataFim = $thisYear . "-" . $thisMonth . "-" . $DaysInCurrentMonth;
    $dataFim = $thisYear . "-12-31";

    // BETWEEN '2022-01-01' AND '2023-12-31';

    $ret = mysqli_query($conn, "SELECT propValorPosDesconto FROM propostas WHERE propStatus='PEDIDO' AND propData BETWEEN '$dataInicio' AND '$dataFim';");
    $total = 0;
    while ($row = mysqli_fetch_array($ret)) {
        $valor = floatval($row['propValorPosDesconto']);
        $total += $valor;
    }

    return $total;
}

function soma_usuario_valores_propostas($conn)
{

    $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
        $cnpjUser = $rowCnpj['usersCnpj'];
    }

    $thisMonth = date('m');
    $thisYear = date('Y');
    $lastYear = $thisYear - 1;
    // $thisYear = "2022";
    $thisDay = date('d');

    $DaysInCurrentMonth = date('t');

    $dataInicio = $thisYear . "-01-01";
    // $dataFim = $thisYear . "-" . $thisMonth . "-" . $DaysInCurrentMonth;
    $dataFim = $thisYear . "-12-31";

    // BETWEEN '2022-01-01' AND '2023-12-31';
    $sql = "SELECT propValorPosDesconto FROM propostas 
WHERE propCnpjCpf = '" . $cnpjUser . "' AND
propData BETWEEN '$dataInicio' AND '$dataFim';";


    $ret = mysqli_query($conn, $sql);
    $total = 0;
    while ($row = mysqli_fetch_array($ret)) {
        $valor = floatval($row['propValorPosDesconto']);
        $total += $valor;
    }

    return $total;
}

function soma_rep_valores_propostas($conn)
{

    $thisMonth = date('m');
    $thisYear = date('Y');
    $lastYear = $thisYear - 1;
    // $thisYear = "2022";
    $thisDay = date('d');

    $DaysInCurrentMonth = date('t');

    $dataInicio = $thisYear . "-01-01";
    // $dataFim = $thisYear . "-" . $thisMonth . "-" . $DaysInCurrentMonth;
    $dataFim = $thisYear . "-12-31";

    // BETWEEN '2022-01-01' AND '2023-12-31';
    $sql = "SELECT propValorPosDesconto FROM propostas 
    WHERE propRepresentante = '" . $_SESSION["useruid"] . "' AND
    propData BETWEEN '$dataInicio' AND '$dataFim';";


    $ret = mysqli_query($conn, $sql);
    $total = 0;
    while ($row = mysqli_fetch_array($ret)) {
        $valor = floatval($row['propValorPosDesconto']);
        $total += $valor;
    }

    return $total;
}


function atualizahorarioedata($conn)
{
    $ret = mysqli_query($conn, "SELECT * FROM propostas;");

    while ($row = mysqli_fetch_array($ret)) {
        $ID = $row['propId'];
        $dataBD = $row['propDataCriacao'];
        $dataBD = explode(" ", $dataBD);

        $wrongData = $dataBD[0];
        $wrongHora = $dataBD[1];

        $wrongData = explode("/", $wrongData);
        $newData = $wrongData[2] . "-" . $wrongData[1] . "-" . $wrongData[0];

        $newHora = $wrongHora;


        $sql = "UPDATE propostas SET propData = ?, propHora = ? WHERE propId ='$ID';";


        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // header("location: ../solicitacao?error=stmtfailed1");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $newData, $newHora);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // echo $newData;
        // echo ' + ';
        // echo $newHora;
        // echo '<br>';
    }
}

function getStatusPedido($conn, $idProp)
{
    $sql = "SELECT * FROM `pedido` RIGHT JOIN `propostas` ON `pedido`.pedPropRef = `propostas`.propId WHERE pedPropRef = '" . $idProp . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $statusPed = $row["pedStatus"];
    }

    return $statusPed;
}

function getNumPedido($conn, $idProp)
{
    $sql = "SELECT * FROM `pedido` RIGHT JOIN `propostas` ON `pedido`.pedPropRef = `propostas`.propId WHERE pedPropRef = '" . $idProp . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $numPed = $row["pedNumPedido"];
    }

    return $numPed;
}

function dateFormat($data)
{

    $dataRaw = explode(" ", $data);
    $newData = $dataRaw[0];

    $newData = explode("/", $newData);

    $res = $newData[0] . "/" . $newData[1] . "/" . $newData[2];

    return $res;
}

function dateFormat2($data)
{

    $dataRaw = explode(" ", $data);
    $newData = $dataRaw[0];

    $newData = explode("-", $newData);

    $res = $newData[2] . "/" . $newData[1] . "/" . $newData[0];

    return $res;
}

function dateFormat3($data)
{

    $dataRaw = explode("-", $data);
    // $newData = $dataRaw[0];

    // $newData = explode("-", $newData);

    $res = $dataRaw[2] . "/" . $dataRaw[1] . "/" . $dataRaw[0];

    return $res;
}



function hourFormat($data)
{

    $dataRaw = explode(" ", $data);
    $newHora = $dataRaw[1];

    $newHora = explode(":", $newHora);

    $res = $newHora[0] . ":" . $newHora[1];

    return $res;
}

function hourFormat2($hour)
{

    $dataRaw = explode(":", $hour);

    $res = $dataRaw[0] . ":" . $dataRaw[1];

    return $res;
}

function getMonthName($conn, $month)
{

    $sql = "SELECT * FROM `mesesano` WHERE mesNum = '" . $month . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $monthName = $row["mesNome"];
    }

    return $monthName;
}

function getMonthAbrv($conn, $month)
{

    $sql = "SELECT * FROM `mesesano` WHERE mesNum = '" . $month . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $monthAbrv = $row["mesAbrv"];
    }

    return $monthAbrv;
}

function hoje()
{
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $hoje = $dt->format("Y-m-d");
    // $horaAtual = $dt->format("H:i:s");

    // $thisMonth = date('m');
    // $thisYear = date('Y');
    // $thisDay = date('d');
    // $hoje = $thisYear . "-" . $thisMonth . "-" . $thisDay;

    return $hoje;
}

function agora()
{

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    // $hoje = $dt->format("Y-m-d");
    $thisHour = $dt->format("H:i:s");
    // $thisHour = date("H:i:s");

    return $thisHour;
}

function criarPrazoModuloII($conn, $data, $statusPrazo)
{
    //Criar BD Prazo
    $dataAtual = hoje();
    $horaAtual = agora();


    $sql = "INSERT INTO prazoproposta (przNumProposta, przData, przHora, przStatus) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../casos?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $data['pedido'], $dataAtual, $horaAtual, $statusPrazo);
    mysqli_stmt_execute($stmt);
    
    if ($statusPrazo == 'Projeto Aceito') {
        salvarDataEntrega($conn, $data['pedido']);
    }
    // mysqli_stmt_close($stmt);
}


function salvarDataEntrega($conn, $numPed)
{

    $dataEntrega = getDataPrazoPosAceite($conn, $numPed);

    $dataEntrega = DateTime::createFromFormat('d/m/Y', $dataEntrega);
    $dataEntrega = $dataEntrega->format('Y-m-d');
    

    atualizarPedidoComDtEntrega($conn, $dataEntrega, $numPed);
}

function atualizarPedidoComDtEntrega($conn, $dataEntrega, $numPed)
{
    $sql = "UPDATE pedido SET pedDtEntrega='$dataEntrega' WHERE pedNumPedido='$numPed'";

    mysqli_query($conn, $sql);

}

function criarPrazoPedido($conn, $numPed, $statusPrazo)
{
    //Criar BD Prazo
    $dataAtual = hoje();
    $horaAtual = agora();


    $sql = "INSERT INTO prazoproposta (przNumProposta, przData, przHora, przStatus) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../comercial?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $numPed, $dataAtual, $horaAtual, $statusPrazo);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
}

function getDataPrazoContada($conn, $numPedOG)
{
    $przDaysOn = 0;
    $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`przData`) as dataContada FROM prazoproposta WHERE przNumProposta='" . $numPedOG . "' ORDER BY przId DESC LIMIT 1;");
    while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        // $przStatus = $rowPrzStatus["przStatus"];
        // $przData = $rowPrzStatus["przData"];
        $przDaysOn = $rowPrzStatus['dataContada'];
    }

    // Inicializa o contador de dias úteis
    $diasUteis = 0;

    // Obtém a data de criação do pedido
    $dataCriacao = date_create();
    date_sub($dataCriacao, date_interval_create_from_date_string($przDaysOn . ' days'));

    // Loop para contar os dias úteis
    for ($i = 0; $i <= abs($przDaysOn); $i++) {
        $dataAtual = clone $dataCriacao;
        date_add($dataAtual, date_interval_create_from_date_string($i . ' days'));

        // Verifica se o dia atual é um sábado ou domingo (fim de semana)
        if (date_format($dataAtual, 'N') <= 5) {
            $diasUteis++;
        }
    }

    $diasUteis = $diasUteis-1;
    return $diasUteis;

}

function getDataPrazoPosAceite($conn, $numPedOG)
{
    $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`przData`) as dataContada FROM prazoproposta WHERE przNumProposta='" . $numPedOG . "'  AND przStatus='Projeto Aceito' ORDER BY przId DESC LIMIT 1;");
    while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        $przStatus = $rowPrzStatus["przStatus"];
        $przData = $rowPrzStatus["przData"];
        // $przDaysOn = $rowPrzStatus['dataContada'];

        $dataCalculada = strtotime($przData . "+ 20 weekdays");
        $dataCalculada = date("d/m/Y", $dataCalculada);
    }

    $codStatus = $przStatus;

    $ret = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$codStatus'");
    while ($row = mysqli_fetch_array($ret)) {
        $calc = $row["stpedCalcularDtPrazo"];
    }

    if ($calc == true) {
        $dataPrazoContada = $dataCalculada;
    } else {
        $dataPrazoContada = "-";
    }


    return $dataCalculada;
}

function getNomeFluxoPed($conn, $idPed)
{
    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idPed'");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row['pedStatus'];

        $ret2 = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$status'");
        while ($row2 = mysqli_fetch_array($ret2)) {
            $nomeFluxo = $row2["stpedNome"];
        }
        $dtAceite = '';

        if (($status == 'Projeto Aceito') || ($status == 'Solicitação de Alteração')) {
            $retPrz = mysqli_query($conn, "SELECT * FROM prazoproposta WHERE przNumProposta='$idPed' AND przStatus='Projeto Aceito'");
            while ($rowPrz = mysqli_fetch_array($retPrz)) {
                $dtAceite = $rowPrz['przData'];
            }

            if ($status == 'Projeto Aceito') {
                $nomeFluxo = 'Proj. Aceito - ' . dateFormat2($dtAceite);
            } else if ($status == 'Solicitação de Alteração') {
                $nomeFluxo = 'Sol. Alteração - ' . dateFormat2($dtAceite);
            }
        }
    }

    return $nomeFluxo;
}

function getDataAceite($conn, $idPed)
{
    $query = "SELECT * FROM prazoproposta WHERE przNumProposta = '$idPed';";

    $ret = mysqli_query($conn, $query);

    $prazoPropostaArray = array(); // Initialize an array to store prazoproposta items

    while ($row = mysqli_fetch_array($ret)) {
        array_push($prazoPropostaArray, $row);
    }

    $dataAceite = "";
    foreach ($prazoPropostaArray as $key => $value) {
        if ($value["przStatus"] == "Projeto Aceito") {
            $dataAceite = $value["przData"];
            $dataAceite = dateFormat2($dataAceite);
        }
    }

    // Use $prazoPropostaArray as needed
   return $dataAceite;
}

function getFullNomeFluxoPed($conn, $codigostatus)
{

    $ret2 = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$codigostatus'");
    while ($row2 = mysqli_fetch_array($ret2)) {
        $nomeFluxo = $row2["stpedNome"];
    }

    return $nomeFluxo;
}

function getCorFluxoPed($conn, $idPed)
{
    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idPed'");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row['pedStatus'];

        $ret2 = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$status'");
        while ($row2 = mysqli_fetch_array($ret2)) {
            $corbg = $row2["stpedCorBg"];
            $cortxt = $row2["stpedCorTexto"];
        }

        $corFluxo = $corbg . " " . $cortxt;
    }

    return $corFluxo;
}

function getFullCorFluxoPed($conn, $codigostatus)
{
    $ret2 = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$codigostatus'");
    while ($row2 = mysqli_fetch_array($ret2)) {
        $corbg = $row2["stpedCorBg"];
        $cortxt = $row2["stpedCorTexto"];
    }

    $corFluxo = $corbg . " " . $cortxt;

    return $corFluxo;
}

function getAndamentoFluxoPed($conn, $numPed)
{
    // $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$numPed'");
    // while ($row = mysqli_fetch_array($ret)) {
    //     $switch = $row['pedStatus'];

    $dias = getDataPrazoContada($conn, $numPed);

    $andamento = '
        <p style="line-height: 1.5rem; font-size: 10pt;">Dias nesta etapa:
                                                                <span class="text-conecta"><b>
                                                                        há ' . $dias . ' dias
                                                                    </b></span>
                                                            </p>
        ';
    // }

    return $andamento;
}

function getAndamentoForTableFluxoPed($conn, $idPed)
{
    // $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idPed'");
    // while ($row = mysqli_fetch_array($ret)) {
    //     $switch = $row['pedStatus'];

    // }
    $dias = getDataPrazoContada($conn, $idPed);

    return $dias;
}

// function getDiasTotaisdoPedido($conn, $numPedOG)
// {
//     $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`pedDtCriacaoPed`) as dataContada FROM pedido  WHERE pedNumPedido='" . $numPedOG . "' ORDER BY pedId DESC LIMIT 1;");
//     while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
//         $przDaysOn = $rowPrzStatus['dataContada'];
//     }

//     return $przDaysOn;
// }

function getDiasTotaisdoPedido($conn, $numPedOG)
{
    $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(), `pedDtCriacaoPed`) as dataContada FROM pedido WHERE pedNumPedido='" . $numPedOG . "' ORDER BY pedId DESC LIMIT 1;");
    
    while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        $dataContada = $rowPrzStatus['dataContada'];
    }

    // Inicializa o contador de dias úteis
    $diasUteis = 0;

    // Obtém a data de criação do pedido
    $dataCriacao = date_create();
    date_sub($dataCriacao, date_interval_create_from_date_string($dataContada . ' days'));

    // Loop para contar os dias úteis
    for ($i = 0; $i <= abs($dataContada); $i++) {
        $dataAtual = clone $dataCriacao;
        date_add($dataAtual, date_interval_create_from_date_string($i . ' days'));

        // Verifica se o dia atual é um sábado ou domingo (fim de semana)
        if (date_format($dataAtual, 'N') <= 5) {
            $diasUteis++;
        }
    }

    $diasUteis = $diasUteis-1;
    return $diasUteis;
}

function  getIniciasTecnicodoPedido($conn, $numPedOG)
{
    $retPrzStatus = mysqli_query($conn, "SELECT * FROM pedido  WHERE pedNumPedido='" . $numPedOG . "' ORDER BY pedId DESC LIMIT 1;");
    while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        $pedTecnico = $rowPrzStatus['pedTecnico'];
    }

    $iniciaisTecnico = substr($pedTecnico,0,2);

    return $iniciaisTecnico;
}

function  getNomeTecnicodoPedido($conn, $numPedOG)
{

    $retPrzStatus = mysqli_query($conn, "SELECT * FROM pedido  WHERE pedNumPedido='" . $numPedOG . "' ORDER BY pedId DESC LIMIT 1;");
    while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        $pedTecnico = $rowPrzStatus['pedTecnico'];
    }

    // $iniciaisTecnico = substr($pedTecnico, 0, 2);

    return $pedTecnico;
}

function changestatustc($conn, $id, $statustc)
{

    switch ($statustc) {
        case 'aprov':
            $descricaoStatus = 'Rep Aprovado';
            break;
        case 'reprov':
            $descricaoStatus = 'Rep Reprovado';
            break;
        default:
            $descricaoStatus = 'EM ANÁLISE';
            break;
    }

    //Atualiza Qualificação Cliente
    $sql = "UPDATE propostas SET propStatus = ? WHERE propId ='$id'";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../dados_proposta?id=" . $id . "&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $descricaoStatus);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
    
    
    $sql = "SELECT * FROM propostas WHERE propId = '" . $id . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $dr = $row["propNomeDr"];
        $pac = $row["propNomePac"];
        $produto = $row["propTipoProd"];
        $representante = $row["propRepresentante"];
        $uf = $row["propUf"];
    }


    //Link live API
    $url = 'https://webhooks.integrately.com/a/webhooks/db094eea3aa241fbae6a0157aacfdf49?';

    $data = array(
        'NumProposta' => $id,
        'Doutor' => $dr,
        'Pac' => $pac,
        'Produto' => $produto,
        'Representante' => $representante,
        'UF' => $uf,
        'Status' => $descricaoStatus

    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function createAnaliseTC($conn, $data)
{
    $sql = "INSERT INTO aprovacaotc (aprovNumProp, aprovChecklist, aprovDeclaracaoLeitura, aprovQuemAnalisou, aprovDataAnalise, aprovStatus, aprovComentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {

        header("location: ../solicitacoes?error=stmtfailedanalise");

        exit();
    }
    $dataAnalise = hoje();


    mysqli_stmt_bind_param($stmt, "sssssss", $data['numprop'], $data['checklist'], $data['declaracao'], $data['user'], $dataAnalise, $data['resultado'], $data['comentario']);
    mysqli_stmt_execute($stmt);
    
    if ($data['resultado'] == "Aprovado") {
        $dataProp = getAllDataFromProp($conn, $data['numprop']);
        $result = array_merge($dataProp, $data);
        $url = "https://webhooks.integrately.com/a/webhooks/58f9dbd098b94751b4000c295f0b6d92";
        notificarPlanejamentoNovaAliseTC($url, $result);
    }
    
    mysqli_stmt_close($stmt);

    header("location: ../dados_proposta?id=" . $data['numprop'] . "&error=analiseenviada");
}

function createAnaliseTCCN($conn, $data)
{
    $sql = "INSERT INTO aprovacaotc (aprovNumProp, aprovChecklist, aprovDeclaracaoLeitura, aprovQuemAnalisou, aprovDataAnalise, aprovStatus, aprovComentario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {

        header("location: ../update-proposta?error=stmtfailedanalise");

        exit();
    }
    $dataAnalise = hoje();

    mysqli_stmt_bind_param($stmt, "sssssss", $data['numprop'], $data['checklist'], $data['declaracao'], $data['user'], $dataAnalise, $data['resultado'], $data['comentario']);
    mysqli_stmt_execute($stmt);


    if ($data['resultado'] == "Aprovado") {
        $dataProp = getAllDataFromProp($conn, $data['numprop']);
        $result = array_merge($dataProp, $data);
        $url = "https://webhooks.integrately.com/a/webhooks/58f9dbd098b94751b4000c295f0b6d92";
        notificarPlanejamentoNovaAliseTC($url, $result);
    }


    mysqli_stmt_close($stmt);

    header("location: ../update-proposta?id=" . $data['numprop'] . "&error=analiseenviada");
}

function existeAnalise($conn, $idProp){

    $sql = "SELECT * FROM aprovacaotc WHERE aprovNumProp = ? ORDER BY aprovId DESC LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../solicitacoes?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $idProp);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function notificarPlanejamentoNovaAliseTC($url, $data)
{

    //Link live API
    $liveUrl = $url;

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($liveUrl, false, $context);
    if ($result === FALSE) { /* Handle error */
    }
}

function reabrirtc($conn, $id)
{

    //1º Get valor FROM `aceite`
    // $dadosAceite = mysqli_query($conn, "SELECT * FROM aceite WHERE aceiteNumPed='$id';");
    // while ($row = mysqli_fetch_array($dadosAceite)) {
    //     $respostaAceiteFROM = $row['aceiteDeAcordo'];
    //     $observacaoFROM = $row['aceiteObs'];
    //     $statusFROM = $row['aceiteStatus'];
    // }

    $ret = mysqli_query($conn, "SELECT * FROM aceite WHERE aceiteNumPed='$id';");
    while ($row = mysqli_fetch_array($ret)) {
        $respostaAceiteFROM = $row['aceiteDeAcordo'];
        $observacaoFROM = $row['aceiteObs'];
        $statusFROM = $row['aceiteStatus'];
    }

    // print_r(mysqli_fetch_array($dadosAceite));
    // exit();

    //2º Insert into `historicoaceite`
    $dataHistorico = array(
        'numPed' => $id,
        'respostaAceiteFROM' => $respostaAceiteFROM,
        'observacaoFROM' => $observacaoFROM,
        'statusFROM' => $statusFROM
    );

    novoHistoricoAceite($conn, $dataHistorico);

    //3º Reset valor FROM `aceite`
    zerarAceite($conn, $id);

    //4º Mudar status do Pedido
    $status = "ACEITE";
    updateStatusCaso($conn, $id, $status);

    //5º Liberar a Aba
    $abaAberta = 'liberado';
    $abaFechada = 'fechado';

    $casoId = getIdFromPed($conn, $id);

    $abas = array(
        'casoId' => $casoId,
        'numped' => $id,
        'documentos' => $abaAberta,
        'agendar' => $abaFechada,
        'aceite' => $abaAberta,
        'relatorios' => $abaFechada,
        'visualizacao' => $abaAberta
    );

    liberarAbas($conn, $abas);


    //registra Log
    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $id,
        'atividade' => "Form Aceite do Pedido Reaberto"
    );

    logAtividadePedProp($conn, $dados);
    criarPrazoPedido($conn, $id, $status);


    $pedId = getIdFromPed($conn, $id);
    header("location: update-caso?id=" . $pedId . "&error=aceiteaberto");
    exit();
}

function novoHistoricoAceite($conn, $dataHistorico)
{
    $sqlProd = "INSERT INTO historicoaceite (aceiteNumPed, aceiteDeAcordo, aceiteObs, aceiteStatus) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../casos?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $dataHistorico['numPed'], $dataHistorico['respostaAceiteFROM'], $dataHistorico['observacaoFROM'], $dataHistorico['statusFROM']);
    mysqli_stmt_execute($stmt);
}

function zerarAceite($conn, $numPed)
{
    $null = null;
    $novoStatus = "VAZIO";

    $sql = "UPDATE aceite SET aceiteDeAcordo = ?, aceiteObs = ?, aceiteStatus = ? WHERE aceiteNumPed = ? ;";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../casos?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $null, $null, $novoStatus, $numPed);
    mysqli_stmt_execute($stmt);
}

function updateStatusCaso($conn, $numPed, $status)
{
    $ret = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$status'");
    while ($row = mysqli_fetch_array($ret)) {
        $posicao = $row["stpedPosicao"];
        $andamentoPed = $row["stpedAndamento"];
    }


    $sql = "UPDATE pedido SET pedAndamento='$andamentoPed', pedStatus='$status', pedPosicaoFluxo='$posicao' WHERE pedNumPedido='$numPed'";

    mysqli_query($conn, $sql);

    // if (mysqli_query($conn, $sql)) {
    //     // header("location: ../casos?error=edit");
    // } else {
    //     // header("location: ../casos?error=edit");
    // }
    // mysqli_close($conn);
}

function addStPedido($conn, $nome, $indexFluxo, $value)
{
    $sql = "INSERT INTO statuspedido (stpedNome,stpedIndiceFluxo,stpedValue) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerpedido?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $nome, $indexFluxo, $value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerpedido?error=none");
    exit();
}

function editStPedido($conn, $nome, $indexFluxo, $value, $posicao, $andamento, $calcdtprazo, $corbg, $cortxt, $id)
{
    $sql = "UPDATE statuspedido SET stpedNome=?, stpedIndiceFluxo=?, stpedValue=?, stpedPosicao=?, stpedAndamento=?, stpedCalcularDtPrazo=?, stpedCorBg=?, stpedCorTexto=? WHERE stpedId= ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerpedido?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssss", $nome, $indexFluxo, $value, $posicao, $andamento, $calcdtprazo, $corbg, $cortxt, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerpedido?error=edit");
    exit();
}

function deleteStPedido($conn, $id)
{
    $sql = "DELETE FROM statuspedido WHERE stpedId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gerpedido?error=deleted");
    } else {
        header("location: gerpedido?error=stmtfailed");
    }
    mysqli_close($conn);
}

function addDocsFaltantes($conn, $nome)
{
    $sql = "INSERT INTO docspedido (docsNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gerpedido?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gerpedido?error=none");
    exit();
}

function deleteDocsFaltantes($conn, $id)
{
    $sql = "DELETE FROM docspedido WHERE docsId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: gerpedido?error=deleted");
    } else {
        header("location: gerpedido?error=stmtfailed");
    }
    mysqli_close($conn);
}

function editPedNumber($conn, $oldnumber, $newnumber)
{

    $oldData = getAllDataFromPed($conn, $oldnumber);
    $propNumber = $oldData["pedPropRef"];
    
    //1 - mudar numero do pedido na proposta
    $sql = "UPDATE propostas SET propPedido = ? WHERE propId =?";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $newnumber, $propNumber);
    mysqli_stmt_execute($stmt);
    

    //2 - mudar numero do pedido nos bancos ACEITE, ADIANTAMENTOS, AGENDA, COMENTARIOSVISUALIZADOR, FEEDBACKACEITE, PRAZOPROPOSTA, QUALIANEXOIDR, QUALIANEXOII, QUALIANEXOIIIDR, QUALIANEXOIIIPAC, QUALIANEXOIPAC, RELATORIOS, RELATORIOUPLOAD, VISUALIZADOR, HISTORICOACEITE

    //ACEITE
    updateSimpleItem($conn, "aceite", "aceiteNumPed", $newnumber, "aceiteNumPed", $oldnumber);
    //ADIANTAMENTOS
    updateSimpleItem($conn, "adiantamentos", "adiantNPed", $newnumber, "adiantNPed", $oldnumber);
    //AGENDA
    updateSimpleItem($conn, "agenda", "agdNumPedRef", $newnumber, "agdNumPedRef", $oldnumber);
    //COMENTARIOSVISUALIZADOR
    updateSimpleItem($conn, "comentariosvisualizador", "comentVisNumPed", $newnumber, "comentVisNumPed", $oldnumber);
    //FEEDBACKACEITE
    updateSimpleItem($conn, "feedbackaceite", "fdaceiteNumPed", $newnumber, "fdaceiteNumPed", $oldnumber);
    //PRAZOPROPOSTA
    updateSimpleItem($conn, "prazoproposta", "przNumProposta", $newnumber, "przNumProposta", $oldnumber);
    //QUALIANEXOIDR
    updateSimpleItem($conn, "qualianexoidr", "xidrIdProjeto", $newnumber, "xidrIdProjeto", $oldnumber);
    //QUALIANEXOII
    updateSimpleItem($conn, "qualianexoii", "xiiIdProjeto", $newnumber, "xiiIdProjeto", $oldnumber);
    //QUALIANEXOIIIDR
    updateSimpleItem($conn, "qualianexoiiidr", "xiiidrIdProjeto", $newnumber, "xiiidrIdProjeto", $oldnumber);
    //QUALIANEXOIIIPAC
    updateSimpleItem($conn, "qualianexoiiipac", "xiiipacIdProjeto", $newnumber, "xiiipacIdProjeto", $oldnumber);
    //QUALIANEXOIPAC
    updateSimpleItem($conn, "qualianexoipac", "xipacIdProjeto", $newnumber, "xipacIdProjeto", $oldnumber);
    //RELATORIOS
    updateSimpleItem($conn, "relatorios", "relNumPedRef", $newnumber, "relNumPedRef", $oldnumber);
    //RELATORIOUPLOAD
    updateSimpleItem($conn, "relatorioupload", "fileNumPed", $newnumber, "fileNumPed", $oldnumber);
    //VISUALIZADOR
    updateSimpleItem($conn, "visualizador", "visNumPed", $newnumber, "visNumPed", $oldnumber);
    //HISTORICOACEITE
    updateSimpleItem($conn, "historicoaceite", "aceiteNumPed", $newnumber, "aceiteNumPed", $oldnumber);


    //3 - mudar numero no pedido
    updateSimpleItem($conn, "pedido", "pedNumPedido", $newnumber, "pedNumPedido", $oldnumber);

    mysqli_stmt_close($stmt);
    header("location: ../mudarpedido?error=success&old=" . $oldnumber . "&new=" . $newnumber);
    exit();
}

function updateSimpleItem($conn, $dbName, $columChanged, $objChanged, $columReference, $objReference)
{

    $sql = "UPDATE " . $dbName . " SET " . $columChanged . " = ? WHERE " . $columReference . " = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../solicitacao?error=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $objChanged, $objReference);
    mysqli_stmt_execute($stmt);
}

function finalizarPedido($conn, $id, $user, $dataAtual)
{
    //salvar no bd de finalização de pedidos
    $sql = "INSERT INTO finalizacaopedido (finpedNumPed, finpedUserFinalizador, finpedDataFinalizacao) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../relatorio?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $id, $user, $dataAtual);
    mysqli_stmt_execute($stmt);


    //mudar status do pedido para ENVIADO
    $novoStatus = "ENVIADO";
    updateStatusCaso($conn, $id, $novoStatus);

    
    mysqli_close($conn);

    $encrypted = hashItemNatural($id);

    header("location: relatorio?id=" . $encrypted);
    exit();
}

function getNomeFinalizador($conn, $pedID){

    $sql = "SELECT * FROM finalizacaopedido WHERE finpedNumPed = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: relatorio?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $pedID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row["finpedUserFinalizador"];
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getDataFinalizador($conn, $pedID){

    $sql = "SELECT * FROM finalizacaopedido WHERE finpedNumPed = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: relatorio?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $pedID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row["finpedDataFinalizacao"];
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}


function newAvaliacaoCaso($conn, $casoId, $ped, $opaceite, $comenttxtaceite, $user)
{
    $abaAberta = 'liberado';
    $abaFechada = 'fechado';
    
    $dataStatus = array(
        'casoId' => $casoId,
        'numped' => $ped,
        'status' => 'ACEITE',
        'comentario' => $comenttxtaceite,
        'revisor' => $user
    );

    //update status para video se aceite SIM e para solicitado alteração se NÃO
    if ($opaceite == 1) {
        //status = agendar video
        $status = 'ACEITE';
        // echo $status;
        // exit();
        sendNotificacaoProjetoLiberado($conn, $dataStatus);
        
        $abas = array(
            'casoId' => $casoId,
            'numped' => $ped,
            'documentos' => $abaAberta,
            'agendar' => $abaFechada,
            'aceite' => $abaAberta,
            'relatorios' => $abaFechada,
            'visualizacao' => $abaFechada
        );

        liberarAbas($conn, $abas);
    } else {
        //status = solicitado alteração
        $status = 'Solicitação de Alteração';
        // echo $status;
        // exit();
        sendNotificacaoSolicitadoAlteracao($conn, $dataStatus);
        
        $abas = array(
            'casoId' => $casoId,
            'numped' => $ped,
            'documentos' => $abaAberta,
            'agendar' => $abaFechada,
            'aceite' => $abaFechada,
            'relatorios' => $abaFechada,
            'visualizacao' => $abaFechada
        );

        liberarAbas($conn, $abas);
    }

    updateStatusCaso($conn, $ped, $status);

    $data = array(
        'pedido' => $ped
    );

    criarPrazoModuloII($conn, $data, $status);

    //insert into bd de avaliação
    criarNovaAvaliacaoPedido($conn, $ped, $opaceite, $comenttxtaceite, $user);

    header("location: ../avaliar-caso?id=" . $casoId . "&error=changed");
    exit();
}

function criarNovaAvaliacaoPedido($conn, $ped, $opaceite, $comenttxtaceite, $user){

    $data = hoje();
    $hora = agora();

    //insert into bd de avaliação
    $sql = "INSERT INTO avaliacaopedido (avNumPed, avStatus, avObservacao, avUserObs, avData, avHora) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../relatorio?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $ped, $opaceite, $comenttxtaceite, $user, $data, $hora);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function liberarAbas($conn, $abas)
{
    $casoId = $abas['casoId'];
    $numped = $abas['numped'];
    $documentos = $abas['documentos'];
    $agendar = $abas['agendar'];
    $aceite = $abas['aceite'];
    $relatorios = $abas['relatorios'];
    $visualizacao = $abas['visualizacao'];

    //Atualiza as abas do pedido
    $sql = "UPDATE pedido SET pedAbaAgenda = ?, pedAbaVisualizacao = ?, pedAbaAceite = ?, pedAbaRelatorio = ?, pedAbaDocumentos = ? WHERE pedNumPedido = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $agendar, $visualizacao, $aceite, $relatorios, $documentos, $numped);
    mysqli_stmt_execute($stmt);
    
    //registra Log
    $dados = array(
        'tipo' => "pedido",
        'dataAtual' => hoje(),
        'horaAtual' => agora(),
        'usuario' => $_SESSION['useruid'],
        'numero' => $numped,
        'atividade' => "Abas do Pedido Alteradas"
    );

    logAtividadePedProp($conn, $dados);
    // mysqli_stmt_close($stmt);
}

// CRUD Permissões Extra
function adicionarPermissoesExtras($conn, $user, $codigo, $descricao)
{
    $sql = "INSERT INTO permissao_usuario (usuario, permissao, descricao) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../relatorio?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $user, $codigo, $descricao);
    mysqli_stmt_execute($stmt);
}

function atualizarPermissoesExtras($conn, $user, $codigo, $descricao, $id)
{
    $sql = "UPDATE permissao_usuario SET usuario = ?, permissao = ?, descricao = ? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $user, $codigo, $descricao, $id);
    mysqli_stmt_execute($stmt);
}

function excluirPermissoesExtras($conn, $id)
{
    $sql = "DELETE FROM permissao_usuario WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

function mostrarTodosPermissoesExtras($conn)
{
    $arrayUser = array();

    $sql = "SELECT * FROM permissao_usuario WHERE 1";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            array_push($arrayUser, $row_user);
        }
        return $arrayUser;
    } else {
        return false;
    }
}

function mostrarEspecificosPermissoesExtras($conn, $id)
{

    $sql = "SELECT * FROM permissao_usuario WHERE id = '$id'";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        return mysqli_fetch_assoc($res);
    } else {
        return false;
    }
}

function pesquisarPermissoesExtras($conn, $user, $perm)
{

    $sql = "SELECT * FROM permissao_usuario WHERE usuario = '$user' AND permissao = '$perm'";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        // return mysqli_fetch_assoc($res);
        return true;
    } else {
        return false;
    }
}

function getPrimeiroNome($nome)
{
    $primeiroNome = explode(" ", $nome);
    $primeiroNome = $primeiroNome[0];
    return $primeiroNome;
}

//Log De Atividades Pedido e Proposta
function logAtividadePedProp($conn, $dados)
{

    //ID será Número do Pedido ou Número da Proposta

    // $dados = array(
    //     'tipo' => $tipo,    
    //     'dataAtual' => $dataAtual,
    //     'horaAtual' => $horaAtual,
    //     'usuario' => $usuario,
    //     'numero' => $numero,
    //     'atividade' => $atividade
    // );

    $sql = "INSERT INTO logatividadepedprop (tipo, dataAtual, horaAtual, usuario, numero, atividade) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {

        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $dados['tipo'], $dados['dataAtual'], $dados['horaAtual'], $dados['usuario'], $dados['numero'], $dados['atividade']);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
}

function mostrarPesoProduto($tipoProduto)
{
    $result = '';

    switch ($tipoProduto) {
        case 'ORTOGNÁTICA':
            $result = "22 larg. x29 alt. x61 comp. (cm ) - PESO 2KG";
            break;

        case 'SMARTMOLD':
            $result = "22 larg x29 alt. x41 comp. (cm) - PESO 1,5KG";
            break;

        case 'RECONSTRUÇÃO ÓSSEA':
            $result = "22 larg. x29 alt. x61 comp. (cm ) PESO 2KG";
            break;

        case 'CRÂNIO PEEK':
            $result = "22 larg. x29 alt. x61 comp. (cm ) PESO 2KG";
            break;

        case 'CRÂNIO TITÂNIO':
            $result = "22 larg. x29 alt. x61 comp. (cm ) PESO 2KG";
            break;

        case 'RECONSTRUÇÃO SOB MEDIDA':
            $result = "22 larg. x29 alt. x61 comp. (cm ) PESO 2KG";
            break;

        case 'ATM':
            $result = "22 larg. x29 alt. x61 comp. (cm ) PESO 2KG";
            break;

        case 'CUSTOMLIFE':
            $result = "peso 1,5Kg dimensões da caixa M - alt 22 x larg 29 x comp 41";
            break;

        default:
            $result = "";
            break;
    }

    return $result;
}

function getDataFinalPedido($conn, $numPed)
{
    $sql = "SELECT * 
    FROM prazoproposta 
    WHERE przNumProposta = ? 
    AND przStatus = 'PROD'
    ORDER BY przId DESC 
    LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../perfil?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $numPed);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['przData'];
    } else {
        $result = '-/-/-';
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getDataDeStatusPedido($conn, $numPed, $status)
{
    $sql = "SELECT * 
    FROM prazoproposta 
    WHERE przNumProposta = ? 
    AND przStatus = ?
    ORDER BY przId DESC 
    LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../perfil?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $numPed, $status);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['przData'];
    } else {
        $result = '-/-/-';
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function calcularDiasUteis($dataInicio, $dataFim) {
    // Converte as datas para objetos DateTime
    $inicio = DateTime::createFromFormat('d/m/Y', $dataInicio);
    $fim = DateTime::createFromFormat('d/m/Y', $dataFim);

    // Garante que as datas foram formatadas corretamente
    if (!$inicio || !$fim) {
        return false;
    }

    // Inicializa o contador de dias úteis
    $diasUteis = 0;

    // Itera sobre cada dia entre as datas
    $intervalo = new DateInterval('P1D');
    $periodo = new DatePeriod($inicio, $intervalo, $fim);

    foreach ($periodo as $dia) {
        // Verifica se o dia é útil (não é sábado ou domingo)
        if ($dia->format('N') < 6) {
            $diasUteis++;
        }
    }

    return $diasUteis;
}

function calcularHorasPlanejamento($conn, $numpedido)
{
    $sql = "SELECT przId, przData, przHora, przStatus
            FROM prazoproposta 
            WHERE przNumProposta = ? 
            ORDER BY przId";

    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);

    if (!$prepare) {
        header("location: ../perfil?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $numpedido);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $horasPlanejamento = 0;
    $horaInicio = null;

    while ($row = mysqli_fetch_assoc($resultData)) {
        if ($row['przStatus'] == 'PLAN') {
            // Se o status for 'PLAN', armazena a hora de início
            $horaInicio = strtotime($row['przData'] . ' ' . $row['przHora']);
            // echo $horaInicio . "<br>";
        } elseif (($row['przStatus'] == 'Pausado' && $horaInicio !== null) || ($row['przStatus'] == 'PROD' && $horaInicio !== null)) {
            // Se o status for 'Pausado' e já tiver uma hora de início, calcula a diferença de horas
            $horaFim = strtotime($row['przData'] . ' ' . $row['przHora']);
            // echo $horaFim . "<br>";
            $horasPlanejamento += ($horaFim - $horaInicio) / 3600; // Converte para horas e adiciona ao total
            $horaInicio = null; // Reinicia a hora de início para o próximo intervalo
        }
    }

    mysqli_stmt_close($stmt);

    return $horasPlanejamento;
}

// function verificarLimitesHoras($conn, $numpedido)
// {
//     // Obtém o tipo de produto do pedido
//     $tipoProduto = obterTipoProduto($conn, $numpedido);

//     // Obtém o tempo total planejado para o pedido
//     // $tempoPlanejado = calcularHorasPlanejamento($conn, $numpedido);
//     // $tempoPlanejadoHoras = converterHoras(calcularHorasPlanejamento($conn, $numpedido));
//     $tempoPlanejadoHoras = getHorasPlanejando($conn, $numpedido);

//     // Define os limites de horas com base no tipo de produto
//     $limiteHoras = ($tipoProduto == 'CUSTOMLIFE' || strpos($tipoProduto, 'SMARTMOLD') !== false || strpos($tipoProduto, 'RECONSTRUÇÃO') !== false || $tipoProduto == 'CRÂNIO EM PEEK' ||  $tipoProduto == 'CRÂNIO EM TITÂNIO' || $tipoProduto == 'MESH 4U') ? 9 : 18;
    
//     // Converte o tempo planejado para horas
    
//     // $tempoPlanejadoHoras = strtotime($tempoPlanejado) / 3600;
//     // $tempoPlanejadoHoras = converterHoras($tempoPlanejadoHoras) ;
    
    
//     // echo strpos($tipoProduto, 'SMARTMOLD') !== false;
//     // echo "<br>";
    
    

//     // Calcula a diferença entre o tempo planejado e o limite
//     $diferenca = intval($limiteHoras) - intval($tempoPlanejadoHoras);
    

//     $part1 = explode(":", $tempoPlanejadoHoras);
//     $part1 = $part1[0];
//     $part1 = intval($part1);

//     // exit();
//     // Verifica o status com base na diferença
//     if ($part1 == 0) {
//         return '0';
//     } elseif ($part1 > 0 && $part1 <= $limiteHoras) {
//         return 'Muito Bom';
//     } elseif ($limiteHoras > 0) {
//         return 'Crítico';
//     } 
// }

// function limiteHorasPorProduto($conn, $numpedido){
//     $tipoProduto = obterTipoProduto($conn, $numpedido);
//     $limiteHoras = ($tipoProduto == 'CUSTOMLIFE' || strpos($tipoProduto, 'SMARTMOLD') !== false || $tipoProduto == 'CRÂNIO EM PEEK' ||  $tipoProduto == 'CRÂNIO EM TITÂNIO' || $tipoProduto == 'MESH 4U') ? 9 : 18;
//     return $limiteHoras;
// }

function verificarLimitesHoras($conn, $numpedido)
{
    //Obtém o multiplicador
    $qtdMultiplicador = getMultiplicadorPedido($conn, $numpedido);
    
    // Obtém o tipo de produto do pedido
    $tipoProduto = obterTipoProduto($conn, $numpedido);

    // Obtém o tempo total planejado para o pedido
    $tempoPlanejado = getHorasPlanejando($conn, $numpedido);

    // Define os limites de horas com base no tipo de produto
    // $limiteHoras = ($tipoProduto == 'CUSTOMLIFE' || $tipoProduto == 'SMARTMOLD' || $tipoProduto == 'CRÂNIO EM PEEK' ||  $tipoProduto == 'CRÂNIO EM TITÂNIO' || $tipoProduto == 'MESH 4U') ? 9 : 18;

    switch ($tipoProduto) {
        case strpos($tipoProduto, 'SMARTMOLD') !== false:
            // case strpos($tipoProduto, 'RECONSTRUÇÃO') !== false:
            $limiteHoras = 1 * 9;
            break;
        case strpos($tipoProduto, 'CUSTOMLIFE') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'CRÂNIO EM PEEK') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'CRÂNIO EM TITÂNIO') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'MESH 4U') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'ORTOGNÁTICA') !== false:
            $limiteHoras = 1 * 18;
            break;
        default:
            $limiteHoras = $qtdMultiplicador * 18;
            break;
    }


    // Converte o tempo planejado para horas
    // $tempoPlanejadoHoras = converterHoras(strtotime($tempoPlanejado) / 3600);
    // echo "tempoPlanejado: ";
    // echo $tempoPlanejado;
    // echo " -> ";


    $part1 = explode(":", $tempoPlanejado);
    $part1 = $part1[0];
    $part1 = intval($part1);

    $meta2 = $limiteHoras + ($limiteHoras * 0.5);
    // echo " meta1: ";
    // echo intval($limiteHoras);

    // echo " | meta2: ";
    // echo intval($meta2);
    // echo " | part1: ";
    // echo $part1;
    
    // exit();
    // Verifica o status com base na diferença
    if (($part1 == 0) || ($part1 == null)){
        $descricao = '0';
    } elseif ($part1 > 0 && $part1 <= $limiteHoras) {
        $descricao = 'Muito Bom';
    } elseif ($part1 > $limiteHoras && $part1 <= $meta2) {
        $descricao = 'Bom';
    } elseif ($part1 > $meta2) {
        $descricao = 'Crítico';
    }

    // echo " | descricao:";
    // echo $descricao;
    // echo "<br>";

    return $descricao;
}

function valorLimiteHoras($conn, $numpedido)
{
    //Obtém o multiplicador
    $qtdMultiplicador = getMultiplicadorPedido($conn, $numpedido);


    // Obtém o tipo de produto do pedido
    $tipoProduto = obterTipoProduto($conn, $numpedido);

    // Define os limites de horas com base no tipo de produto
    // $limiteHoras = ($tipoProduto == 'CUSTOMLIFE' || $tipoProduto == 'SMARTMOLD' || $tipoProduto == 'CRÂNIO EM PEEK' ||  $tipoProduto == 'CRÂNIO EM TITÂNIO' || $tipoProduto == 'MESH 4U') ? 9 : 18;
    switch ($tipoProduto) {
        case strpos($tipoProduto, 'SMARTMOLD') !== false:
            // case strpos($tipoProduto, 'RECONSTRUÇÃO') !== false:
            $limiteHoras = 1 * 9;
            break;
        case strpos($tipoProduto, 'CUSTOMLIFE') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'CRÂNIO EM PEEK') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'CRÂNIO EM TITÂNIO') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'MESH 4U') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        default:
            $limiteHoras = $qtdMultiplicador * 18;
            break;
    }

    return $limiteHoras;
}

function valorOriginal($tipoProduto)
{   

    if($tipoProduto == 'SMARTMOLD'){

        return 150;

    }
    elseif($tipoProduto == 'ORTOGNÁTICA'){

        return 200;

    }
    else{
        return 150;
    }
    
}


function valorResultante($descricao, $limiteHoras,$tipoProduto)
{

    $valorOriginal = valorOriginal($tipoProduto);

    switch ($descricao) {
        case 'Muito Bom':
            $valorResultante = $valorOriginal;
            break;
        case 'Bom':
            $valorResultante = $valorOriginal * 0.5;
            break;
        case 'Crítico':
            $valorResultante = $valorOriginal * 0.3;
            break;
        case '0':
            $valorResultante = 0;
            break;
        default:
            $valorResultante = $valorOriginal;
            break;
    }

    return $valorResultante;
}

function limiteHorasPorProduto($conn, $numpedido)
{
    //Obtém o multiplicador
    $qtdMultiplicador = getMultiplicadorPedido($conn, $numpedido);

    $tipoProduto = obterTipoProduto($conn, $numpedido);
    // $limiteHoras = ($tipoProduto == 'CUSTOMLIFE' || strpos($tipoProduto, 'SMARTMOLD') !== false || strpos($tipoProduto, 'RECONSTRUÇÃO') !== false || $tipoProduto == 'CRÂNIO EM PEEK' ||  $tipoProduto == 'CRÂNIO EM TITÂNIO' || $tipoProduto == 'MESH 4U') ? 9 : 18;
    switch ($tipoProduto) {
        case strpos($tipoProduto, 'SMARTMOLD') !== false:
            $limiteHoras = 1 * 9;
            break;
        case strpos($tipoProduto, 'CUSTOMLIFE') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'CRÂNIO EM PEEK') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'CRÂNIO EM TITÂNIO') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'MESH 4U') !== false:
            $limiteHoras = $qtdMultiplicador * 9;
            break;
        case strpos($tipoProduto, 'ORTOGNATICA') !== false:
            $limiteHoras = 18;
            break;
        default:
            $limiteHoras = $qtdMultiplicador * 18;
            break;
    }
    return $limiteHoras;
}

// Função para obter o tipo de produto do pedido
function obterTipoProduto($conn, $numpedido)
{
    $sql = "SELECT pedTipoProduto FROM pedido WHERE pedNumPedido = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $numpedido);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $tipoProduto);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $tipoProduto;
    } else {
        header("location: ../quadrotecnicos?error=stmtfailed");
        exit();
    }
}

function converterHoras($horas)
{
    // Converte as horas totais para formato 'H:i:s'
    $formato = 'H:i:s';
    $formatado = gmdate($formato, $horas * 3600);

    return $formatado;
}

function getAnvisaFromCodigo($conn, $codigo){
    $sql = "SELECT * 
    FROM produtos 
    WHERE prodCodCallisto = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../op?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['prodAnvisa'];
    } else {
        $result = 'N/A';
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getAcompanhaFromCodigo($conn, $codigo){
    $sql = "SELECT * 
    FROM produtos 
    WHERE prodCodCallisto = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../op?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['prodTxtOp'];
    } else {
        $result = 'N/A';
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getQtdFromCodigoAndProp($conn, $codigo, $prop)
{
    $sql = "SELECT * 
    FROM itensproposta 
    WHERE itemCdg = ?
    AND itemPropRef = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../op?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $codigo, $prop);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['itemQtd'];
    } else {
        $result = 'N/A';
        return $result;
    }

    mysqli_stmt_close($stmt);
}


function getPropFromPed($conn, $codigo)
{
    $searchPed = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido=" . $codigo . ";");
    $data = mysqli_fetch_array($searchPed);
    
    return $data;
}

function getLinkArquivo($conn, $codigo)
{
    $pedData = getPropFromPed($conn, $codigo);
    $prop = $pedData["pedPropRef"];


    $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $prop . "' ;");
    while ($rowFile = mysqli_fetch_array($retFile)) {
        if (($rowFile['fileCdnUrl'] != null)) {
            $url = $rowFile['fileCdnUrl'];
        } else {
            $url = "-";
        }
    }

    return $url;
}

function getDescricaoAnvisaFromCodigo($conn, $codigo)
{
    $sql = "SELECT * 
    FROM produtos 
    WHERE prodCodCallisto = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../op?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['prodDescricaoAnvisa'];
    } else {
        $result = 'N/A';
        return $result;
    }

    mysqli_stmt_close($stmt);
}

// function getHorasPlanejando($conn, $pedNum)
// {
//     $arrayStatus = [];
//     $query2 = mysqli_query($conn, "SELECT * FROM prazoproposta WHERE przNumProposta LIKE '%$pedNum%' ORDER BY przId ASC") or die("Aconteceu algo errado!");
//     while ($rowFaq2 = mysqli_fetch_array($query2)) {
//         $nomeFluxo = getFullNomeFluxoPed($conn, $rowFaq2['przStatus']);
//         $dataFluxo = dateFormat2($rowFaq2['przData']);
//         $horaFluxo = $rowFaq2['przHora'];
//         $corFluxoFull = getFullCorFluxoPed($conn, $rowFaq2['przStatus']);
//         $userFluxo = getNomeTecnicodoPedido($conn, $pedNum);
//         $item = [
//             "Fluxo" => $nomeFluxo,
//             "Data" => $dataFluxo,
//             "Hora" => $horaFluxo,
//             "Cor" => $corFluxoFull,
//             "User" => $userFluxo,
//         ];

//         array_push($arrayStatus, $item);
//     }
   
    
//     $thistermino = null;
//     foreach ($arrayStatus as $chave => $valor) {
//         $chaveParametro = $chave + 1;
//         if (array_key_exists($chaveParametro, $arrayStatus)) {
//             $horatermino = $arrayStatus[$chaveParametro]["Hora"];
//             $datatermino = $arrayStatus[$chaveParametro]["Data"];
//         } else {
//             $thistermino = "00:00:00";
//         }
        
//         $soma = 0;
//         // $arr[3] será atualizado com cada valor de $arr...
//         foreach ($valor as $chave2 => $valor2) {
//             $thisstatus = $valor['Fluxo'];
//             $thiscor = $valor['Cor'];
//             $thisdata = $valor['Data'];
//             $thishora = $valor['Hora'];
//             $thisuser = $valor['User'];
//         }
        
//         // $fluxosDesejados = ['Planejando', 'Projetando PDF', 'Projetando Produção', 'Projeto Aceito', 'Solicitação de Alteração', 'Pausado'];
//         $fluxosDesejados = ['Planejando', 'Projetando PDF', 'Projetando Produção', 'Pré Planejamento', 'Segmentação'];
//         if (in_array($thisstatus, $fluxosDesejados)) {
//             $data1 = $datatermino . " " .  $horatermino;
//             $data2 = $thisdata ." " .  $thishora;
            
//             // // Converte as strings para objetos DateTime
//             // $datetime1 = DateTime::createFromFormat("d/m/Y H:i:s", $data1);
//             // $datetime2 = DateTime::createFromFormat("d/m/Y H:i:s", $data2);
            
//             // // Calcula a diferença entre as duas datas
//             // $diferenca = $datetime1->diff($datetime2);
            
//             // // Obtém o resultado formatado em H:i:s
//             // $resultado = $diferenca->format("%H:%i:%s");
//             // Converte as strings para objetos DateTime
//             $datetime1 = DateTime::createFromFormat("d/m/Y H:i:s", $data1);
//             $datetime2 = DateTime::createFromFormat("d/m/Y H:i:s", $data2);
            
//             // Calcula a diferença total em segundos
//             $diferenca_segundos = $datetime1->getTimestamp() - $datetime2->getTimestamp();
            
//             // Calcula dias, horas, minutos e segundos a partir da diferença em segundos
//             $dias = floor($diferenca_segundos / (24 * 60 * 60));
//             $horas = floor(($diferenca_segundos % (24 * 60 * 60)) / 3600);
//             $minutos = floor(($diferenca_segundos % 3600) / 60);
//             $segundos = $diferenca_segundos % 60;
            
//             // Formata o resultado
//             $resultado = sprintf('%02d:%02d:%02d', $dias * 24 + $horas, $minutos, $segundos);
//             $soma = $soma + $resultado;
            
//         }
//     }

//     return $soma;
// }

function getHorasPlanejando($conn, $pedNum)
{
    $arrayStatus = [];
    $query2 = mysqli_query($conn, "SELECT * FROM prazoproposta WHERE przNumProposta LIKE '%$pedNum%' ORDER BY przId ASC") or die("Aconteceu algo errado!");

    while ($rowFaq2 = mysqli_fetch_array($query2)) {
        $nomeFluxo = getFullNomeFluxoPed($conn, $rowFaq2['przStatus']);
        $dataFluxo = dateFormat2($rowFaq2['przData']);
        $horaFluxo = $rowFaq2['przHora'];
        $corFluxoFull = getFullCorFluxoPed($conn, $rowFaq2['przStatus']);
        $userFluxo = getNomeTecnicodoPedido($conn, $pedNum);
        $item = [
            "Fluxo" => $nomeFluxo,
            "Data" => $dataFluxo,
            "Hora" => $horaFluxo,
            "Cor" => $corFluxoFull,
            "User" => $userFluxo,
        ];

        array_push($arrayStatus, $item);
    }

    $soma = 0;

    for ($i = 0; $i < count($arrayStatus) - 1; $i++) {
        $thisItem = $arrayStatus[$i];
        $nextItem = $arrayStatus[$i + 1];

        $thisStatus = $thisItem['Fluxo'];
        $nextStatus = $nextItem['Fluxo'];

        if (in_array($thisStatus, ['Planejando', 'Projetando PDF', 'Projetando Produção', 'Pré Planejamento', 'Segmentação'])) {
            if ($nextItem['Hora'] == null) {
                $nextItemHora = "00:00:00";
            } else{
                $nextItemHora = $nextItem['Hora'];
            }

            if ($thisItem['Hora'] == null) {
                $thisItemHora = "00:00:00";
            } else{
                $thisItemHora = $thisItem['Hora'];
            }

            $data1 = $nextItem['Data'] . " " . $nextItemHora;
            $data2 = $thisItem['Data'] . " " . $thisItemHora;

            // echo $data1 . " - " . $data2;

            $datetime1 = DateTime::createFromFormat("d/m/Y H:i:s", $data1);
            $datetime2 = DateTime::createFromFormat("d/m/Y H:i:s", $data2);

            // Calcula a diferença total em segundos
            $diferenca_segundos = $datetime1->getTimestamp() - $datetime2->getTimestamp();

            // Calcula dias, horas, minutos e segundos a partir da diferença em segundos
            $dias = floor($diferenca_segundos / (24 * 60 * 60));
            $horas = floor(($diferenca_segundos % (24 * 60 * 60)) / 3600);
            $minutos = floor(($diferenca_segundos % 3600) / 60);
            $segundos = $diferenca_segundos % 60;

            // Soma os resultados ao total
            $soma += $dias * 24 * 60 * 60 + $horas * 60 * 60 + $minutos * 60 + $segundos;
        }
    }

    // Converte a soma total para o formato H:i:s
    $soma_formatada = sprintf('%02d:%02d:%02d', floor($soma / (60 * 60)), floor(($soma % (60 * 60)) / 60), $soma % 60);

    return $soma_formatada;
}


function getMultiplicadorPedido($conn, $numPed)
{
    $pedData = getAllDataFromPed($conn, $numPed);

    $produtos = $pedData["pedProduto"];

    $produtos = explode("/", $produtos);
    

    $multiplicador = 0;

    if (strpos($pedData["pedProduto"], "PC-303-T3") !== false) {
        $multiplicador++;
    }
    
    
    foreach ($produtos as $key => $produto) {
        $categoria = getCategoriaProduto($conn, $produto);

        if (($categoria != "BIOMODELO") && ($categoria != "EXTRA")) {
            $multiplicador++;
        }
    }

    return $multiplicador;
}

function getCategoriaProduto($conn, $produto)
{
    $searchProd = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $produto . "';");
    $data = mysqli_fetch_array($searchProd);

    if(isset($data["prodCategoria"])){
        return $data["prodCategoria"];
    }
    
}

function getTipoProduto($conn, $produto)
{
    $searchProd = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $produto . "';");
    $data = mysqli_fetch_array($searchProd);
    return $data["pedTipoProduto"];
}

//Notif Email Qualificação Cliente
function enviarNotificacaoDeQualificacao($conn, $data, $idQualificacao)
{
    $thisYear = date("Y");

    $cnpj = cleanCNPJ($data["cnpj"]);

    // Campo E-mail
    $arquivo = '
        <html>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
        <style>
            .box {
                background-color: #373342;
                padding: 10px 10px;
                display: flex;
                justify-content: center;
            }
            .box-middle {
                background-color: #e9e9e9;
                padding: 5px 70px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            h2 {
                color: #fff;
                font-weight: 500px;
                font-family: "Montserrat", sans-serif;
                display: block;
            }
            .box h4 {
                color: #ee7624;
                font-weight: 400px;
                font-family: "Montserrat", sans-serif;
                display: block;
            }
            h3,h4 {
                font-family: "Montserrat", sans-serif;
            }
            li {
                font-family: "Montserrat", sans-serif;
            }
            ul {
                list-style-type: none;
                text-align: center;
            }
            p {
                font-weight: 300px;
                font-family: "Montserrat", sans-serif;
                text-align: justify;
                font-size: 11pt;
                line-height: 1.5rem;
            }
            .font-text {
                font-family: "Montserrat", sans-serif;
            }
            .d-block {
                display: flex;
                flex-direction: column;
            }
        </style>
        <body>
            <div class="logo">
            </div>
            <div class="box">
                <div>
                    <h2>Portal Conecta</h2>
                    <h4>- Qualificação de Cliente -</h4>
                </div>
            </div>
            <div class="d-block">
                <div class="box-middle">
                    <h3>Olá ' . $data["empresa"] . '!</h3>
                </div>
                <div class="box-middle">
                    <p>Prezado cliente, </p>
                    <p style="text-indent: 30px;">
                        A CPMH visa sempre manter altos parâmetros de eficácia e segurança em seus processos e em conformidade
                        segundo determinações da legislação sanitária. Para tanto, alguns procedimentos foram adotados por nossa
                        empresa a fim de assegurar nossa qualidade. Avaliamos nossos clientes, fornecedores e serviços
                        terceirizados para comprovar a regularidade de nossos parceiros.
                        Por este motivo, para a conclusão do cadastro e qualificação da ' . $data["empresa"] . '.
                    </p>
                    <h4>Por gentileza enviar:</h4>
                    <p style="text-indent: 0;">
                        - Formulário de qualificação de cliente que deve ser preenchido em nosso site ou pelo link:
                        <a href="https://www.jotform.com/210063892486662?razaoSocial=' . $data["empresa"] . '&nome2=' . $data["nomeUsuario"] . '&email120=' . $data["email"] . '&cnpj121=' . $cnpj . '&uf=' . $data["uf"] . '*&id=' . $idQualificacao . '">[clique aqui]</a> ;<br>
                        - AFE para Produtos Para a Saúde emitida pela ANVISA; <br>
                        - Licença Sanitária vigente (Alvará Sanitário) emitido pela Vigilância Sanitária local; <br>
                        - Licença de Funcionamento vigente (Alvará de Localização e Funcionamento) emitido pela prefeitura ou
                        administração (difere do documento emitido pela Vigilância Sanitária); <br>
                        - Certidão de Regularidade Técnica (CRT) vigente emitida pelo Conselho Regional do respectivo
                        responsável técnico; <br>
                        - Contrato Social; <br>
                        - Cartão CNPJ; <br>
                        - Inscrição Estadual;<br>
                    </p>
                    <p><b>
                            *Em caso de a documentação estar em processo de renovação, favor encaminhar o último documento
                            válido +
                            protocolo de renovação.
                        </b>
                        <br>
                        <br>
                        Atenciosamente,
                    </p>
                </div>
            </div>
            <div class="d-block">
            </div>
            <div class="box-middle" style="padding-bottom: : 40px;">
                <small class="font-text" style="color: gray;">&copy; Portal Conecta ' . $thisYear . '</small>
            </div>
            <div class="box-middle" style="padding-bottom: : 40px;"></div>
        </body>
        </html>
    ';

    $destino = $data["email"];
    $assunto = "Qualificação Cliente - Portal Conecta";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: notificacao@conecta.cpmhdigital.com.br';
    $headers .= 'Cc: qualidade@fixhealth.com.br';

    $enviaremail = mail($destino, $assunto, $arquivo, $headers);
    if ($enviaremail) {
        header("location: ../qualificacaocliente?error=enviado&empr=" . $data["empresa"]);
    }
}

function existeCNPJ($conn, $cnpj)
{
    // Sanitize o CNPJ para evitar SQL injection
    $cnpj = mysqli_real_escape_string($conn, $cnpj);

    // Consulta SQL para verificar se o CNPJ existe na tabela
    $query = "SELECT COUNT(*) as total FROM qualificacao WHERE cnpj = '$cnpj'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Obtém o resultado da contagem
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];

        // Se o total for maior que zero, o CNPJ existe na tabela
        return $total > 0;
    } else {
        // Tratamento de erro, se necessário
        echo "Erro na consulta: " . mysqli_error($conn);
        return false;
    }
}

function cleanCNPJ($cnpj)
{
    // Remove todos os caracteres não numéricos
    $numeros = preg_replace("/[^0-9]/", "", $cnpj);
    return $numeros;
}

function atualizarDataEnvioForm($conn, $data)
{
    $hoje = hoje();

    $sql = "UPDATE qualificacao SET dataenvioformqualificacao = ? WHERE cnpj = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../qualificacaocliente?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $hoje, $data["cnpj"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function adicionarEmpresaQualificação($conn, $data)
{
    $status = "ENVIADO";
    $hoje = hoje();

    $sql = "INSERT INTO qualificacao (cnpj, statusgeral, dataenvioformqualificacao) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../qualificacaocliente?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $data["cnpj"], $status, $hoje);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getStatusFromData($data)
{
    // Tenta converter a string da data para um objeto DateTime
    $dataReferencia = DateTime::createFromFormat('Y-m-d', $data);

    // Verifica se a data é válida
    if (!$dataReferencia || $dataReferencia->format('Y-m-d') !== $data) {
        return '<span class="btn badge-dark">-</span>';
    }

    // Obtém a data de hoje
    $hoje = new DateTime();

    // Calcula a diferença em dias entre a data de referência e hoje
    $diferencaDias = $hoje->diff($dataReferencia)->days;

    // Verifica as condições para determinar o status
    if ($dataReferencia < $hoje) {
        return '<span class="btn badge-danger">Vencido </span>';
    } elseif ($diferencaDias <= 30) {
        return '<span class="btn badge-warning">Vencendo</span>';
    } else {
        return '<span class="btn badge-success">Válido</span>';
    }
}


function cleanDate($data)
{
    if (!empty($data) && ($data != "0000-00-00")) {
        return dateFormat3($data);
    } else {
        return "___/___/___";
    }
}

function transformStatusGeralQualificacao($statusgeral)
{
    switch ($statusgeral) {
        case 'VALIDO':
            $badge = '<span class="btn rounded-pill bg-success text-white">VÁLIDO</span>';
            break;

        case 'VENCIDO':
            $badge = '<span class="btn rounded-pill bg-danger text-white">VENCIDO</span>';
            break;

        case 'ENVIADO':
            $badge = '<span class="btn rounded-pill bg-info text-white">ENVIADO</span>';
            break;

        default:
            $badge = '<span class="btn rounded-pill bg-dark text-white">-</span>';
            break;
    }

    return $badge;
}

function transformStatusGeralQualificacao2($statusgeral)
{
    switch ($statusgeral) {
        case 'VALIDO':
            $badge = '<span class="alert alert-success">VÁLIDO</span>';
            break;

        case 'VENCIDO':
            $badge = '<span class="alert alert-danger">VENCIDO</span>';
            break;

        case 'ENVIADO':
            $badge = '<span class="alert alert-info">ENVIADO</span>';
            break;

        default:
            $badge = '<span class="alert alert-dark">-</span>';
            break;
    }

    return $badge;
}

function getItemFromTable($conn, $item, $itemname, $table)
{
    // Sanitize o nome da coluna para evitar injeção de SQL
    $item = mysqli_real_escape_string($conn, $item);

    // Use um prepared statement para evitar injeção de SQL
    $query = "SELECT * FROM $table WHERE $itemname = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "Erro na preparação da declaração: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $item);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        echo "Erro na consulta: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_close($stmt);
}

function atualizarQualificacao($conn, $id, $cnpj, $situacao, $cartadistribuicao, $dataenvioformqualificacao, $licencafuncionamento, $licencasanitaria, $crt, $afe, $cbpfcbpad)
{
    $hashId = hashItemNatural($id);

    $sql = "UPDATE qualificacao SET cnpj = ?, situacao = ?, cartadistribuicao = ?, dataenvioformqualificacao = ?, licencafuncionamento = ?, licencasanitaria = ?, crt = ?, afe = ?, cbpfcbpad = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../editqualificacao?id=" . $hashId . "&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssss", $cnpj, $situacao, $cartadistribuicao, $dataenvioformqualificacao, $licencafuncionamento, $licencasanitaria, $crt, $afe, $cbpfcbpad, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


function addComentQualificacao($conn, $coment, $idref, $user)
{
    $hashId = hashItemNatural($idref);

    $sql = "INSERT INTO comentariosqualificacao (comentUser, comentRef, comentText, comentHorario, comentTipoUser) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../editqualificacao?id=" . $hashId . "&error=stmfailedsent");
        exit();
    }

    $usuario = getAllDataFromRep($conn, $user);
    $tipoUserRAW = $usuario["usersPerm"];
    $tipoUser = getPermissionNome($conn, $tipoUserRAW);

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $dataAtual = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

    mysqli_stmt_bind_param($stmt, "sssss", $user, $idref, $coment, $dataAtual, $tipoUser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteQualificacao($conn, $id){
    $sql = "DELETE FROM qualificacao WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../qualificacaocliente?error=stmtfaileddltcirurgia");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function qualificacaoRecebida($conn, $id, $data){

    $statusGeral = "RECEBIDO";

    $sql = "UPDATE qualificacao SET statusgeral = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../agradecimentoqualificacao?error==stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $statusGeral, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    //Notificar Slack Qualidade
    notificarQualificacaoClienteSlack($conn, $data["cnpj"], $id, $statusGeral, $data);

    // criarRegistroPreenchimentoQualificacao($conn, $user, $data['submission_id'], $data['nome2']);

}

function getLastItemFromTable($conn, $itemname, $table)
{
    // Sanitize o nome da coluna para evitar injeção de SQL
    $itemname = mysqli_real_escape_string($conn, $itemname);

    // Use um prepared statement para evitar injeção de SQL
    $query = "SELECT * FROM $table ORDER BY $itemname DESC LIMIT 1";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "Erro na preparação da declaração: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row["id"];
    } else {
        echo "Erro na consulta: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_close($stmt);
}

function getURLFromPedido($conn, $pedido)
{
    // Sanitize o nome da coluna para evitar injeção de SQL
    $pedido = mysqli_real_escape_string($conn, $pedido);

    // Use um prepared statement para evitar injeção de SQL
    $query = "SELECT * FROM visualizador WHERE visNumPed = '$pedido';";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "Erro na preparação da declaração: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row["visUrl3D"];
    } else {
        echo "Erro na consulta: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_close($stmt);
}


function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Check for IP from shared internet
        $userIP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check for IP passed from proxy
        $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Get the user's IP address
        $userIP = $_SERVER['REMOTE_ADDR'];
    }
    return $userIP;
}
