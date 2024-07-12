<?php
session_start();
if (!empty($_GET)) {
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';

    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {

        $id = addslashes($_GET['id']);

        $ret = mysqli_query($conn, "SELECT * FROM qualianexoiiidr WHERE xiiidrIdProjeto='" . $id . "';");
        while ($row = mysqli_fetch_array($ret)) {
            // $dataEHoraDoc  = explode(" ", $row['xiiidrData']);
            // $dataDoc = $dataEHoraDoc[0];
            $dataDoc = explode("-", $row['xiiidrData']);
            $dia = $dataDoc[2];
            $mes = $dataDoc[1];
            $ano = $dataDoc[0];
            $data = $dia . '/' . $mes . '/' . $ano;

            $nomedr = $row['xiiidrNomeDr'];
            $crm = $row['xiiidrNumConselho'];
            $nomedr = $row['xiiidrNomeDr'];

            $status = $row['xiiidrStatusQualidade'];



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

                    table {
                        border: solid 1px #000 !important;

                    }

                    tr,
                    td {
                        border: solid 1px #000 !important;

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
                        <div class="col p-2">
                            <table style="width:100%; border: 1px solid #000;">
                                <tr style="border: 1px solid #000;">
                                    <td rowspan="2" style="width: 200px; border: 1px solid #000;"><img class="p-1" src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0906db058ec5ee8cc4bcd93d25503562.png" width="200px" alt="Logo CPMH"></td>
                                    <td rowspan="2" class="text-center" style="font-weight: bold; font-size: 20px; border: 1px solid #000;">Procedimento do Sistema da Gestão da Qualidade FORM QUA Nº 036</td>
                                    <td class="text-center" style="font-weight: bold; border: 1px solid #000;">Revisão: 00</td>
                                </tr>
                                <tr style="border: 1px solid #000;">
                                    <td class="text-center" style="font-weight: bold; border: 1px solid #000;">Pág. 1 de 1</td>
                                </tr>
                                <tr style="border: 1px solid #000;">
                                    <td colspan="3" class="text-center" style="font-weight: bold; font-size: 16px; border: 1px solid #000;">Anexo III - Dr(a) TERMO DE CONSENTIMENTO DE INFORMAÇÕES E IMAGENS</td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <div style="border: 1px solid #000;">
                        <div class="row">
                            <div class="col">
                                <div class="p-3">
                                    <h6 style="font-weight: bold; text-decoration: underline;">Termo de consentimento a ser autorizado pelo médico(a) e paciente:</h6>
                                    <p style="text-align: justify;">Por meio do presente termo, de livre e espontânea vontade, AUTORIZO a empresa
                                        fabricante CPMH do implante Sob Medida o uso de meus dados e qualquer outra informação
                                        que seja necessário para o processo junto a ANVISA, transitando os dados necessários e que
                                        os mesmos serão armazenados pela empresa e autorizo também o uso de minha imagem,
                                        livre de quaisquer ônus para a empresa fornecedora dos materiais cirúrgicos, CPMH –
                                        COMÉRCIO E INDÚSTRIA DE PRODUTOS MÉDICO–HOSPITALARES E ODONTOLÓGICOS LTDA,
                                        com o propósito de consulta profissional, pesquisas, literatura específica da área médica e
                                        mídias da empresa fabricante. Sendo de minha vontade, declaro a autorização do uso acima
                                        descrito sem nenhuma reclamação de direito.</p>
                                    <h6 style="font-weight: bold;">Termo aditivo <b style="text-decoration: underline;">exclusivo</b> para Produtos/Implantes Personalizados: </h6>
                                    <p style="text-align: justify;">Declaro ainda, ter
                                        ciência de que um técnico habilitado em saúde (enfermeiro/instrumentador) da equipe CPMH
                                        poderá acompanhar a cirurgia a fim de prestar instruções quanto ao uso do implante Sob
                                        Medida. Para tanto, a data da cirurgia deverá ser informada com antecedência à CPMH para
                                        agendamento do técnico.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col d-flex justify-content-center">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: bold;">Nome do Dr.:</td>
                                            <td class="px-2 pt-3"><?php echo $nomedr; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Assinatura do Dr(a).:</td>
                                            <td class="px-2 py-3"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Data</td>
                                            <td class="px-2 pt-3"><?php echo $data; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Nº Conselho</td>
                                            <td class="px-2 pt-3"><?php echo $crm; ?></td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="d-print-none d-flex justify-content-center py-5">
                    <button class="btn btn-primary m-2" onclick="window.print();return false;">Imprimir</button>

                    <?php
                    if ($status == 'EM ANÁLISE') {
                    ?>
                        <a href="aprovxiiidr?id=<?php echo $id; ?>&type=reprov">
                            <span class="btn btn-danger m-2" onClick="return confirm('Você está prestes a REPROVAR este documento. Confirma sua ação?');"><i class="fa fa-times-circle" aria-hidden="true"></i> Reprovar</span>
                        </a>

                        <a href="aprovxiiidr?id=<?php echo $id; ?>&type=aprov">
                            <span class="btn btn-success m-2" onClick="return confirm('Você está prestes a APROVAR este documento. Confirma sua ação?');"><i class="fa fa-check-circle" aria-hidden="true"></i> Aprovar</span>
                        </a>
                    <?php
                    } else {
                    ?>
                        <span class="btn btn-secondary m-2"><?php echo $status; ?></span>

                    <?php
                    }
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