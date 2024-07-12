<?php

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';
    require_once 'functionsqualidade.inc.php';

    $nomecriador = addslashes($_POST['nomecriador']);
    $tp_contacriador = addslashes($_POST['tp_contacriador']);
    $dtcriacao = addslashes($_POST['dtcriacao']);
    $id = addslashes($_POST["docid"]);    

    $nomedr = addslashes($_POST['nomedr']);
    $cpfdr = addslashes($_POST['cpfdr']);
    $especialidade = addslashes($_POST['especialidade']);

    $tipocr = addslashes($_POST['tipocr']);
    $ufcr = addslashes($_POST['ufcr']);
    $nconselho = addslashes($_POST['nconselho']);
    $numconselho = $tipocr.'-'.$ufcr.'-'.$nconselho;

    $telefone = addslashes($_POST['telefone']);
    $cidadedr = addslashes($_POST['cidadedr']);
    $data = addslashes($_POST['data']);
    $nomepaciente = addslashes($_POST['nomepaciente']);
    $datanascpaciente = addslashes($_POST['datanascpaciente']);
    $cpfpaciente = addslashes($_POST['cpfpaciente']);
    $procedimento = addslashes($_POST['procedimento']);
    $hospital = addslashes($_POST['hospital']);
    $bairro = addslashes($_POST['bairro']);
    $cidade = addslashes($_POST['cidade']);
    $estado = addslashes($_POST['estado']);
    $codigocid = addslashes($_POST['codigocid']);
    $patologia = addslashes($_POST['patologia']);
    $resumo = addslashes($_POST['resumo']);
    $descricao = addslashes($_POST['descricao']);
    $radioImplante = addslashes($_POST['radioImplante']);
    
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

    sendAnexoII($conn, $id, $nomecriador, $tp_contacriador, $nomedr, $cpfdr, $especialidade, $numconselho, $telefone, $cidadedr, $data, $nomepaciente, $datanascpaciente, $cpfpaciente, $procedimento, $hospital, $bairro, $cidade, $estado, $codigocid, $patologia, $resumo, $descricao, $radioImplante, $textoProduto,$statusQualidade, $statusEnvio, $signatureFileName, $file);   


} else {
    header("location: ../anexoidr");
    exit();
}