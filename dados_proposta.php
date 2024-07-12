<?php
session_start();

if (isset($_GET["id"])) {
    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Representante')) || ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

?>
        <style>
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

            .bg-cinza {
                background-color: #cfcfcf;
            }

            .bg-lilas {
                background-color: #8665E6;
            }
        </style>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';
            require_once 'includes/functions.inc.php';

            $idViewer = addslashes($_GET['id']);

            $existeAnalise = existeAnalise($conn, $idViewer);

            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idViewer . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $lista = $row['propListaItens'];
                $statusComercal = $row["propStatus"];


                $statusPedido = "";
                $numPed = "";
                $numFluxo = 5;
                $przStatus = "";
                $numPedOG = "";

                $projetista = null;
                if ($row['propProjetistas'] != null) {
                    $projetista = $row['propProjetistas'];
                }

                //Foto 1
                $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplana WHERE imgplanNumProp='" . $idViewer . "';");

                if (($retPic) && ($retPic->num_rows != 0)) {
                    while ($rowPic = mysqli_fetch_array($retPic)) {
                        $temanexo = true;
                    }
                } else {
                    $temanexo = false;
                }

                //Foto 2
                $retPic2 = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $idViewer . "';");

                if (($retPic2) && ($retPic2->num_rows != 0)) {
                    while ($rowPic2 = mysqli_fetch_array($retPic2)) {
                        $temanexo = true;
                    }
                } else {
                    $temanexo = false;
                }


                $retPic2 = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $idViewer . "';");

                if (($retPic2) && ($retPic2->num_rows != 0)) {
                    while ($rowPic2 = mysqli_fetch_array($retPic2)) {
                        $picPathB = $rowPic2['imgplanPathImg'];
                    }
                } else {
                    $picPathB = "none";
                }

                $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplana WHERE imgplanNumProp='" . $idViewer . "';");

                if (($retPic) && ($retPic->num_rows != 0)) {
                    while ($rowPic = mysqli_fetch_array($retPic)) {
                        $picPathA = $rowPic['imgplanPathImg'];
                    }
                } else {
                    $picPathA = "none";
                }

                $encrypted = hashItemNatural($row['propId']);

                $tipoProduto = ["propTipoProd"];

                //Solicitação de Troca
                $produtoProposto = null;
                $statusTroca = null;
                $retSolTroca = mysqli_query($conn, "SELECT * FROM solicitacaotrocaproduto WHERE solNumProp='" . $idViewer . "';");
                if (($retSolTroca) && ($retSolTroca->num_rows != 0)) {
                    while ($rowSolTroca = mysqli_fetch_array($retSolTroca)) {
                        $temSolicitacao = true;
                        $produtoProposto = $rowSolTroca["solProd"];
                        $statusTroca = $rowSolTroca["solStatus"];
                    }
                } else {
                    $temSolicitacao = false;
                    $produtoProposto = null;
                    $statusTroca = null;
                }

                $retStFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $idViewer . "';");
                if (($retStFin) && ($retStFin->num_rows != 0)) {
                    while ($rowStFin = mysqli_fetch_array($retStFin)) {
                        $statusFin = $rowStFin["apropStatus"];
                    }
                } else {
                    $statusFin = "AGUARDANDO";
                }


                //Cores Status Financeiro
                if ($statusFin == "Aprovado") {
                    $moodStatusFin = "bg-success";
                } else {
                    if ($statusFin == "Reprovado") {
                        $moodStatusFin = "bg-danger";
                    } else {

                        $moodStatusFin = "bg-secondary";
                    }
                }

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
                                $statusPedido = getStatusPedido($conn, $idViewer);
                                $numPed = getNumPedido($conn, $idViewer);
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


                $envioTC = $row["propEnvioTC"];
                $envioRelatorio = $row["propEnvioRelatorio"];
            ?>

                <div id="main" class="font-montserrat">
                    <div>
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "stmfailed") {
                                echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                            } else if ($_GET["error"] == "deleted") {
                                echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Item excluido da proposta!</p></div>";
                            } else if ($_GET["error"] == "solicitado") {
                                echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Solicitação de Troca de Produto executada!</p></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm" id="titulo-pag">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3" style="color: #fff">
                                            <h2 class="text-conecta" style="font-weight: 400;">Informações da <span style="font-weight: 800;"> Proposta - <span id="idNumProposta"><?php echo $idViewer ?></span></span></h2>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-color: #ee7624;">

                                <br>
                                <div class="d-flex justify-content-center">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="row w-100">
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
                                                                                            echo "Prazo Estimado: <span class='text-conecta'><b>" . $preventrega = getDataPrazoPosAceite($conn, $numPedOG) . "</b></span>";
                                                                                        } else {
                                                                                            echo "Dias nesta fase: <span class='text-conecta'><b>" . $dataPrazoContada . "</b></span>";
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
                                            </div>
                                            <?php
                                            if (($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Administrador')) {
                                            ?>
                                                <div class="row w-100 py-2">
                                                    <div class="card shadow mr-1 my-1 rounded w-100" style="background-color: #ee7624; height: 120px;">
                                                        <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                                            <div class="container-fluid text-center">
                                                                <div class="row">
                                                                    <div class="col d-flex justify-content-center">
                                                                        <div class="p-1">
                                                                            <h4 class="text-white py-2" style="text-align: center; font-size: 10pt;"><i class="fas fa-plus"></i> Reenvio de Arquivos</h4>
                                                                            <a href="reenviotc?id=<?php echo $encrypted; ?>" class="text-decoration-none"><button class="btn btn-light hover-bigger" style="color: #ee7624; font-size: 8pt;">Acesse aqui</button></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row w-100">
                                                    <div class="card shadow mr-1 my-1 rounded w-100">
                                                        <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                                            <div class="container-fluid text-center">
                                                                <div class="row">
                                                                    <div class="col d-flex justify-content-center">
                                                                        <div class="form p-1">
                                                                            <form action="includes/editprodutoporrepresentante.inc.php" method="POST">
                                                                                <h5 style="color: silver; text-align: center;" class="py-2">Troca de Produto</h5>
                                                                                <?php
                                                                                if ($temSolicitacao) {
                                                                                ?>
                                                                                    <div>
                                                                                        <div class='my-2 pb-0 alert alert-warning pt-3 text-center'>
                                                                                            <p>Solicitado a Troca de Produto para <span class="text-conecta"><b><?php echo $produtoProposto; ?></b></span>: <span class="badge badge-info"><?php echo $statusTroca; ?></span></p>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md">
                                                                                            <!--<label class="form-label text-black" for="tipoProd">Tipo de Produto</label>-->
                                                                                            <select name="tipoProd" class="form-control" id="tipoProd">
                                                                                                <?php
                                                                                                $retTipoProduto = mysqli_query($conn, "SELECT * FROM produtosproposta ORDER BY prodpropNome ASC;");
                                                                                                while ($rowTipoProduto = mysqli_fetch_array($retTipoProduto)) {
                                                                                                ?>
                                                                                                    <option value="<?php echo $rowTipoProduto['prodpropNome']; ?>" <?php if ($tipoProduto == $rowTipoProduto['prodpropNome']) echo ' selected="selected"'; ?>> <?php echo $rowTipoProduto['prodpropNome']; ?></option>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>

                                                                                        <div class="form-group col-md" hidden>
                                                                                            <label class="text-black" for="idproposta">ID Proposta</label>
                                                                                            <input type="text" class="form-control" id="idproposta" name="idproposta" value="<?php echo $idViewer; ?>" required readonly>
                                                                                        </div>

                                                                                        <div class="form-group col-md" hidden>
                                                                                            <label class="text-black" for="user">User Solicitante</label>
                                                                                            <input type="text" class="form-control" id="user" name="user" value="<?php echo $_SESSION["useruid"];; ?>" required readonly>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md">
                                                                                            <div class="p-1">
                                                                                                <button type="submit" name="submit" class="btn btn-primary" style="font-size: small;"> Solicitar Troca </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="col-md">
                                            <div class="card shadow mr-1 my-1">

                                                <div class="card-body">

                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="content-panel">
                                                                        <div class="form-horizontal style-form" name="form1">

                                                                            <div class="container-fluid pt-0 mt-0 py-4">
                                                                                <?php
                                                                                if (($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Administrador')) {
                                                                                ?>
                                                                                    <h6 style="color: silver;">Análise Rápida de Tomografia</h6>
                                                                                    <hr>

                                                                                    <!--<div class="row d-flex justify-content-around aling-items-center py-1">
                                                                                    <div class="form-group text-center col-md">
                                                                                        <a href="analiseRep?tc=aprov&id=<?php echo $idViewer; ?>" class="btn btn-success" style="font-size: small;"> Aprovado </a>
                                                                                    </div>

                                                                                    <div class="form-group text-center col-md">
                                                                                        <a href="analiseRep?tc=reprov&id=<?php echo $idViewer; ?>" class="btn btn-danger" style="font-size: small;"> Reprovado </a>
                                                                                    </div>

                                                                                </div>-->

                                                                                    <?php
                                                                                    if (!$existeAnalise) {
                                                                                    ?>
                                                                                        <div class="row d-flex justify-content-around aling-items-center py-1">
                                                                                            <div class="form-group text-center col-md">
                                                                                                <span class="btn btn-conecta" id="btnOpneRefazer" data-toggle="modal" data-target="#analiserapida"> Fazer Análise</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else {
                                                                                        $resultado = $existeAnalise['aprovStatus'];
                                                                                    ?>
                                                                                        <div class="form-group text-center col-md">
                                                                                            <div class="p-2">
                                                                                                <p><b>Resultado:
                                                                                                        <?php
                                                                                                        if ($resultado == "Aprovado") {
                                                                                                        ?>
                                                                                                            <span style="color: #28a745;">TC passou nos critérios</span>.
                                                                                                        <?php
                                                                                                        } else {
                                                                                                        ?>
                                                                                                            <span style="color: #dc3545 ;">TC reprovou nos critérios</span>.
                                                                                                        <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                    </b>
                                                                                                </p>

                                                                                            </div>
                                                                                            <div class="row d-flex justify-content-between aling-items-center py-1">
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <span class="btn btn-conecta" data-toggle="modal" data-target="#relatorioanalise"> <i class="fas fa-print"></i> Relatório da Análise </span>
                                                                                                    <span class="btn btn-conecta" data-toggle="modal" data-target="#certezarefazer"> <i class="fas fa-redo"></i></span>
                                                                                                    <span class="btn btn-conecta d-none" id="btnOpenRefazer" data-toggle="modal" data-target="#analiserapida"> Fazer Análise</span>
                                                                                                </div>
                                                                                            </div>
                                                                                    <?php
                                                                                    }
                                                                                }
                                                                                    ?>


                                                                                        </div>


                                                                                        <div class="container-fluid pt-0 mt-0 py-4">
                                                                                            <h6 style="color: silver;">Status da Proposta</h6>
                                                                                            <hr>
                                                                                            <div class="row d-flex justify-content-around aling-items-center py-1">
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center">Planejamento (TC)</h5>
                                                                                                    <p class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></p>
                                                                                                </div>

                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center">Comercial</h5>
                                                                                                    <p class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></p>
                                                                                                </div>

                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center">Financeiro</h5>
                                                                                                    <p class="badge <?php echo $moodStatusFin; ?>" style="color:#fff;"><?php echo $statusFin; ?></p>
                                                                                                </div>

                                                                                                <div class="form-group text-center col-md">
                                                                                                    <div class="col-md d-flex justify-content-center mt-1">
                                                                                                        <span class="btn-prop bg-info bg-hover-sm w-100" data-toggle="modal" data-target="#veranexo"><i class="bi bi-eye"></i> Ver Anexo</span>
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>

                                                                                        <script>
                                                                                            window.onload = function() {
                                                                                                var initial = document.querySelector('.statustc');
                                                                                                watchStatusTc(initial);
                                                                                                console.log(initial.value);
                                                                                            };

                                                                                            function watchStatusTc(value) {

                                                                                                var status = value.value;
                                                                                                var comentInput = document.querySelector('.coment');
                                                                                                var projInput = document.querySelector('.projetistas');

                                                                                                if (status == "TC REPROVADA") {
                                                                                                    comentInput.hidden = false;
                                                                                                } else {
                                                                                                    comentInput.hidden = true;
                                                                                                }

                                                                                                if (status == "TC APROVADA") {
                                                                                                    projInput.hidden = false;
                                                                                                } else {
                                                                                                    projInput.hidden = true;
                                                                                                }

                                                                                            }
                                                                                        </script>


                                                                                        <div class="container-fluid pt-0 mt-0">
                                                                                            <h6 style="color: silver;">Dados da Proposta </h6>
                                                                                            <hr>
                                                                                            <div class="row d-flex justify-content-around aling-items-center py-1">
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="text-center">Dr(a)</h5>
                                                                                                    <p><?php echo $row['propNomeDr']; ?></p>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center" style="color: silver;">|</h5>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="telefone">Telefone Dr(a)</h5>
                                                                                                    <p><?php echo $row['propTelefoneDr']; ?></p>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center" style="color: silver;">|</h5>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="emaildr">E-mail Dr(a)</h5>
                                                                                                    <p><?php echo $row['propEmailDr']; ?></p>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center" style="color: silver;">|</h5>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="convenio">Convênio</h5>
                                                                                                    <p><?php echo $row['propConvenio']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row d-flex justify-content-around aling-items-center py-1">
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="emailenvio">E-mail Contato</h5>
                                                                                                    <p><?php echo $row['propEmailEnvio']; ?></p>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center" style="color: silver;">|</h5>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="nomepac">Paciente</h5>
                                                                                                    <p><?php echo $row['propNomePac']; ?></p>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center" style="color: silver;">|</h5>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="representante">Representante</h5>
                                                                                                    <p><?php echo $row['propRepresentante']; ?></p>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md">
                                                                                                    <h5 class="text-center" style="color: silver;">|</h5>
                                                                                                </div>
                                                                                                <div class="form-group text-center col-md-2">
                                                                                                    <h5 class="form-label text-black" for="uf">UF</h5>
                                                                                                    <p><?php echo $row['propUf']; ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="container-fluid pt-0 mt-0 py-4">
                                                                                            <div class="form-row bg-light-gray2 rounded shadow d-flex justify-content-center align-items-center">
                                                                                                <div class="form-group col-md p-2">
                                                                                                    <h5 class="form-label text-black d-flex justify-content-center align-items-center" for="tipoProd"><b>Produto</b></h6>
                                                                                                        <span class="d-flex justify-content-center" style="color: #ee7624;"><b><?php echo $row['propTipoProd'];
                                                                                                                                                                                if ($row['propEspessura'] != null) {
                                                                                                                                                                                    echo " - " . $row['propEspessura'];
                                                                                                                                                                                } ?></b></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="container-fluid pt-0 mt-0">
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
                                                                                                        $retItens = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $idViewer . "';");
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
                                                                </div>
                                                        </section>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <div class="row">
                                                <div class="card m-1 shadow mb-3 w-100" style="background-color: #ee7624;">
                                                    <div class="card-body container-fluid">
                                                        <div class="row d-flex justify-content-center py-2">
                                                            <div class="col d-flex justify-content-center">
                                                                <h5 style="color: white; text-align: center;"><b>Comentários do Cliente</b></h5>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md d-flex justify-content-center">

                                                                <?php
                                                                $idProjeto = $_GET['id'];
                                                                $retComent = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$idProjeto';");


                                                                while ($rowComent = mysqli_fetch_array($retComent)) {
                                                                    $comentarioCliente = $rowComent['propComentarioProduto'];
                                                                }
                                                                ?>



                                                                <p style="line-height: 1.2rem; text-align: center; color: white !important;">
                                                                    <?php echo $comentarioCliente; ?>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card shadow mr-1 my-1 rounded w-100">
                                                    <div class="card-body container-fluid">
                                                        <div class="row d-flex">
                                                            <div class="col-md">
                                                                <div>
                                                                    <?php
                                                                    if (isset($_GET["error"])) {
                                                                        if ($_GET["error"] == "sent") {
                                                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Feedback enviado!</p></div>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div>
                                                                        <h5 style="color: silver; text-align: center;">Comentários</h5>
                                                                        <small class="d-flex justify-content-center pb-2" style="color: silver; text-align: center;"> (CHAT CN x Planejamento)</small>
                                                                        <div class="rounded">

                                                                            <?php
                                                                            $idProjeto = $_GET['id'];
                                                                            $retMsg = mysqli_query($conn, "SELECT * FROM comentariosproposta WHERE comentVisNumProp='$idProjeto' ORDER BY comentVisId ASC");


                                                                            while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                                                $msg = $rowMsg['comentVisText'];
                                                                                $owner = $rowMsg['comentVisUser'];
                                                                                $timer = $rowMsg['comentVisHorario'];
                                                                                $tipoUsuario = $rowMsg['comentVisTipoUser'];
                                                                                switch ($tipoUsuario) {
                                                                                    case 'Administrador':
                                                                                        $ownerColor = 'darkred';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Representante':
                                                                                        $ownerColor = 'darkpink';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Comercial':
                                                                                        $ownerColor = 'darkblue';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Planejador(a)':
                                                                                        $ownerColor = 'darkpurple';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Financeiro':
                                                                                        $ownerColor = 'darkgreen';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Qualidade ':
                                                                                        $ownerColor = 'brown';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    default:
                                                                                        $ownerColor = 'orange';
                                                                                        $hourColor = "#874214";
                                                                                        break;
                                                                                }

                                                                                $timer = explode(" ", $timer);
                                                                                $data = $timer[0];
                                                                                // $dataAmericana = explode("-", $date);
                                                                                // $ano = str_split($dataAmericana[0]);
                                                                                // $ano = $ano[0] . $ano[1];
                                                                                // $data = $dataAmericana[2] . '/' . $dataAmericana[1] . '/' . $ano;


                                                                                $hora = $timer[1];
                                                                                // $horaEnvio = explode(":", $hour);
                                                                                // $hora = 'às ' . $horaEnvio[0] . ':' . $horaEnvio[1];
                                                                                $horario = $data . ' às ' . $hora;

                                                                                $tipoUsuario = $rowMsg['comentVisTipoUser'];
                                                                                switch ($tipoUsuario) {
                                                                                    case 'Administrador':
                                                                                        $ownerColor = 'darkred';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Representante':
                                                                                        $ownerColor = 'darkpink';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Comercial':
                                                                                        $ownerColor = 'darkblue';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Planejador(a)':
                                                                                        $ownerColor = 'darkpurple';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Financeiro':
                                                                                        $ownerColor = 'darkgreen';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    case 'Qualidade ':
                                                                                        $ownerColor = 'brown';
                                                                                        $hourColor = "#fff";
                                                                                        break;

                                                                                    default:
                                                                                        $ownerColor = 'orange';
                                                                                        $hourColor = "#874214";
                                                                                        break;
                                                                                }

                                                                            ?>
                                                                                <?php
                                                                                if ($_SESSION['useruid'] == $owner) {


                                                                                ?>
                                                                                    <div class="row py-1">
                                                                                        <div class="col d-flex justify-content-end w-50">
                                                                                            <div class="bg-secondary bg-gradient text-white rounded rounded-3 px-2 py-1">
                                                                                                <h6><b><?php echo $owner; ?>:</b></h6>
                                                                                                <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 200px;"><?php echo $msg; ?></p>
                                                                                                <small style="color: #323236;"><?php echo $horario; ?></small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <div class="row py-1">
                                                                                        <div class="col d-flex justify-content-start w-50">
                                                                                            <div class="bg-<?php echo $ownerColor; ?>-conecta text-white rounded rounded-3 px-2 py-1">
                                                                                                <h6><b><?php echo $owner; ?>:</b></h6>
                                                                                                <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 300px;"><?php echo $msg; ?></p>
                                                                                                <small style="color: <?php echo $hourColor; ?>;"><?php echo $horario; ?></small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="row d-flex justify-content-center">
                                                                            <div class="col-sm px-2 py-3">
                                                                                <form action="includes/comentpropostaRep.inc.php" method="post">
                                                                                    <div class="container" hidden>
                                                                                        <div class="row">
                                                                                            <div class="col">
                                                                                                <label for="nprop">Nº Pedido</label>
                                                                                                <input type="text" class="form-control" name="nprop" id="nprop" value="<?php echo $idProjeto; ?>" readonly>
                                                                                            </div>
                                                                                            <div class="col">
                                                                                                <label for="user">Usuário</label>
                                                                                                <input type="text" class="form-control" name="user" id="user" value="<?php echo $_SESSION['useruid']; ?>" readonly>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="container">
                                                                                        <div class="row">
                                                                                            <div class="col d-flex justify-content-around align-items-start">
                                                                                                <div class="p-1">
                                                                                                    <textarea class="form-control color-bg-dark color-txt-wh" style="font-size: 0.8rem;" name="coment" id="coment" rows="1" onkeyup="limite_textarea(this.value)" maxlength="300"></textarea><br><br>
                                                                                                    <div class="row d-flex justify-content-start p-0 m-0">
                                                                                                        <small class="pl-2 text-muted" style="margin-top: -30px !important;"><small class="text-muted" id="cont">300</small> Caracteres restantes</small>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="p-1">
                                                                                                    <button type="submit" name="submit" class="btn btn-primary" style="font-size: small;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        limite_textarea(document.getElementById("descricao").value);
                                                                    });

                                                                    function limite_textarea(valor) {
                                                                        quant = 300;
                                                                        total = valor.length;
                                                                        if (total <= quant) {
                                                                            resto = quant - total;
                                                                            document.getElementById('cont').innerHTML = resto;
                                                                        } else {
                                                                            document.getElementById('texto').value = valor.substr(0, quant);
                                                                        }
                                                                    }
                                                                </script>

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


                <!-- Modal Anexo-->
                <div class="modal fade" id="veranexo" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-black">Anexos da Proposta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row d-flex">
                                        <div class="col-md">
                                            <div class="card rounded shadow">
                                                <div class="card-body">
                                                    <div class="col ">
                                                        <iframe src="<?php echo $picPathA; ?>/gallery/-/nav/thumbs/-/fit/cover/-/loop/true/-/allowfullscreen/native/-/thumbwidth/100/" width="100%" height="600" allowfullscreen="true" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md">
                                            <div class="card rounded shadow">
                                                <div class="card-body">
                                                    <div class="col ">
                                                        <iframe src="<?php echo $picPathB; ?>/gallery/-/nav/thumbs/-/fit/cover/-/loop/true/-/allowfullscreen/native/-/thumbwidth/100/" width="100%" height="600" allowfullscreen="true" frameborder="0">
                                                        </iframe>
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

                <!-- Modal Certeza Refazer Análise Rápida de Tomografia-->
                <div class="modal fade" id="certezarefazer" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="container-fluid">
                                    <div class="row pt-4">
                                        <div class="col d-flex justify-content-center align-items-center">
                                            <p>Refazer a Análise <span class="text-conecta">excluirá</span> a análise feita anteriormente. Está ciente e deseja prosseguir?</p>

                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col d-flex justify-content-center">
                                            <button type="button" class="btn btn-outline-conecta mr-2" id="btnCloseCerteza" data-dismiss="modal" aria-label="Fechar">
                                                Cancelar
                                            </button>

                                            <span class="btn btn-conecta ml-2" onclick="colseandopen()"> Ciente</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Análise Rápida de Tomografia-->
                <div class="modal fade" id="analiserapida" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div style="color: #55585B;">
                                    <h4 class="modal-title text-black"><i class="far fa-flag"></i> Análise de TC</h4>
                                    <span class="text-muted">Preencha os pré-requisitos de uma boa tomografia</span>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form p-4" name="form1" method="post" action="includes/analisetc.inc.php">
                                    <div class="container-fluid">
                                        <div class="row d-flex justify-content-between align-items-start" hidden>
                                            <div class="col-md" hidden>
                                                <div class="form-group">
                                                    <label for="user">Usuário</label>
                                                    <input type="text" class="form-control" name="user" id="user" value="<?php echo $_SESSION['useruid']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="numprop">Nº Proposta</label>
                                                    <input type="text" class="form-control" name="numprop" id="numprop" value="<?php echo $idViewer; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="checklist">Escolha Checklist</label>
                                                    <input type="text" class="form-control" name="checklist" id="checklist">
                                                </div>
                                                <div class="form-group">
                                                    <label for="resultado">Resultado</label>
                                                    <input type="text" class="form-control" name="resultado" id="resultado">
                                                </div>
                                                <div class="form-group">
                                                    <label for="declaracao">Declaro que Li</label>
                                                    <input type="text" class="form-control" name="declaracao" id="declaracao">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-between align-items-start">
                                            <div class="col-md">
                                                <?php if (($envioTC == "true") || ($envioTC == null)) { ?>
                                                    <div>
                                                        <h5 style="color: #55585B;" class="pb-2">Checklist</h5>
                                                        <div class="pb-2">
                                                            <div class="form-check py-1 d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" value="1" id="check1">
                                                                <label class="form-check-label px-1" for="check1">
                                                                    não está cortada
                                                                </label>
                                                            </div>
                                                            <div class="form-check py-1 d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" value="2" id="check2">
                                                                <label class="form-check-label px-1" for="check2">
                                                                    possui menos de 6 meses
                                                                </label>
                                                            </div>
                                                            <div class="form-check py-1 d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" value="3" id="check3">
                                                                <label class="form-check-label px-1" for="check3">
                                                                    não contém artefatos de movimento
                                                                </label>
                                                            </div>
                                                            <div class="form-check py-1 d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" value="4" id="check4">
                                                                <label class="form-check-label px-1" for="check4">
                                                                    possui pelo menos 200 imagens
                                                                </label>
                                                            </div>
                                                            <div class="form-check py-1 d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" value="5" id="check5">
                                                                <label class="form-check-label px-1" for="check5">
                                                                    as iniciais do paciente estão corretas
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div>
                                                        <h5 style="color: #55585B;" class="pb-2">Checklist</h5>
                                                        <div class="pb-2">
                                                            <div class="form-check py-1 d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" value="6" id="check6">
                                                                <label class="form-check-label px-1" for="check6">
                                                                    Produto Confere c/ Pedido
                                                                </label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <script>
                                                    // Obtenha todos os checkboxes
                                                    const checkboxes = document.querySelectorAll('.form-check-input');
                                                    const inputCheck = document.getElementById('checklist');
                                                    const inputResultado = document.getElementById('resultado');

                                                    var checkboxValues = []; // Array para armazenar os valores selecionados

                                                    // Adicione um evento de clique a cada checkbox
                                                    checkboxes.forEach(function(checkbox) {
                                                        checkbox.addEventListener('click', function() {
                                                            handleCheckbox(checkbox);
                                                            console.log(checkboxValues);
                                                            // Verifique se todos os checkboxes estão marcados
                                                            const allChecked = Array.from(checkboxes).every(function(checkbox) {
                                                                return checkbox.checked;
                                                            });

                                                            var elementResultadoPassou = document.querySelector('#resultado-passou');
                                                            var elementResultadoReprovou = document.querySelector('#resultado-reprovou');
                                                            var elementRelatorioReprovou = document.querySelector('#relatorio-reprovou');
                                                            var elementConfirmacaoPassou = document.querySelector('#confirmacao-passou');
                                                            // Execute a condição se todos os checkboxes estiverem marcados
                                                            if (allChecked) {
                                                                // Coloque aqui o código que deseja executar quando todos os checkboxes estiverem marcados
                                                                // console.log('Todos os checkboxes estão marcados.');
                                                                elementResultadoPassou.classList.remove('d-none');
                                                                elementConfirmacaoPassou.classList.remove('d-none');
                                                                elementResultadoReprovou.classList.add('d-none');
                                                                elementRelatorioReprovou.classList.add('d-none');

                                                                inputResultado.value = "Aprovado";
                                                                inputCheck.value = checkboxValues.join(", ");
                                                                obrigatorioRadio();
                                                            } else {
                                                                // console.log('Falta checkbox.');
                                                                cleanDeclaracao();
                                                                elementResultadoPassou.classList.add('d-none');
                                                                elementConfirmacaoPassou.classList.add('d-none');
                                                                elementResultadoReprovou.classList.remove('d-none');
                                                                elementRelatorioReprovou.classList.remove('d-none');

                                                                inputResultado.value = "Reprovado";
                                                                inputCheck.value = checkboxValues.join(", ");

                                                            }
                                                        });
                                                    });

                                                    function handleCheckbox(checkbox) {
                                                        var value = checkbox.value;

                                                        if (checkbox.checked) {
                                                            // Adiciona o valor ao array se o checkbox foi marcado
                                                            checkboxValues.push(value);
                                                        } else {
                                                            // Remove o valor do array se o checkbox foi desmarcado
                                                            var index = checkboxValues.indexOf(value);
                                                            if (index > -1) {
                                                                checkboxValues.splice(index, 1);
                                                            }
                                                        }
                                                        checkboxValues.sort();
                                                    }

                                                    function handleDeclaracao(result) {
                                                        result = result.value;
                                                        const inputDeclaracao = document.getElementById('declaracao');
                                                        inputDeclaracao.value = result;
                                                    }

                                                    function obrigatorioRadio() {
                                                        document.getElementById("flexRadioDefault1").required = true;
                                                        document.getElementById("flexRadioDefault2").required = true;
                                                    }

                                                    function tirarObrigatorioRadio() {
                                                        document.getElementById("flexRadioDefault1").required = false;
                                                        document.getElementById("flexRadioDefault2").required = false;
                                                    }

                                                    function cleanDeclaracao() {
                                                        tirarObrigatorioRadio();
                                                        const inputDeclaracao = document.getElementById('declaracao');
                                                        inputDeclaracao.value = "";
                                                        document.getElementById("flexRadioDefault1").checked = false;
                                                        document.getElementById("flexRadioDefault2").checked = false;
                                                    }
                                                </script>


                                                <!--<div class="d-flex justify-content-start pt-2">
                                                <button class="btn btn-conecta" onclick=""> <i class="fas fa-check"></i> </button>
                                            </div>-->

                                            </div>
                                            <div class="col-md-4 d-flex justify-content-end">
                                                <?php
                                                $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $idViewer . "' ;");
                                                while ($rowFile = mysqli_fetch_array($retFile)) {
                                                    if (($rowFile['fileCdnUrl'] != null)) {
                                                        $linktc = $rowFile['fileCdnUrl'];
                                                    } else {
                                                        $linktc = "null";
                                                    }
                                                }
                                                ?>
                                                <span class="px-1">
                                                    Link: <a href="<?php echo $linktc; ?>" class="text-conecta" target="_blank"> Clique Aqui </a>
                                                </span>
                                            </div>


                                        </div>
                                        <div class="row py-2 mt-2 d-flex justify-content-between align-items-start">
                                            <div class="col-md border p-2">
                                                <span id="resultado-passou" class="d-none">Resultado: <span style="color: #28a745;">TC passou nos critérios</span></span>

                                                <span id="resultado-reprovou" class="d-none">Resultado: <span style="color: #dc3545 ;">TC reprovou nos critérios</span>, portanto, não poderá ser cadastrada.
                                                    Converse com o cliente e peça nova TC.</span>
                                            </div>
                                        </div>
                                        <hr style="border: 1px dashed silver;">
                                        <div class="row py-2 mt-2 d-flex justify-content-between align-items-start">
                                            <div class="col-md p-2">
                                                <span id="relatorio-reprovou" class="d-none">*Um relatório da análise ficará disponível para ser mandado para o cliente</span>
                                                <span id="confirmacao-passou" class="d-none">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="não tenho dúvidas" onclick="handleDeclaracao(this)">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Declaro que conferi a TC e <span class="text-conecta">não tenho dúvidas</span> que atende a todos os requisitos necessários, <span style="text-decoration: underline;">não necessitando passar por re-aprovação do planejamento. </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="ainda tenho alguma dúvida" onclick="handleDeclaracao(this)">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Declaro que conferi a TC, confirmo que ela atende as exigências acima, mas <span class="text-conecta">ainda tenho alguma dúvida</span> que exige <span style="text-decoration: underline;">atenção de um técnico.</span>
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="comentario">Comentário (opcional)</label>
                                                        <input type="text" class="form-control" name="comentario" id="comentario">
                                                    </div>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row py-2 mt-2 d-flex justify-content-center align-items-center">
                                            <div class="col-md p-2">
                                                <div class="d-flex justify-content-center pt-2">
                                                    <button type="submit" name="submit" class="btn btn-outline-conecta" onclick=""> Salvar </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Relatório de Análise Rápida de Tomografia-->
                <div class="modal fade" id="relatorioanalise" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content font-montserrat">
                            <div class="modal-header">
                                <div style="color: #55585B;">
                                    <h4 class="modal-title text-black"><i class="far fa-file-image"></i> Relatório da Análise de TC</h4>
                                    <span class="text-muted">Abaixo está o que foi preenchido relacionado a tomografia enviada</span>
                                </div>
                                <button type="button" class="close hide-on-print" data-dismiss="modal" aria-label="Fechar" style="border: none; outline: none;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php
                                if (!$existeAnalise) {
                                    $numProposta = null;
                                    $quemAnalisou = null;
                                    $dataAnalise = null;
                                    $checklist = null;
                                    $resultado = null;
                                    $declaracao = null;
                                    $comentarioAnalise = null;
                                } else {
                                    $numProposta = $existeAnalise['aprovNumProp'];
                                    $quemAnalisou = $existeAnalise['aprovQuemAnalisou'];
                                    $dataAnalise = dateFormat2($existeAnalise['aprovDataAnalise']);
                                    $checklist = $existeAnalise['aprovChecklist'];
                                    $resultado = $existeAnalise['aprovStatus'];
                                    $declaracao = $existeAnalise['aprovDeclaracaoLeitura'];
                                    $comentarioAnalise = $existeAnalise['aprovComentario'];
                                }

                                $checklist = explode(",", $checklist);

                                $checkUm = false;
                                $checkDois = false;
                                $checkTrês = false;
                                $checkQuatro = false;
                                $checkCinco = false;
                                $checkSeis = false;

                                // Verifica se o número está presente no array
                                if (in_array(1, $checklist)) {
                                    $checkUm = true;
                                } else {
                                    $checkUm = false;
                                }

                                if (in_array(2, $checklist)) {
                                    $checkDois = true;
                                } else {
                                    $checkDois = false;
                                }

                                if (in_array(3, $checklist)) {
                                    $checkTrês = true;
                                } else {
                                    $checkTrês = false;
                                }

                                if (in_array(4, $checklist)) {
                                    $checkQuatro = true;
                                } else {
                                    $checkQuatro = false;
                                }

                                if (in_array(5, $checklist)) {
                                    $checkCinco = true;
                                } else {
                                    $checkCinco = false;
                                }

                                if (in_array(6, $checklist)) {
                                    $checkSeis = true;
                                } else {
                                    $checkSeis = false;
                                }
                                ?>
                                <div class="row">
                                    <div class="col" style="display: flex; justify-content: space-around;">
                                        <p>Nº Proposta: <span style="color: #ee7624;"> <?php echo $numProposta; ?></span></p>
                                        <p>Analisado por: <span style="color: #ee7624;"> <?php echo $quemAnalisou; ?></span></p>
                                        <p>Data: <span style="color: #ee7624;"> <?php echo $dataAnalise; ?></span></p>
                                    </div>
                                </div>
                                <hr style="border: #cfcfcf 1px dashed; letter-spacing: 4px;">

                                <div class="row">

                                    <div class="col">
                                        <?php if (($envioTC == "true") || ($envioTC == null)) { ?>
                                            <h5>Checklist</h5>

                                            <div class="p-2">
                                                <?php
                                                if ($checkUm) {
                                                ?>
                                                    <p><span style="color: #28a745;"><i class="fas fa-check"></i></span> não está cortada</p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p><span style="color: #dc3545 ;"><i class="fas fa-times"></i></span> não está cortada</p>
                                                <?php
                                                }
                                                ?>


                                                <?php
                                                if ($checkDois) {
                                                ?>
                                                    <p><span style="color: #28a745;"><i class="fas fa-check"></i></span> possui menos de 6 meses</p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p><span style="color: #dc3545 ;"><i class="fas fa-times"></i></span> possui menos de 6 meses</p>
                                                <?php
                                                }
                                                ?>


                                                <?php
                                                if ($checkTrês) {
                                                ?>
                                                    <p><span style="color: #28a745;"><i class="fas fa-check"></i></span> não contém artefatos de movimento</p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p><span style="color: #dc3545 ;"><i class="fas fa-times"></i></span> não contém artefatos de movimento</p>
                                                <?php
                                                }
                                                ?>


                                                <?php
                                                if ($checkQuatro) {
                                                ?>
                                                    <p><span style="color: #28a745;"><i class="fas fa-check"></i></span> possui pelo menos 200 imagens</p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p><span style="color: #dc3545 ;"><i class="fas fa-times"></i></span> possui pelo menos 200 imagens</p>
                                                <?php
                                                }
                                                ?>


                                                <?php
                                                if ($checkCinco) {
                                                ?>
                                                    <p><span style="color: #28a745;"><i class="fas fa-check"></i></span> as iniciais do paciente estão corretas</p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p><span style="color: #dc3545 ;"><i class="fas fa-times"></i></span> as iniciais do paciente estão corretas</p>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php } else { ?>
                                            <h5>Checklist</h5>

                                            <div class="p-2">
                                                <?php
                                                if ($checkSeis) {
                                                ?>
                                                    <p><span style="color: #28a745;"><i class="fas fa-check"></i></span> Produto Confere c/ Pedido</p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p><span style="color: #dc3545 ;"><i class="fas fa-times"></i></span> Produto Confere c/ Pedido</p>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        <?php } ?>
                                        <div class="p-2">
                                            <p>Resultado:
                                                <?php
                                                if ($resultado == "Aprovado") {
                                                ?>
                                                    <span style="color: #28a745;">TC passou nos critérios</span>.
                                                <?php
                                                } else {
                                                ?>
                                                    <span style="color: #dc3545 ;">TC reprovou nos critérios</span>, portanto, não poderá ser cadastrada.
                                                    Será necessário enviar nova tomografia que atenda todos os itens acima.
                                                <?php
                                                }
                                                ?>

                                            </p>

                                        </div>

                                        <?php
                                        if ($resultado == "Aprovado") {
                                            if ($declaracao == "não tenho dúvidas") {
                                        ?>
                                                <div class="p-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="não tenho dúvidas" checked>
                                                        <label class="form-check-label">
                                                            Declaro que conferi a TC e <span style="color: #ee7624;">não tenho dúvidas</span> que atende a todos os requisitos necessários, <span style="text-decoration: underline;">não necessitando passar por re-aprovação do planejamento. </span>
                                                        </label>
                                                    </div>
                                                </div>

                                            <?php
                                            } else {
                                            ?>
                                                <div class="p-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="ainda tenho alguma dúvida" checked>
                                                        <label class="form-check-label">
                                                            Declaro que conferi a TC, confirmo que ela atende as exigências acima, mas <span style="color: #ee7624;">ainda tenho alguma dúvida</span> que exige <span style="text-decoration: underline;">atenção de um técnico.</span>
                                                        </label>
                                                    </div>
                                                </div>

                                        <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                        if ($comentarioAnalise != null) {

                                        ?>
                                            <hr>
                                            <div class="p-2">
                                                <p>Comentário: <?php echo $comentarioAnalise; ?></p>
                                            </div>



                                        <?php

                                        }
                                        ?>

                                        <div class="p-2 d-flex justify-content-center">
                                            <button class="btn btn-outline-conecta hide-on-print m-2" onclick="imprimirModal(); return false;">Imprimir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function colseandopen() {
                        document.getElementById("btnCloseCerteza").click();
                        document.getElementById("btnOpenRefazer").click();
                    }

                    function imprimirModal() {
                        //pegar id proposta
                        var idProp = document.getElementById("idNumProposta").textContent;

                        console.log(idProp);

                        // Obtém o conteúdo da modal pelo ID
                        var modalContent = document.getElementById("relatorioanalise").innerHTML;

                        // Obtém todos os elementos <link> e <style> da página atual
                        var estilosPagina = document.querySelectorAll('link[rel="stylesheet"], style');

                        // Cria uma string para armazenar o CSS
                        var cssPagina = '';

                        var cssBotao = `
                            <style>
                                @import url('https://fonts.cdnfonts.com/css/montserrat');

                                .font-montserrat {
                                    font-family: 'Montserrat', sans-serif;
                                }

                                h4,
                                .h4 {
                                font-size: 1.5rem;
                                }
                                p {
                                color: #6c757d;
                                }
                                .m-2 {
                                margin: 0.5rem !important;
                                }
                                .p-2 {
                                padding: 0.5rem !important;
                                }
                                .btn {
                                display: inline-block;
                                font-weight: 400;
                                color: white;
                                text-align: center;
                                vertical-align: middle;
                                -webkit-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none;
                                background-color: transparent;
                                border: 2px solid transparent;
                                padding: 0.375rem 0.75rem;
                                font-size: 1rem;
                                line-height: 1.5;
                                border-radius: 0.25rem;
                                transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                                }
                                .btn-outline-conecta {
                                color: #ee7624 !important;
                                border-color: #ee7624!important;
                                opacity: 0.8 !important;
                                }
                                @media print {
                                    .hide-on-print {
                                        display: none !important;
                                    }
                                }
                            </style>
                            `;

                        // Copia o conteúdo de cada elemento para a string de CSS
                        estilosPagina.forEach(function(estilo) {
                            cssPagina += estilo.outerHTML;
                        });

                        // Abre uma nova janela
                        var janelaImprimir = window.open('', '_blank');

                        // Escreve o conteúdo da modal e o CSS na nova janela
                        janelaImprimir.document.write('<html><head><title>Relatório de Análise de TC - Proposta ' + idProp + '</title>' + cssPagina + cssBotao + '</head><body>' + modalContent + '</body></html>');

                        // Imprime a nova janela
                        janelaImprimir.print();

                        // Fecha a nova janela
                        janelaImprimir.close();
                    }
                </script>

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