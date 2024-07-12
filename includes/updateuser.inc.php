<?php
if (isset($_POST["update"])) {

    $usersid = addslashes($_POST["usersid"]);
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $telefone = addslashes($_POST["telefone"]);
    $aprov = addslashes($_POST["aprov"]);
    $perm = addslashes($_POST["perm"]);

    if (empty($_POST['emailempresa'])) {
        $emailempresa = ' ';
    } else { 
        $emailempresa = addslashes($_POST["emailempresa"]);
    }

    if (empty($_POST['cnpj'])) {
        $cnpj = ' ';
    } else { 
        $cnpj = addslashes($_POST["cnpj"]);
    }

    if (empty($_POST['empresa'])) {
        $empresa = ' ';
    } else { 
        $empresa = addslashes($_POST["empresa"]);
    }

    if (empty($_POST['crm'])) {
        $crm = ' ';
    } else { 
        $crm = addslashes($_POST["crm"]);
    }

    if (empty($_POST['cpf'])) {
        $cpf = ' ';
    } else { 
        $cpf = addslashes($_POST["cpf"]);
    }

    if (empty($_POST['especialidade'])) {
        $especialidade = ' ';
    } else { 
        $especialidade = addslashes($_POST["especialidade"]);
    }
        
    if (empty($_POST["nmdrresp"])) {
        $nmdrresp = ' ';
    } else { 
        $nmdrresp = addslashes($_POST["nmdrresp"]);
    }

    if (empty($_POST['ufdr'])) {
        $ufdr = ' ';
    } else { 
        $ufdr = addslashes($_POST["ufdr"]);
    }

    if (empty($_POST['paiscidade'])) {
        $paiscidade = ' ';
    } else { 
        $paiscidade = addslashes($_POST["paiscidade"]);
    }
    
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editUser($conn, $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $emailempresa, $cnpj, $empresa, $crm, $cpf, $especialidade, $nmdrresp, $ufdr, $paiscidade, $usersid);
} else if (isset($_POST["updatecomercial"])) {

    $usersid = addslashes($_POST["usersid"]);
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $telefone = addslashes($_POST["telefone"]);
    $aprov = addslashes($_POST["aprov"]);
    $perm = '9DTC';

    if (empty($_POST['emailempresa'])) {
        $emailempresa = ' ';
    } else { 
        $emailempresa = addslashes($_POST["emailempresa"]);
    }

    if (empty($_POST['cnpj'])) {
        $cnpj = ' ';
    } else { 
        $cnpj = addslashes($_POST["cnpj"]);
    }

    if (empty($_POST['empresa'])) {
        $empresa = ' ';
    } else { 
        $empresa = addslashes($_POST["empresa"]);
    }

    if (empty($_POST['crm'])) {
        $crm = ' ';
    } else { 
        $crm = addslashes($_POST["crm"]);
    }

    if (empty($_POST['cpf'])) {
        $cpf = ' ';
    } else { 
        $cpf = addslashes($_POST["cpf"]);
    }

    if (empty($_POST['especialidade'])) {
        $especialidade = ' ';
    } else { 
        $especialidade = addslashes($_POST["especialidade"]);
    }
        
    if (empty($_POST["nmdrresp"])) {
        $nmdrresp = ' ';
    } else { 
        $nmdrresp = addslashes($_POST["nmdrresp"]);
    }

    if (empty($_POST['ufdr'])) {
        $ufdr = ' ';
    } else { 
        $ufdr = addslashes($_POST["ufdr"]);
    }

    if (empty($_POST['paiscidade'])) {
        $paiscidade = ' ';
    } else { 
        $paiscidade = addslashes($_POST["paiscidade"]);
    }
    
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editUserComercial($conn, $nome, $uf, $email, $uid, $celular, $telefone, $aprov, $perm, $emailempresa, $cnpj, $empresa, $crm, $cpf, $especialidade, $nmdrresp, $ufdr, $paiscidade, $usersid);
} else {
    header("location: ../produtos");
    exit();
}
