<?php
session_start();
if (!empty($_GET)) {
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';

    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {

        $id = addslashes($_GET['id']);

        $ret = mysqli_query($conn, "SELECT * FROM qualianexoipac WHERE xipacIdProjeto='" . $id . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $dataEHoraDoc  = explode(" ", $row['xipacDataCriacao']);
            $dataDoc = $dataEHoraDoc[0];

            $nome = $row['xipacNomePac'];
            $identidade = $row['xipacIdentidade'];
            $orgao = $row['xipacOrgaoId'];
            $cpf = $row['xipacCPF'];
            $reside = $row['xipacReside'];
            $bairro = $row['xipacBairro'];
            $cidade = $row['xipacCidade'];
            $estado = $row['xipacEstado'];
            $telefone = $row['xipacTelefone'];
            $email = $row['xipacEmail'];

            $status = $row['xipacStatusQualidade'];



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
                                <h6 style="text-align: start; color: #366097; font-weight: bold;" class="py-3 mx-3">A ser preenchido pelo paciente ou responsável legal:</h6>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div style="border: 1px solid #000;" class="p-3">
                                <p style="color: #000; text-align: justify;">Eu, <?php echo $nome; ?>, (paciente / responsável legal pelo paciente acima citado), documento de identidade nº <?php echo $identidade; ?>,
                                    órgão expedidor <?php echo $orgao; ?>, CPF nº <?php echo $cpf; ?>, residente à <?php echo $reside; ?>, bairro <?php echo $bairro; ?>, cidade <?php echo $cidade; ?>,
                                    estado <?php echo $estado; ?>, telefone <?php echo $telefone; ?>, e-mail <?php echo $email ?>,
                                    recebi pessoalmente as informações do(a) prescritor(a) sobre o tratamento e declaro que entendi as orientações
                                    recebidas, incluindo as restrições e recomendações de uso, prestadas pelo profissional de saúde e estou de
                                    acordo com a proposta de utilização excepcional de dispositivo médico sob medida do tratamento indicado.
                                </p>
                                <div class="container pt-2">
                                    <div class="row p-4">
                                        <div class="col">
                                            <hr style="border-top: 1px solid #000; width: 50vw;">
                                            <p style="color: #000; text-align: center;">Assinatura do paciente ou do responsável legal</p>
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
                        <a href="aprovxipac?id=<?php echo $id; ?>&type=reprov">
                            <span class="btn btn-danger m-2" onClick="return confirm('Você está prestes a REPROVAR este documento. Confirma sua ação?');"><i class="fa fa-times-circle" aria-hidden="true"></i> Reprovar</span>
                        </a>

                        <a href="aprovxipac?id=<?php echo $id; ?>&type=aprov">
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