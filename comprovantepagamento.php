<?php

session_start();
if (!empty($_GET)) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Comercial')) || ($_SESSION["userperm"] == 'Administrador')) {
        include("php/head_prop.php");
        require_once 'includes/dbh.inc.php';

        $id = addslashes($_GET['id']);
        $temKit = '';
        $temTxtAcompanha  = '';
        $txtImposto = '';
        $imposto = null;

        $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $id . "';");
        while ($row = mysqli_fetch_array($ret)) {

            $numProp = $row['apropNumProp'];

            $nomeusuario = $row['apropNomeUsuario'];
            $dataenvioBD = $row['apropData'];
            $ipmaquina = $row['apropIp'];
            $cpfcnpj = $row['apropCPFCNPJ'];
            $formapagto = $row['apropFormaPgto'];
            $status = $row['apropStatus'];



            // $dataenvioBD = explode(" ", $dataenvioBD);
            // $dataBD = $dataenvioBD[0];
            // $horaBD = $dataenvioBD[1];

            // $dataBD = explode("/", $dataBD);
            // $dataenvio = $dataBD[2] . '-' . $dataBD[1] . '-' . $dataBD[0];

            $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $nomeusuario . "';");
            while ($rowUser = mysqli_fetch_array($retUser)) {
                $nomeCompleto = $rowUser['usersName'];
            }

            $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $numProp . "';");
            while ($rowProp = mysqli_fetch_array($retProp)) {
                $valorprop = $rowProp['propValorPosDesconto'];
            }

            $valorprop = floatval($valorprop);
            $valorprop = number_format($valorprop, 2, ',', '.');
            $valorprop = 'R$ ' . $valorprop;


            $ext = $row['apropExtensionFile'];
            // if (($ext == 'png') || ($ext == 'jpg') || ($ext == 'jpeg')) {
            //     $retImg = mysqli_query($conn, "SELECT * FROM filefinanceiro WHERE filefinPropId='" . $numProp . "';");
            //     while ($rowImg = mysqli_fetch_array($retImg)) {
            //         $fileName = $rowImg['filefinRealName'];
            //         $filePath = $rowImg['filefinPath'];
            //     }

            //     $caminhoProp = $filePath . '/' . $fileName;
            //     $caminhoProp = substr($caminhoProp, 3);
            // } else {
            //     $caminhoProp = $filePath . '/' . $fileName;
            //     $caminhoProp = substr($caminhoProp, 3);

            // }

            if (($ext == 'png') || ($ext == 'jpg') || ($ext == 'jpeg')) {
                $openIframe = false;
            } else {
                $openIframe = true;
            }

            $retImg = mysqli_query($conn, "SELECT * FROM filefinanceiro WHERE filefinPropId='" . $numProp . "';");
            while ($rowImg = mysqli_fetch_array($retImg)) {
                $fileName = $rowImg['filefinRealName'];
                $filePath = $rowImg['filefinPath'];
            }

            $caminhoProp = $filePath . '/' . $fileName;
            $caminhoProp = substr($caminhoProp, 3);
        }

        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $_GET['id'] . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $dataEHoraProp = explode(" ", $row['propDataCriacao']);
            $dataProp = $dataEHoraProp[0];

            $total = $row['propValorSomaTotal'];
            $porcDesconto = $row['propDesconto'];
            $valorDesconto = $row['propoValorDesconto'];

            $email = $row['propEmailEnvio'];
            $empresa = $row['propEmpresa'];

            $txtReprovada = $row['propTxtReprov'];
            $planovenda = $row['propPlanoVenda'];

            $rep = $row['propRepresentante'];
            $status = $row['propStatus'];

            $cnpjcpf = $row['propCnpjCpf'];

            if (strlen($cnpjcpf) === 18) {
                $temcnpj = true;
                $temcpf = false;
            } else {
                $temcnpj = false;
                $temcpf = true;
            }


            $retRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $rep . "';");
            while ($rowRep = mysqli_fetch_array($retRep)) {
                $representante = $rowRep['usersName'];
                $representante = explode(" ", $representante);
                $representante = $representante[0];
                $representanteFone = $rowRep['usersCel'];
            }

            $valorprop = $row['propValorPosDesconto'];
            $planovenda = $row['propPlanoVenda'];

            $needle = '20%';
            if (strpos($planovenda, $needle) !== false) {
                $porcentagem = 0.2;
                $typeEntrada = '20%';
            } else {
                $needle = '30%';
                if (strpos($planovenda, $needle) !== false) {
                    $porcentagem = 0.3;
                    $typeEntrada = '30%';
                } else {
                    $needle = '50%';
                    if (strpos($planovenda, $needle) !== false) {
                        $porcentagem = 0.5;
                        $typeEntrada = '50%';
                    } else {
                        $porcentagem = 1;
                        $typeEntrada = "100%";
                    }
                }
            }

            $valorprop = floatval($valorprop);

            $valorapagar = $porcentagem * $valorprop;
            $valorapagar = number_format($valorapagar, 2, ',', '.');
            $valorapagar = 'R$ ' . $valorapagar;

            $valorprop = number_format($valorprop, 2, ',', '.');
            $valorprop = 'R$ ' . $valorprop;

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

            <body class="bg-white">

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
                <?php
                if ($status == "APROVADO") {
                    $retAceiteProp = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $id . "';");
                    while ($rowAceiteProp = mysqli_fetch_array($retAceiteProp)) {
                ?>
                        <div class='my-2 pb-0 alert alert-success pt-3 text-center'>
                            <p>Essa proposta foi aprovada pelo usuário <?php echo $rowAceiteProp['apropNomeUsuario']; ?> no IP <?php echo $rowAceiteProp['apropIp']; ?> às <?php echo $rowAceiteProp['apropData']; ?></p>
                        </div>
                <?php
                    }
                }
                ?>

                <?php
                if ($status == "PROP. ENVIADA") {
                ?>
                    <div class='d-print-none my-2 pb-0 alert alert-success pt-3 text-center'>
                        <p>Essa proposta foi enviada para aprovação do cliente. Aguarde retorno.</p>
                    </div>
                <?php
                }
                ?>

                <div class="container">
                    <div class="row">
                        <div class="col p-3 d-flex">
                            <div class="col-4 d-flex justify-content-start align-items-center">
                                <!-- <h3>Proposta Comercial</h3> -->
                                <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0906db058ec5ee8cc4bcd93d25503562.png" alt="CPMH Digital" style="width: 20vw;">
                            </div>
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <h6>Proposta Nº <?php echo $row['propId'] ?></h6>
                            </div>
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <h6><?php echo $dataProp ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col p-3 d-flex">
                            <div class="col-8 d-flex justify-content-start px-2">


                                <h6><b>negocios@cpmh.com.br</b></h6>
                            </div>
                            <div class="col-4 d-flex justify-content-end">
                                <h6><b>Validade:</b> 30 dias</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col p-3 d-flex">
                            <div class="col-3 d-flex justify-content-start">
                                <span><b>E-mail: </b><?php echo " " . $email ?></span>

                            </div>
                            <div class="col-3 d-flex justify-content-start">
                                <?php
                                if ($temcnpj) {
                                ?>
                                    <span><b>CNPJ</b><?php echo " " . $cnpjcpf ?></span>
                                <?php
                                }
                                ?>
                                <?php
                                if ($temcpf) {
                                ?>
                                    <span><b>CPF</b><?php echo " " . $cnpjcpf ?></span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-3 d-flex justify-content-start">
                                <?php
                                if ($empresa != null) {
                                ?>
                                    <span><b>Empresa</b><?php echo " " . $empresa ?></span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-3 d-flex justify-content-end">
                                <span><b>Repres.</b><?php echo " " . $representante . " " . $representanteFone; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col p-3 d-flex">
                            <div class="col-3 d-flex justify-content-start">
                                <span><b>Nome Dr(a)</b><?php echo " " . $row['propNomeDr'] ?></span>
                            </div>
                            <div class="col-3 d-flex justify-content-start">
                                <span><b>Nome Paciente</b><?php echo " " . $row['propNomePac'] ?></span>

                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <span><b>Convênio</b><?php if ($row['propConvenio'] != '') echo " " . $row['propConvenio']; ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>

                <div class="container">
                    <div class="row d-flex align-items-end">
                        <div class="col">
                            <h3>Comprovante de Pagamento</h3>
                            <h5>Plano de Venda</h5>
                            <p style="line-height: 1.2rem;"><?php echo $planovenda; ?></p>
                        </div>
                        <div class="col">
                            <h5 class="text-black">Valor A Pagar: </h5>
                            <p style="line-height: 1.2rem;"><?php echo "(" . $typeEntrada . ") " . $valorapagar; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-black">Nome Usuário: </h5>
                            <p><?php echo $nomeCompleto; ?></p>
                        </div>
                        <div class="col">
                            <h5 class="text-black">Data Envio: </h5>
                            <p><?php echo $dataenvioBD; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-black">IP: </h5>
                            <p><?php echo $ipmaquina; ?></p>
                        </div>
                        <div class="col">
                            <h5 class="text-black">CPF/CNPJ: </h5>
                            <p><?php echo $cpfcnpj; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-black">Forma Pagto: </h5>
                            <p><?php echo $formapagto; ?></p>
                        </div>
                        <div class="col">
                            <h5 class="text-black">Valor Proposta: </h5>
                            <p><?php echo $valorprop; ?></p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center py-4">
                        <?php if ($openIframe) { ?>
                            <iframe src="<?php echo $caminhoProp; ?>" width="100%" height="600" style="border: none;"></iframe>
                        <?php } else { ?>
                            <img src="<?php echo $caminhoProp; ?>" style="max-height: 50vh;" alt="Comprovante Proposta <?php echo $id; ?>">
                        <?php } ?>
                    </div>

                </div>


                <div class="d-print-none d-flex justify-content-center">
                    <button class="btn btn-primary m-2" onclick="window.print();return false;">Imprimir</button>

                    <!-- <a href="/sendNotification.php?id=<?php echo $row['propId']; ?>">
                    <span class="btn btn-primary m-2" onClick="return confirm('Você está ciente de que essa proposta será enviada para o email <?php echo $email ?>?');"><i class="far fa-paper-plane"></i> Enviar Proposta</span>
                </a> -->
                    <?php
                    if ($status != "PROP. ENVIADA") {
                    ?>
                        <a href="manageSend?id=<?php echo $id; ?>">
                            <span class="btn btn-primary m-2" onClick="return confirm('Você está ciente de que essa proposta será enviada para o email <?php echo $email ?>?');"><i class="far fa-paper-plane"></i> Enviar Proposta</span>
                        </a>
                    <?php
                    }
                    ?>
                </div>
    <?php

        }
    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}
    ?>