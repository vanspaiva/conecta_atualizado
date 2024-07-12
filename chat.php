<?php include("php/head_index.php");

if (isset($_SESSION["useruid"])) {
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <h2 class="text-white text-center pt-2">Chat</h2>
        <div class="container-fluid">
            <div class="row py-3">
                <div class="col col-sm-12 col-12 d-flex justify-content-center w-100" id="titulo-pag">
                    <div class="bg-light rounded" style="width: 90vw; min-width: 890px;">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-4 col-4 py-1">
                                        <!--Caixa de Pesquisa-->
                                        <div class="px-2 pt-1 rounded" style="background-color: #f1f1f1;" id="serach-contatos">
                                            <label for="searchInput"><i class="fa fa-search" style="color: #BCBCCB;"></i></label>
                                            <input class="rounded px-2" style="border: none;  width: 90%; background-color: transparent;" type="search" id="searchInput" placeholder="Procurar contato...">
                                        </div>

                                        <div id="lista-contatos">
                                            <!--Cartão de Mensagem-->
                                            <div class="card mt-2">
                                                <div class="card-body">
                                                    <h6>John Doe</h6>
                                                    <p>Lorem ipsum dolor sit amet ...</p>
                                                </div>
                                            </div>

                                            <!--Cartão de Mensagem-->
                                            <div class="card mt-2">
                                                <div class="card-body">
                                                    <h6>John Doe</h6>
                                                    <p>Lorem ipsum dolor sit amet...</p>
                                                </div>
                                            </div>

                                            <!--Cartão de Mensagem-->
                                            <div class="card mt-2">
                                                <div class="card-body">
                                                    <h6>John Doe</h6>
                                                    <p>Lorem ipsum dolor sit amet...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-8" id="conversa">
                                        <div class="container bg-light rounded mb-2">
                                            <div class="background-white rounded border px-3">
                                                <div class="row d-flex justify-content-center align-items-center">
                                                    <div class="col-11 p-2 text-black d-flex justify-content-start">
                                                        <div>
                                                            <h5>John Doe</h5>
                                                            <p>Planejamento</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 p-2 d-flex justify-content-end">
                                                        <a href="javascript:void(0)" class="closebtn-chat " onclick="closeNav()">&times;</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col background-white rounded border px-3">
                                                    <img src="https://miro.medium.com/max/1372/0*8u63aqVTouLcITZ5" alt="error">
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
    header("location: login.php");
    exit();
}

    ?>