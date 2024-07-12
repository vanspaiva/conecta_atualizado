<?php

session_start();
if (!empty($_GET) && isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    //  $idProp = $_GET['id'];

    // // decrypt to get again $plaintext
    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    // $parts = explode(':', $_GET['id']);
    // $idProp = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

    $idProp = deshashItemNatural(addslashes($_GET['id']));

?>

    <body class="bg-light-gray2">
        <style>
            .pointer:hover {
                cursor: pointer;
            }

            .thumbnail {
                position: relative;
                width: 300px;
                height: 300px;
                border-radius: 10px;
                overflow: hidden;
            }

            .thumbnail img {
                position: absolute;
                left: 50%;
                top: 50%;
                height: 100%;
                width: auto;
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .thumbnail img.portrait {
                width: 100%;
                height: auto;
            }

            .bg-amarelo {
                background-color: #FAF53D;
            }

            .bg-verde-claro {
                background-color: #9FFFD2;
            }

            .bg-verde {
                background-color: #34B526;
            }

            .bg-rosa {
                background-color: #FAA4B5;
            }

            .bg-vermelho {
                background-color: #FA242A;
            }

            .bg-vermelho-claro {
                background-color: #FA6069;
            }

            .bg-roxo {
                background-color: #C165FF;
            }

            .bg-azul {
                background-color: #42A1DB;
            }
            
            .bg-lilas {
                background-color: #8665E6;
            }
        </style>
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        // set the default timezone to use.
        date_default_timezone_set('UTC');
        $dtz = new DateTimeZone("America/Sao_Paulo");
        $dt = new DateTime("now", $dtz);
        $datacriacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idProp . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $lista = $row['propListaItens'];
            $array_items = $row['propListaItensBD'];
            $array_items = explode(',', $array_items);

            $statusComercal = $row["propStatus"];

            if ($row['propTxtReprov'] != null) {
                $txtReprov = $row['propTxtReprov'];
            } else {
                $txtReprov = null;
            }

            if ($row['propProjetistas'] != null) {
                $projetista = $row['propProjetistas'];
            }

            $tipoProduto = $row['propTipoProd'];
            // $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplan WHERE imgplanNumProp='" . $_GET['id'] . "';");
            // while ($rowPic = mysqli_fetch_array($retPic)) {
            //     $picPathA = $rowPic['imgplanPathImgA'];
            //     $picPathB = $rowPic['imgplanPathImgB'];
            // }

            //Cores Status TC
            if ($row['propStatusTC'] == "TC APROVADA") {
                $moodStatus = "bg-success";
                $colorText = "";
            } else {

                if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                    $moodStatus = "bg-danger";
                } else {
                    $moodStatus = "bg-amarelo text-dark";
                }
            }

            $statusPedido = "";
            $numPed = "";
            $numFluxo = 5;
            $przStatus = "";


            //Cores Status Comercial
            if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                $moodStatusComercial = "bg-amarelo";
            } else {

                if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                    $moodStatusComercial = "bg-verde-claro";
                } else {
                    if ($row['propStatus'] == 'APROVADO') {
                        $moodStatusComercial = "bg-verde text-white";
                        $numFluxo = 10;
                    } else {
                        if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                            $moodStatusComercial = "bg-roxo text-white";
                            $statusPedido = getStatusPedido($conn, $idProp);
                            $numPed = getNumPedido($conn, $idProp);
                            if ($numPed != null) {
                                $retNumPed = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$numPed'");
                                while ($rowNumPed = mysqli_fetch_array($retNumPed)) {
                                    $numFluxo = $rowNumPed['pedPosicaoFluxo'];
                                    $numFluxo = intval($numFluxo);
                                    $numFluxo = $numFluxo * 20;
                                }
                                $numPedOG = $numPed;
                                $numPed = "Nº " . $numPed . " - ";
                            } else {
                                $numFluxo = 0;
                            }

                            $dataPrazoContada = getDataPrazoContada($conn, $numPedOG);
                        } else {
                            if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                $moodStatusComercial = "bg-vermelho text-white";
                            } else {
                                if (strpos($row['propStatus'], 'COTADO') !== false) {
                                    $moodStatusComercial = "bg-rosa";
                                } else {
                                    if (strpos($row['propStatus'], 'COTAR') !== false) {
                                        $moodStatusComercial = "bg-vermelho-claro text-white";
                                    } else {
                                        if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                            $moodStatusComercial = "bg-azul text-white";
                                        } else {
                                            $moodStatusComercial = "bg-amarelo";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }




            switch ($statusPedido) {
                case 'CRIADO':
                    $statusPedido = 'Pedido Criado';
                    break;
                case 'PLAN':
                    $statusPedido = 'Planejamento';
                    break;
                case 'VIDEO':
                    $statusPedido = 'Aguardando Vídeo';
                    break;
                case 'ACEITE':
                    $statusPedido = 'Aguardando Aceite';
                    break;
                case 'PROD':
                    $statusPedido = 'Em Produção';
                    break;
                case 'ENVIADO':
                    $statusPedido = 'Pedido Enviado';
                    break;

                default:
                    $statusPedido = '';
                    break;
            }






        ?>

            <div id="main" class="font-montserrat">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        } else if ($_GET["error"] == "deleted") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Item excluido da proposta!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-10 " id="titulo-pag">
                            <div class="d-flex">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2 row-padding-2">
                                    <div class="row px-3" style="color: #fff">
                                        <h2 class="text-conecta" style="font-weight: 400;">Reenvio de Arquivos - <span style="font-weight: 800;"> Proposta Nº <?php echo $idProp; ?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-color: #ee7624;">

                            <br>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow">

                                            <div class="card-body">

                                                <section id="main-content">
                                                    <section class="wrapper">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="content-panel">
                                                                    <div class="form-row bg-light-gray2 rounded shadow d-flex justify-content-center align-items-center">
                                                                        <div class="form-group col-md p-2">
                                                                            <h5 class="form-label text-black d-flex justify-content-center align-items-center" for="tipoProd"><b>Produto</b></h6>
                                                                                <span class="d-flex justify-content-center" style="color: #ee7624;"><b><?php echo $tipoProduto;
                                                                                                                                                        //if ($row['propEspessura'] != null) {
                                                                                                                                                        //echo " - " . $row['propEspessura'];
                                                                                                                                                        //} 
                                                                                                                                                        ?></b></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="container-fluid pt-0 mt-0 py-4">
                                                                        <h6 style="color: silver;" class="text-center">Status da Proposta</h6>
                                                                        <hr>
                                                                        <div class="row d-flex justify-content-around aling-items-center py-1">
                                                                            <div class="form-group text-center col-md">
                                                                                <h5 class="text-center">Status TC</h5>
                                                                                <h4><span class="badge <?php echo $moodStatus; ?> d-block"><?php echo $row['propStatusTC']; ?> </span></h4>
                                                                            </div>

                                                                            <div class="form-group text-center col-md">
                                                                                <h5 class="text-center">Status Pedido</h5>
                                                                                <h4><span class="badge <?php echo $moodStatusComercial; ?> d-block">

                                                                                        <?php
                                                                                        echo $numPed;
                                                                                        if ($row["propStatus"] == "PEDIDO") {
                                                                                            echo $statusPedido;
                                                                                        } else {
                                                                                            echo $row["propStatus"];
                                                                                        }
                                                                                        ?>
                                                                                        <?php //if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; 
                                                                                        ?>
                                                                                    </span></h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row pt-4">
                                                                        <div class="form-group col-md-3">
                                                                            <h6 class="form-label text-black" for="nomedr">Dr(a)</h6>
                                                                            <p><?php echo $row['propNomeDr']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                                            <p><?php echo $row['propNomePac']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <h6 class="form-label text-black" for="emailenvio">E-mail Contato</h6>
                                                                            <p><?php echo $row['propEmailEnvio']; ?></p>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <h6 class="form-label text-black" for="usercriador">Usuário Criador</h6>
                                                                            <p><?php echo $row['propUserCriacao']; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row py-4 d-flex justify-content-center">
                                                                        <div class="form-group">
                                                                            <button class="btn btn-conecta" data-toggle="modal" data-target="#tabelaprodutos"> <i class="fas fa-list"></i> Conferir Produtos</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col">
                                                                        <!--Fluxo e Prazo-->
                                                                        <h4 class="text-conecta" style="font-weight: 700;">Fluxo e Prazo</h4>
                                                                        <hr style="border-color: #ee7624;">

                                                                        <div>
                                                                            <div class="p-2 mb-2">
                                                                                <div class="row p-2">
                                                                                    <?php
                                                                                    switch ($tipoProduto) {

                                                                                        case 'ORTOGNÁTICA':
                                                                                            include_once 'fluxo/otognatica.php';
                                                                                            break;
                                                                                        case 'ORTOGNATICA':
                                                                                            include_once 'fluxo/otognatica.php';
                                                                                            break;
                                                                                        case 'SMARTMOLD':
                                                                                            include_once 'fluxo/smartmold.php';
                                                                                            break;
                                                                                        case 'ATM':
                                                                                            include_once 'fluxo/atm.php';
                                                                                            break;
                                                                                        case 'RECONSTRUÇÃO ÓSSEA':
                                                                                            include_once 'fluxo/reconstrucao.php';
                                                                                            break;
                                                                                        case 'RECONSTRUCAO OSSEA':
                                                                                            include_once 'fluxo/reconstrucao.php';
                                                                                            break;
                                                                                        case 'CUSTOMLIFE':
                                                                                            include_once 'fluxo/customlife.php';
                                                                                            break;
                                                                                        default:

                                                                                            break;
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                            </div>
                                            </section>
                                        <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card shadow mr-1 my-1 rounded w-100">
                                            <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                                <div class="container-fluid text-center">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <div class="p-1">
                                                                <div>
                                                                    <h5 style="color: silver; text-align: center;" class="py-2">Prazos</h5>

                                                                    <div class='my-2 pb-0 pt-3 text-center'>
                                                                        <p>Fase atual: <span class="text-conecta"><b>
                                                                                    <?php
                                                                                    if ($statusComercal == "PEDIDO") {
                                                                                        echo $statusPedido;
                                                                                    } else {
                                                                                        echo $statusComercal;
                                                                                    }
                                                                                    ?>
                                                                                </b></span></p>
                                                                        <p>
                                                                                    
                                                                                            <?php
                                                                                            if ($statusComercal == "PEDIDO") {
                                                                                                
                                                                                                $nomeStatus = getNomeFluxoPed($conn, $numPedOG);

                                                                                                if (($nomeStatus == "Projeto Aceito") || ($nomeStatus == "Produção") || ($nomeStatus == "Projetando Produção")) {
                                                                                                    echo "Prazo Estimado: <span class='text-conecta'><b>". $preventrega = getDataPrazoPosAceite($conn, $numPedOG) . "</b></span>";
                                                                                                } else {
                                                                                                    echo "Dias nesta fase: <span class='text-conecta'><b>". $dataPrazoContada . "</b></span>";
                                                                                                }
                                                                                            } else {
                                                                                                echo "Não disponível";
                                                                                            }
                                                                                            ?>
                                                                                        
                                                                                </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $numFluxo; ?>%" aria-valuenow="<?php echo $numFluxo; ?>" aria-valuemin="0" aria-valuemax="100">
                                                                    <?php echo $numFluxo . '%'; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <form class="form-horizontal style-form" name="form1" action="includes/reenviotc.inc.php" method="POST">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="propid">Prop ID</label>
                                                                    <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $idProp; ?>" readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="useruid">Uid</label>
                                                                    <input type="text" class="form-control" id="useruid" name="useruid" value="<?php echo $_SESSION["useruid"]; ?>" readonly>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="datacriacao">Data</label>
                                                                    <input type="text" class="form-control" id="datacriacao" name="datacriacao" value="<?php echo $datacriacao; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <!--ENVIO TC-->

                                                                    <h4 class="text-conecta" style="font-weight: 700;">Re-Envio de exames</h4>
                                                                    <hr style="border-color: #ee7624;">
                                                                    <p style="line-height: 1.25rem;"><b style="color: #ee7624;">ATENÇÃO!</b> Certifique-se de que a <b>data da tomografia</b> corresponde a <b>mesma do laudo</b> e que se encontram dentro do <b>prazo validade de 6 meses</b>, determinação da ANVISA conforme RDC 305/2019 .</p>


                                                                    <div class="border border-5 rounded bg-light" style="border-style: dashed !important; border-width: 2px !important;">
                                                                        <div class="p-2 mb-2 bg-light text-dark rounded">
                                                                            <div class="row p-2">
                                                                                <div class="col-md form-group ">
                                                                                    <label class='control-label text-black'>Anexe aqui a tomografia do paciente <b style="color: red;">*</b></label>
                                                                                    <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                                        <div>
                                                                                            <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile11" hidden></i></h2>
                                                                                            <p class="uploader-conecta-button" id="widget11">
                                                                                                <input id="tcfile" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file file gdrive dropbox" data-multiple="false" />
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <script>
                                                                                        // var NUMBER_STORED_FILES = 0;
                                                                                        const widget1 = uploadcare.Widget("#tcfile", {
                                                                                            publicKey: 'fe82618d53dc578231ce'
                                                                                        });

                                                                                        widget1.onUploadComplete(info => {

                                                                                            var isstored = info.isStored;
                                                                                            var filename = info.name;
                                                                                            var filesize = info.size;
                                                                                            var fileuuid = info.uuid;
                                                                                            var cdnUrl = info.cdnUrl;
                                                                                            console.log(info);

                                                                                            document.getElementById("isstored11").value = isstored;
                                                                                            document.getElementById("filename11").value = filename;
                                                                                            document.getElementById("filesize11").value = filesize;
                                                                                            document.getElementById("fileuuid11").value = fileuuid;
                                                                                            document.getElementById("cdnurl11").value = cdnUrl;
                                                                                            // NUMBER_STORED_FILES++;
                                                                                            // document.getElementById("qtdfiles").value = NUMBER_STORED_FILES;

                                                                                            document.getElementById("checkfile11").hidden = false;
                                                                                            // widget1.parentNode.classList.remove('uploader-conecta-button');
                                                                                            // widget1.parentNode.classList.add('uploader-done-button');
                                                                                        });
                                                                                    </script>

                                                                                    <style>
                                                                                        .hovericon {
                                                                                            transition: ease all 0.2s;
                                                                                        }

                                                                                        .hovericon:hover {
                                                                                            transform: scale(0.9);
                                                                                            cursor: pointer;
                                                                                        }
                                                                                    </style>
                                                                                </div>

                                                                                <div class="col-md form-group">
                                                                                    <label class='control-label text-black'>Anexe aqui o laudo da tomografia (TC) <b style="color: red;">*</b></label>
                                                                                    <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                                        <div>
                                                                                            <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile22" hidden></i></h2>
                                                                                            <p class="uploader-conecta-button" id="widget22">
                                                                                                <input id="laudofile" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file gdrive dropbox" data-multiple="false" />
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!--<small class="text-muted">Arquivos permitidos: pdf</small>-->
                                                                                    <script>
                                                                                        const widget2 = uploadcare.Widget("#laudofile", {
                                                                                            publicKey: 'fe82618d53dc578231ce'
                                                                                        });
                                                                                        widget2.onUploadComplete(info => {

                                                                                            var isstored = info.isStored;
                                                                                            var filename = info.name;
                                                                                            var filesize = info.size;
                                                                                            var fileuuid = info.uuid;
                                                                                            var cdnurl = info.cdnUrl;

                                                                                            document.getElementById("isstored22").value = isstored;
                                                                                            document.getElementById("filename22").value = filename;
                                                                                            document.getElementById("filesize22").value = filesize;
                                                                                            document.getElementById("fileuuid22").value = fileuuid;
                                                                                            document.getElementById("cdnurl22").value = cdnurl;

                                                                                            // document.getElementById("submit").disabled = false;

                                                                                            // NUMBER_STORED_FILES++;
                                                                                            // document.getElementById("qtdfiles").value = NUMBER_STORED_FILES;

                                                                                            document.getElementById("checkfile22").hidden = false;
                                                                                        });
                                                                                    </script>
                                                                                    <style>
                                                                                        .hovericon {
                                                                                            transition: ease all 0.2s;
                                                                                        }

                                                                                        .hovericon:hover {
                                                                                            transform: scale(0.9);
                                                                                            cursor: pointer;
                                                                                        }
                                                                                    </style>
                                                                                </div>

                                                                            </div>
                                                                            <div class="row p-2">
                                                                                <div class="col-md form-group ">
                                                                                    <label class='control-label text-black'>Anexe aqui modelos referentes ao caso <b style="color: red;">*</b></label>
                                                                                    <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                                        <div>
                                                                                            <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile3" hidden></i></h2>
                                                                                            <p class="uploader-conecta-button">
                                                                                                <input id="modelofile" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file file gdrive dropbox" data-multiple="false" />
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <script>
                                                                                        const widget3 = uploadcare.Widget("#modelofile", {
                                                                                            publicKey: 'fe82618d53dc578231ce'
                                                                                        });

                                                                                        widget3.onUploadComplete(info => {

                                                                                            var isstored = info.isStored;
                                                                                            var filename = info.name;
                                                                                            var filesize = info.size;
                                                                                            var fileuuid = info.uuid;
                                                                                            var cdnurl = info.cdnUrl;

                                                                                            document.getElementById("isstored3").value = isstored;
                                                                                            document.getElementById("filename3").value = filename;
                                                                                            document.getElementById("filesize3").value = filesize;
                                                                                            document.getElementById("fileuuid3").value = fileuuid;
                                                                                            document.getElementById("cdnurl3").value = cdnurl;

                                                                                            // NUMBER_STORED_FILES++;
                                                                                            // document.getElementById("qtdfiles").value = NUMBER_STORED_FILES;

                                                                                            document.getElementById("checkfile3").hidden = false;
                                                                                        });
                                                                                    </script>

                                                                                    <style>
                                                                                        .hovericon {
                                                                                            transition: ease all 0.2s;
                                                                                        }

                                                                                        .hovericon:hover {
                                                                                            transform: scale(0.9);
                                                                                            cursor: pointer;
                                                                                        }
                                                                                    </style>
                                                                                </div>

                                                                                <div class="col-md form-group">
                                                                                    <label class='control-label text-black'>Anexe aqui fotos referentes ao caso <b style="color: red;">*</b></label>
                                                                                    <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                                        <div>
                                                                                            <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile4" hidden></i></h2>
                                                                                            <p class="uploader-conecta-button">
                                                                                                <input id="fotofile" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file gdrive dropbox" data-multiple="false" />
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!--<small class="text-muted">Arquivos permitidos: pdf</small>-->
                                                                                    <script>
                                                                                        const widget4 = uploadcare.Widget("#fotofile", {
                                                                                            publicKey: 'fe82618d53dc578231ce'
                                                                                        });
                                                                                        widget4.onUploadComplete(info => {

                                                                                            var isstored = info.isStored;
                                                                                            var filename = info.name;
                                                                                            var filesize = info.size;
                                                                                            var fileuuid = info.uuid;
                                                                                            var cdnurl = info.cdnUrl;

                                                                                            document.getElementById("isstored4").value = isstored;
                                                                                            document.getElementById("filename4").value = filename;
                                                                                            document.getElementById("filesize4").value = filesize;
                                                                                            document.getElementById("fileuuid4").value = fileuuid;
                                                                                            document.getElementById("cdnurl4").value = cdnurl;

                                                                                            // NUMBER_STORED_FILES++;
                                                                                            // document.getElementById("qtdfiles").value = NUMBER_STORED_FILES;

                                                                                            document.getElementById("checkfile4").hidden = false;
                                                                                        });
                                                                                    </script>
                                                                                    <style>
                                                                                        .hovericon {
                                                                                            transition: ease all 0.2s;
                                                                                        }

                                                                                        .hovericon:hover {
                                                                                            transform: scale(0.9);
                                                                                            cursor: pointer;
                                                                                        }
                                                                                    </style>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="groupfiles" hidden>
                                                                        <div class="py-4">
                                                                            <div class="row">
                                                                                <div class="col-md form-group">
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="isstored11">Is Stored</label>
                                                                                        <input class="form-control" name="isstored11" id="isstored11" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filename11">File Name</label>
                                                                                        <input class="form-control" name="filename11" id="filename11" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filesize11">File Size</label>
                                                                                        <input class="form-control" name="filesize11" id="filesize11" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="fileuuid11">File Uuid</label>
                                                                                        <input class="form-control" name="fileuuid11" id="fileuuid11" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="cdnurl11">Cdn Url</label>
                                                                                        <input class="form-control" name="cdnurl11" id="cdnurl11" type="text" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="py-4">
                                                                            <div class="row">
                                                                                <div class="col-md form-group">
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="isstored22">Is Stored</label>
                                                                                        <input class="form-control" name="isstored22" id="isstored22" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filename22">File Name</label>
                                                                                        <input class="form-control" name="filename22" id="filename22" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filesize22">File Size</label>
                                                                                        <input class="form-control" name="filesize22" id="filesize22" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="fileuuid22">File Uuid</label>
                                                                                        <input class="form-control" name="fileuuid22" id="fileuuid22" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="cdnurl22">Cdn Url</label>
                                                                                        <input class="form-control" name="cdnurl22" id="cdnurl22" type="text" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="py-4">
                                                                            <div class="row">
                                                                                <div class="col-md form-group">
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="isstored3">Is Stored</label>
                                                                                        <input class="form-control" name="isstored3" id="isstored3" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filename3">File Name</label>
                                                                                        <input class="form-control" name="filename3" id="filename3" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filesize3">File Size</label>
                                                                                        <input class="form-control" name="filesize3" id="filesize3" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="fileuuid3">File Uuid</label>
                                                                                        <input class="form-control" name="fileuuid3" id="fileuuid3" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="cdnurl3">Cdn Url</label>
                                                                                        <input class="form-control" name="cdnurl3" id="cdnurl3" type="text" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="py-4">
                                                                            <div class="row">
                                                                                <div class="col-md form-group">
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="isstored4">Is Stored</label>
                                                                                        <input class="form-control" name="isstored4" id="isstored4" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filename4">File Name</label>
                                                                                        <input class="form-control" name="filename4" id="filename4" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filesize4">File Size</label>
                                                                                        <input class="form-control" name="filesize4" id="filesize4" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="fileuuid4">File Uuid</label>
                                                                                        <input class="form-control" name="fileuuid4" id="fileuuid4" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="cdnurl4">Cdn Url</label>
                                                                                        <input class="form-control" name="cdnurl4" id="cdnurl4" type="text" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="py-4 col d-flex justify-content-center">
                                                                        <button class="btn btn-conecta" type="submit" name="submit" id="submit">Enviar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            </div>
            <!-- Modal Add Material Midia -->
            <div class="modal fade" id="tabelaprodutos" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-conecta">Tabela de Produtos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col"><b>#</b></th>
                                            <th scope="col"><b>Cdg</b></th>
                                            <th scope="col"><b>Descrição</b></th>
                                            <th scope="col"><b>Qtd</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $retItens = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $idProp . "';");
                                        while ($rowItens = mysqli_fetch_array($retItens)) {
                                        ?>
                                            <tr>
                                                <th><?php echo $i ?></th>
                                                <td><?php echo $rowItens['itemCdg']; ?></td>
                                                <td><?php echo $rowItens['itemNome']; ?></td>
                                                <td><?php echo $rowItens['itemQtd']; ?></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="js/standart.js"></script>

    </body>

    </html>

<?php
    include_once 'php/footer_index.php';
} else {

    header("location: index");
    exit();
}

?>