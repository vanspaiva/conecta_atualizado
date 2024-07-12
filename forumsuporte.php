<?php
session_start();

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática') || ($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Analista Dados')) {
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
                <div class="row d-flex justify-content-center py-3">
                    <div class="col-sm">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-around align-items-center">
                                        <div>
                                            <h2 class="text-conecta" style="font-weight: 400;">Fórum Interno <span style="font-weight: 700;">Conecta</span></h2>
                                            <p class="text-muted">Antes de enviar alguma pergunta ou sugestão, verifique se já não foi feito algum comentário parecido com o seu!</p>
                                        </div>
                                        <span class="d-flex justify-content-center"><a class="btn btn-conecta" href="suporteconecta"><i class="fas fa-plus"></i> Novo Item</a></span>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: #ee7624;">

                            <!--<div class="row">
                                <div class="col">
                                    <form action="forumsuporte" method="POST">
                                        <div class="col d-flex justify-content-center">
                                            <div class="input-group rounded">
                                                <input type="search" name="searchInput" class="form-control rounded" placeholder="Pesquise aqui algum assunto..." aria-label="Pesquise aqui algum assunto..." aria-describedby="search-addon" />
                                                <button class="input-group-text border-0" id="search-addon" type="search" value="search" name="search">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>-->

                            <div class="row p-3 d-flex justify-content-center">
                                <div class="col-8">
                                    <div class="w-100">
                                        <div class="">
                                            <form action="forumsuporte" method="POST">
                                                <div class="col d-flex justify-content-center">
                                                    <div class="input-group rounded">
                                                        <input type="search" name="searchInput" class="form-control rounded" placeholder="Pesquise aqui algum assunto..." aria-label="Pesquise aqui algum assunto..." aria-describedby="search-addon" />
                                                        <button class="input-group-text border-0" id="search-addon" type="search" value="search" name="search">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="container">

                            <?php
                            if (isset($_POST["search"])) {

                                //get the post value
                                $valorPesquisado = $_POST["searchInput"];
                                $valorPesquisado = preg_replace("#[^0-9a-z]#i", "", $valorPesquisado);

                                $query = mysqli_query($conn, "SELECT * FROM forum WHERE faqSetor LIKE '%$valorPesquisado%' OR faqAssuntoPrincipal LIKE '%$valorPesquisado%' OR faqTexto LIKE '%$valorPesquisado%' OR faqTipoTexto LIKE '%$valorPesquisado%' ORDER BY faqDataCriacao DESC") or die("Aconteceu algo errado!");
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
                                        $faqID = $rowFaq['faqId'];
                                        $titulo = $rowFaq['faqAssuntoPrincipal'];
                                        $userCriador = $rowFaq['faqUserCriador'];
                                        $tipo = $rowFaq['faqTipoTexto'];
                                        $status = $rowFaq['faqStatus'];

                                        $timestamp = $rowFaq['faqDataCriacao'];
                                        $timestamp = explode(" ", $timestamp);
                                        $timestampData = $timestamp[0];
                                        $timestampHora = $timestamp[1];

                                        $timestampData = explode("-", $timestampData);
                                        $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                        $timestampHora = explode(":", $timestampHora);
                                        $hora = $timestampHora[0] . ':' . $timestampHora[1];

                                        $numComents = 0;
                                        $retComent = mysqli_query($conn, "SELECT * FROM comentariosforum WHERE faqcomentFaqId='$faqID';");
                                        while ($rowComent = mysqli_fetch_array($retComent)) {
                                            $numComents++;
                                        }
                                    ?>
                                        <!-- INICIO CARTÃO FORUM -->
                                        <div class="row py-3">
                                            <div class="card w-100 shadow">
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-2 d-sm-none d-md-block d-none d-sm-block">
                                                                <span style="width: fit-content; background-color: #ee7624;" class="badge text-white d-flex justify-content-center align-items-center">
                                                                    <div class="container py-2">
                                                                        <div class="row d-flex justify-content-center align-items-center">
                                                                            <h5><b><?php echo $numComents; ?></b></h5>
                                                                        </div>
                                                                        <div class="row d-flex justify-content-center align-items-center">
                                                                            resposta<?php if ($numComents != 1) {
                                                                                        echo 's';
                                                                                    } ?>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>

                                                            <div class="col-5 col-sm col-xs d-flex justify-content-start align-items-center">
                                                                <div>
                                                                    <a href="q?id=<?php echo $faqID; ?>">
                                                                        <h4 class="forum-link py-2 text-black"><?php echo $titulo; ?></h4>
                                                                    </a>
                                                                    <div class="d-flex">
                                                                        <?php if ($tipo == "Dúvida") { ?>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-warning text-dark"><?php echo $tipo; ?></span>
                                                                        <?php } ?>
                                                                        <?php if ($tipo == "Melhoria") { ?>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-info text-dark"><?php echo $tipo; ?></span>
                                                                        <?php } ?>
                                                                        <?php if (($status == "Respondido") || ($status == "Resolvido")) { ?>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-success text-white">status: <?php echo $status; ?></span>
                                                                        <?php
                                                                        } else { ?>
                                                                            <span class="m-1 px-2 badge rounded-pill bg-secondary text-white">status: <?php echo $status; ?></span>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <p class="mx-1 px-1">criado por <b><?php echo $userCriador; ?></b></p>

                                                                </div>
                                                            </div>

                                                            <div class="col-5 d-sm-none d-md-block d-none d-sm-block">
                                                                <p class="d-flex justify-content-end align-items-center"><small><?php echo $data; ?> às <?php echo $hora; ?> </small></p>
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



                                $retFaq = mysqli_query($conn, "SELECT * FROM forum ORDER BY faqDataCriacao DESC;");
                                while ($rowFaq = mysqli_fetch_array($retFaq)) {
                                    $faqID = $rowFaq['faqId'];
                                    $titulo = $rowFaq['faqAssuntoPrincipal'];
                                    $userCriador = $rowFaq['faqUserCriador'];
                                    $tipo = $rowFaq['faqTipoTexto'];
                                    $status = $rowFaq['faqStatus'];

                                    $timestamp = $rowFaq['faqDataCriacao'];
                                    $timestamp = explode(" ", $timestamp);
                                    $timestampData = $timestamp[0];
                                    $timestampHora = $timestamp[1];

                                    $timestampData = explode("-", $timestampData);
                                    $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                    $timestampHora = explode(":", $timestampHora);
                                    $hora = $timestampHora[0] . ':' . $timestampHora[1];

                                    $numComents = 0;
                                    $retComent = mysqli_query($conn, "SELECT * FROM comentariosforum WHERE faqcomentFaqId='$faqID';");
                                    while ($rowComent = mysqli_fetch_array($retComent)) {
                                        $numComents++;
                                    }
                                    ?>
                                    <!-- INICIO CARTÃO FORUM -->
                                    <div class="row py-3">
                                        <div class="card w-100 shadow">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-2 d-sm-none d-md-block d-none d-sm-block">
                                                            <span style="width: fit-content; background-color: #ee7624;" class="badge text-white d-flex justify-content-center align-items-center">
                                                                <div class="container py-2">
                                                                    <div class="row d-flex justify-content-center align-items-center">
                                                                        <h5><b><?php echo $numComents; ?></b></h5>
                                                                    </div>
                                                                    <div class="row d-flex justify-content-center align-items-center">
                                                                        resposta<?php if ($numComents != 1) {
                                                                                    echo 's';
                                                                                } ?>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </div>

                                                        <div class="col-5 col-sm col-xs d-flex justify-content-start align-items-center">
                                                            <div>
                                                                <a href="q?id=<?php echo $faqID; ?>">
                                                                    <h4 class="forum-link py-2 text-black"><?php echo $titulo; ?></h4>
                                                                </a>
                                                                <div class="d-flex">
                                                                    <?php if ($tipo == "Dúvida") { ?>
                                                                        <span class="m-1 px-2 badge rounded-pill bg-warning text-dark"><?php echo $tipo; ?></span>
                                                                    <?php } ?>
                                                                    <?php if ($tipo == "Melhoria") { ?>
                                                                        <span class="m-1 px-2 badge rounded-pill bg-info text-dark"><?php echo $tipo; ?></span>
                                                                    <?php } ?>
                                                                    <?php if (($status == "Respondido") || ($status == "Resolvido")) { ?>
                                                                        <span class="m-1 px-2 badge rounded-pill bg-success text-white">status: <?php echo $status; ?></span>
                                                                    <?php
                                                                    } else { ?>
                                                                        <span class="m-1 px-2 badge rounded-pill bg-secondary text-white">status: <?php echo $status; ?></span>
                                                                    <?php } ?>
                                                                </div>
                                                                <p class="mx-1 px-1">criado por <b><?php echo $userCriador; ?></b></p>

                                                            </div>
                                                        </div>

                                                        <div class="col-5 d-sm-none d-md-block d-none d-sm-block">
                                                            <p class="d-flex justify-content-end align-items-center"><small><?php echo $data; ?> às <?php echo $hora; ?> </small></p>
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
                            ?>

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