<?php 
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
    // // decrypt to get again $plaintext
    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    // $parts = explode(':', addslashes($_GET['id']));
    // $idProjeto = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

    $idProjeto = deshashItem(addslashes($_GET['id']));

    //pesquisar proposta
    $retTry = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idProjeto';");
    while ($rowTry = mysqli_fetch_array($retTry)) {
        $userCriador = $rowTry['pedUserCriador'];
    }

    if ($_SESSION["useruid"] == $userCriador) {


        //chamar do banco de dados todos os casos
        $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idProjeto'");
        while ($row = mysqli_fetch_array($ret)) {

            $propID = $row['pedPropRef'];
            $pedID = $row['pedNumPedido'];
            $tipoProd = $row['pedTipoProduto'];
            $nomedr = $row['pedNomeDr'];
            $nomepac = $row['pedNomePac'];

            $dtInicioBD = $row['pedDtCriacaoPed'];
            $dtInicioBD = explode(" ", $dtInicioBD);
            $dataInicioAmericana = $dtInicioBD[0];
            $HoraInicioAmericana = $dtInicioBD[1];

            $dataInicioAmericana = explode("-", $dataInicioAmericana);
            $HoraInicioAmericana = explode(":", $HoraInicioAmericana);

            $dataInicio = $dataInicioAmericana[2] . '/' . $dataInicioAmericana[1] . '/' . $dataInicioAmericana[0];
            $horaInicio = $HoraInicioAmericana[0] . ':' . $HoraInicioAmericana[1];
            $dtInicioProj = $dataInicio . ' ' . $horaInicio;


            $numFluxo = $row['pedPosicaoFluxo'];
            $numFluxo = intval($numFluxo);
            $numFluxo = $numFluxo * 20;

            $andamento = $row['pedStatus'];

            switch ($andamento) {
                case 'CRIADO':
                    $nomeFluxo = 'Pedido Criado';
                    break;
                case 'PLAN':
                    $nomeFluxo = 'Planejamento';
                    break;
                case 'VIDEO':
                    $nomeFluxo = 'Aguardando Vídeo';
                    break;
                case 'ACEITE':
                    $nomeFluxo = 'Aguardando Aceite';
                    break;
                case 'PROD':
                    $nomeFluxo = 'Em Produção';
                    break;
                case 'ENVIADO':
                    $nomeFluxo = 'Pedido Enviado';
                    break;

                default:
                    $nomeFluxo = '';
                    break;
            }

            //pesquisar proposta
            $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$propID';");
            while ($rowProp = mysqli_fetch_array($retProp)) {
                $cdgCallisto = $rowProp['propListaItens'];
                $cdgCallisto = explode(',', $cdgCallisto);
                $cdgImg = $cdgCallisto[0];
            }

            //pesquisar imagem
            $retImg = mysqli_query($conn, "SELECT * FROM imagensprodutos WHERE imgprodCodCallisto='$cdgImg';");
            while ($rowImg = mysqli_fetch_array($retImg)) {
                $linkImg = $rowImg['imgprodLink'];
                $altImg = $rowImg['imgprodNome'];
                $categoria = $rowImg['imgprodCategoria'];
            }

?>


            <body class="bg-light-gray2">
                <?php
                include_once 'php/navbar-dash.php';
                include_once 'php/lateral-nav.php';
                ?>

                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">
                    <div class="container-fluid">
                        <div class="row row-3">
                            <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                            </div>
                            <div class="col-sm-10 justify-content-start" id="titulo-pag">
                                <h2>Projeto <?php echo $pedID; ?></h2>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>

                        <div class="row my-2 p-1">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-head"></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-2 d-flex align-items-end">
                                                <span class="d-flex justify-content-center shadow-sm" style="border-radius: 50%; padding: 5px 10px;">
                                                    <img class="img-icon-case" src="<?php echo $linkImg; ?>" alt="<?php echo $altImg; ?>">
                                                </span>
                                            </div>
                                            <div class="col-sm-4 p-2">
                                                <div class="row d-flex align-itens-center justify-content-start pt-2">
                                                    <h5 class="d-flex justify-content-center"><span class="badge bg-secondary" style="color: #ffffff;"><?php echo $nomeFluxo; ?></span></h5>
                                                </div>
                                                <div class="row d-flex align-items-center justify-content-start">
                                                    <h4><?php echo $tipoProd; ?></h4>
                                                </div>
                                                <div class="row d-flex align-items-center justify-content-start">
                                                    Doutor: <?php echo $nomedr; ?>
                                                </div>
                                                <div class="row d-flex align-items-center justify-content-start">
                                                    Paciente: <?php echo $row['pedNomePac']; ?>
                                                </div>

                                            </div>
                                            <div class="col-sm-6 row-padding-1">

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
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="row my-2 p-1">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <!--Cartão Principal com ABAS-->
                                    <div class="col-sm">
                                        <div class="card">
                                            <div class="card-head"></div>
                                            <div class="card-body">

                                                <div class="d-flex justify-content-center">
                                                    <!--Tabs for large devices-->
                                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link <?php if ($row['pedAbaAgenda'] == 'fechado') {
                                                                                    echo 'disabled';
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>" <?php if ($row['pedAbaAgenda'] == 'fechado') {
                                                                                            echo '';
                                                                                        } else {
                                                                                            echo 'style="color: #000000;"';
                                                                                        } ?> id="pills-agendar-video-tab" data-toggle="pill" href="#pills-agendar-video" role="tab" aria-controls="pills-agendar-video" aria-selected="true"><img class="img-icon-agendar-pb" src="assets/img/agend-icon.png" alt="Agendar Vídeo"> Agendar Vídeo</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link <?php if ($row['pedAbaVisualizacao'] == 'fechado') {
                                                                                    echo 'disabled';
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>" <?php if ($row['pedAbaVisualizacao'] == 'fechado') {
                                                                                            echo '';
                                                                                        } else {
                                                                                            echo 'style="color: #000000;"';
                                                                                        } ?> id="pills-visualizar-projeto-tab" data-toggle="pill" href="#pills-visualizar-projeto" role="tab" aria-controls="pills-visualizar-projeto" aria-selected="false"><img class="img-icon-projeto-pb" src="assets/img/proj-icon.png" alt="Visualizar Projeto"> Visualizar Projeto</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link <?php if ($row['pedAbaAceite'] == 'fechado') {
                                                                                    echo 'disabled';
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>" <?php if ($row['pedAbaAceite'] == 'fechado') {
                                                                                            echo '';
                                                                                        } else {
                                                                                            echo 'style="color: #000000;"';
                                                                                        } ?> id="pills-aceite-projeto-tab" data-toggle="pill" href="#pills-aceite-projeto" role="tab" aria-controls="pills-aceite-projeto" aria-selected="false"><img class="img-icon-aceite-pb" src="assets/img/aceite-icon.png" alt="Aceite do Projeto"> Aceite do Projeto</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link <?php if ($row['pedAbaRelatorio'] == 'fechado') {
                                                                                    echo 'disabled';
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>" <?php if ($row['pedAbaRelatorio'] == 'fechado') {
                                                                                            echo '';
                                                                                        } else {
                                                                                            echo 'style="color: #000000;"';
                                                                                        } ?> id="pills-relatorio-tab" data-toggle="pill" href="#pills-relatorio" role="tab" aria-controls="pills-contact" aria-selected="false"><img class="img-icon-relatorio-pb" src="assets/img/relatorio-icon.png" alt="Relatórios"> Relatórios</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link " <?php if ($row['pedAbaDocumentos'] == 'fechado') {
                                                                                        echo '';
                                                                                    } else {
                                                                                        echo 'style="color: #000000;"';
                                                                                    } ?> id="pills-docs-anvisa-tab" data-toggle="pill" href="#pills-docs-anvisa" role="tab" aria-controls="pills-docs-anvisa" aria-selected="false"><img class="img-icon-docs-pb" src="assets/img/anvisa-icon.png" alt="Docs Anvisa"> Docs Anvisa</a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="pills-inicio-tab" data-toggle="pill" href="#pills-inicio" role="tab" aria-controls="pills-inicio" aria-selected="false"><i class="fas fa-bookmark"></i> Início</a>
                                                        </li>
                                                    </ul>
                                                    <!--Tabs for smaller devices-->
                                                    <ul class="nav nav-pills mb-3 d-inline-flex" id="pills-tab-small" role="tablist">
                                                        <li class="nav-item" style="margin: auto; width: 40px !important;">
                                                            <a class="nav-link d-flex justify-content-center <?php if ($row['pedAbaAgenda'] == 'fechado') {
                                                                                                                    echo 'disabled';
                                                                                                                } else {
                                                                                                                    echo 'available';
                                                                                                                } ?>" id="pills-agendar-video-tab" data-toggle="pill" href="#pills-agendar-video" role="tab" aria-controls="pills-agendar-video" aria-selected="true" style="width: 30px !important; margin: 0px; margin-right: 0px;">
                                                                <i class="fas fa-calendar-alt fa-2x"></i>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" style="margin: auto; width: 40px !important;">
                                                            <a class="nav-link d-flex justify-content-center <?php if ($row['pedAbaVisualizacao'] == 'fechado') {
                                                                                                                    echo 'disabled';
                                                                                                                } else {
                                                                                                                    echo 'available';
                                                                                                                } ?>" id="pills-visualizar-projeto-tab" data-toggle="pill" href="#pills-visualizar-projeto" role="tab" aria-controls="pills-visualizar-projeto" aria-selected="false" style="width: 30px !important; margin: 0px; margin-right: 0px;">
                                                                <i class="fas fa-cube fa-2x"></i>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" style="margin: auto; width: 40px !important;">
                                                            <a class="nav-link d-flex justify-content-center <?php if ($row['pedAbaAceite'] == 'fechado') {
                                                                                                                    echo 'disabled';
                                                                                                                } else {
                                                                                                                    echo 'available';
                                                                                                                } ?>" id="pills-aceite-projeto-tab" data-toggle="pill" href="#pills-aceite-projeto" role="tab" aria-controls="pills-aceite-projeto" aria-selected="false" style="width: 30px !important; margin: 0px; margin-right: 0px;">
                                                                <i class="fas fa-check-double fa-2x"></i>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" style="margin: auto; width: 40px !important;">
                                                            <a class="nav-link d-flex justify-content-center <?php if ($row['pedAbaRelatorio'] == 'fechado') {
                                                                                                                    echo 'disabled';
                                                                                                                } else {
                                                                                                                    echo 'available';
                                                                                                                } ?>" id="pills-relatorio-tab" data-toggle="pill" href="#pills-relatorio" role="tab" aria-controls="pills-contact" aria-selected="false" style="width: 30px !important; margin: 0px; margin-right: 0px;">
                                                                <i class="fas fa-file-pdf fa-2x"></i>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" style="margin: auto; width: 40px !important;">
                                                            <a class="nav-link d-flex justify-content-center <?php if ($row['pedAbaDocumentos'] == 'fechado') {
                                                                                                                    echo 'disabled';
                                                                                                                } else {
                                                                                                                    echo 'available';
                                                                                                                } ?>" id="pills-docs-anvisa-tab" data-toggle="pill" href="#pills-docs-anvisa" role="tab" aria-controls="pills-docs-anvisa" aria-selected="false" style="width: 30px !important; margin: 0px; margin-right: 0px;">
                                                                <i class="fas fa-book fa-2x"></i>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" style="margin: auto; width: 40px !important;">
                                                            <a class="nav-link active d-flex justify-content-center" id="pills-inicio-tab" data-toggle="pill" href="#pills-inicio" role="tab" aria-controls="pills-inicio" aria-selected="false" style="width: 30px !important; margin: 0px; margin-right: 0px;">
                                                                <i class="fas fa-bookmark fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>


                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade " id="pills-agendar-video" role="tabpanel" aria-labelledby="pills-agendar-video-tab">

                                                        <?php
                                                        $retStatusAgenda = mysqli_query($conn, "SELECT * FROM agenda WHERE agdNumPedRef='$idProjeto';");
                                                        while ($rowStatusAgenda = mysqli_fetch_array($retStatusAgenda)) {
                                                            if ($rowStatusAgenda['agdStatus'] == 'VAZIO') {

                                                        ?>
                                                                <?php include_once 'agendar.php'; ?>
                                                            <?php
                                                            } else {
                                                                $dataBD = $rowStatusAgenda['agdData'];
                                                                $dataBD = explode("-", $dataBD);
                                                                $dataEscolhida = $dataBD[2] . '/' . $dataBD[1] . '/' . $dataBD[0];
                                                                $horaEscolhida = $rowStatusAgenda['agdHora'];
                                                            ?>

                                                                <div class="text-center pt-4">
                                                                    <h4 style="color:#ee7624">Vídeo Agendada</h4>
                                                                    <p>Sua vídeo foi marcada para o dia <b> <?php echo $dataEscolhida; ?> ás <?php echo $horaEscolhida; ?></b>.</p>
                                                                    <p> Aguarde o dia da sua vídeo e verifique seu e-mail. Quando estiver próximo da data você será notificado</p>
                                                                </div>
                                                                <div class="d-flex justify-content-end align-items-baseline" style="z-index: -1;">
                                                                    <i class="far fa-calendar-check fa-7x" style="color: #e9ecef; "></i>
                                                                </div>

                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="tab-pane fade" id="pills-visualizar-projeto" role="tabpanel" aria-labelledby="pills-visualizar-projeto-tab">
                                                        <div class="bg-visualizar">
                                                            <?php
                                                            if (isset($_GET["error"])) {
                                                                if ($_GET["error"] == "stmtfailed") {
                                                                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                } else if ($_GET["error"] == "none") {
                                                                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>URL atualizada com sucesso!</p></div>";
                                                                }
                                                            }
                                                            ?>

                                                            <?php
                                                            $retUrl = mysqli_query($conn, "SELECT * FROM visualizador WHERE visNumPed='$idProjeto'");


                                                            while ($rowUrl = mysqli_fetch_array($retUrl)) {
                                                                $url = $rowUrl['visUrl3D'];
                                                            }

                                                            $items = explode(".in/", $url);
                                                            $end = $items[1];
                                                            ?>

                                                            <div class="row" id="primeira-coluna">

                                                                <div class="col-sm d-flex justify-content-center align-items-center py-3" style="height: 500px;">
                                                                    <iframe class="rounded " allowfullscreen webkitallowfullscreen style="min-width: 300px; width: 50vw;" height="480" frameborder="0" seamless src="https://p3d.in/e/<?php echo $end; ?>+shading,dl,help,share,spin,link-hidden"></iframe>
                                                                </div>


                                                                <!--<div class="col-sm d-flex justify-content-center align-items-center p-4 m-4 mx-2 rounded" style="background-color: #e9ecef;">
                                                                    <div class="container">
                                                                        <div class="row d-flex justify-content-center p-2 mb-3">
                                                                            <div class="col">
                                                                                <h5 class="text-center">Projeto aceito</h5>
                                                                                <p class="text-center">Quando você achar que o planejamento está
                                                                                    correto e de acordo com as especificações
                                                                                    aperte o botão abaixo para aceitar o projeto.</p>
                                                                                <div class="d-flex justify-content-center">
                                                                                    <a class="btn btn-primary" id="aceite-projeto-tab" data-toggle="pill" href="#pills-aceite-projeto" role="tab" aria-controls="pills-aceite-projeto-tab" aria-selected="true">Aceitar Projeto</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row d-flex justify-content-center p-2">
                                                                            <div class="col">
                                                                                <h5 class="text-center">Problemas com o design?</h5>
                                                                                <p class="text-center">Deseja entrar em contato com os projetistas por meio
                                                                                    de vídeo novamente?</p>
                                                                                <div class="d-flex justify-content-center">
                                                                                    <a class="btn btn-primary" id="agendar-video-tab" data-toggle="pill" href="#pills-agendar-video" role="tab" aria-controls="pills-agendar-video" aria-selected="true">Remarcar Vídeo</a>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>->

                                                            </div>
                                                            <!--<div>
                                                                <?php
                                                                if (isset($_GET["error"])) {
                                                                    if ($_GET["error"] == "sent") {
                                                                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Feedback enviado!</p></div>";
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="container border rounded p-3 mt-3" style="border-style: dashed !important; border-color: silver; border-width: 3px !important; max-height: 650px; overflow-y: hidden;">
                                                                    <h5 style="color: silver; text-align: center;" class="pt-2">Mensagens de Feedbacks</h5>
                                                                    <div class="container rounded p-3" style="max-height: 400px; overflow-y: scroll;">

                                                                        <?php
                                                                        $retMsg = mysqli_query($conn, "SELECT * FROM comentariosvisualizador WHERE comentVisNumPed='$idProjeto' ORDER BY comentVisId ASC");


                                                                        while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                                            $msg = $rowMsg['comentVisText'];
                                                                            $owner = $rowMsg['comentVisUser'];
                                                                            $timer = $rowMsg['comentVisHorario'];
                                                                            $timer = explode(" ", $timer);
                                                                            $date = $timer[0];
                                                                            $dataAmericana = explode("-", $date);
                                                                            $ano = str_split($dataAmericana[0]);
                                                                            $ano = $ano[0] . $ano[1];
                                                                            $data = $dataAmericana[2] . '/' . $dataAmericana[1] . '/' . $ano;


                                                                            $hour = $timer[1];
                                                                            $horaEnvio = explode(":", $hour);
                                                                            $hora = 'às ' . $horaEnvio[0] . ':' . $horaEnvio[1];
                                                                            $horario = $data . ' ' . $hora;


                                                                        ?>
                                                                            <?php
                                                                            if ($_SESSION['useruid'] == $owner) {


                                                                            ?>
                                                                                <div class="row p-1">
                                                                                    <div class="col d-flex justify-content-end w-50">
                                                                                        <div class="bg-secondary bg-gradient text-white rounded rounded-3 px-2 py-1">
                                                                                            <h4><b><?php echo $owner; ?>:</b></h4>
                                                                                            <p class="text-white text-wrap" style="max-width: 200px;"><?php echo $msg; ?></p>
                                                                                            <small style="color: #323236;"><?php echo $horario; ?></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <div class="row p-1">
                                                                                    <div class="col d-flex justify-content-start w-50">
                                                                                        <div class="bg-orange-conecta text-white rounded rounded-3 px-2 py-1">
                                                                                            <h4><b><?php echo $owner; ?>:</b></h4>
                                                                                            <p class="text-white text-wrap" style="max-width: 300px;"><?php echo $msg; ?></p>
                                                                                            <small style="color: #874214;"><?php echo $horario; ?></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="row d-flex justify-content-center">
                                                                        <div class="col-sm px-2 mx-1 py-3">
                                                                            <form action="includes/addfeedbackvisualizer.inc.php" method="post">
                                                                                <div class="container" hidden>
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <label for="nped">Nº Pedido</label>
                                                                                            <input type="text" class="form-control" name="nped" id="nped" value="<?php echo $idProjeto; ?>" readonly>
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
                                                                                            <div class="p-2">
                                                                                                <textarea class="form-control color-bg-dark color-txt-wh" name="coment-txt" id="coment-txt" rows="1" style="min-width: 200px; width: 50vw;" onkeyup="limite_textarea(this.value)" maxlength="300"></textarea><br><br>
                                                                                                <div class="row d-flex justify-content-start p-0 m-0">
                                                                                                    <small class="pl-2 text-muted" style="margin-top: -40px !important;"><small class="text-muted" id="cont">300</small> Caracteres restantes</small>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="p-2">
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
                                                            </script>-->

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-aceite-projeto" role="tabpanel" aria-labelledby="pills-aceite-projeto-tab">
                                                        <div class="row bg-aceite">
                                                            <div class="col-sm-6" id="div-form-aceite">

                                                                <?php
                                                                $retStatusAceite = mysqli_query($conn, "SELECT * FROM aceite WHERE aceiteNumPed='$idProjeto';");
                                                                while ($rowStatusAceite = mysqli_fetch_array($retStatusAceite)) {
                                                                    $TESTE = 'ENVIADO';
                                                                    if ($TESTE == 'VAZIO') {

                                                                ?>
                                                                        <form action="includes/aceite.inc.php" method="POST" class="form-aceite">
                                                                            <div class="container-fluid">
                                                                                <div class="form-group" hidden>
                                                                                    <label class="label-control" for="projeto">Projeto</label>
                                                                                    <input class="form-control" type="text" id="projeto" name="projeto" value="<?php echo $_GET['id']; ?>">
                                                                                </div>

                                                                                <b>Estou de acordo com o projeto demonstrado durante a vídeo,
                                                                                    com suas especificações e autorizo a fabricação.</b>
                                                                                <div>
                                                                                    <input type="radio" id="aceito" name="op-aceite" value="1" onchange="escolhaAceite(this);"><label for="aceito">Aceito</label>
                                                                                    <br>
                                                                                    <input type="radio" id="n-aceito" name="op-aceite" value="0" onchange="escolhaAceite(this);"><label for="n-aceito">Não Aceito</label>
                                                                                </div>

                                                                                <script>
                                                                                    function escolhaAceite(src) {
                                                                                        var opcao = src.value;

                                                                                        if (opcao == 0) {
                                                                                            document.getElementById("txt_comentAceite").innerHTML = "<label class='py-2' for='coment-txt-aceite'>Observações ou melhorias a serem feitas (projeto)</label><textarea class='form-control' name='coment-txt-aceite' id='coment-txt-aceite' rows='3'></textarea>";

                                                                                        } else if (opcao == 1) {
                                                                                            document.getElementById("txt_comentAceite").innerHTML = "";
                                                                                        }
                                                                                    }
                                                                                </script>
                                                                                <!--Caixa de texto para comentários:-->
                                                                                <p id="txt_comentAceite"></p><br><br>

                                                                                <br>
                                                                                <button type="submit" name="aceitar" class="btn btn-primary"> Aceitar Projeto</button>

                                                                            </div>
                                                                        </form>
                                                                    <?php
                                                                    } else {
                                                                    ?>

                                                                        <div class="text-center pt-4">
                                                                            <h4 style="color:#ee7624">Projeto Aceito!</h4>
                                                                            <p>Agradecemos a confiança. Em breve seu projeto será concluído e você receberá uma notificação quando estiver tudo pronto.</p>
                                                                        </div>

                                                                <?php
                                                                    }
                                                                }
                                                                ?>


                                                            </div>

                                                            <div class="col-sm-6" id="div-form-avalicao">
                                                                <?php
                                                                $retStatusFDAceite = mysqli_query($conn, "SELECT * FROM feedbackaceite WHERE fdaceiteNumPed='$idProjeto';");
                                                                while ($rowStatusFDAceite = mysqli_fetch_array($retStatusFDAceite)) {
                                                                    if ($rowStatusFDAceite['fdaceiteStatus'] == 'VAZIO') {

                                                                ?>
                                                                        <form action="includes/feedbackaceite.inc.php" method="POST" class="form-avalicao">
                                                                            <div class="container-fluid">
                                                                                <div class="form-group" hidden>
                                                                                    <label class="label-control" for="projeto">Projeto</label>
                                                                                    <input class="form-control" type="text" id="projeto" name="projeto" value="<?php echo $_GET['id']; ?>">
                                                                                </div>
                                                                                <p><a style="text-decoration: none; font-weight: bold;">Importante lembrá-lo que os prazos de entrega serão contabilizados
                                                                                        a partir da data do aceite do Dr(a) no projeto. Prazo Estimado(dias úteis)*:</a>
                                                                                    - Reconstruções (titânio ou PEEK) - 15 a 20 dias*
                                                                                    - Smartmold - 13 dias*
                                                                                    - Guia Cirúrgico CMF - 5 dias*
                                                                                    - Guia Cirúrgico Vertebral - 10 dias*
                                                                                    - Crânio PMMA - 10 dias*</p>

                                                                                <b>Para evolução da equipe, compartilhe seu feedback ou elogio do Projetista/Engenheiro</b>
                                                                                <div>
                                                                                    <input type="radio" id="melhorar" name="op-avalicao" value="0" onchange="escolhaAvaliacao(this);"><label for="melhorar">Podemos melhorar a experiência</label>
                                                                                    <br>
                                                                                    <input type="radio" id="n-melhorar" name="op-avalicao" value="1" onchange="escolhaAvaliacao(this);"><label for="n-melhorar">Atendeu minhas expectativas</label>
                                                                                </div>

                                                                                <script>
                                                                                    function escolhaAvaliacao(src) {
                                                                                        var opcao = src.value;

                                                                                        if (opcao == 0) {

                                                                                            document.getElementById("txt_comentAvaliacao").innerHTML = "<label class='py-2' for='coment-txt-avaliacao'>Observações ou melhorias a serem feitas (equipe)</label><textarea class='form-control' name='coment-txt-avaliacao' id='coment-txt-avaliacao' rows='3'></textarea>";

                                                                                        } else if (opcao == 1) {
                                                                                            document.getElementById("txt_comentAvaliacao").innerHTML = "";
                                                                                        }
                                                                                    }
                                                                                </script>
                                                                                <!--Caixa de texto para comentários:-->
                                                                                <p id="txt_comentAvaliacao"> </p><br><br>
                                                                                <br>
                                                                                <button type="submit" name="send" class="btn btn-primary">Enviar Avaliação</button>

                                                                            </div>
                                                                        </form>
                                                                    <?php
                                                                    } else {
                                                                    ?>

                                                                        <div class="text-center pt-4">
                                                                            <h4 style="color:#ee7624">Feedback Enviado!</h4>
                                                                            <p>Obrigado pela colaboração!</p>
                                                                        </div>

                                                                <?php
                                                                    }
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-relatorio" role="tabpanel" aria-labelledby="pills-relatorio-tab">
                                                        <div class="container-fluid">
                                                            <h3 class="px-3 pb-2" style="color: silver;">Projeto <?php echo $idProjeto; ?></h3>
                                                            <div class="px-3 pb-2 row d-flex justify-content-between">
                                                                <div class="col">
                                                                    <h6 class="py-2">Relatório de Atividades do Projeto</h6>
                                                                    <p>Dr: <?php echo $nomedr; ?></p>
                                                                    <p>Pac: <?php echo $nomepac; ?></p>
                                                                    <p>Produto: <?php echo $tipoProd; ?></p>
                                                                </div>
                                                                <div class="col" style="text-align: end;">
                                                                    <p>Início do Projeto: <?php echo $dtInicioProj; ?></p>
                                                                    <p>ID Projeto: <?php echo $idProjeto; ?></p>
                                                                    <p>Status: <span class="badge badge-info"><?php echo $nomeFluxo; ?></p></span>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            if (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)')) {
                                                                $ret = mysqli_query($conn, "SELECT * FROM visualizador WHERE visNumPed='$idProjeto';");
                                                                while ($row = mysqli_fetch_array($ret)) {
                                                            ?>
                                                                    <div class="border rounded p-3 m-4" style="border-style: dashed !important; border-color: silver; border-width: 3px !important;">
                                                                        <div class="d-flex justify-content-center">
                                                                            <form action="includes/uploadrelatorio.inc.php" method="post" enctype="multipart/form-data">
                                                                                <h5 style="color: silver;"><b>Upload de Relatórios</b></h5>
                                                                                <div class="row d-flex justify-content-center w-100">
                                                                                    <div class="col form-group">
                                                                                        <label class="form-label text-black" for="user">Usuário</label>
                                                                                        <input type="text" class="form-control" id="user" name="user" value="<?php if ($row['visUser'] == null) {
                                                                                                                                                                    echo $_SESSION['useruid'];
                                                                                                                                                                } else {
                                                                                                                                                                    echo $row['visUser'];
                                                                                                                                                                } ?>" readonly>
                                                                                    </div>
                                                                                    <div class="col form-group">
                                                                                        <label class="form-label text-black" for="nped">Nº Pedido</label>
                                                                                        <input type="text" class="form-control" id="nped" name="nped" value="<?php echo $row['visNumPed']; ?>" readonly>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col form-group">
                                                                                        <div class="mb-3">
                                                                                            <label for="arquivo" class="form-label">Selecione aqui o arquivo</label>
                                                                                            <input class="form-control" type="file" id="arquivo" name="arquivo">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="d-flex justify-content-center py-2">
                                                                                    <button type="submit" name="update" class="btn btn-success">Salvar</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>

                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                            <?php
                                                            $retRelatorio = mysqli_query($conn, "SELECT * FROM relatorios WHERE relNumPedRef='$idProjeto';");
                                                            while ($rowRelatorio = mysqli_fetch_array($retRelatorio)) {
                                                                if ($rowRelatorio['relStatus'] == 'VAZIO') {
                                                            ?>
                                                                    <div class="d-flex justify-content-center">
                                                                        <span class="alert alert-warning">Nenhum relatório disponível</span>
                                                                    </div>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <hr style="border-bottom: 1px solid silver;">
                                                                    <div class="d-flex justify-content-center">
                                                                        <h4 class="py-4">Novo Relatório disponível!</h4>
                                                                    </div>
                                                                    <?php
                                                                    $retFile = mysqli_query($conn, "SELECT * FROM relatorioupload WHERE fileNumPed= '" . $idProjeto . "' ;");
                                                                    while ($rowFile = mysqli_fetch_array($retFile)) {
                                                                        $nomearquivo = $rowFile['fileRealName'];
                                                                    }
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col d-flex justify-content-center">
                                                                            <a id="btndownload" class="btn btn-secondary" href="download.php?file=<?php echo $nomearquivo; ?>" download><i class="fas fa-file-download"></i> Baixar Relatório</a>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-docs-anvisa" role="tabpanel" aria-labelledby="pills-docs-anvisa-tab">
                                                        <?php
                                                        //contadores documentos
                                                        $contDr = 0;
                                                        $contPac = 0;

                                                        //pesquisar anexoidr
                                                        $retanexoidr = mysqli_query($conn, "SELECT * FROM qualianexoidr WHERE xidrIdProjeto='$pedID';");
                                                        while ($rowanexoidr = mysqli_fetch_array($retanexoidr)) {
                                                            $statusAnexoidr = $rowanexoidr['xidrStatusEnvio'];

                                                            switch ($statusAnexoidr) {
                                                                case 'VAZIO':
                                                                    $iconAnexoidr = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;

                                                                case 'ENVIADO':
                                                                    $iconAnexoidr = '<i style="color: green;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contDr++;
                                                                    break;

                                                                case 'EDITAR':
                                                                    $iconAnexoidr = '<i class="fas fa-exclamation-circle fa-1x"></i>';
                                                                    break;

                                                                case 'EDITADO':
                                                                    $iconAnexoidr = '<i style="color: #ffc107;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contDr++;
                                                                    break;

                                                                default:
                                                                    $iconAnexoidr = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;
                                                            }
                                                        }

                                                        //pesquisar anexoii
                                                        $retanexoii = mysqli_query($conn, "SELECT * FROM qualianexoii WHERE xiiIdProjeto='$pedID';");
                                                        while ($rowanexoii = mysqli_fetch_array($retanexoii)) {
                                                            $statusAnexoii = $rowanexoii['xiiStatusEnvio'];

                                                            switch ($statusAnexoii) {
                                                                case 'VAZIO':
                                                                    $iconAnexoii = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;

                                                                case 'ENVIADO':
                                                                    $iconAnexoii = '<i style="color: green;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contDr++;
                                                                    break;

                                                                case 'EDITAR':
                                                                    $iconAnexoii = '<i class="fas fa-exclamation-circle fa-1x"></i>';
                                                                    break;

                                                                case 'EDITADO':
                                                                    $iconAnexoii = '<i style="color: #ffc107;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contDr++;
                                                                    break;

                                                                default:
                                                                    $iconAnexoii = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;
                                                            }
                                                        }

                                                        //pesquisar anexoiiidr
                                                        $retanexoiiidr = mysqli_query($conn, "SELECT * FROM qualianexoiiidr WHERE xiiidrIdProjeto='$pedID';");
                                                        while ($rowanexoiiidr = mysqli_fetch_array($retanexoiiidr)) {
                                                            $statusAnexoiiidr = $rowanexoiiidr['xiiidrStatusEnvio'];

                                                            switch ($statusAnexoiiidr) {
                                                                case 'VAZIO':
                                                                    $iconAnexoiiidr = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;

                                                                case 'ENVIADO':
                                                                    $iconAnexoiiidr = '<i style="color: green;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contDr++;
                                                                    break;

                                                                case 'EDITAR':
                                                                    $iconAnexoiiidr = '<i class="fas fa-exclamation-circle fa-1x"></i>';
                                                                    break;

                                                                case 'EDITADO':
                                                                    $iconAnexoiiidr = '<i style="color: #ffc107;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contDr++;
                                                                    break;

                                                                default:
                                                                    $iconAnexoiiidr = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;
                                                            }
                                                        }

                                                        //pesquisar anexoipac
                                                        $retanexoipac = mysqli_query($conn, "SELECT * FROM qualianexoipac WHERE xipacIdProjeto='$pedID';");
                                                        while ($rowanexoipac = mysqli_fetch_array($retanexoipac)) {
                                                            $statusAnexoipac = $rowanexoipac['xipacStatusEnvio'];

                                                            switch ($statusAnexoipac) {
                                                                case 'VAZIO':
                                                                    $iconAnexoipac = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;

                                                                case 'ENVIADO':
                                                                    $iconAnexoipac = '<i style="color: green;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contPac++;
                                                                    break;

                                                                case 'EDITAR':
                                                                    $iconAnexoipac = '<i class="fas fa-exclamation-circle fa-1x"></i>';
                                                                    break;

                                                                case 'EDITADO':
                                                                    $iconAnexoipac = '<i style="color: #ffc107;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contPac++;
                                                                    break;

                                                                default:
                                                                    $iconAnexoipac = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;
                                                            }
                                                        }

                                                        //pesquisar anexoiiipac
                                                        $retanexoiiipac = mysqli_query($conn, "SELECT * FROM qualianexoiiipac WHERE xiiipacIdProjeto='$pedID';");
                                                        while ($rowanexoiiipac = mysqli_fetch_array($retanexoiiipac)) {
                                                            $statusAnexoiiipac = $rowanexoiiipac['xiiipacStatusEnvio'];

                                                            switch ($statusAnexoiiipac) {
                                                                case 'VAZIO':
                                                                    $iconAnexoiiipac = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;

                                                                case 'ENVIADO':
                                                                    $iconAnexoiiipac = '<i style="color: green;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contPac++;
                                                                    break;

                                                                case 'EDITAR':
                                                                    $iconAnexoiiipac = '<i class="fas fa-exclamation-circle fa-1x"></i>';
                                                                    break;

                                                                case 'EDITADO':
                                                                    $iconAnexoiiipac = '<i style="color: #ffc107;" class="fas fa-check-circle fa-1x"></i>';
                                                                    $contPac++;
                                                                    break;

                                                                default:
                                                                    $iconAnexoiiipac = '<i class="fas fa-minus-circle fa-1x"></i>';
                                                                    break;
                                                            }
                                                        }

                                                        if ($contDr == 3) {
                                                            $corContadorDr = 'success';
                                                        } else {
                                                            $corContadorDr = 'secondary';
                                                        }

                                                        if ($contPac == 2) {
                                                            $corContadorPac = 'success';
                                                        } else {
                                                            $corContadorPac = 'secondary';
                                                        }

                                                        ?>

                                                        <div class="row">
                                                            <div class="col-sm-6 d-flex justify-content-start">
                                                                <span class="btn btn-<?php echo $corContadorDr; ?> span-status-doc">Docs Doutor(a): <?php echo $contDr; ?>/3</span>
                                                            </div>
                                                            <div class="col-sm-6 d-flex justify-content-end">
                                                                <span class="btn btn-<?php echo $corContadorPac; ?> span-status-doc">Docs Paciente: <?php echo $contPac; ?>/2</span>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="lista-links">
                                                            <div class="col-sm-9"><br>
                                                                <h3>Documentos Doutor(a)</h3><br>
                                                                <a href="#" class="mb-2 pb-3">01 - Anexo I - Personalizados - Termo de responsabilidade</a><br><br>
                                                                <a href="#" class="mb-2 pb-3">02 - Anexo II - Personalizados - Laudo e CID</a><br><br>
                                                                <a href="#" class="mb-2 pb-3">03 - Anexo III - Personalizados - Dados Dr(a)</a><br><br><br>
                                                                <h3>Documentos Paciente</h3><br>
                                                                <a href="#" class="mb-2 pb-3">04 - Anexo I - Personalizados - Termo de responsabilidade</a><br><br>
                                                                <a href="#" class="mb-2 pb-3">05 - Anexo III - Personalizados - Dados Paciente</a><br><br>
                                                            </div>

                                                            <div class="col-sm-3"><br>
                                                                <h3></h3><br><br><br>
                                                                <a href="anexoidr?id=<?php echo $pedID; ?>" target="_blank" class="mb-2 pb-3"><i class="fas fa-external-link-alt external-link fa-1x"></i></a><span><?php echo $iconAnexoidr; ?></span> <br><br>
                                                                <a href="anexoii?id=<?php echo $pedID; ?>" target="_blank" class="mb-2 pb-3"><i class="fas fa-external-link-alt external-link fa-1x"></i></a><span><?php echo $iconAnexoii; ?></span> <br><br>
                                                                <a href="anexoiiidr?id=<?php echo $pedID; ?>" target="_blank" class="mb-2 pb-3"><i class="fas fa-external-link-alt external-link fa-1x"></i></a><span><?php echo $iconAnexoiiidr; ?></span> <br><br><br>
                                                                <h3></h3><br><br><br>
                                                                <a href="anexoipac?id=<?php echo $pedID; ?>" target="_blank" class="mb-2 pb-3"><i class="fas fa-external-link-alt external-link fa-1x"></i></a><span><?php echo $iconAnexoipac; ?></span> <br><br>
                                                                <a href="anexoiiipac?id=<?php echo $pedID; ?>" target="_blank" class="mb-2 pb-3"><i class="fas fa-external-link-alt external-link fa-1x"></i></a><span><?php echo $iconAnexoiiipac; ?></span> <br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show active" id="pills-inicio" role="tabpanel" aria-labelledby="pills-inicio-tab">
                                                        <div class="container-fluid">
                                                            <div class="py-2 row d-flex justify-content-between align-items-center">
                                                                <div class="col">
                                                                    <h3 class="pb-2" style="color: silver;">Projeto <?php echo $idProjeto; ?></h3>
                                                                    <p>Início do Projeto: <?php echo $dtInicioProj; ?></p>
                                                                    <p>Referente a Proposta: <?php echo $propID; ?></p>
                                                                </div>
                                                                <div class="col d-flex justify-content-end">
                                                                    <p>Status: <span class="badge badge-info"><?php echo $nomeFluxo; ?></p></span>
                                                                </div>
                                                            </div>


                                                            <form class="form-horizontal style-form " name="form1" action="includes/reenvioarquivos.inc.php" method="POST">
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="propid">Prop ID</label>
                                                                        <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $propID; ?>" readonly>
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
                                                                        <h4 class="text-conecta">Re-Envio de exames</h4>

                                                                        <b style="color: #ee7624;">ATENÇÃO! Certifique-se de que a tomografia foi realizada dentro de um prazo de 6 meses.</b>
                                                                        <p style="line-height: 1.25rem;">O laudo tomográfico deve ter correspondência (mesma data) às imagens tomográficas anexadas. A tomografia enviada deve ser acompanhada de seu laudo correspondente, conforme RDC 305/2019 e determinação da ANVISA</p>


                                                                        <div class="border border-5 rounded bg-light" style="border-style: dashed !important; border-width: 2px !important;">
                                                                            <div class="p-2 mb-2 bg-light text-dark rounded">
                                                                                <div class="row p-2">
                                                                                    <div class="col-md form-group ">
                                                                                        <label class='control-label text-black'>Anexe aqui a tomografia do paciente</label>
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
                                                                                        <label class='control-label text-black'>Anexe aqui o laudo da tomografia (TC) </label>
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
                                                                                        <label class='control-label text-black'>Anexe aqui modelos referentes ao caso </label>
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
                                                                                        <label class='control-label text-black'>Anexe aqui fotos referentes ao caso </label>
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
                                    <!-- <?php //include_once 'php/lateral_card.php'; 
                                            ?> -->
                                </div>
                            </div>
                            <div class="col-sm-1"></div>

                        </div>

                    </div>
                </div>

                <?php include_once 'php/footer_index.php' ?>

    <?php
        }
    }
} else {

    header("location: index");
    exit();
}

    ?>