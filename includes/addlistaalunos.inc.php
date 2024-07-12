<?php

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';

    $listaRAW = addslashes($_POST["lista"]);
    $listaArray = commadotToArray($listaRAW);

    foreach ($listaArray as &$value) {

        $valueArray = explode(",", $value);
        $nome = $valueArray[0];
        $email = $valueArray[1];
        $fone = $valueArray[2];

        if (!emailExiste($conn, $email)) {
            addContatoListaAlunos($conn, $nome, $email, $fone);
        }
    }

    header("location: ../certificados?error=listasalva");
    exit();
}

function commadotToArray($str)
{
    $arr = explode("\n", $str);
    return $arr;
}

function addContatoListaAlunos($conn, $nome, $email, $fone)
{
    //Criar item Aluno
    $sql = "INSERT INTO aluno (nome, tel, email) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../certificados?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $nome, $fone, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function emailExiste($conn, $email)
{
    $ret = mysqli_query($conn, "SELECT * FROM aluno WHERE email='$email'");

    if (($ret) && ($ret->num_rows != 0)) {
        return true;
    } else {
        return false;
    }
}
