<?php
session_start();


// $userPerm = $_SESSION["userperm"];
// $userPermCod = $_SESSION["userpermcod"];

// $retType = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro='$userPermCod';");

// if (($retType) && ($retType->num_rows != 0)) {
//     $open = true;
// } else {
//     $open = false;
// }

// print_r((isset($_SESSION["useruid"])) && ($open));
// exit();

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Analista Dados') || ($_SESSION["userperm"] == 'Representante'))) {
// if ($open) {
    require_once 'includes/dbh.inc.php';
    include("php/head_index.php");
    
?>

    <body class="bg-light-gray2">
        <?php
        // ob_start();
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">


                <?php
                if ($_SESSION["userperm"] == 'Representante') {
                    $rep = $_SESSION["useruid"];

                    $contagemPropEmAnalise = 0;
                    $contagemPedPendentes = 0;
                    $contagemPropPed = 0;

                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propRepresentante='$rep';");
                    while ($row = mysqli_fetch_array($ret)) {
                        if (strpos($row['propStatus'], 'PEDIDO') !== true) {
                            $contagemPropEmAnalise++;
                        }
                    }

                    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedRep='$rep';");
                    while ($row = mysqli_fetch_array($ret)) {
                        $contagemPropPed++;
                    }

                    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedRep='$rep' AND pedStatus <> 'PROD';");
                    while ($row = mysqli_fetch_array($ret)) {
                        $contagemPedPendentes++;
                    }

                ?>

                    <div class="row py-3 d-flex justify-content-center">

                        <div class="col-sm-8 d-flex justify-content-center">
                            <form class="w-100" action="pesquisaitens" method="POST">
                                <div class="col d-flex justify-content-center">
                                    <div class="input-group rounded">
                                        <div class="px-2">
                                            <select name="tipo" id="tipo" class="form-select p-2">
                                                <option value="propostas">Proposta</option>
                                                <option value="pedido">Pedido</option>
                                            </select>
                                        </div>
                                        <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui uma proposta ou pedido..." aria-label="Pesquise aqui uma proposta ou pedido..." aria-describedby="search-addon" />
                                        <div class="px-2 d-flex justify-content-center align-items-center">
                                            <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="search-addon" type="search" value="search" name="search">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>


                    <div class="row p-4">
                        <div class="container">

                            <?php
                            if (isset($_POST["search"])) {

                                //get the post value
                                $valorPesquisado = $_POST["searchInput"];
                                $tabela = $_POST["tipo"];
                                $rep = $_SESSION["useruid"];

                                if ($tabela == 'propostas') {

                                    $valorPesquisado = preg_replace("#[^0-9a-z]#i", "", $valorPesquisado);

                                    $query = mysqli_query($conn, "SELECT * FROM propostas WHERE propId LIKE '%$valorPesquisado%' AND propRepresentante='$rep' ORDER BY propDataCriacao DESC") or die("Aconteceu algo errado!");
                                    $count =  mysqli_num_rows($query);
                                    if ($count == 0) {
                            ?>
                                        <div class="container-fluid py-4">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-warning text-center" role="alert">
                                                        Nenhum resultado encontrado!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        while ($rowFaq = mysqli_fetch_array($query)) {
                                            $id = $rowFaq['propId'];
                                            $solicitante = $rowFaq['propUserCriacao'];
                                            $produto = $rowFaq['propTipoProd'];
                                            $statusTC = $rowFaq['propStatusTC'];
                                            $status = $rowFaq['propStatus'];

                                            $dr = $rowFaq['propNomeDr'];
                                            $pac = $rowFaq['propNomePac'];

                                            $timestamp = $rowFaq['propDataCriacao'];
                                            // $timestamp = explode(" ", $timestamp);
                                            // $timestampData = $timestamp[0];
                                            // $timestampHora = $timestamp[1];

                                            // $timestampData = explode("-", $timestampData);
                                            // $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                            // $timestampHora = explode(":", $timestampHora);
                                            // $hora = $timestampHora[0] . ':' . $timestampHora[1];

                                            $rep = $rowFaq['propRepresentante'];

                                        ?>
                                            <!-- INICIO CARTÃO FORUM -->
                                            <div class="row py-3">
                                                <div class="card w-100">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-5 col-sm col-xs d-flex justify-content-start align-items-center">
                                                                    <div>
                                                                        <a href="dados_proposta?id=<?php echo $id; ?>">
                                                                            <h4 class="forum-link py-2 text-black"><?php echo 'Proposta ' . $id . ' - ' . $produto; ?></h4>
                                                                        </a>
                                                                        <div class="d-flex">
                                                                            <span class="m-1 px-2 badge rounded-pill bg-secondary text-white"><?php echo $status; ?></span>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-secondary text-white"><?php echo $statusTC; ?></span>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <p><?php echo 'Dr: ' . $dr; ?></p>

                                                                            <p><?php echo 'Pac: ' . $pac; ?></p>
                                                                        </div>
                                                                        <p class="mx-1 px-1">enviado por <b><?php echo $solicitante; ?></b></p>
                                                                        <p class="mx-1 p-1"><b><?php echo 'Representante: ' . $rep; ?></b></p>

                                                                    </div>
                                                                </div>

                                                                <div class="col-5 d-sm-none d-md-block d-none d-sm-block">
                                                                    <p class="d-flex justify-content-end align-items-center"><small><?php echo $timestamp; ?> </small></p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- FIM CARTÃO FORUM -->
                                        <?php

                                        }
                                    }
                                } else {
                                    $valorPesquisado = preg_replace("#[^0-9a-z]#i", "", $valorPesquisado);

                                    $query = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido LIKE '%$valorPesquisado%' AND pedRep='$rep' ORDER BY pedDtCriacaoPed DESC") or die("Aconteceu algo errado!");
                                    $count =  mysqli_num_rows($query);
                                    if ($count == 0) {
                                        ?>
                                        <div class="container-fluid py-4">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-warning text-center" role="alert">
                                                        Nenhum resultado encontrado!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        while ($rowFaq = mysqli_fetch_array($query)) {
                                            $id = $rowFaq['pedPropRef'];
                                            $numped = $rowFaq['pedNumPedido'];
                                            $solicitante = $rowFaq['pedUserCriador'];
                                            $produto = $rowFaq['pedTipoProduto'];
                                            $statusTC = null;
                                            $status = $rowFaq['pedStatus'];

                                            $dr = $rowFaq['pedNomeDr'];
                                            $pac = $rowFaq['pedNomePac'];

                                            $timestamp = $rowFaq['pedDtCriacaoPed'];
                                            $timestamp = explode(" ", $timestamp);
                                            $timestampData = $timestamp[0];
                                            $timestampHora = $timestamp[1];

                                            $timestampData = explode("-", $timestampData);
                                            $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                            $timestampHora = explode(":", $timestampHora);
                                            $hora = $timestampHora[0] . ':' . $timestampHora[1];

                                            $timestamp = $data . ' ' . $hora;

                                            $rep = $rowFaq['pedRep'];

                                        ?>
                                            <!-- INICIO CARTÃO FORUM -->
                                            <div class="row py-3">
                                                <div class="card w-100">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-5 col-sm col-xs d-flex justify-content-start align-items-center">
                                                                    <div>
                                                                        <a href="dados_proposta?id=<?php echo $id; ?>">
                                                                            <h4 class="forum-link py-2 text-black"><?php echo 'Pedido ' . $numped . ' - ' . $produto; ?></h4>
                                                                        </a>
                                                                        <div class="d-flex">
                                                                            <span class="m-1 px-2 badge rounded-pill bg-secondary text-white"><?php echo $status; ?></span>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <p><?php echo 'Dr: ' . $dr; ?></p>

                                                                            <p><?php echo 'Pac: ' . $pac; ?></p>
                                                                        </div>
                                                                        <p class="mx-1 px-1">enviado por <b><?php echo $solicitante; ?></b></p>
                                                                        <p class="mx-1 p-1"><b><?php echo 'Representante: ' . $rep; ?></b></p>

                                                                    </div>
                                                                </div>

                                                                <div class="col-5 d-sm-none d-md-block d-none d-sm-block">
                                                                    <p class="d-flex justify-content-end align-items-center"><small><?php echo $timestamp; ?> </small></p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- FIM CARTÃO FORUM -->
                            <?php

                                        }
                                    }
                                }
                            }
                            ?>

                        </div>

                    </div>



                <?php
                }

                if ($_SESSION["userperm"] != 'Representante') {
                ?>
                    <script>
                        window.location.replace("index");
                    </script>
                <?php
                }
                ?>
            </div>
        </div>



        <!-- GetButton.io widget -->
        <script type="text/javascript">
            (function() {
                var options = {
                    whatsapp: "+55 61 99946-8880", // WhatsApp number
                    call_to_action: "Enviar uma mensagem", // Call to action
                    position: "right", // Position may be 'right' or 'left'
                    pre_filled_message: "Olá! Vim do Conecta 2.0, estou precisando de ajuda", // WhatsApp pre-filled message
                };
                var proto = document.location.protocol,
                    host = "getbutton.io",
                    url = proto + "//static." + host;
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = url + '/widget-send-button/js/init.js';
                s.onload = function() {
                    WhWidgetSendButton.init(host, proto, options);
                };
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            })();
        </script>
        <!-- /GetButton.io widget -->

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>