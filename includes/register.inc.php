<?php


if (isset($_POST["submit"])) {

    $permission = addslashes($_POST["usuario"]);
    $name = addslashes($_POST["name"]);
    $username = strtolower(addslashes($_POST["username"]));
    $email = addslashes($_POST["email"]);
    $celular = addslashes($_POST["celular"]);
    $telefone = addslashes($_POST["tel"]);
    $uf = addslashes($_POST["uf"]);

    $terms = addslashes($_POST["termsCheck"]);

    if (empty($_POST["termsCheck"])) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=termserror");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=termserror");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=termserror");
        }
        exit();
    }

    if (empty($_POST['tipocr'])) {
        $tipocr = null;
    } else {
        $tipocr = addslashes($_POST["tipocr"]);
    }

    if (empty($_POST['ufcr'])) {
        $ufcr = null;
    } else {
        $ufcr = addslashes($_POST["ufcr"]);
    }

    if (empty($_POST['crm'])) {
        $numconselho = null;
    } else {
        $numconselho = addslashes($_POST["crm"]);
    }

    $crm = $tipocr . '-' . $ufcr . '-' . $numconselho;

    if (empty($_POST['especialidade'])) {
        $especialidade = null;
    } else {
        $especialidade = addslashes($_POST["especialidade"]);
    }

    if (empty($_POST['cnpj'])) {
        $cnpj = null;
    } else {
        $cnpj = addslashes($_POST["cnpj"]);
    }

    if (empty($_POST['cpf'])) {
        $cpf = null;
    } else {
        $cpf = addslashes($_POST["cpf"]);
    }

    if (empty($_POST['empresa'])) {
        $empresa = null;
    } else {
        $empresa = addslashes($_POST["empresa"]);
    }

    if (empty($_POST['emailempresa'])) {
        $emailempresa = null;
    } else {
        $emailempresa = addslashes($_POST["emailempresa"]);
    }

    if (empty($_POST['drResp'])) {
        $responsavel = null;
    } else {
        $responsavel = addslashes($_POST["drResp"]);
    }

    if (empty($_POST['ufdr'])) {
        $ufdr = null;
    } else {
        $ufdr = addslashes($_POST["ufdr"]);
    }

    if (empty($_POST['paiscidade'])) {
        $paiscidade = null;
    } else {
        $paiscidade = addslashes($_POST["paiscidade"]);
    }

    if (empty($_POST['outraespec'])) {
        $outraespec = null;
    } else {
        $outraespec = addslashes($_POST["outraespec"]);
    }

    if ($outraespec != null) {
        $especialidade = $outraespec;
    }

    $pwd = addslashes($_POST["password"]);
    $pwdrepeat = addslashes($_POST["confirmpassword"]);
    $aprovacao = "AGRDD";


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat, $telefone, $uf) !== false) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=emptyinput");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=emptyinput");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=emptyinput");
        }
        exit();
    }

    if (invalidUid($username) !== false) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=invaliduid");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=invaliduid");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=invaliduid");
        }
        exit();
    }

    if (invalidEmail($email) !== false) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=invalidemail");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=invalidemail");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=invalidemail");
        }
        exit();
    }

    if (pwdMatch($pwd, $pwdrepeat) !== false) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=passworddontmatch");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=passworddontmatch");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=passworddontmatch");
        }
        exit();
    }

    if (uidExists($conn, $username, $email) !== false) {
        if ($permission == 'doutor') {
            header("location: ../cadastro?tipo=Doutor(a)&error=usernametaken");
        } else if ($permission == 'paciente') {
            header("location: ../cadastro?tipo=Paciente&error=usernametaken");
        } else if ($permission == 'distribuidor') {
            header("location: ../cadastro?tipo=Distribuidor(a)&error=usernametaken");
        }

        exit();
    }

    createUser($conn, $name, $username, $email, $celular, $telefone, $uf, $crm, $especialidade, $cnpj, $cpf, $empresa, $emailempresa, $responsavel, $ufdr, $paiscidade, $pwd, $permission, $aprovacao);
} else {
    header("location: ../cadastro");
    exit();
}
