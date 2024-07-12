<?php
session_start();

if (isset($_GET["id"])) {
    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Representante')) || ($_SESSION["userperm"] == 'Administrador'))) {
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
        </style>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';
            require_once 'includes/functions.inc.php';

            $idViewer = addslashes($_GET['id']);

            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idViewer . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $lista = $row['propListaItens'];

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

                $encrypted = hashItem($row['propId']);

                $tipoProduto = ["propTipoProd"];

                //Solicitação de Troca
                $produtoProposto = null;
                $statusTroca = null;
                $retSolTroca = mysqli_query($conn, "SELECT * FROM solicitacaotrocaproduto WHERE solNumProp='" . $idViewer . "';");
                if (($retSolTroca) && ($retSolTroca->num_rows != 0)) {
                    while ($rowSolTroca = mysqli_fetch_array($retSolTroca)) {
                        $temSolicitação = true;
                        $produtoProposto = $rowSolTroca["solProd"];
                        $statusTroca = $rowSolTroca["solStatus"];
                    }
                } else {
                    $temSolicitação = false;
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
                        } else {
                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                $moodStatusComercial = "bg-roxo text-white";
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
                                            <h2 class="text-conecta" style="font-weight: 400;">Informações da <span style="font-weight: 800;"> Proposta - <?php echo $idViewer ?></span></h2>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-color: #ee7624;">

                                <br>
                                <div class="d-flex justify-content-center">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md">
                                            <div class="card shadow mr-1 my-1">

                                                <div class="card-body">

                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="content-panel">
                                                                        <form class="form-horizontal style-form" name="form1">
                                                                            <div class="form-row" hidden>
                                                                                <div class="form-group col-md">
                                                                                    <label class="form-label text-black" for="propid">Prop ID</label>
                                                                                    <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                                                    <small class="text-muted">ID não é editável</small>
                                                                                </div>
                                                                            </div>
                                                                            <div class="container-fluid pt-0 mt-0">
                                                                                <h6 style="color: silver;">Status da Proposta</h6>
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

                                                                            <div class="form-row">
                                                                                <div class="form-group col-md coment" hidden>
                                                                                    <label class="form-label text-black" for="status">Comentário</label>
                                                                                    <textarea class="form-control" name="textReprov" id="textReprov" cols="30" rows="3"><?php echo $row['propTxtReprov']; ?></textarea>
                                                                                </div>
                                                                                <div class="form-group col-md projetistas" hidden>
                                                                                    <label for="projetista" class="form-label text-black">Projetista</label>
                                                                                    <select class="form-control" name="projetista" id="projetista">
                                                                                        <option>Escolha um projetista...</option>
                                                                                        <?php
                                                                                        $retProjetistas = mysqli_query($conn, "SELECT * FROM users WHERE usersPerm='2PLJ' ORDER BY usersName ASC; ");
                                                                                        while ($rowProjetistas = mysqli_fetch_array($retProjetistas)) {
                                                                                            $nmCompleto = $rowProjetistas['usersName'];
                                                                                            $nmCompleto = explode(' ', $nmCompleto);
                                                                                            $nmCompleto = $nmCompleto[0];

                                                                                            if ($nmCompleto == $projetista) {
                                                                                                $selected = 'selected="selected"';
                                                                                            } else {
                                                                                                $selected = '';
                                                                                            }

                                                                                            echo '<option value="' . $nmCompleto . '" ' . $selected . '>' . $nmCompleto . '</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="form-row p-2 mb-2 d-flex align-items-center" style="background-color: #f7f7f7; border-radius: 8px">
                                                                                <div class="col-md">
                                                                                    <h6 class="form-label text-black" for="status">Comentário TC</h6>
                                                                                    <span name="textReprov" id="textReprov"><?php echo $row['propTxtReprov']; ?></span>
                                                                                </div>
                                                                                <?php
                                                                                if ($temanexo) {
                                                                                ?>
                                                                                    <div class="col-md-2">
                                                                                        <span class="btn btn-sm btn-conecta" data-toggle="modal" data-target="#veranexo"><i class="bi bi-eye"></i> Ver Anexo</span>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <div class="form-row p-2 mb-2 d-flex align-items-center" style="background-color: #f7f7f7; border-radius: 8px">
                                                                                <div class="col-md">
                                                                                    <h6 class="form-label text-black" for="status">Comentário Comercial</h6>
                                                                                    <span name="textComercial" id="textComercial"><?php echo $row['propTxtComercial']; ?></span>
                                                                                </div>
                                                                            </div>-->

                                                                            <hr>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-3">
                                                                                    <h6 class="form-label text-black" for="nomedr">Dr(a)</h6>
                                                                                    <p><?php echo $row['propNomeDr']; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <h6 class="form-label text-black" for="telefone">Telefone Dr(a)</h6>
                                                                                    <p><?php echo $row['propTelefoneDr']; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <h6 class="form-label text-black" for="emaildr">E-mail Dr(a)</h6>
                                                                                    <p><?php echo $row['propEmailDr']; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <h6 class="form-label text-black" for="convenio">Convênio</h6>
                                                                                    <p><?php echo $row['propConvenio']; ?></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-4">
                                                                                    <h6 class="form-label text-black" for="emailenvio">E-mail Contato</h6>
                                                                                    <p><?php echo $row['propEmailEnvio']; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                                                    <p><?php echo $row['propNomePac']; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <h6 class="form-label text-black" for="representante">Representante</h6>
                                                                                    <p><?php echo $row['propRepresentante']; ?></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md p-2" style="border: 1px solid #ee7624; border-radius: 10px;">
                                                                                    <h5 class="form-label text-black d-flex justify-content-center" for="tipoProd"><b>Produto</b></h6>
                                                                                        <p class="d-flex justify-content-center" style="color: #ee7624;"><b><?php echo $row['propTipoProd']; ?></b></p>
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

                                                                            <hr>


                                                                        </form>
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
                                                <div class="card shadow mr-1 my-1 rounded">

                                                    <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                                        <div class="container-fluid text-center">
                                                            <div class="row">
                                                                <div class="col d-flex justify-content-center">
                                                                    <div class="form p-1">
                                                                        <form action="includes/editprodutoporrepresentante.inc.php" method="POST">
                                                                            <h5 style="color: silver; text-align: center;" class="py-2">Troca de Produto</h5>
                                                                            <?php
                                                                            if ($temSolicitação) {
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
                                            <div class="row py-2">
                                                <div class="card shadow mr-1 my-1 rounded" style="background-color: #ee7624; height: 120px;">

                                                    <div class="card-body h-auto d-flex justify-content-center align-items-center">
                                                        <div class="container-fluid text-center">
                                                            <div class="row">
                                                                <div class="col d-flex justify-content-center">
                                                                    <div class="p-1">
                                                                        <h4 class="text-white py-2" style="text-align: center; font-size: 14pt;"><i class="fas fa-plus"></i> Reenvio de Arquivos</h4>
                                                                        <a href="reenviotc?id=<?php echo $encrypted; ?>" class="text-decoration-none"><button class="btn btn-light hover-bigger" style="color: #ee7624; font-size: 10pt;">Acesse aqui</button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card shadow mr-1 my-1">
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
                                                                                                        <small class="pl-2 text-muted" style="margin-top: -40px !important;"><small class="text-muted" id="cont">300</small> Caracteres restantes</small>
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