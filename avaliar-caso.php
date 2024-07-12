<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        $idPed = addslashes($_GET['id']);



        $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedId='" . $idPed . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $numeroCaso = $row['pedNumPedido'];
            $encrypted = hashItemNatural($numeroCaso);
            $produto = $row['pedTipoProduto'];
            $observacao = $row['pedObservacao'];
            $idProjeto = $row['pedNumPedido'];

            $status = $row['pedStatus'];

            $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propPedido=" . $numeroCaso . ";");
            while ($rowProp = mysqli_fetch_array($retProp)) {
                if ($rowProp["propEspessura"] != null) {
                    $produto = $produto . " - " . $rowProp["propEspessura"];
                }
            }

        ?>
            <div id="main" class="font-montserrat">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Salvo com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="py-4 d-flex justify-content-center">
                        <div class="container-fluid">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-center' id='back'>
                                        <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="">
                                        <h2 class="text-conecta" style="font-weight: 400;">Informações do Caso <span style="font-weight: 700;"><?php echo $numeroCaso ?></span>
                                            <a href="unit?id=<?php echo $encrypted; ?>">
                                                <button class="btn text-conecta"><i class="fas fa-eye fa-2x"></i></button>
                                            </a>
                                        </h2>
                                        <p class="text-muted"> Os formulários abaixo são independentes, atente-se para salvá-los separadamente.</p>
                                    </div>
                                </div>
                            </div>
                            <hr style="border: 1px solid #ee7624">
                            <br>
                            <div class="row d-flex justify-content-center">
                                <!--Cartão Esquerda Chat-->
                                <div class="col-sm-3">
                                    <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "sentcoment") {
                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p style='line-height: 1.5rem;'>Comentário enviado!</p></div>";
                                        } else if ($_GET["error"] == "errorcoment") {
                                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p style='line-height: 1.5rem;'>Falha ao enviar o comentário!</p></div>";
                                        }
                                    }
                                    ?>

                                    <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="border-top: #ee7624 7px solid; ">
                                        <h5 style="color: silver; text-align: center;">Comentários</h5>
                                        <small class="d-flex justify-content-center pt-2 pb-4" style="color: silver; text-align: center;"> (CHAT Dr(a) x Planejamento)</small>
                                    </div>

                                    <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="max-height: 500px; overflow-y: scroll;" id="cardCommentarios">
                                        <div class="card-body container-fluid">
                                            <div class="row d-flex">
                                                <div class="col-md">
                                                    <div>
                                                        <div>
                                                            <div class="rounded">

                                                                <?php
                                                                // $idProjeto = $_GET['id'];
                                                                // echo $idProjeto;

                                                                $retMsg = mysqli_query($conn, "SELECT * FROM comentariosvisualizador WHERE comentVisNumPed='$idProjeto' ORDER BY comentVisId ASC");


                                                                while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                                    $msg = $rowMsg['comentVisText'];
                                                                    $owner = $rowMsg['comentVisUser'];
                                                                    $timer = $rowMsg['comentVisHorario'];
                                                                    $tipoUsuario = $rowMsg['comentVisTipoUser'];

                                                                    $timer = explode(" ", $timer);
                                                                    $data = dateFormat3($timer[0]);
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
                                                                            $ownerColor = 'vermelho';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        case 'Representante':
                                                                            $ownerColor = 'rosa';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        case 'Comercial':
                                                                            $ownerColor = 'azul';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        case 'Planejador(a)':
                                                                            $ownerColor = 'lilas';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        case 'Planej. Ortognática':
                                                                            $ownerColor = 'lilas';
                                                                            $hourColor = "#fff";
                                                                            break;
                                                                        case 'Financeiro':
                                                                            $ownerColor = 'verde-escuro';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        case 'Qualidade':
                                                                            $ownerColor = 'marrom';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        case 'Doutor(a)':
                                                                            $ownerColor = 'verde';
                                                                            $hourColor = "#fff";
                                                                            break;

                                                                        default:
                                                                            $ownerColor = 'conecta';
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
                                                                                <div class="bg-<?php echo $ownerColor; ?> text-white rounded rounded-3 px-2 py-1">
                                                                                    <h6><b><?php echo $owner; ?>:</b></h6>
                                                                                    <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 200px;"><?php echo $msg; ?></p>
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
                                                                    <form action="includes/comentCaso.inc.php" method="post">
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

                                <div class="col-6">
                                    <div class="card shadow h-100">
                                        <div class="card-header">
                                            <h5 class="text-muted">Informações do Caso</h5>
                                        </div>
                                        <div class="card-body">
                                            <section id="main-content">
                                                <section class="wrapper">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="content-panel">
                                                                <form class="form-horizontal style-form" name="form1" action="includes/updatecasos.inc.php" method="post">

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="tecnico">Técnico</label>
                                                                            <p><?php echo $row['pedTecnico']; ?></p>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="numped">Nº do Pedido <a href="update-caso?id=<?php echo $idPed; ?>">
                                                                                    <span class="btn text-conecta"><i class="fas fa-edit"></i></span>
                                                                                </a></label>
                                                                            <p><?php echo $row['pedNumPedido']; ?></p>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="numprop">Nº da Prop. (Ref) <a href="update-plan?id=<?php echo $row['pedPropRef']; ?>" class="text-conecta"><i class="fas fa-link"></i></a> </label>
                                                                            <p><?php echo $row['pedPropRef']; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="nomedr">Doutor(a)</label>
                                                                            <p><?php echo $row['pedNomeDr']; ?></p>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="nomepac">Paciente</label>
                                                                            <p><?php echo $row['pedNomePac']; ?></p>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="tipoproduto">Tipo Produto</label>
                                                                            <p><?php echo $produto; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="observacao">Observação</label>
                                                                            <p><?php echo $observacao; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md">
                                                                            <div class="p-2">
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

                                                                                        <div class="d-flex justify-content-center">
                                                                                            <h4 class="py-4">Relatório do Projeto disponível!</h4>
                                                                                        </div>
                                                                                        <?php
                                                                                        $retFile = mysqli_query($conn, "SELECT * FROM relatorios WHERE relNumPedRef= '" . $idProjeto . "' ;");
                                                                                        while ($rowFile = mysqli_fetch_array($retFile)) {
                                                                                            $urlDownload = $rowFile['relPath'];
                                                                                        }
                                                                                        ?>
                                                                                        <div class="row">
                                                                                            <div class="col d-flex justify-content-center">
                                                                                                <a id="btndownload" class="btn btn-conecta" href="<?php echo $urlDownload; ?>" target="_blank"><i class="fas fa-file-download"></i> Baixar Relatório</a>
                                                                                            </div>
                                                                                        </div>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md">
                                                                            <div class="bg-visualizar">
                                                                                <?php
                                                                                $retUrl = mysqli_query($conn, "SELECT * FROM visualizador WHERE visNumPed='$idProjeto'");

                                                                                if (($retUrl) && ($retUrl->num_rows != 0)) {
                                                                                    while ($rowUrl = mysqli_fetch_array($retUrl)) {
                                                                                        $url = $rowUrl['visUrl3D'];
                                                                                        $url2 = $rowUrl['visUrl3D2'];
                                                                                    }
                                                                                    $items = explode(".in/", $url);
                                                                                    $end = $items[1];
                                                                                    $items2 = explode(".in/", $url2);
                                                                                    $end2 = $items2[1];
                                                                                } else {
                                                                                    $url = "";
                                                                                    $end = "";
                                                                                }
                                                                                ?>
                                                                                <div class="container-fluid">
                                                                                    <!-- <div class="row d-flex justify-content-between align-items-start bg-light py-2">
                                                                                        <div class="col-sm-6 d-flex justify-content-center align-items-center" >
                                                                                            <h3 class="p-2 text-conecta text-center">Caso Inicial</h3>
                                                                                        </div>
                                                                                        <div class="col-sm-6 d-flex justify-content-center align-items-center">
                                                                                            <h3 class="p-2 text-conecta text-center">Projeto</h3>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row d-flex justify-content-between align-items-start bg-light py-2">
                                                                                        <div class="col-sm-6 d-flex justify-content-center align-items-center py-3" style="height: 500px;">
                                                                                            <iframe class="rounded " allowfullscreen webkitallowfullscreen style="min-width: 300px; ;width: 25vw;" height="480" frameborder="0" seamless src="https://p3d.in/e/<?php echo $end; ?>+shading,dl,help,share,spin,link-hidden"></iframe>
                                                                                        </div>
                                                                                        <div class="col-sm-6 d-flex justify-content-center align-items-center py-3" style="height: 500px;">
                                                                                            <iframe class="rounded " allowfullscreen webkitallowfullscreen style="min-width: 300px; ;width: 25vw;" height="480" frameborder="0" seamless src="https://p3d.in/e/<?php echo $end2; ?>+shading,dl,help,share,spin,link-hidden"></iframe>
                                                                                        </div>
                                                                                    </div> -->

                                                                                    <div class="row d-flex justify-content-between align-items-start bg-light py-2">
                                                                                        <div class="col-sm-6 d-flex justify-content-center align-items-center py-3" style="height: 500px;">
                                                                                            <div class="container-fluid">
                                                                                                <div class="row d-flex justify-content-center">
                                                                                                    <h4 style="color:#ee7624">Caso Inicial</h4>
                                                                                                </div>
                                                                                                <div class="row d-flex justify-content-center">
                                                                                                    <iframe class="rounded " allowfullscreen webkitallowfullscreen style="min-width: 300px; ;width: 25vw;" height="480" frameborder="0" seamless src="https://p3d.in/e/<?php echo $end2; ?>+shading,dl,help,share,spin,link-hidden"></iframe>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                        <div class="col-sm-6 d-flex justify-content-center align-items-center py-3" style="height: 500px;">
                                                                                            <div class="container-fluid">
                                                                                                <div class="row d-flex justify-content-center">
                                                                                                    <h4 style="color:#ee7624">Projeto</h4>
                                                                                                </div>
                                                                                                <div class="row d-flex justify-content-center">
                                                                                                    <iframe class="rounded " allowfullscreen webkitallowfullscreen style="min-width: 300px; ;width: 25vw;" height="480" frameborder="0" seamless src="https://p3d.in/e/<?php echo $end; ?>+shading,dl,help,share,spin,link-hidden"></iframe>

                                                                                                </div>

                                                                                            </div>
                                                                                        </div>

                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-3 container-fluid">
                                    <div class="row pb-4">
                                        <div class="col">
                                            <div class="card shadow h-100">
                                                <div class="card-header">
                                                    <h5 class="text-muted">Formulário Avaliação Interna</h5>
                                                </div>
                                                <div class="card-body bg-visualizar">
                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="content-panel">
                                                                        <form class="form-horizontal style-form border p-4" name="form1" action="includes/avaliar-caso.inc.php" method="post">
                                                                            <div class="form-row" hidden>
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="casoId">Caso ID</label>
                                                                                    <input type="number" class="form-control" id="casoId" name="casoId" value="<?php echo $row['pedId']; ?>" required readonly>
                                                                                    <small class="text-muted">ID não é editável</small>
                                                                                </div>
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="ped">Num Ped</label>
                                                                                    <input type="number" class="form-control" id="ped" name="ped" value="<?php echo $row['pedNumPedido']; ?>" required readonly>
                                                                                    <small class="text-muted">ID não é editável</small>
                                                                                </div>
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="user">usuario</label>
                                                                                    <input type="text" class="form-control" id="user" name="user" value="<?php echo $_SESSION['useruid']; ?>" required readonly>
                                                                                </div>

                                                                            </div>
                                                                            <p style="line-height: 1.5rem;" class="text-muted"><b>Preencha o formulário de acordo com o projeto ao lado. Caso tenha alguma alteração, descreva detalhadamente antes de liberar para vídeo.</b></p>
                                                                            <hr>

                                                                            <h5 class="text-conecta"> <b>Projeto pode ser liberado?</b></h5>
                                                                            <div class="py-4 d-flex">
                                                                                <span class="btn btn-success px-2 mx-2" onclick="clicarSim()" id="fakebtn1">Liberar</span>
                                                                                <span class="btn btn-warning px-2 mx-2" onclick="clicarNao()" id="fakebtn2">Solicitar alterações</span>
                                                                            </div>
                                                                            <div class="py-4" hidden>
                                                                                <input type="radio" id="simradio" name="op-aceite" value="1" onchange="escolhaAceite(this);"><label for="sim" class="px-2">Liberar</label>
                                                                                <br>
                                                                                <input type="radio" id="naoradio" name="op-aceite" value="0" onchange="escolhaAceite(this);"><label for="nao" class="px-2">Solicitar alterações</label>
                                                                            </div>

                                                                            <script>
                                                                                function escolhaAceite(src) {
                                                                                    var opcao = src.value;

                                                                                    if (opcao == 0) {
                                                                                        document.getElementById("txt_comentAceite").innerHTML = "<label class='pt-2' for='coment-txt-aceite' style='line-height:1.5rem;'><i class='fa-solid fa-triangle-exclamation text-warning'></i> Observações ou melhorias a serem feitas (projeto). Não esqueça de <b> enviar</b> sua escolha.</label><textarea class='form-control' name='coment-txt-aceite' id='coment-txt-aceite' rows='3'></textarea>";

                                                                                    } else if (opcao == 1) {
                                                                                        document.getElementById("txt_comentAceite").innerHTML = "<label> <i class='fa-solid fa-circle-check text-success'></i> Projeto será liberado! Não esqueça de <b> enviar</b> sua escolha.</label>";
                                                                                    }
                                                                                }

                                                                                function clicarSim() {
                                                                                    var radioButton = document.getElementById("simradio");
                                                                                    var radioButton1 = document.getElementById("fakebtn1");
                                                                                    var radioButton2 = document.getElementById("fakebtn2");

                                                                                    radioButton.click();

                                                                                    radioButton2.disabled = true;
                                                                                    radioButton1.classList.add("btn-success");
                                                                                    radioButton2.classList.remove("btn-warning");
                                                                                    radioButton2.classList.add("btn-secondary");

                                                                                }

                                                                                function clicarNao() {
                                                                                    var radioButton = document.getElementById("naoradio");
                                                                                    var radioButton1 = document.getElementById("fakebtn2");
                                                                                    var radioButton2 = document.getElementById("fakebtn1");

                                                                                    radioButton.click();

                                                                                    radioButton2.disabled = true;
                                                                                    radioButton1.classList.add("btn-warning");
                                                                                    radioButton2.classList.remove("btn-success");
                                                                                    radioButton2.classList.add("btn-secondary");

                                                                                }
                                                                            </script>
                                                                            <!--Caixa de texto para comentários:-->
                                                                            <p id="txt_comentAceite"></p><br><br>


                                                                            <div class="form-row">
                                                                                <div class="form-group col-md p-2">
                                                                                    <div class="d-flex justify-content-start">
                                                                                        <button type="submit" name="avaliarprojeto" class="btn btn-outline-conecta">Enviar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="card shadow h-100">
                                                <div class="card-header" style="background-color: #ee7624;">
                                                    <h5 class="text-white">Comentários</h5>
                                                </div>
                                                <div class="card-body bg-visualizar">
                                                    <div class="container-fluid">
                                                        <?php
                                                        $retAvaliacao = mysqli_query($conn, "SELECT * FROM avaliacaopedido WHERE avNumPed= '" . $numeroCaso . "';");

                                                        if (($retAvaliacao) && ($retAvaliacao->num_rows != 0)) {
                                                            while ($rowAvaliacao = mysqli_fetch_array($retAvaliacao)) {

                                                                //avId avNumPed avStatus avObservacao avUserObs avData avHora

                                                                $statusav = $rowAvaliacao['avStatus'];
                                                                if ($statusav == 0) {
                                                                    $statusav = "Sol. Alteração";
                                                                    $color = "warning text-dark";
                                                                } else {
                                                                    $statusav = "Liberado";
                                                                    $color = "success text-white";
                                                                }

                                                                $obs = $rowAvaliacao['avObservacao'];
                                                                $user = $rowAvaliacao['avUserObs'];
                                                                $data = $rowAvaliacao['avData'];
                                                                $hora = $rowAvaliacao['avHora'];
                                                        ?>
                                                                <div class="row d-flex p-4 m-2 w-100 py-4 rounded" style="background-color: #f0f1f3;">
                                                                    <div class="col col-sm col-xs d-flex justify-content-start align-items-center">
                                                                        <div>
                                                                            <span class="px-2 badge rounded-pill bg-<?php echo $color; ?>"><?php echo $statusav; ?></span>

                                                                            <h4 class="forum-link py-2 text-black"><?php echo $obs; ?></h4>

                                                                            <p>comentário de <b><?php echo $user; ?></b></p>
                                                                            <p><small><?php echo dateFormat2($data); ?> às <?php echo hourFormat2($hora); ?> </small></p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            <?php
                                                            }
                                                        } else {

                                                            ?>
                                                            <div class="col d-flex justify-content-center text-center">
                                                                <h5 class="px-2 alert rounded-pill text-dark">Nenhum comentário adicionado</h5>

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
                        </div>
                    </div>

                </div>

            </div>
            </div>
        <?php } ?>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>