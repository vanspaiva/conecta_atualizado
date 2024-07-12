<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática') || ($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Adm Comercial')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';

    $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $nomeCompleto = $row['usersName'];
    }
?>
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';


        $idFAQ = $_GET['id'];
        ?>

        <style>
            .btn-sac {
                padding: 5px 10px;
                background-color: #f37a23;
                border: 1px solid #f37a23;
                border-radius: 20px;
                opacity: 1;
                font-size: 1.2rem;
                font-weight: bold;
                transition: ease-in-out 0.2s;
            }

            .btn-sac:hover {
                opacity: 0.8;
                cursor: pointer;
            }

            .forum-link:hover {
                text-decoration: none !important;
            }
        </style>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-3 w-100">

                    <div class="col-sm justify-content-start" id="titulo-pag">
                        <div class="container-fluid">
                            
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2">
                                    <div class="row px-3">
                                        <h2 class="text-conecta" style="font-weight: 400;">Fórum Interno <span style="font-weight: 700;">Conecta</span></h2>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-color: #ee7624;">

                            <!-- INICIO FORUM -->
                            <div class="row py-3 d-flex justify-content-center">
                                <div class="col-10">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row py-2 pb-4" style="border: 2px dashed silver;">
                                                    <div class="col col-sm col-xs d-flex justify-content-start align-items-center">
                                                        <?php
                                                        $retFaq = mysqli_query($conn, "SELECT * FROM forum WHERE faqId='$idFAQ';");
                                                        while ($rowFaq = mysqli_fetch_array($retFaq)) {
                                                            $faqID = $rowFaq['faqId'];
                                                            $titulo = $rowFaq['faqAssuntoPrincipal'];
                                                            $userCriador = $rowFaq['faqUserCriador'];
                                                            $tipo = $rowFaq['faqTipoTexto'];
                                                            $texto = $rowFaq['faqTexto'];
                                                            $status = $rowFaq['faqStatus'];

                                                            $timestamp = $rowFaq['faqDataCriacao'];
                                                            $timestamp = explode(" ", $timestamp);
                                                            $timestampData = $timestamp[0];
                                                            $timestampHora = $timestamp[1];

                                                            $timestampData = explode("-", $timestampData);
                                                            $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                                            $timestampHora = explode(":", $timestampHora);
                                                            $hora = $timestampHora[0] . ':' . $timestampHora[1];
                                                        ?>
                                                            <div class="container">
                                                                <div class="row d-flex justify-content-between align-items-center w-100">
                                                                    <div class="text-start">
                                                                        <h2 class="forum-link py-2 text-black"><?php echo $titulo; ?></h2>
                                                                        <?php if (($status == "Respondido") || ($status == "Resolvido")) { ?>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-success text-white">status: <?php echo $status; ?></span>
                                                                        <?php
                                                                        } else { ?>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-secondary text-white">status: <?php echo $status; ?></span>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php if ($tipo == "Dúvida") { ?>
                                                                        <div class="text-center">
                                                                            <span style="color: #ffc107"><b>Dúvida</b></span>
                                                                            <br>
                                                                            <i style="color: #ffc107" class="fas fa-bookmark fa-3x"></i>

                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                    <?php if ($tipo == "Melhoria") { ?>
                                                                        <div class="text-center">
                                                                            <span style="color: #0dcaf0"><b>Melhoria</b></span>
                                                                            <br>
                                                                            <i style="color: #0dcaf0" class="fas fa-bookmark fa-3x"></i>

                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex justify-content-between">
                                                                    <p>criado por <b><?php echo $userCriador; ?></b></p>
                                                                    <p><small><?php echo $data; ?> às <?php echo $hora; ?> </small></p>
                                                                </div>
                                                                <br>
                                                                <div class="p-4" style="background-color: #ededed;">
                                                                    <p style="text-align: justify; font-size: 1.2rem; color: black; line-height: 1.3rem;"><?php echo $texto; ?></p>
                                                                </div>

                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="row  p-2 d-flex justify-content-center">
                                                    <div class="col w-100">
                                                        <!-- <h5 style="color: silver; text-align: center;" class="px-3 pt-2">Respostas</h5> -->
                                                        <div class="container rounded p-3">

                                                            <?php
                                                            $retMsg = mysqli_query($conn, "SELECT * FROM comentariosforum WHERE faqcomentFaqId='$idFAQ' ORDER BY faqcomentId ASC");


                                                            while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                                $msg = $rowMsg['faqcomentTexto'];
                                                                $owner = $rowMsg['faqcomentUserCriador'];
                                                                $timer = $rowMsg['faqcomentDataCriacao'];
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
                                                                <div class="row  p-1">
                                                                    <div class="col">
                                                                        <div style="background-color: #ededed;" class="text-black rounded rounded-3 px-2 py-1">
                                                                            <h4 style="color: #b9b9b9;"><b><?php echo $owner; ?>:</b></h4>
                                                                            <p style="color: #858585;" class="text-wrap"><?php echo $msg; ?></p>
                                                                            <small style="color: #b9b9b9;"><?php echo  $horario; ?></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php

                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm px-2 mx-1 py-3">
                                                        <form action="includes/addcomentfaq.inc.php" method="post">
                                                            <div class="container" hidden>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="nfaq">Nº FAQ</label>
                                                                        <input type="text" class="form-control" name="nfaq" id="nfaq" value="<?php echo $idFAQ; ?>" readonly>
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

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>