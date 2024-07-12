<?php

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';
    require_once 'functionsqualidade.inc.php';

    $nomecriador = addslashes($_POST['nomecriador']);
    $tp_contacriador = addslashes($_POST['tp_contacriador']);
    $nome = addslashes($_POST['nome']);
    $crm = addslashes($_POST['crm']);
    $tipocr = addslashes($_POST['tipocr']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $nomepaciente = addslashes($_POST['nomepaciente']);
    $sexo = addslashes($_POST['sexo']);
    $idade = addslashes($_POST['idade']);
    $diagnostico = addslashes($_POST['diagnostico']);
    $codigocid = addslashes($_POST['codigocid']);
    $cidade = addslashes($_POST['cidade']);
    $data = addslashes($_POST['data']);

    $radioImplante = addslashes($_POST["radioImplante"]);

    $id = addslashes($_POST["docid"]);

    switch ($radioImplante) {
        case "ATM":
            $textoProduto = "Placa de reconstrução maxilo facial sob medida";
            break;
        case "ATM Bilateral":
            $textoProduto = "Placa de reconstrução maxilo facial sob medida";
            break;
        case "Reconstrução Facial":
            $textoProduto = "Placa de reconstrução maxilo facial sob medida";
            break;
        case "Ortognática":
            $textoProduto = "Placa de fixação buco-maxilofacial sob medida";
            break;
        case "Cranioplastia":
            $textoProduto = null;
            break;
        case "Coluna":
            $textoProduto = "Placa reconstrução sob medida";
            break;
        case "Ortopedia":
            $textoProduto = "Placa reconstrução sob medida";
            break;
        case "CustomLIFE":
            $textoProduto = "Placa reconstrução sob medida";
            break;
        default:
            $textoProduto = null;
    }


    $statusQualidade = 'EM ANÁLISE';
    $statusEnvio = 'ENVIADO';

    $signature = $_POST['signature'];
    $signatureFileName = uniqid() . '.png';
    $signature = str_replace('data:image/png;base64,', '', $signature);
    $signature = str_replace(' ', '+', $signature);
    $data = base64_decode($signature);
    $file = 'signatures/' . $signatureFileName;
    file_put_contents($file, $data);

    sendAnexoIDr($conn, $id, $nomecriador, $tp_contacriador, $nome, $crm, $tipocr, $telefone, $email, $nomepaciente, $sexo, $idade, $diagnostico, $codigocid, $textoProduto, $radioImplante, $statusQualidade, $statusEnvio, $cidade, $data, $signatureFileName, $file);
} else {
    header("location: ../anexoidr");
    exit();
}
