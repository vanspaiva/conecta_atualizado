<?php

function sendAnexoIDr($conn, $id, $nomecriador, $tp_contacriador, $nome, $crm, $tipocr, $telefone, $email, $nomepaciente, $sexo, $idade, $diagnostico, $codigocid, $textoProduto, $radioImplante, $statusQualidade, $statusEnvio, $cidade, $data, $signatureFileName, $file)
{

    $sql = "UPDATE qualianexoidr SET xidrUserCriador='$nomecriador', xidrTipoContaCriador='$tp_contacriador', xidrStatusEnvio='$statusEnvio', xidrStatusQualidade='$statusQualidade', xidrNomeDr='$nome', xidrNumConselho='$crm', xidrTipoConselho='$tipocr', xidrTelefone='$telefone', xidrEmail='$email', xidrNomePaciente='$nomepaciente', xidrSexo='$sexo', xidrIdade='$idade', xidrDiagnostico='$diagnostico', xidrCodigoCID='$codigocid', xidrTextoProduto='$textoProduto', xidrProduto='$radioImplante', xidrCidade='$cidade', xidrData='$data', xidrNomeArquivoAss='$signatureFileName', xidrPathArquivoAss ='$file'   WHERE xidrIdProjeto='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../unit?id=" . $id);
    } else {
        header("location: ../unit?id=" . $id);
    }
    mysqli_close($conn);
}

function aprovxidr($conn, $id, $newStatus)
{

    $sql = "UPDATE qualianexoidr SET xidrStatusQualidade='$newStatus' WHERE xidrIdProjeto='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: ../viewanexoidr?id=" . $id);
    } else {
        header("location: ../viewanexoidr?id=" . $id);
    }
    mysqli_close($conn);
}

function sendAnexoIPac($conn, $id, $nomecriador, $tp_contacriador, $nomepac, $identidade, $orgaoid, $cpf, $residente, $bairro, $cidade, $estado, $telefone, $email, $statusQualidade, $statusEnvio)
{

    $sql = "UPDATE qualianexoipac SET xipacUserCriador='$nomecriador', xipacTipoContaCriador='$tp_contacriador', xipacStatusEnvio='$statusEnvio', xipacStatusQualidade='$statusQualidade', xipacNomePac='$nomepac', xipacIdentidade='$identidade', xipacOrgaoId='$orgaoid', xipacCPF='$cpf', xipacReside='$residente', xipacBairro='$bairro', xipacCidade='$cidade', xipacEstado='$estado', xipacTelefone='$telefone', xipacEmail='$email'  WHERE xipacIdProjeto='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../unit?id=" . $id);
    } else {
        header("location: ../unit?id=" . $id);
    }
    mysqli_close($conn);
}

function aprovxipac($conn, $id, $newStatus)
{

    $sql = "UPDATE qualianexoipac SET xipacStatusQualidade='$newStatus' WHERE xipacIdProjeto='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: ../viewanexoipac?id=" . $id);
    } else {
        header("location: ../viewanexoipac?id=" . $id);
    }
    mysqli_close($conn);
}

function sendAnexoIIIDr($conn, $id, $nomecriador, $tp_contacriador, $nomedr, $crm, $data, $statusQualidade, $statusEnvio)
{
    $sql = "UPDATE qualianexoiiidr SET xiiidrUserCriador='$nomecriador', xiiidrTipoContaCriador='$tp_contacriador', xiiidrStatusEnvio='$statusEnvio', xiiidrStatusQualidade='$statusQualidade', xiiidrNomeDr='$nomedr', xiiidrNumConselho='$crm', xiiidrData='$data' WHERE xiiidrIdProjeto='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../unit?id=" . $id);
    } else {
        header("location: ../unit?id=" . $id);
    }
    mysqli_close($conn);
}

function aprovxiiidr($conn, $id, $newStatus)
{
    $sql = "UPDATE qualianexoiiidr SET xiiidrStatusQualidade='$newStatus' WHERE xiiidrIdProjeto='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: ../viewanexoiiidr?id=" . $id);
    } else {
        header("location: ../viewanexoiiidr?id=" . $id);
    }
    mysqli_close($conn);
}

function sendAnexoIIIPac($conn, $id, $nomecriador, $tp_contacriador, $nomepac, $data, $statusQualidade, $statusEnvio)
{
    $sql = "UPDATE qualianexoiiipac SET xiiipacUserCriador='$nomecriador', xiiipacTipoContaCriador='$tp_contacriador', xiiipacStatusEnvio='$statusEnvio', xiiipacStatusQualidade='$statusQualidade', xiiipacNomePac='$nomepac', xiiipacData='$data' WHERE xiiipacIdProjeto='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../unit?id=" . $id);
    } else {
        header("location: ../unit?id=" . $id);
    }
    mysqli_close($conn);
}

function aprovxiiipac($conn, $id, $newStatus)
{
    $sql = "UPDATE qualianexoiiipac SET xiiipacStatusQualidade='$newStatus' WHERE xiiipacIdProjeto='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: ../viewanexoiiipac?id=" . $id);
    } else {
        header("location: ../viewanexoiiipac?id=" . $id);
    }
    mysqli_close($conn);
}

function sendAnexoII($conn, $id, $nomecriador, $tp_contacriador, $nomedr, $cpfdr, $especialidade, $numconselho, $telefone, $cidadedr, $data, $nomepaciente, $datanascpaciente, $cpfpaciente, $procedimento, $hospital, $bairro, $cidade, $estado, $codigocid, $patologia, $resumo, $descricao, $radioImplante, $textoProduto, $statusQualidade, $statusEnvio, $signatureFileName, $file){
    $sql = "UPDATE qualianexoii SET xiiUserCriador='$nomecriador', xiiTipoContaCriador='$tp_contacriador', xiiStatusEnvio='$statusEnvio', xiiStatusQualidade='$statusQualidade', xiiNomeDr='$nomedr', xiiCPFDr='$cpfdr', xiiEspecialidade='$especialidade', xiiNumConselho='$numconselho', xiiTelefoneDr='$telefone', xiiCidadeDr='$cidadedr', xiiData='$data', xiiNomePac='$nomepaciente', xiiDataNascPac='$datanascpaciente', xiiCPFPac='$cpfpaciente', xiiProcedimento='$procedimento', xiiHospital='$hospital', xiiBairro='$bairro', xiiCidade='$cidade', xiiEstado='$estado', xiiNumCID='$codigocid', xiiNomePatologia='$patologia', xiiResumoCirurgia='$resumo', xiiDescricaoCaso='$descricao', xiiImplanteCirurgia='$radioImplante', xiiTextoProduto='$textoProduto', xiiNomeArquivoAss='$signatureFileName', xiiPathArquivoAss ='$file' WHERE xiiIdProjeto='$id'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../unit?id=" . $id);
    } else {
        header("location: ../unit?id=" . $id);
    }
    mysqli_close($conn);
}

function aprovxii($conn, $id, $newStatus)
{
    $sql = "UPDATE qualianexoii SET xiiStatusQualidade='$newStatus' WHERE xiiIdProjeto='$id';";

    if (mysqli_query($conn, $sql)) {
        header("location: ../viewanexoii?id=" . $id);
    } else {
        header("location: ../viewanexoii?id=" . $id);
    }
    mysqli_close($conn);
}