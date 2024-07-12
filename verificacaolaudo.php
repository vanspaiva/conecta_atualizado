<?php

session_start();
if (!empty($_GET)) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';
?>

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

            $propid = addslashes($_GET['id']);

            $ret = mysqli_query($conn, "SELECT * FROM laudostomograficos WHERE laudoNumProp='" . $propid . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $id = $row['laudoId'];
                $numProp = $row['laudoNumProp'];
                $status = $row['laudoStatus'];
                $datalaudo1 = $row['DataLaudoTC'];
                $dataanvdr1 = $row['DataAnvisaDr'];
                $dataanvpac1 = $row['DataAnvisaPac'];
                $ntransacao = $row['NTransacao'];
                $nexpedicao = $row['NExpedicao'];

                // if ($datalaudo1 != null) {
                //     $datalaudo = explode("/", $datalaudo1);
                //     $datalaudo = $datalaudo[2] . "-" . $datalaudo[1] . "-" . $datalaudo[0];
                // } else {
                //     $datalaudo = $row['DataLaudoTC'];
                // }

                // if ($dataanvdr1 != null) {
                //     $dataanvdr = explode("/", $dataanvdr1);
                //     $dataanvdr = $dataanvdr[2] . "-" . $dataanvdr[1] . "-" . $dataanvdr[0];
                // } else {
                //     $dataanvdr = $row['DataAnvisaDr'];
                // }

                // if ($dataanvpac1 != null) {
                //     $dataanvpac = explode("/", $dataanvpac1);
                //     $dataanvpac = $dataanvpac[2] . "-" . $dataanvpac[1] . "-" . $dataanvpac[0];
                // } else {
                //     $dataanvpac = $row['DataAnvisaPac'];
                // }

                $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $numProp . "';");
                while ($rowProp = mysqli_fetch_array($retProp)) {
                    $nomeusuario = $rowProp['propUserCriacao'];
                    $statusTC = $rowProp['propStatusTC'];
                    $nomedr = $rowProp['propNomeDr'];
                    $nomepac = $rowProp['propNomePac'];
                    $modalidade = $rowProp['propTipoProd'];
                    $laudoObs = $rowProp['propTxtLaudo'];
                    $numPed = $rowProp['propPedido'];
                    $distribuidor = $rowProp['propEmpresa'];
                }

                $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $nomeusuario . "';");
                while ($rowUser = mysqli_fetch_array($retUser)) {
                    $nomeCompleto = $rowUser['usersName'];
                }


            ?>

                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center py-4">
                            <div class="col-sm-10 justify-content-start">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3">
                                            <h2 class="text-conecta" style="font-weight: 400;">Laudo da <span style="font-weight: 700;"> proposta nº <?php echo $numProp ?></span></h2>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-color: #ee7624;">

                                <br>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card mb-2 shadow rounded">
                                                <div class="card-header">
                                                    Atualização das Informações
                                                </div>
                                                <div class="card-body">
                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="content-panel">
                                                                        <div class="container">
                                                                            <!-- <div class="row pt-4">
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" id="comentlaudo" <?php
                                                                                                                                                // if ($laudoObs != null) {
                                                                                                                                                //     echo "checked";
                                                                                                                                                // }
                                                                                                                                                ?> onchange="checkComment()">
                                                                            <label class="form-check-label" for="comentlaudo">
                                                                                Adicionar Comentário
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                            <script>
                                                                                // $(document).ready(function() {
                                                                                //     checkComment();
                                                                                // });

                                                                                // function checkComment() {
                                                                                //     if (document.getElementById('comentlaudo').checked) {
                                                                                //         document.getElementById("sectioncomment").hidden = false;
                                                                                //     } else {
                                                                                //         document.getElementById("sectioncomment").hidden = true;
                                                                                //     }
                                                                                // }
                                                                            </script>
                                                                            <div class="row py-4" id="sectioncomment">
                                                                                <div class="col">
                                                                                    <form class="form-horizontal style-form" name="form1" action="includes/comentLaudo.inc.php" method="post" enctype="multipart/form-data">
                                                                                        <div class="form-row" hidden>
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="idprop">Id Prop</label>
                                                                                                <input type="number" class="form-control" id="idprop" name="idprop" value="<?php echo $propid; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-row">
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="newdata">Dt. Laudo</label>
                                                                                                <input type="date" class="form-control" id="newdata" name="newdata" value="<?php echo $datalaudo1; ?>">
                                                                                            </div>
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="newdataanvdr">Dt. Anv Dr(a)</label>
                                                                                                <input type="date" class="form-control" id="newdataanvdr" name="newdataanvdr" value="<?php echo $dataanvdr1; ?>">
                                                                                            </div>
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="newdataanvpac">Dt. Anv Pac</label>
                                                                                                <input type="date" class="form-control" id="newdataanvpac" name="newdataanvpac" value="<?php echo $dataanvpac1; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-row">
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="ntransacao">Nº Transação</label>
                                                                                                <input type="text" class="form-control" id="ntransacao" name="ntransacao" value="<?php echo $ntransacao; ?>">
                                                                                            </div>
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="nexpedicao">Nº Expedição</label>
                                                                                                <input type="text" class="form-control" id="nexpedicao" name="nexpedicao" value="<?php echo $nexpedicao; ?>">
                                                                                            </div>
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="status">Status</label>
                                                                                                <select name="status" class="form-control" id="status" required>
                                                                                                    <option value="Protocolar" <?php if ($status == 'Protocolar') echo ' selected="selected"'; ?>>Protocolar</option>
                                                                                                    <option value="Protocolado" <?php if ($status == 'Protocolado') echo ' selected="selected"'; ?>>Protocolado</option>
                                                                                                    <option value="Pendente" <?php if ($status == 'Pendente') echo ' selected="selected"'; ?>>Pendente</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-row">
                                                                                            <div class="form-group col-md">
                                                                                                <label class="form-label text-black" for="txtcoment">Observação</label>
                                                                                                <input type="text" class="form-control" id="txtcoment" name="txtcoment" value="<?php if ($laudoObs != null) {
                                                                                                                                                                                    echo $laudoObs;
                                                                                                                                                                                }  ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-end">
                                                                                            <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>

                                                                            <!-- <?php
                                                                                    if ($status == 'Pendente') { ?>
                                                                    <div class="row d-flex justify-content-center pb-2">
                                                                        <div class="pt-3 px-3">
                                                                            <a href="aprovlaudo?type=aprov&id=<?php echo $id; ?>"><button class="btn btn-success smallOnHover"><i class="fas fa-check-circle fa-2x"></i></button></a>
                                                                        </div>
                                                                        <div class="pt-3 px-3">
                                                                            <a href="aprovlaudo?type=reprov&id=<?php echo $id; ?>"><button class="btn btn-danger smallOnHover"><i class="fas fa-times-circle fa-2x"></i></button></a>
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
                                                                                    }
                                                                ?> -->


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card shadow rounded">
                                                <div class="card-header">
                                                    Informações do Pedido
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="text-black">Nome Usuário: </h5>
                                                            <p><?php echo $nomeCompleto; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Dt. Laudo: </h5>
                                                            <p><?php echo $datalaudo1; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Dt. Anv Dr(a): </h5>
                                                            <p><?php echo $dataanvdr1; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Dt. Anv Pac: </h5>
                                                            <p><?php echo $dataanvpac1; ?></p>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="text-black">Dr(a): </h5>
                                                            <p><?php echo $nomedr; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Paciente: </h5>
                                                            <p><?php echo $nomepac; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Modalidade: </h5>
                                                            <p><?php echo $modalidade; ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="text-black">Proposta </h5>
                                                            <p><?php echo $propid; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Pedido </h5>
                                                            <p><?php echo $numPed; ?></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black">Distribuidor </h5>
                                                            <p><?php echo $distribuidor; ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="row pb-4">
                                                        <div class="col-md d-flex justify-content-center">
                                                            <?php
                                                            $retFile = mysqli_query($conn, "SELECT * FROM filedownloadlaudo WHERE fileNumPropRef= '" . $propid . "' ;");
                                                            while ($rowFile = mysqli_fetch_array($retFile)) {
                                                            ?>
                                                                <!--<a href="download?file=<?php echo $rowFile['fileRealName'] ?>" class="btn btn-outline-secondary"><i class="bi bi-cloud-arrow-down"></i> Download TC</a>-->
                                                                <div class="container-fluid">
                                                                    <div class="row d-flex justify-content-center">
                                                                        <a href="<?php echo $rowFile['fileCdnUrl']; ?>" class="btn btn-outline-secondary" target="_blank"><i class="far fa-folder-open"></i> Pasta Drive</a>
                                                                    </div>
                                                                    <div class="row d-flex justify-content-center">
                                                                        <div class="col">
                                                                            <small class="text-muted py-2">Link Pasta: <input class="form-control pointer" style="color: #ee7624;" onclick="copyText()" id="folderId" value="<?php echo $rowFile['fileCdnUrl']; ?>" readonly /></small>
                                                                        </div>
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