<?php

if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    

    $nomecriador = addslashes($_POST["nomecriador"]);
    $emailcriacao = addslashes($_POST["emailcriacao"]);
    $dtcriacao = addslashes($_POST["dtcriacao"]);
    $statuscaso = addslashes($_POST["statuscaso"]);
    $idprop = addslashes($_POST["idprop"]);

    $nomedr = addslashes($_POST["nomedr"]);

    $emaildr = addslashes($_POST["emaildr"]);
    $teldr = addslashes($_POST["teldr"]);
    $nomepaciente = addslashes($_POST["nomepaciente"]);
    $convenio = addslashes($_POST["convenio"]);

    if (empty($_POST['outroconvenio'])) {
        $convenio = $convenio;
    } else {
        $convenio = addslashes($_POST["outroconvenio"]);
    }

    $convenio = strtoupper($convenio);

    $ret = mysqli_query($conn, "SELECT * FROM convenios WHERE convName='$convenio'");
    $num_rows = mysqli_num_rows($ret);

    if ($num_rows == null) {
        $sql = "INSERT INTO convenios (convName) VALUES (?)";
        $stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../solicitacao?error=stmtfailed3");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $convenio);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $cnpjcpf = addslashes($_POST["cnpjcpf"]);

    // $emailempresa = $_POST["emailempresa"];

    if (empty($_POST['emailempresa'])) {
        $emailEnvio = $emaildr;
    } else {
        $emailEnvio = addslashes($_POST["emailempresa"]);
    }

    if (empty($_POST['userdr'])) {
        $userdr = null;
    } else {
        $userdr = addslashes($_POST["userdr"]);
    }

    if (empty($_POST['empresa'])) {
        $empresa = null;
    } else {
        $empresa = addslashes($_POST['empresa']);
    }

    if (empty($_POST['crm'])) {
        $crm = " ";
    } else {
        $crm = addslashes($_POST["crm"]);
    }

    $itensJson = addslashes($_POST["longListaItens"]);
    $listaItens = addslashes($_POST["listaItens"]);
    $listaQtdItens = addslashes($_POST['listaQtdItens']);

    if (empty($_POST['espessuraSmartmold'])) {
        $espessurasmartmold = null;
    } else {
        $espessurasmartmold = addslashes($_POST["espessuraSmartmold"]);
    }

    $propStatusTC = "ANALISAR";
    $tipoGeral = addslashes($_POST["tipoProd"]);
    $radio = addslashes($_POST['radioTaxa']);

    switch ($radio) {
        case 'sim':
            $radioTaxa = 'sim';
            break;

        case 'não':
            $radioTaxa = 'não';
            break;

        default:
            $radioTaxa = 'erro';
            break;
            break;
    }


    // $fileName = $_FILES['file']['name'];

    // $fileTmpName = $_FILES['file']['tmp_name'];
    // $path = "files/".$fileName;


    // $keyInputNumber = $_POST['keyInputNumber'];
    // $WebLink = addslashes($_POST['weblinkInput']);


    // if (empty($_FILES["tcfile"]["name"])) {
    //     $pname = null;
    //     $tname = null;        
    // } else {
    //     #file name with a random number so that similar dont get replaced
    //     $original_name = $_FILES["tcfile"]["name"];
    //     $pname = rand(1000, 10000) . "-" . $_FILES["tcfile"]["name"];

    //     #temporary file name to store file
    //     $tname = $_FILES["tcfile"]["tmp_name"];
    // } 


    $isstored1 = addslashes($_POST["isstored1"]);
    $filename1 = addslashes($_POST["filename1"]);
    $filesize1 = addslashes($_POST["filesize1"]);
    $fileuuid1 = addslashes($_POST["fileuuid1"]);
    $cdnurl1 = addslashes($_POST["cdnurl1"]);
    if (empty($_POST['filename1'])) {
        $envioTC = "false";
    } else {
        $envioTC = "true";
    }

    $isstored2 = addslashes($_POST["isstored2"]);
    $filename2 = addslashes($_POST["filename2"]);
    $filesize2 = addslashes($_POST["filesize2"]);
    $fileuuid2 = addslashes($_POST["fileuuid2"]);
    $cdnurl2 = addslashes($_POST["cdnurl2"]);
    if (empty($_POST['filename2'])) {
        $envioRelatorio = "false";
    } else {
        $envioRelatorio = "true";
    }


    $isstored3 = addslashes($_POST["isstored3"]);
    $filename3 = addslashes($_POST["filename3"]);
    $filesize3 = addslashes($_POST["filesize3"]);
    $fileuuid3 = addslashes($_POST["fileuuid3"]);
    $cdnurl3 = addslashes($_POST["cdnurl3"]);


    $isstored4 = addslashes($_POST["isstored4"]);
    $filename4 = addslashes($_POST["filename4"]);
    $filesize4 = addslashes($_POST["filesize4"]);
    $fileuuid4 = addslashes($_POST["fileuuid4"]);
    $cdnurl4 = addslashes($_POST["cdnurl4"]);

    $datalaudo = addslashes($_POST["datalaudo"]);

    if (empty($_POST['nomeenvio'])) {
        $nomeenvio = null;
    } else {
        $nomeenvio = addslashes($_POST["nomeenvio"]);
    }

    if (empty($_POST['telenvio'])) {
        $telenvio = null;
    } else {
        $telenvio = addslashes($_POST["telenvio"]);
    }

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $thisHour = $dt->format("H:i:s");

    $thisData = $dt->format("Y-m-d");


    if (empty($_POST['comentarioproduto'])) {
        $comentarioproduto = " ";
    } else {
        $comentarioproduto = addslashes($_POST["comentarioproduto"]);
    }

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // echo "Envio TC: ";
    // print_r($envioTC);
    // echo "<br>";
    // echo "Envio Relatorio: ";
    // print_r($envioRelatorio);
    // echo "</pre>";

    // exit();

    createProposta($conn, $idprop, $nomecriador, $emailcriacao, $dtcriacao, $statuscaso, $propStatusTC, $empresa, $nomedr, $crm, $emaildr, $teldr, $nomepaciente, $convenio, $emailEnvio, $tipoGeral, $itensJson, $listaItens, $listaQtdItens, $espessurasmartmold, $radioTaxa, $userdr, $cnpjcpf, $isstored1, $filename1, $filesize1, $fileuuid1, $cdnurl1, $isstored2, $filename2, $filesize2, $fileuuid2, $cdnurl2, $isstored3, $filename3, $filesize3, $fileuuid3, $cdnurl3, $isstored4, $filename4, $filesize4, $fileuuid4, $cdnurl4, $datalaudo, $nomeenvio, $telenvio, $thisHour, $thisData, $comentarioproduto, $envioTC, $envioRelatorio);

    // createProposta($conn, $idprop, $nomecriador, $emailcriacao, $dtcriacao, $statuscaso, $propStatusTC, $empresa, $nomedr, $crm, $emaildr, $teldr, $nomepaciente, $convenio, $emailEnvio, $tipoGeral, $itensJson, $listaItens, $listaQtdItens, $espessurasmartmold, $radioTaxa, $userdr, $cnpjcpf, $tname, $pname);
    // createProposta($conn, $idprop, $nomecriador, $emailcriacao, $dtcriacao, $statuscaso, $propStatusTC, $empresa, $nomedr, $crm, $emaildr, $teldr, $nomepaciente, $convenio, $emailEnvio, $tipoGeral, $listaItens, $fileName, $fileTmpName, $path);    


} else {
    header("location: ../solicitacao");
    exit();
}
