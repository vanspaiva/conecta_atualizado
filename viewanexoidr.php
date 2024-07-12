<?php
session_start();
if (!empty($_GET)) {
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';

    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {

        $id = addslashes($_GET['id']);

        $ret = mysqli_query($conn, "SELECT * FROM qualianexoidr WHERE xidrIdProjeto='" . $id . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $dataEHoraDoc  = explode(" ", $row['xidrDataUpdate']);
            $dataDoc = $dataEHoraDoc[0];
            $dataDoc = explode("-", $dataDoc);
            $dataDoc = $dataDoc[2] . "/" . $dataDoc[1] . "/" . $dataDoc[0];

            $nomedr = $row['xidrNomeDr'];
            $tipoconselho = $row['xidrTipoConselho'];
            $crm = $row['xidrNumConselho'];
            $telefone = $row['xidrTelefone'];
            $email = $row['xidrEmail'];
            $nomepac = $row['xidrNomePaciente'];
            $sexo = $row['xidrSexo'];
            $idade = $row['xidrIdade'];
            $diagnostico = $row['xidrDiagnostico'];
            $cid = $row['xidrCodigoCID'];
            $textProd = $row['xidrTextoProduto'];
            $cidade = $row['xidrCidade'];

            $status = $row['xidrStatusQualidade'];



?>

            <style media="print">
                @page {
                    size: auto;
                    margin: 0;
                }
            </style>
            <style>
                #printOnly {
                    display: none;
                }

                @media print {
                    #printOnly {
                        display: block;
                    }
                }
            </style>

            <body class="bg-white" style="overflow-x: hidden;">

                <div class="faixaRoxa d-print-none py-2">
                    <div class="conatiner">
                        <div class="row d-flex">
                            <div class="col d-flex justify-content-center">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h6 style="text-align: center; color: #366097; font-weight: bold;" class="py-3 px-4">Agência Nacional de Vigilância Sanitária - ANVISA</h6>
                            <h6 style="text-align: center; color: #366097; font-weight: bold;" class="pb-3 px-5">TERMO DE RESPONSABILIDADE E ESCLARECIMENTO PARA A UTILIZAÇÃO EXCEPCIONAL
                                DO DISPOSITIVO MÉDICO SOB MEDIDA DE FABRICAÇÃO NACIONAL</h5>
                                <h6 style="text-align: start; color: #366097; font-weight: bold;" class="py-3 mx-3">A ser preenchido pelo profissional de saúde:</h6>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div style="border: 1px solid #000;" class="p-3">
                                <p style="color: #000; text-align: justify;">Eu, <?php echo $nomedr; ?>, registrado no conselho profissional <?php echo $tipoconselho; ?>, sob o número <?php echo $crm; ?>, telefone <?php echo $telefone; ?>, e-mail <?php echo $email; ?>, sou o responsável pelo tratamento e acompanhamento do(a) paciente <?php echo $nomepac; ?> do sexo <?php echo $sexo; ?>,
                                    com idade de <?php echo $idade; ?> anos completos, com diagnóstico de <?php echo $diagnostico; ?>, CID <?php echo $cid; ?>, para quem estou indicando o dispositivo médico sob medida <?php echo $textProd; ?>, fabricado pela empresa CPMH - Comércio e Indústria de Produtos Médicos Hospitalares e Odontológicos Ltda (CNPJ 13.532.259/0001-25), por entender que esta é uma melhor opção terapêutica em relação ao uso de produtos regularizados na Anvisa. </p>
                                <p style="color: #000; text-align: justify;">Declaro de informei ao paciente/responsável legal que este produto <span style="text-decoration: underline;">não possui registro no Brasil,</span> portanto não possui a sua segurança e eficácia avaliada pela Anvisa, podendo causar reações adversas inesperadas ao paciente.</p>
                                <p style="color: #000; text-align: justify;">Local e data: <?php echo " " . $cidade . " - " . $dataDoc; ?></p>
                                <div class="container pt-2">
                                    <div class="row p-4">
                                        <div class="col">
                                            <div class="d-flex justify-content-center">
                                                <img src="arquivos/<?php echo $row['xidrPathArquivoAss']; ?>" alt="Assinatura <?php echo $row['xidrNomeArquivoAss']; ?>">
                                            </div>
                                            <hr style="border-top: 1px solid #000; width: 50vw;">
                                            <p style="color: #000; text-align: center;">Assinatura do(a) profissional de saúde</p>
                                            <p style="color: #000; text-align: center;">Número de Inscrição no Conselho Profissional</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="d-print-none d-flex justify-content-center">
                    <button class="btn btn-primary m-2" onclick="window.print();return false;">Imprimir</button>

                    <?php
                    if ($status == 'EM ANÁLISE') {
                    ?>
                        <a href="aprovxidr?id=<?php echo $id; ?>&type=reprov">
                            <span class="btn btn-danger m-2" onClick="return confirm('Você está prestes a REPROVAR este documento. Confirma sua ação?');"><i class="fa fa-times-circle" aria-hidden="true"></i> Reprovar</span>
                        </a>

                        <a href="aprovxidr?id=<?php echo $id; ?>&type=aprov">
                            <span class="btn btn-success m-2" onClick="return confirm('Você está prestes a APROVAR este documento. Confirma sua ação?');"><i class="fa fa-check-circle" aria-hidden="true"></i> Aprovar</span>
                        </a>
                    <?php } else {
                    ?>
                        <span class="btn btn-secondary m-2"><?php echo $status; ?></span>

                    <?php }

                    ?>
                </div>
    <?php

        }
        include_once 'php/footer_index.php';
    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}
    ?>