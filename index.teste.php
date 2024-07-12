<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (isset($_SESSION["useruid"])) {
    $user = $_SESSION["useruid"];
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    include("php/head_index.php");


?>
    <style>
        .slider-banner {
            position: relative;
            display: inline-block;
            width: 70vw;
            height: 30vw;
            text-align: center;
            margin-top: 40px;
            box-sizing: border-box;
            overflow: hidden;
            border-radius: 10px;
        }

        .slider-banner input {
            display: none;
        }

        .slider-image {
            position: absolute;
            left: 0;
            display: inline-block;
            width: 60vw;
            height: 40vw;
            /* border: 6px solid white; */
            text-align: center;
            opacity: 0;
            visibility: hidden;
            transition: left .2s ease-in;
            overflow: hidden;
        }

        .slider-image img {
            width: 100%;
        }

        .nav label {
            position: absolute;
            top: 40%;
            display: block;
            color: rgba(255, 255, 255, .8);
            font-family: 'Arial', sans-serif;
            font-size: 24px;
            font-weight: bold;
            line-height: 50px;
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, .3);
            text-align: center;
            opacity: 0;
            z-index: 9;
        }

        input:checked+.slider-image {
            position: absolute;
            display: inline-block;
            opacity: 1;
            visibility: visible;
            transition: left .2s ease-in;
        }

        .nav label:hover {
            opacity: 1;
            cursor: pointer;
        }

        .slider-image img:hover+.nav label {
            opacity: .75;
        }

        .nav .prev {
            left: 0;
            border-radius: 0 10px 10px 0;
        }

        .nav .next {
            right: 0;
            border-radius: 10px 0 0 10px;
        }

        .bullet-nav {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .bullet {
            position: relative;
            display: inline-block;
            width: 2vw;
            height: 10px;
            background-color: #555555a8;
            /* border: 1px solid #111; */
        }

        .bullet:hover {
            cursor: pointer;
        }

        .bullet:first-child {
            border-radius: 10px 0 0 10px;
        }

        .bullet:last-child {
            border-radius: 0 10px 10px 0;
        }

        input#slideA:checked~.bullet-nav label#bulletA,
        input#slideB:checked~.bullet-nav label#bulletB,
        input#slideC:checked~.bullet-nav label#bulletC {
            background-color: #ffffff;
        }

        .btn-solicitacao {
            width: 100%;
            height: 150px;
            /* border: 5px solid #ee7624; */
            border-radius: 10px;
            color: white;
            /* background: rgb(238, 118, 36);
            background: linear-gradient(90deg, rgba(238, 118, 36, 1) 35%, rgba(244, 181, 139, 1) 100%); */
            transform: scale(0.9);
            transition: ease-in-out all 0.4s;
            text-align: left;
            background-image: url("https://i.imgur.com/u2HUnPN.png");
            background-repeat: no-repeat;
            background-position: bottom right;
            background-size: cover;
        }

        .btn-solicitacao:hover {
            transform: scale(1);
            cursor: pointer;
        }
    </style>

    <body class="bg-conecta">

        <?php
        include_once 'php/navbar.php';
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

                    <div class="row p-4 d-flex justify-content-center">

                        <div class="col-md-10 mb-4 p-4">
                            <div class="card border-left-primary shadow py-2 px-4">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                Responsável pelos Estados </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <div class='d-block p-1'>
                                                    <?php
                                                    $sessionUser = $_SESSION["useruid"];
                                                    $retUF = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='$sessionUser';");
                                                    while ($rowUF = mysqli_fetch_array($retUF)) {
                                                        if ($rowUF['repUF'] != null) {
                                                    ?>
                                                            <span class="badge bg-secondary my-1" style="font-size: 1rem; color:#fff;"> <?php echo $rowUF['repUF']; ?></span>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-search-location fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row p-4 d-flex justify-content-center">

                        <!-- Cadastros Total -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Propostas Em Análise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropEmAnalise; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-clipboard-list fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cadastros Pendentes -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pedidos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropPed; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bi bi-collection fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cadastros Aprovados -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pedidos Pendentes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPedPendentes; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                <?php
                }

                if ($_SESSION["userperm"] != 'Doutor(a)') {
                ?>
                    <div class="main">
                        <div class="container-fluid">
                            <!--btn-->
                            <div class="row d-flex justify-content-center px-3" style="height: 100%;">
                                <div class="col-8 d-flex justify-content-center align-items-center ">
                                    <a href="solicitacao" style="text-decoration: none;" class="w-100">
                                        <div class="btn-solicitacao p-3 d-flex justify-content-center align-items-center shadow">
                                            <h2 style="text-align: left;">Solicitar <br> <b>Proposta</b></h2>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center m-0 p-0">
                                <div class="col-8 d-flex justify-content-around align-items-center container-fluid">

                                    <!--Itens-->
                                        <div class="indexCard">
                                            <a class="text-decoration-none" href="dadosproduto">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="assets/img/indexIcons/i-form.svg" alt="Ícone Dados dos Produtos" class="d-block iconesIndex" />
                                                    <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Formulários</b></p>
                                                </div>
                                            </a>
                                        </div>


                                        <div class="indexCard">
                                            <a class="text-decoration-none" href="materiais">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="assets/img/indexIcons/i-catalogo.svg" alt="Ícone Materiais de Mídia" class="d-block iconesIndex" />
                                                    <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Materiais de Apoio</b></p>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="indexCard">
                                            <a class="text-decoration-none" href="tecnicacir">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="assets/img/indexIcons/i-tecnica.svg" alt="Ícone Técnica Cirúrgica" class="d-block iconesIndex" />
                                                    <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Técnica Cirúrgica</b></p>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="indexCard">
                                            <a class="text-decoration-none" href="sac">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="assets/img/indexIcons/i-sac.svg" alt="Ícone Deixe Seus Elogios Ou Reclamações" class="d-block iconesIndex" />
                                                    <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>SAC</b></p>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="indexCard">
                                            <a class="text-decoration-none" target="_blank" href="https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="assets/img/indexIcons/i-chat.svg" alt="Ícone Suporte Técnico" class="d-block iconesIndex" />
                                                    <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Suporte</b></p>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="indexCard">
                                            <a class="text-decoration-none" href="visitafabrica">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="assets/img/indexIcons/i-visita.svg" alt="Ícone Visitar a Fábrica" class="d-block iconesIndex" />
                                                    <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Visita a Fábrica</b></p>
                                                </div>
                                            </a>
                                        </div>
                                </div>
                            </div>

                            <hr style="border-color: white;">

                            <div class="row">
                                <!--Graph-->
                                <div class="col-8">
                                    <div class="card">
                                        <div class="card-body">

                                        </div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--Table-->
                                <div class="col">

                                </div>
                            </div>

                            <div class="row d-flex justify-content-center px-3" style="height: 100%;">
                                <!--Banner-->
                                <div class="col d-flex justify-content-center">
                                    <div class="slider-banner shadow-lg mb-5">
                                        <input type="radio" name="slider" id="slideA" checked />
                                        <div class="slider-image">
                                            <img src="http://farm9.staticflickr.com/8241/8562523343_9bb49b7b7b.jpg" />
                                            <span class="nav">
                                                <label for="slideC" class="prev">&lt;</label>
                                                <label for="slideB" class="next">&gt;</label>
                                            </span>
                                        </div>

                                        <input type="radio" name="slider" id="slideB" />
                                        <div class="slider-image">
                                            <img src="http://farm9.staticflickr.com/8517/8562729616_35b1384aa1.jpg" />
                                            <span class="nav">
                                                <label for="slideA" class="prev">&lt;</label>
                                                <label for="slideC" class="next">&gt;</label>
                                            </span>
                                        </div>

                                        <input type="radio" name="slider" id="slideC" />
                                        <div class="slider-image">
                                            <img src="http://farm9.staticflickr.com/8465/8113424031_72048dd887.jpg" />
                                            <span class="nav">
                                                <label for="slideB" class="prev">&lt;</label>
                                                <label for="slideA" class="next">&gt;</label>
                                            </span>
                                        </div>

                                        <div class="bullet-nav">
                                            <label for="slideA" id="bulletA" class="bullet"></label>
                                            <label for="slideB" id="bulletB" class="bullet"></label>
                                            <label for="slideC" id="bulletC" class="bullet"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        <?php
                }

                if ($_SESSION["userperm"] != 'Representante') {
        ?>

            <div class="row row-2">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 d-flex justify-content-center">
                    <a href="solicitacao"><button class="btn btn-conecta"><i class="fas fa-plus"></i> Nova Solicitação de Proposta</button></a>
                </div>
                <div class="col-sm-3"></div>
            </div>

            <div class="row mt-5">

                <div class="col col-sm">
                    <div class="container">
                        <div class="row ">

                            <div class="indexCard col-4 col-sm-4 col-xs-6 d-flex justify-content-center align-items-center">
                                <a class="text-decoration-none" href="dadosproduto">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="assets/img/indexIcons/i-form.svg" alt="Ícone Dados dos Produtos" class="d-block iconesIndex" />
                                        <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Formulários</b></p>
                                    </div>
                                </a>
                            </div>



                            <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                <a class="text-decoration-none" href="materiais">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="assets/img/indexIcons/i-catalogo.svg" alt="Ícone Materiais de Mídia" class="d-block iconesIndex" />
                                        <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Materiais de Apoio</b></p>
                                    </div>
                                </a>
                            </div>



                            <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                <a class="text-decoration-none" href="tecnicacir">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="assets/img/indexIcons/i-tecnica.svg" alt="Ícone Técnica Cirúrgica" class="d-block iconesIndex" />
                                        <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Técnica Cirúrgica</b></p>
                                    </div>
                                </a>
                            </div>

                        </div>

                        <div class="row">

                            <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                <a class="text-decoration-none" href="sac">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="assets/img/indexIcons/i-sac.svg" alt="Ícone Deixe Seus Elogios Ou Reclamações" class="d-block iconesIndex" />
                                        <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>SAC</b></p>
                                    </div>
                                </a>
                            </div>



                            <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">

                                <a class="text-decoration-none" target="_blank" href="https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="assets/img/indexIcons/i-chat.svg" alt="Ícone Suporte Técnico" class="d-block iconesIndex" />
                                        <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Suporte</b></p>
                                    </div>
                                </a>
                            </div>



                            <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                <a class="text-decoration-none" href="visitafabrica">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="assets/img/indexIcons/i-visita.svg" alt="Ícone Visitar a Fábrica" class="d-block iconesIndex" />
                                        <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Visita a Fábrica</b></p>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

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

            $(document).ready(function() {
                document.getElementById("mySidenav").style.width = "200px";
            });
        </script>
        <!-- /GetButton.io widget -->


        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>