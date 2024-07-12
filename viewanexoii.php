<?php
session_start();
if (!empty($_GET)) {
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';

    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {

        $id = addslashes($_GET['id']);

        $ret = mysqli_query($conn, "SELECT * FROM qualianexoii WHERE xiiIdProjeto='" . $id . "';");
        while ($row = mysqli_fetch_array($ret)) {
            // $dataEHoraDoc  = explode(" ", $row['xiiDataCriacao']);
            // $dataDoc = $dataEHoraDoc[0];

            $nomedr = $row['xiiNomeDr'];
            $cpfdr = $row['xiiCPFDr'];
            $especialidade = $row['xiiEspecialidade'];
            $numconselho = $row['xiiNumConselho'];

            $telefone = $row['xiiTelefoneDr'];
            $cidadedr = $row['xiiCidadeDr'];
            $data = $row['xiiData'];
            $data = explode("-", $data);
            $dataDoc = $data[2] . '/' . $data[1] . '/' . $data[0];

            $nomepaciente = $row['xiiNomePac'];
            $datanascpaciente = $row['xiiDataNascPac'];
            $datanascpaciente = explode("-", $datanascpaciente);
            $datanascpaciente = $datanascpaciente[2] . '/' . $datanascpaciente[1] . '/' . $datanascpaciente[0];

            $cpfpaciente = $row['xiiCPFPac'];
            $procedimento = $row['xiiProcedimento'];
            $hospital = $row['xiiHospital'];
            $bairro = $row['xiiBairro'];
            $cidade = $row['xiiCidade'];
            $estado = $row['xiiEstado'];
            $codigocid = $row['xiiNumCID'];
            $patologia = $row['xiiNomePatologia'];
            $resumo = $row['xiiResumoCirurgia'];
            $descricao = $row['xiiDescricaoCaso'];
            $radioImplante = $row['xiiImplanteCirurgia'];
            $textProd = $row['xiiTextoProduto'];

            $status = $row['xiiStatusQualidade'];



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
                            <p style="text-align: end;"><?php echo $cidade . ' - ' . $dataDoc; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4 style="text-align: center; font-weight: bold;" class="py-3 px-4">ANEXO II – ANVISA LAUDO CIRÚRGICO </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">Dr(a)</td>
                                        <td class="p-2 text-start"><?php echo $nomedr; ?></td>
                                        <td class="p-2" style="font-weight: bold; text-align: end;">CPF:</td>
                                        <td class="p-2 text-start"><?php echo $cpfdr; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-start"><?php echo $especialidade; ?></td>
                                        <td class="p-2 text-start"><?php echo $numconselho; ?></td>
                                        <td></td>
                                        <td class="p-2 text-start"><?php echo $telefone; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">Paciente</td>
                                        <td class="p-2 " style="text-align: start;" colspan="3"><?php echo $nomepaciente; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">Data Nasc.:</td>
                                        <td class="p-2 text-start"><?php echo $datanascpaciente; ?></td>
                                        <td class="p-2" style="font-weight: bold; text-align: end;">CPF:</td>
                                        <td class="p-2 text-start"><?php echo $cpfpaciente; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">Hospital:</td>
                                        <td class="p-2 text-start"><?php echo $hospital; ?></td>
                                        <td class="p-2" style="font-weight: bold; text-align: end;">Bairro:</td>
                                        <td class="p-2 text-start"><?php echo $bairro . ' / ' . $cidade . ' - ' . $estado; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">CID:</td>
                                        <td class="p-2 text-start" colspan="3"><?php echo $codigocid . ' | ' . $patologia; ?></td>

                                    </tr>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">Procedimento:</td>
                                        <td class="p-2 " style="text-align: start;" colspan="3"><?php echo $procedimento; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="font-weight: bold; text-align: start;">Implante para cirurgia:</td>
                                        <td class="p-2 " style="text-align: start;" colspan="3"><?php echo $textProd; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row py-5">
                        <div class="col px-2">
                            <h6 class="px-2" style="font-weight: bold;">Tipo de Cirurgia Proposta</h6>
                            <p style="text-indent: 30px; text-align: justify; text-justify: inter-word; color: #000;"><?php echo $resumo; ?></p>

                            <h5 class="px-2 pb-3 pt-5" style="font-weight: bold;">A ANVISA</h5>
                            <h6 class="px-2" style="font-weight: bold;">Justificativa do ato cirúrgico e uso do implante sob medida</h6>
                            <p style="text-indent: 30px; text-align: justify; text-justify: inter-word; color: #000;"><?php echo $descricao; ?></p>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="container pt-2">
                                <div class="row p-4">
                                    <div class="col">
                                        <div class="d-flex justify-content-center">
                                            <img src="<?php echo $row['xiiPathArquivoAss']; ?>" alt="Assinatura <?php echo $row['xiiNomeArquivoAss']; ?>">
                                        </div>
                                        <hr style="border-top: 1px solid #000; width: 50vw;">
                                        <p style="color: #000; text-align: center;">Assinatura do(a) profissional de saúde</p>
                                        <p style="color: #000; text-align: center;"><?php echo $nomedr; ?></p>
                                        <p style="color: #000; text-align: center;"><?php echo $numconselho; ?></p>
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