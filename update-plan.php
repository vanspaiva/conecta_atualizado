<?php
session_start();
if (!empty($_GET)) {
    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Planejador(a)')) || (($_SESSION["userperm"] == 'Planej. Ortognática')) || ($_SESSION["userperm"] == 'Administrador')) || $_SESSION["useruid"] == "lenicomercial" || $_SESSION["useruid"] == "lenirodrigues" || $_SESSION["useruid"] == "thaissa" || $_SESSION["useruid"] == "samuel900" ) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $idGERAL = addslashes($_GET['id']);
        $existeAnalise = existeAnalise($conn, $idGERAL);
?>
        <!-- Add jQuery 1.8 or later to your page, 33 KB -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Get Fotorama from CDNJS, 19 KB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>


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

                .box-overall1,
                .box-overall2 {
                    z-index: 999;
                    background-color: #48484838;
                    position: absolute;

                }

                .change-color-on-hover:hover {
                    color: #323236 !important;
                }
            </style>

            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idGERAL . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $lista = $row['propListaItens'];
                $array_items = $row['propListaItensBD'];
                $array_items = explode(',', $array_items);

                $data = $row['propDataCriacao'];
                $nomedr = $row['propNomeDr'];
                $nomepac = $row['propNomePac'];
                $uf = $row['propUf'];

                $statusComercal = $row["propStatus"];

                $statusPedido = "";
                $numPed = "";
                $numFluxo = 5;
                $przStatus = "";
                $numPedOG = "";

                if ($row['propTxtReprov'] != null) {
                    $txtReprov = $row['propTxtReprov'];
                } else {
                    $txtReprov = null;
                }

                $projetista = "";
                if ($row['propProjetistas'] != null) {
                    $projetista = $row['propProjetistas'];
                }

                // $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplan WHERE imgplanNumProp='" . $_GET['id'] . "';");
                // while ($rowPic = mysqli_fetch_array($retPic)) {
                //     $picPathA = $rowPic['imgplanPathImgA'];
                //     $picPathB = $rowPic['imgplanPathImgB'];
                // }

                if ($row['propTxtComercial'] != null) {
                    $temComentarioComercial = true;
                    $comentComercial = $row['propTxtComercial'];
                } else {
                    $temComentarioComercial = false;
                    $comentComercial = '';
                }

                $userCriador = $row["propUserCriacao"];

                $retDist = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $userCriador . "';");
                while ($rowDist = mysqli_fetch_array($retDist)) {
                    $telDist = $rowDist['usersFone'];
                }

                // $retEtapa = mysqli_query($conn, "SELECT * FROM etapasanaliseplanejamento WHERE etpNumProp='" . $idGERAL . "';");
                // while ($rowEtapa = mysqli_fetch_array($retEtapa)) {
                //     $etapa = $rowEtapa["etpFluxo"];
                // }

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
                                $statusPedido = getStatusPedido($conn, $idGERAL);
                                $numPed = getNumPedido($conn, $idGERAL);
                                if ($numPed != null) {
                                    $retNumPed = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$numPed'");
                                    while ($rowNumPed = mysqli_fetch_array($retNumPed)) {
                                        $numFluxo = $rowNumPed['pedPosicaoFluxo'];
                                        $numFluxo = intval($numFluxo);
                                        $numFluxo = $numFluxo * 25;
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
                            } else if ($_GET["error"] == "pastacriada") {
                                echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Pasta da proposta criada!</p></div>";
                            }
                        }
                        ?>
                    </div>

                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm-1 d-flex justify-content-end align-items-center">
                                        <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                    <div class="col-sm-11 pt-2">
                                        <div class="row px-3" style="color: #fff">
                                            <h2 class="text-conecta" style="font-weight: 400;">Proposta Nº <span style="font-weight: 700;"><?php echo $idGERAL; ?><?php if ($row["propStatusTC"] == "REENVIADA") { ?><span class="badge bg-warning text-dark">REENVIADA</span><?php } ?> </span></h2>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #ee7624">
                                <br>
                                <div class="row d-flex justify-content-center">
                                    <div class="col d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="border-top: #ee7624 7px solid;">
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
                                                                    <small class="d-flex justify-content-center" style="color: silver; text-align: center;"> (CHAT CN x Planejamento)</small>
                                                                    <div class="rounded">

                                                                        <?php

                                                                        $idProjeto = $_GET['id'];

                                                                        $sql = "SELECT 
                                                                                c.comentVisUser, 
                                                                                c.comentVisText, 
                                                                                c.comentVisHorario, 
                                                                                c.comentVisTipoUser,
                                                                                m.nome, 
                                                                                m.path,
                                                                                COALESCE(c.comentVisHorario, m.data_upload) AS data
                                                                            FROM 
                                                                                comentariosproposta AS c
                                                                            LEFT JOIN 
                                                                                midias_comentarios_plan AS m ON c.comentVisId = m.idComentario
                                                                            WHERE 
                                                                                c.comentVisNumProp = \"$idProjeto\"

                                                                            UNION

                                                                            SELECT 
                                                                                c.comentVisUser, 
                                                                                c.comentVisText, 
                                                                                c.comentVisHorario, 
                                                                                c.comentVisTipoUser,
                                                                                m.nome, 
                                                                                m.path,
                                                                                m.data_upload AS data
                                                                            FROM 
                                                                                midias_comentarios_plan AS m
                                                                            LEFT JOIN 
                                                                                comentariosproposta AS c ON c.comentVisId = m.idComentario
                                                                            WHERE 
                                                                                c.comentVisId IS NULL  -- Garantir que estamos pegando registros de midias sem correspondência
                                                                            ORDER BY 
                                                                                data ASC;"; 

                                                                        $retMsg = mysqli_query($conn, $sql);


                                                                        while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                                            $msg = $rowMsg['comentVisText'];
                                                                            if($rowMsg['comentVisUser'] == null)
                                                                                $owner = $rowMsg['mediaUser'];
                                                                            else
                                                                                $owner = $rowMsg['comentVisUser'];

                                                                            if($rowMsg['comentVisHorario'] == null){

                                                                                $timer = $rowMsg['data'];
                                                                            }
                                                                            else
                                                                                $timer = $rowMsg['comentVisHorario'];


                                                                            $tipoUsuario = $rowMsg['comentVisTipoUser'];

                                                                            $nomeArq = $rowMsg['nome'];
                                                                            $arqPath = "includes/" . $rowMsg['path'];
                                                                            
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
                                                                                            <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 200px;">
                                                                                                <?php
                                                                                                    echo $msg . "<br>"; 
                                                                                                ?>
                                                                                                <a href="http://localhost:8092/projetos/conecta_atualizado/<?=$arqPath?>">
                                                                                                    <img style="margin: 5px;" height="50px" width="50px" src="<?=$arqPath?>" alt="imagem"
                                                                                                    <?php
                                                                                                        if($arqPath == "includes/") 
                                                                                                        echo "hidden"; 
                                                                                                    ?>
                                                                                                >
                                                                                                </a>
                                                                                            </p>

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
                                                                            <form action="includes/comentpropostaPlan.inc.php" method="post" enctype="multipart/form-data">
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

                                                                                                <div>
                                                                                                    <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
                                                                                                        <input type="file" name="file"/> 
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
                                        <div class="col-md">
                                            <div class="card p-2 my-2 shadow" style="border-top: #ee7624 7px solid;">
                                                <div class="card-body">
                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="d-flex justify-content-start">
                                                                    <div class="box-overall1 rouded p-2 m-2" hidden <?php // if($etapa < 2){ echo " hidden"; }
                                                                                                                    ?>>
                                                                        <span></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md border rounded p-2 m-2 etapa1Elem">
                                                                    <h4 style="color: silver;">Etapa 1 - Informações Adicionais</h4>
                                                                    <hr>
                                                                    <section id="main-content">
                                                                        <section class="wrapper">
                                                                            <div class="row px-3 d-flex justify-content-center">
                                                                                <div class="col-md">
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <h6 class="form-label text-black" for="nomedr">Dr(a)</h6>
                                                                                            <p><?php echo $row['propNomeDr']; ?></p>
                                                                                            <p>xxxx-xxxx<?php //echo $row['propTelefoneDr']; ?></p>
                                                                                            <p>xxxx@xxxx.com<?php //echo $row['propEmailDr']; ?></p>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                                                            <p><?php echo $row['propNomePac']; ?></p>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <h6 class="form-label text-black" for="emailenvio">Distribuidor</h6>
                                                                                            <p><?php echo $row['propEmpresa']; ?></p>
                                                                                            <p><?php echo $row['propEmailEnvio']; ?></p>
                                                                                            <p><?php echo $telDist; ?></p>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <h6 class="form-label text-black" for="representante">Representante</h6>
                                                                                            <p><?php echo $row['propRepresentante']; ?></p>
                                                                                        </div>
                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row px-3">
                                                                                <div class="col-md">
                                                                                    <h5 style="color: silver;">Devolutiva</h5>
                                                                                    <?php
                                                                                    include("formetapa1plan.php");
                                                                                    ?>

                                                                                </div>

                                                                            </div>
                                                                        </section>
                                                                    </section>
                                                                </div>
                                                                <div class="d-flex justify-content-start">
                                                                    <div class="box-overall2 rouded p-2 m-2" hidden <?php //if($etapa < 3){ echo "hidden"; }
                                                                                                                    ?>>
                                                                        <span></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md border rounded p-2 m-2 etapa2Elem">
                                                                    <h4 style="color: silver;">Etapa 2 - Status</h4>
                                                                    <hr>
                                                                    <div class="content-panel p-2">
                                                                        <form class="form-horizontal style-form" name="form1" action="includes/updateplan.inc.php" method="post" enctype="multipart/form-data">
                                                                            <div class="form-row" hidden>
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="propid">Prop ID</label>
                                                                                    <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                                                    <small class="text-muted">ID não é editável</small>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row p-2 mb-2 d-flex justify-content-center">
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="status">Status Prop <?php if ($row['propTxtComercial'] != null) { ?><span class="btn text-success px-2" data-toggle="modal" data-target="#vercomentario"><i class="fas fa-comments"></i></span><?php } ?></label>
                                                                                    <br>
                                                                                    <p class="badge bg-primary text-white"><?php echo $row['propStatus']; ?></p>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Modal Comentário Comercial-->
                                                                            <div class="modal fade" id="vercomentario" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title text-black">Comentário Comercial</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="container-fluid">
                                                                                                <div class="row d-flex">
                                                                                                    <div class="col-md">
                                                                                                        <div class="form-row p-2 mb-2 d-flex align-items-center" style="background-color: #f7f7f7; border-radius: 8px">
                                                                                                            <div class="form-group col-md">
                                                                                                                <span name="comentario" id="comentario"><?php echo $comentComercial; ?></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row p-2 mb-2 d-flex justify-content-center">
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="statustc"><b>Status TC</b></label>
                                                                                    <select name="statustc" class="form-control statustc" id="statustc" onchange="watchStatusTc(this)">
                                                                                        <?php
                                                                                        $retStatus = mysqli_query($conn, "SELECT * FROM statusplanejamento ORDER BY stplanIndiceFluxo ASC;");
                                                                                        while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                                        ?>
                                                                                            <option value="<?php echo $rowStatus['stplanNome']; ?>" <?php if ($row['propStatusTC'] == $rowStatus['stplanNome']) echo ' selected="selected"'; ?>> <?php echo $rowStatus['stplanNome']; ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>

                                                                                    </select>
                                                                                </div>
                                                                            </div>


                                                                            <script>
                                                                                window.onload = function() {
                                                                                    var initial = document.querySelector('.statustc');
                                                                                    watchStatusTc(initial);
                                                                                    // console.log(initial.value);
                                                                                };

                                                                                function watchStatusTc(value) {

                                                                                    var status = value.value;
                                                                                    var comentInput = document.querySelector('.coment');
                                                                                    var projInput = document.querySelector('.projetistas');
                                                                                    var arquivosInput = document.querySelector('.selectArquivos');

                                                                                    // if (status.includes('REPROVADA')) {
                                                                                    //     comentInput.hidden = false;
                                                                                    // } else {
                                                                                    //     comentInput.hidden = true;
                                                                                    // }

                                                                                    // if (status.includes('APROVADA')) {
                                                                                    //     projInput.hidden = false;
                                                                                    // } else {
                                                                                    //     projInput.hidden = true;
                                                                                    // }

                                                                                    if (status.includes('APROVADA')) {

                                                                                        projInput.hidden = false;
                                                                                        comentInput.hidden = false;
                                                                                        arquivosInput.hidden = true;

                                                                                    } else if (status.includes('REPROVADA')) {

                                                                                        projInput.hidden = true;
                                                                                        comentInput.hidden = false;
                                                                                        if (status.includes('ARQUIVO')) {
                                                                                            arquivosInput.hidden = false;
                                                                                        } else {
                                                                                            arquivosInput.hidden = true;
                                                                                        }

                                                                                    }

                                                                                }
                                                                            </script>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-4 projetistas" hidden>
                                                                                    <label class="form-label text-black" for="projetista">Técnico</label>
                                                                                    <select name="projetista" class="form-control" id="projetista">
                                                                                    <option value="0">Escolha um projetista...</option>
                                                                                        <?php
                                                                                        $retTecnico = mysqli_query($conn, "SELECT * FROM responsavelagenda r INNER JOIN users u ON r.responsavelagendaNome = u.usersUid ORDER BY `u`.`usersName` ASC;");
                                                                                        while ($rowTecnico = mysqli_fetch_array($retTecnico)) {
                                                                                            $firstName = getPrimeiroNome($rowTecnico['usersName']);
                                                                                        ?>
                                                                                            <option value="<?php echo $rowTecnico['responsavelagendaNome']; ?>" <?php if ($projetista == $rowTecnico['responsavelagendaNome']) echo ' selected="selected"'; ?>><?php echo $firstName; ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="container" hidden>
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <label for="nprop">Nº Pedido</label>
                                                                                            <input type="text" class="form-control" name="nprop2" id="nprop2" value="<?php echo $idProjeto; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            <label for="user">Usuário</label>
                                                                                            <input type="text" class="form-control" name="user2" id="user2" value="<?php echo $_SESSION['useruid']; ?>" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-md coment" hidden>
                                                                                    <label class="form-label text-black" for="textReprov">Comentário</label>
                                                                                    <textarea class="form-control" name="textReprov" id="textReprov" cols="30" rows="3"><?php echo $txtReprov; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row selectArquivos" hidden>
                                                                                <label class="form-label text-black">Selecione os arquivos faltantes</label>
                                                                                <div class="form-group col-md d-flex justify-content-center">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="checkbox" id="tcCheck" value="tc">
                                                                                        <label class="form-check-label" for="tcCheck">TC</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="checkbox" id="laudoCheck" value="laudo">
                                                                                        <label class="form-check-label" for="laudoCheck">Laudo</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="checkbox" id="modeloCheck" value="modelo">
                                                                                        <label class="form-check-label" for="modeloCheck">Modelo</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="checkbox" id="imagemCheck" value="imagem">
                                                                                        <label class="form-check-label" for="imagemCheck">Imagens</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <?php
                                                                                // <div class="form-group col-md">

                                                                                //         include("new-upload1.php");

                                                                                //     </div>
                                                                                ?>
                                                                                <div class="form-group col-md">
                                                                                    <?php
                                                                                    include("new-upload2.php");
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="d-flex justify-content-end">
                                                                                <button type="submit" name="update" class="btn btn-primary">Salvar</button>
                                                                            </div>
                                                                        </form>

                                                                        <!--<div class="form-row">
                                                            <div class="form-group">
                                                                <div class="fotorama">
                                                                    <img src="https://ucarecdn.com/90b7c795-721a-4799-9741-929eb6b59dae/-/preview/500x500/">
                                                                    <img src="https://ucarecdn.com/c458a82e-05a2-4eee-8925-972484d073b9/-/preview/500x500/">
                                                                    <img src="https://ucarecdn.com/0afd873d-11a5-453a-89e5-9a9f38c863a1/-/preview/500x500/">
                                                                    <img src="https://ucarecdn.com/b87fb787-8df2-4cd7-97ba-d3dbc121cb19/-/preview/500x500/">
                                                                </div>
                                                            </div>
                                                        </div>-->

                                                                        <!-- Modal Fotos
                                                                        <div class="modal fade" id="verfotosA" tabindex="-1" role="dialog" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title text-black">Fotos Projeto (caso bom)</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="container-fluid d-flex justify-content-center">
                                                                                            <div class="row w-100 ">
                                                                                                <div class="col ">
                                                                                                    <iframe src="<?php //echo $picPathA; 
                                                                                                                    ?>/gallery/-/nav/thumbs/-/fit/cover/-/loop/true/-/allowfullscreen/native/-/thumbwidth/100/" width="100%" height="600" allowfullscreen="true" frameborder="0">
                                                                                                    </iframe>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>-->

                                                                        <!-- Modal Fotos-->
                                                                        <div class="modal fade" id="verfotosB" tabindex="-1" role="dialog" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title text-black">Fotos Projeto (caso reprovado)</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="container-fluid d-flex justify-content-center">
                                                                                            <div class="row w-100 ">
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


                                                                        <script>
                                                                            function copyText() {
                                                                                /* Get the text field */
                                                                                var copyText = document.getElementById("folderId");

                                                                                /* Select the text field */
                                                                                copyText.select();
                                                                                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                                                                                /* Copy the text inside the text field */
                                                                                navigator.clipboard.writeText(copyText.value);

                                                                                /* Alert the copied text */
                                                                                alert("Link copiado: " + copyText.value);
                                                                            }
                                                                        </script>




                                                                    </div>
                                                                </div>
                                                                <!--<div class="col-md border rounded p-2 m-2">
                                                        <h4 style="color: silver;">Etapa 3 - Imagens TC</h4>
                                                        <hr>
                                                        <div class="content-panel p-2">
                                                            <form class="form-horizontal style-form" name="form1" action="includes/updateplanform3.inc.php" method="post" enctype="multipart/form-data">
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="propid">Prop ID</label>
                                                                        <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    window.onload = function() {
                                                                        var initial = document.querySelector('.statustc');
                                                                        watchStatusTc(initial);
                                                                        // console.log(initial.value);
                                                                    };

                                                                    function watchStatusTc(value) {

                                                                        var status = value.value;
                                                                        var comentInput = document.querySelector('.coment');
                                                                        var projInput = document.querySelector('.projetistas');
                                                                        var arquivosInput = document.querySelector('.selectArquivos');

                                                                        // if (status.includes('REPROVADA')) {
                                                                        //     comentInput.hidden = false;
                                                                        // } else {
                                                                        //     comentInput.hidden = true;
                                                                        // }

                                                                        // if (status.includes('APROVADA')) {
                                                                        //     projInput.hidden = false;
                                                                        // } else {
                                                                        //     projInput.hidden = true;
                                                                        // }

                                                                        if (status.includes('APROVADA')) {

                                                                            projInput.hidden = false;
                                                                            comentInput.hidden = false;
                                                                            arquivosInput.hidden = true;

                                                                        } else if (status.includes('REPROVADA')) {

                                                                            projInput.hidden = true;
                                                                            comentInput.hidden = false;
                                                                            if (status.includes('ARQUIVO')) {
                                                                                arquivosInput.hidden = false;
                                                                            } else {
                                                                                arquivosInput.hidden = true;
                                                                            }

                                                                        }

                                                                    }
                                                                </script>


                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <?php
                                                                        require_once 'includes/dbh.inc.php';

                                                                        $id = $_GET['id'];

                                                                        $retPic2 = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $id . "';");

                                                                        if (($retPic2) && ($retPic2->num_rows != 0)) {
                                                                            while ($rowPic2 = mysqli_fetch_array($retPic2)) {
                                                                                $picPathB = $rowPic2['imgplanPathImg'];
                                                                            }
                                                                        } else {
                                                                            $picPathB = "none";
                                                                        }
                                                                        ?>

                                                                        <script>
                                                                            // $(document).ready(function() {
                                                                            //     var elem = document.getElementById("cdnurl2").value;
                                                                            //     if (elem != "none") {
                                                                            //         // console.log(elem);
                                                                            //         create_imgB(elem);
                                                                            //     }

                                                                            // });


                                                                            // function create_imgB(elem) {
                                                                            //     var img = document.createElement('img');
                                                                            //     img.src = elem;
                                                                            //     img.classList.add("thumbnail");
                                                                            //     document.getElementById('image-preview2').appendChild(img);
                                                                            // }
                                                                        </script>


                                                                        <div class="py-4">
                                                                            <div class="row">
                                                                                <div class="col-md form-group ">
                                                                                    <label class='control-label text-black'><b>Laudo Planejamento</b></label>
                                                                                    <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                                        <div>
                                                                                            <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile2" hidden></i></h2>
                                                                                            <p class="uploader-conecta-button" id="widget2">
                                                                                                <input id="foto2" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file file gdrive dropbox" data-multiple="false" data-images-only="true" data-preview-step="true" />
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <script>
                                                                                        // var NUMBER_STORED_FILES = 0;
                                                                                        // const widget2 = uploadcare.Widget("#foto2", {
                                                                                        //     publicKey: 'fe82618d53dc578231ce'
                                                                                        // });

                                                                                        // widget2.onUploadComplete(info => {

                                                                                        //     var filename = info.name;
                                                                                        //     var cdnurl = info.cdnUrl;

                                                                                        //     document.getElementById("filename2").value = filename;
                                                                                        //     document.getElementById("cdnurl2").value = cdnurl;
                                                                                        //     document.getElementById("checkfile2").hidden = false;
                                                                                        // });
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
                                                                            //<div class="row d-flex justify-content-center" id="image-preview2"> </div>-
                                                                        </div>
                                                                        <div class="py-4" hidden>
                                                                            <div class="row">
                                                                                <div class="col-md form-group">
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="filename2">File Name</label>
                                                                                        <input class="form-control" name="filename2" id="filename2" type="text" readonly>
                                                                                    </div>
                                                                                    <div class="form-group d-inline-block flex-fill">
                                                                                        <label class="control-label" style="color:black;" for="cdnurl2">Cdn Url</label>
                                                                                        <input class="form-control" name="cdnurl2" id="cdnurl2" type="text" value="<?php echo $picPathB; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <?php
                                                                        if (isset($_POST["saveimg2"])) {

                                                                            $filename2 = addslashes($_POST["filename2"]);
                                                                            $cdnurl2 = addslashes($_POST["cdnurl2"]);

                                                                            require_once 'includes/functions.inc.php';

                                                                            uploadArquivoRefTCB($conn, $filename2, $cdnurl2, $id);
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="update" class="btn btn-primary">Salvar</button>
                                                                </div>
                                                            </form>

                                                            <script>
                                                                function copyText() {
                                                                    /* Get the text field */
                                                                    var copyText = document.getElementById("folderId");

                                                                    /* Select the text field */
                                                                    copyText.select();
                                                                    copyText.setSelectionRange(0, 99999); /* For mobile devices */

                                                                    /* Copy the text inside the text field */
                                                                    navigator.clipboard.writeText(copyText.value);

                                                                    /* Alert the copied text */
                                                                    alert("Link copiado: " + copyText.value);
                                                                }
                                                            </script>




                                                        </div>
                                                    </div>-->
                                                            </div>
                                                        </section>
                                                    </section>

                                                </div>
                                            </div>

                                            <div class="card m-1 shadow my-3" style="background-color: #ee7624;">
                                                <div class="card-body container-fluid">
                                                    <div class="row d-flex justify-content-center py-2">
                                                        <div class="col d-flex justify-content-center">
                                                            <h5 style="color: white; text-align: center;"><b>Comentários do Cliente</b></h5>
                                                        </div>
                                                    </div>

                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md d-flex justify-content-center">

                                                            <?php
                                                            $idProjeto = $idGERAL;
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

                                            <div class="card p-2 my-2 shadow">
                                                <div class="card-body">
                                                    <h4 style="color: silver;" class="pb-3">Informações Proposta</h4>
                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col-md">
                                                                    <div class="form-row bg-light-gray2 rounded shadow d-flex justify-content-center align-items-center">
                                                                        <div class="form-group col-md p-2">
                                                                            <h5 class="form-label text-black d-flex justify-content-center align-items-center" for="tipoProd"><b>Produto</b></h6>
                                                                                <span class="d-flex justify-content-center" style="color: #ee7624;"><b><?php echo $row['propTipoProd'];
                                                                                                                                                        if ($row['propEspessura'] != null) {
                                                                                                                                                            echo " - " . $row['propEspessura'];
                                                                                                                                                        } ?></b></span>
                                                                        </div>
                                                                    </div>
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
                                                                                $retItens = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $id . "';");
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

                                                                    <!--<div class="form-row mt-4">
                                                                        <div class="form-group col-md d-flex justify-content-center">
                                                                            <?php
                                                                            //$retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $idGERAL . "' ;");
                                                                            //while ($rowFile = mysqli_fetch_array($retFile)) {
                                                                            ?>
                                                                                //!--<a href="download?file=<?php //echo $rowFile['fileRealName'] 
                                                                                                            ?>" class="btn btn-outline-secondary"><i class="bi bi-cloud-arrow-down"></i> Download TC</a>--
                                                                                <div class="container-fluid">
                                                                                    <div class="row d-flex justify-content-center">
                                                                                        <a href="<?php //echo $rowFile['fileCdnUrl']; 
                                                                                                    ?>" class="btn btn-outline-secondary" target="_blank"><i class="bi bi-cloud-arrow-down"></i> Download TC</a>
                                                                                    </div>
                                                                                    <div class="row d-flex justify-content-center">
                                                                                        <div class="col">
                                                                                            <small class="text-muted py-2">Link Pasta: <input class="form-control pointer" style="color: #ee7624;" onclick="copyText()" id="folderId" value="<?php //echo $rowFile['fileCdnUrl']; 
                                                                                                                                                                                                                                                ?>" readonly /></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php

                                                                            //}
                                                                            ?>

                                                                        </div>
                                                                    </div>-->
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="border-top: #ee7624 7px solid;">
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
                                                                            <p>Prazo (desta fase):
                                                                                <span class="text-conecta"><b>
                                                                                        <?php
                                                                                        if ($statusComercal == "PEDIDO") {
                                                                                            echo $dataPrazoContada;
                                                                                        } else {
                                                                                            echo "Não disponível";
                                                                                        }
                                                                                        ?>
                                                                                    </b></span>
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
                                            <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="background-color: #ee7624;">
                                                <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                                    <div class="container-fluid text-center">
                                                        <div class="row">
                                                            <div class="col d-flex justify-content-center">
                                                                <div class="p-1">
                                                                    <div>
                                                                        <h5 style="color: white; text-align: center;" class="py-2">Pasta de Arquivos</h5>

                                                                        <div class="form-row mt-4">
                                                                            <div class="form-group col-md d-flex justify-content-center">
                                                                                <?php
                                                                                $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $idGERAL . "' ;");
                                                                                while ($rowFile = mysqli_fetch_array($retFile)) {
                                                                                    if (($rowFile['fileCdnUrl'] != null)) {
                                                                                ?>
                                                                                        <div class="container-fluid">
                                                                                            <div class="row d-flex justify-content-center">
                                                                                                <a href="<?php echo $rowFile['fileCdnUrl']; ?>" class="btn btn-outline-light" target="_blank"><i class="bi bi-cloud-arrow-down"></i> Download TC</a>
                                                                                            </div>
                                                                                            <div class="row d-flex justify-content-center py-2">
                                                                                                <div class="col">
                                                                                                    <small class="text-white py-2">Link Pasta: <input class="form-control pointer" style="color: #ee7624;" onclick="copyText()" id="folderId" value="<?php echo $rowFile['fileCdnUrl']; ?>" readonly /></small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <div class="container-fluid">
                                                                                            <div class="row d-flex justify-content-center">
                                                                                                <a href="criarpastaapi?id=<?php echo $idGERAL; ?>&data=<?php echo $data; ?>&nomedr=<?php echo $nomedr; ?>&nomepac=<?php echo $nomepac; ?>&uf=<?php echo $uf; ?>" class="btn btn-outline-light change-color-on-hover" target="_blank"><i class="fas fa-folder-open"></i> Criar Pasta</a>
                                                                                            </div>
                                                                                        </div>
                                                                                <?php
                                                                                    }
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
                                            </div>
                                            <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="border-top: #ee7624 7px solid;">
                                                <div class="card-body container-fluid">
                                                    <div class="row d-flex">
                                                        <div class="col-md">
                                                            <?php
                                                            if (!$existeAnalise) {
                                                            ?>
                                                                <div class="row d-flex justify-content-around aling-items-center py-1">
                                                                    <div class="form-group text-center col-md">
                                                                        <p style="line-height: normal;">Análise de TC ainda não foi feita pelo Representante (<?php echo $row['propRepresentante']; ?>)</p>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            } else {
                                                                $resultado = $existeAnalise['aprovStatus'];
                                                            ?>
                                                                <div class="row d-flex justify-content-between aling-items-center py-1">
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
                                                                        <span class="btn btn-conecta" data-toggle="modal" data-target="#relatorioanalise"> <i class="fas fa-print"></i> Relatório da Análise </span>

                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
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

                                <!--
                            <div class="card p-2 m-4 shadow">
                                <div class="card-body">
                                    <h4 style="color: silver;">Informações Adicionais</h4>
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md">
                                                    <hr>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-3">
                                                            <h6 class="form-label text-black" for="nomedr">Dr(a)</h6>
                                                            <p><?php echo $row['propNomeDr']; ?></p>
                                                            <p><?php echo $row['propTelefoneDr']; ?></p>
                                                        </div>
                                                        
                                                        <div class="form-group col-md-3">
                                                            <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                            <p><?php echo $row['propNomePac']; ?></p>
                                                        </div>
                                                        
                                                       
                                                        <div class="form-group col-md-3">
                                                            <h6 class="form-label text-black" for="representante">Representante</h6>
                                                            <p><?php echo $row['propRepresentante']; ?></p>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <h6 class="form-label text-black" for="emailenvio">Distribuidor</h6>
                                                            <p><?php echo $row['propEmpresa']; ?></p>
                                                            <p><?php echo $row['propEmailEnvio']; ?></p>
                                                            <p><?php echo $telDist; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                    </section>
                                </div>
                            </div>-->
                            <?php } ?>
                            </div>
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

    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}


?>