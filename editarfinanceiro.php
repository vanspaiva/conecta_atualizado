<?php
session_start();

if (!empty($_GET)) {
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';

    $id = addslashes($_GET['id']);

    // // decrypt to get again $plaintext
    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    // $parts = explode(':', $id);
    // $idAceite = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

    $idAceite = deshashItem($id);

    require_once 'includes/dbh.inc.php';

    if (isset($_SESSION["useruid"])) {

?>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->

        <body class="bg-light-gray2">

            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $id = $_GET['id'];

            $ret = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropId='" . $idAceite . "';");
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

                date_default_timezone_set('UTC');
                $dtz = new DateTimeZone("America/Sao_Paulo");
                $dt = new DateTime("now", $dtz);
                $data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

                $localIP = getHostByName(getHostName());

                $userAceite = $_SESSION["useruid"];
                $dataAceite = $data_criacao;
                $ipAceite = $localIP;


            ?>

                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">

                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center py-4">
                            <div class="col-sm-8 justify-content-start" id="titulo-pag">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3">
                                            <h2 class="text-white fw-bold">Proposta - <?php echo $numProp ?> </h2>
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
                                                                <div class="row d-flex justify-content-center py-4">
                                                                    <?php if ($openIframe) { ?>
                                                                        <div id="preview">
                                                                            <iframe src="<?php echo $caminhoProp; ?>" width="100%" height="600" style="border: none;"></iframe>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <div id="preview">
                                                                            <img src="<?php echo $caminhoProp; ?>" width="100%" alt="Comprovante Proposta <?php echo $id; ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>

                                                                <form class="mt-4 pt-4" action="includes/updateFileFin.inc.php" method="post" enctype="multipart/form-data">
                                                                    <div class="form-row" hidden>
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="aceiteid">Aceite ID</label>
                                                                            <input type="number" class="form-control" id="aceiteid" name="aceiteid" value="<?php echo $idAceite; ?>" required readonly>
                                                                            <small class="text-muted">ID não é editável</small>
                                                                        </div>

                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="useruid">User</label>
                                                                            <input type="text" class="form-control" id="useruid" name="useruid" value="<?php echo $userAceite; ?>" required readonly>
                                                                        </div>

                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="userip">IP</label>
                                                                            <input type="text" class="form-control" id="userip" name="userip" value="<?php echo $ipAceite; ?>" required readonly>
                                                                        </div>

                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="datacriacao">Data</label>
                                                                            <input type="text" class="form-control" id="datacriacao" name="datacriacao" value="<?php echo $dataAceite; ?>" required readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md form-group ">
                                                                        <label class='control-label text-black'>Anexe aqui o seu comprovante de pagamento <b style="color: red;">*</b></label>
                                                                        <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                                            <div>
                                                                                <label class="d-block" for="finfile" style="text-align: center;"><i class="fas fa-upload fa-3x hovericon"></i></label>
                                                                                <small class="d-block" id="file-name" style="text-align: center; color: #ee7624;"></small>
                                                                            </div>
                                                                        </div>
                                                                        <input class="form-control" type="file" id="finfile" name="finfile" onchange="javascript:updateList()" accept="image/jpeg,image/png,application/pdf" hidden>
                                                                        <small class="text-muted">Imagens ou PDF</small>
                                                                        <script>
                                                                            updateList = function() {
                                                                                var input = document.getElementById('finfile');
                                                                                var output = document.getElementById('file-name');

                                                                                output.innerHTML = '';
                                                                                for (var i = 0; i < input.files.length; ++i) {
                                                                                    output.innerHTML += input.files.item(i).name;
                                                                                }
                                                                            }

                                                                            $("#finfile").on('change', function() {

                                                                                var imgPath = $(this)[0].value;
                                                                                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

                                                                                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                                                                                    if (typeof(FileReader) != "undefined") {

                                                                                        var holder = $("#preview");

                                                                                        holder.empty();

                                                                                        var reader = new FileReader();
                                                                                        reader.onload = function(e) {
                                                                                            $("<img />", {
                                                                                                "src": e.target.result,
                                                                                                "class": "portrait",
                                                                                                "width": "500"
                                                                                            }).appendTo(holder);

                                                                                        }
                                                                                        holder.show();
                                                                                        reader.readAsDataURL($(this)[0].files[0]);
                                                                                    } else {
                                                                                        alert("Alguma coisa deu errado!");
                                                                                    }
                                                                                } else {
                                                                                    if (typeof(FileReader) != "undefined") {

                                                                                        var holder = $("#preview");

                                                                                        holder.empty();

                                                                                        var reader = new FileReader();
                                                                                        reader.onload = function(e) {
                                                                                            $("<iframe />", {
                                                                                                "src": e.target.result,
                                                                                                "width": "600",
                                                                                                "height": "600"
                                                                                            }).appendTo(holder);

                                                                                        }
                                                                                        holder.show();
                                                                                        reader.readAsDataURL($(this)[0].files[0]);
                                                                                    } else {
                                                                                        alert("Alguma coisa deu errado!");
                                                                                    }
                                                                                }
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
                                                                    <div class="d-flex justify-content-center pt-3">
                                                                        <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                                                                    </div>
                                                                </form>

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