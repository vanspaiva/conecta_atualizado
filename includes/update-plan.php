<?php include("php/head_index.php");

require_once 'includes/dbh.inc.php';

if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Planejador(a)')) || ($_SESSION["userperm"] == 'Administrador'))) {

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
        </style>
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $_GET['id'] . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $lista = $row['propListaItens'];
            $array_items = $row['propListaItensBD'];
            $array_items = explode(',', $array_items);

            if ($row['propTxtReprov'] != null) {
                $txtReprov = $row['propTxtReprov'];
            } else {
                $txtReprov = null;
            }

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
                                        <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2 row-padding-2">
                                    <div class="row px-3" style="color: #fff">
                                        <h2>Informações da Proposta - <?php echo $_GET['id'] ?> </h2>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="card">

                                <div class="card-body">

                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="content-panel">
                                                        <form class="form-horizontal style-form" name="form1" action="includes/updateplan.inc.php" method="post" enctype="multipart/form-data">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="propid">Prop ID</label>
                                                                    <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($temComentarioComercial) {
                                                            ?>
                                                                <div class="form-row p-2 mb-2 d-flex align-items-center" style="background-color: #f7f7f7; border-radius: 8px">
                                                                    <div class="form-group col-md">
                                                                        <h6 class="form-label text-black">Comentário Comercial</h6>
                                                                        <span name="comentario" id="comentario"><?php echo $comentComercial; ?></span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <div class="form-row p-2 mb-2 border border-secondary" style="background-color: #e1e1e1; border-radius: 8px">
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="statustc">Status TC</label>
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
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="status">Status Prop</label>
                                                                    <input type="text" class="form-control" id="status" name="status" value="<?php echo $row['propStatus']; ?>" readonly>
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

                                                                    } else if (status.includes('REPROVADA')) {

                                                                        projInput.hidden = true;
                                                                        comentInput.hidden = false;

                                                                    }

                                                                }
                                                            </script>
                                                            <div class="form-row">
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
                                                                <div class="form-group col-md coment" hidden>
                                                                    <label class="form-label text-black" for="status">Comentário</label>
                                                                    <textarea class="form-control" name="textReprov" id="textReprov" cols="30" rows="1"><?php echo $txtReprov; ?></textarea>
                                                                </div>

                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="update" class="btn btn-primary">Salvar</button>
                                                            </div>
                                                        </form>
                                                        <div class="form-row">
                                                            <div class="form-group col-md">
                                                                <?php
                                                                include("uploadplan1.php");
                                                                ?>
                                                            </div>
                                                            <div class="form-group col-md">
                                                                <?php
                                                                include("uploadplan2.php");
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-3">
                                                                <h6 class="form-label text-black" for="nomedr">Dr(a)</h6>
                                                                <p><?php echo $row['propNomeDr']; ?></p>
                                                            </div>
                                                            <!-- <div class="form-group col-md-3">
                                                                    <h6 class="form-label text-black" for="crm">Nº Conselho Dr(a)</h6>
                                                                    <p><?php echo $row['propNConselhoDr']; ?></p>
                                                                </div> -->
                                                            <div class="form-group col-md-3">
                                                                <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                                <p><?php echo $row['propNomePac']; ?></p>
                                                            </div>
                                                            <!-- <div class="form-group col-md-3">
                                                                    <h6 class="form-label text-black" for="telefone">Telefone Dr(a)</h6>
                                                                    <p><?php echo $row['propTelefoneDr']; ?></p>
                                                                </div> -->
                                                            <!-- <div class="form-group col-md-3">
                                                                    <h6 class="form-label text-black" for="emaildr">E-mail Dr(a)</h6>
                                                                    <p><?php echo $row['propEmailDr']; ?></p>
                                                                </div> -->
                                                            <div class="form-group col-md-3">
                                                                <h6 class="form-label text-black" for="representante">Representante</h6>
                                                                <p><?php echo $row['propRepresentante']; ?></p>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <h6 class="form-label text-black" for="emailenvio">E-mail Contato</h6>
                                                                <p><?php echo $row['propEmailEnvio']; ?></p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-row">

                                                            <!-- <div class="form-group col-md-3">
                                                                    <h6 class="form-label text-black" for="emailenvio">E-mail Envio</h6>
                                                                    <p><?php echo $row['propEmailEnvio']; ?></p>
                                                                </div> -->
                                                            <!-- <div class="form-group col-md-3">
                                                                    <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                                    <p><?php echo $row['propNomePac']; ?></p>
                                                                </div> -->
                                                            <!-- <div class="form-group col-md-3">
                                                                    <h6 class="form-label text-black" for="convenio">Convênio</h6>
                                                                    <p><?php echo $row['propConvenio']; ?></p>
                                                                </div> -->
                                                            <div class="form-group col-md p-2" style="border: 1px solid #ee7624; border-radius: 10px;">
                                                                <h5 class="form-label text-black d-flex justify-content-center" for="tipoProd"><b>Produto</b></h6>
                                                                    <p class="d-flex justify-content-center" style="color: #ee7624;"><b><?php echo $row['propTipoProd'];
                                                                                                                                        if ($row['propEspessura'] != null) {
                                                                                                                                            echo " - " . $row['propEspessura'];
                                                                                                                                        } ?></b></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <!-- <div class="form-group col-md-6">
                                                                    <h6 class="form-label text-black" for="validade">Validade</h6>
                                                                    <p><?php echo $row['propValidade'] ?></p>
                                                                </div> -->
                                                            <!-- <div class="form-group col-md-6">
                                                                    <h6 class="form-label text-black" for="representante">Representante</h6>
                                                                    <p><?php echo $row['propRepresentante']; ?></p>
                                                                </div> -->
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

                                                        <div class="form-row mt-4">
                                                            <div class="form-group col-md d-flex justify-content-center">
                                                                <?php
                                                                $retFile = mysqli_query($conn, "SELECT * FROM filedownload WHERE fileNumPropRef= '" . $_GET['id'] . "' ;");
                                                                while ($rowFile = mysqli_fetch_array($retFile)) {
                                                                ?>
                                                                    <!--<a href="download?file=<?php echo $rowFile['fileRealName'] ?>" class="btn btn-outline-secondary"><i class="bi bi-cloud-arrow-down"></i> Download TC</a>-->
                                                                    <div class="container-fluid">
                                                                        <div class="row d-flex justify-content-center">
                                                                            <a href="<?php echo $rowFile['fileCdnUrl']; ?>" class="btn btn-outline-secondary" target="_blank"><i class="bi bi-cloud-arrow-down"></i> Download TC</a>
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

                                                        <hr>

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


?>