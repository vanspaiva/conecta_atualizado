<?php

session_start();
if (!empty($_GET)) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Financeiro'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';
?>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->

        <body class="bg-light-gray2">
            <style>
                .smallOnHover {
                    transition: ease-in-out 0.2s;
                }

                .smallOnHover:hover {
                    transform: scale(0.9);
                }
            </style>
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $id = addslashes($_GET['id']);

            $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropId='" . $id . "';");
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
                    $planovenda = $rowProp['propPlanoVenda'];
                }

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



            ?>

                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">

                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center py-4">
                            <div class="col-sm-8 justify-content-start">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3">
                                            <h2 class="text-center text-conecta" style="font-weight: 400;">Proposta - <span style="font-weight: 700;"> <?php echo $numProp ?></span></h2>

                                        </div>
                                    </div>
                                </div>
                                <hr style="border-color: #ee7624;">
                                <br>
                                <div class="card">
                                    <div class="card-body">
                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="content-panel">
                                                            <div class="container">
                                                                <?php if ($status == 'Em Análise') { ?>
                                                                    <div class="row d-flex justify-content-center pb-2">
                                                                        <div class="pt-3 px-3">
                                                                            <a href="aceiteprop?type=aprov&id=<?php echo $id; ?>"><button class="btn btn-success smallOnHover"><i class="fas fa-check-circle fa-2x"></i></button></a>
                                                                        </div>
                                                                        <div class="pt-3 px-3">
                                                                            <a href="aceiteprop?type=reprov&id=<?php echo $id; ?>"><button class="btn btn-danger smallOnHover"><i class="fas fa-times-circle fa-2x"></i></button></a>
                                                                        </div>
                                                                    </div>
                                                                    <hr class="pb-3">
                                                                    <?php } else {
                                                                    if ($status == 'Aprovado') {
                                                                    ?>
                                                                        <div class="row d-flex justify-content-center pb-2">
                                                                            <div class="alert alert-success" role="alert">
                                                                                Status: <?php echo $status; ?>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="pb-3">
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="row d-flex justify-content-center pb-2">
                                                                            <div class="alert alert-danger" role="alert">
                                                                                Status: <?php echo $status; ?>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="pb-3">
                                                                <?php
                                                                    }
                                                                } ?>
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
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <h5 class="text-black">Plano de Venda: </h5>
                                                                        <p style="line-height: 1.2rem;"><?php echo $planovenda; ?></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h5 class="text-black">Valor A Pagar: </h5>
                                                                        <p style="line-height: 1.2rem;"><?php echo "(" . $typeEntrada . ") " . $valorapagar; ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex justify-content-center py-4">
                                                                    <?php if ($openIframe) { ?>
                                                                        <iframe src="<?php echo $caminhoProp; ?>" width="100%" height="600" style="border: none;"></iframe>
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo $caminhoProp; ?>" width="auto" style="height: 100vh;" alt="Comprovante Proposta <?php echo $id; ?>">
                                                                    <?php } ?>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

                <?php include_once 'php/footer_index.php' ?>

        <?php

    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}


        ?>