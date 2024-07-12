<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
?>
    <style>
        hr.solid {
            border-top: 3px solid #6c757d;
        }

        .offset-row-2 {
            margin-top: -20px;
            width: max-content;
            background-color: #fff;
            padding: 0px 15px;
            z-index: 1;
        }

        .line-heading {
            margin-top: 10vh;
            margin-bottom: 5vh;
        }
    </style>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <!--<iframe src="https://docs.google.com/viewer?embedded=true&url=https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/portfolio-cpmh-resumido.pdf" style="width: 100%; height: 100vh; border: none;"></iframe>-->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        <h2 class="text-conecta" style="font-weight: 400;">Encontre <span style="font-weight: 700;">Ajuda</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center align-items-center w-100">
                    <div class="col p-3">
                        <div class="card bg-transparent border-0">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class="col-4 m-3 d-flex justify-content-center align-items-center w-100">
                                    <a class="container-fluid text-black btn btn-conecta shadow" target="_blank" href="meuscasos">
                                        <div class="row d-flex justify-content-center align-items-center w-100">
                                            <div class="col-6 d-flex justify-content-end align-items-center">
                                                <i class="far fa-calendar-alt fa-2x"></i>
                                            </div>
                                            <div class="col d-flex justify-content-start align-items-center">
                                                <h6 class="text-white"> Vídeo c/ <br> pedido <br> andamento</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-4 m-3 d-flex justify-content-center align-items-center w-100">
                                    <a class="container-fluid text-black btn btn-conecta shadow" target="_blank" href="agendartecnicacir">
                                        <div class="row d-flex justify-content-center align-items-center w-100">
                                            <div class="col-6 d-flex justify-content-end align-items-center">
                                                <i class="fa-solid fa-headphones fa-2x"></i>
                                            </div>
                                            <div class="col d-flex justify-content-start align-items-center">
                                                <h6 class="text-white"> Não possui <br> pedido <br> dúvida técnica</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-4 m-3 d-flex justify-content-center align-items-center w-100">
                                    <a class="container-fluid text-black btn btn-conecta shadow" target="_blank" href="https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda">
                                        <div class="row d-flex justify-content-center align-items-center w-100">
                                            <div class="col-6 d-flex justify-content-end align-items-center">
                                                <i class="fa-brands fa-whatsapp fa-2x"></i>
                                            </div>
                                            <div class="col d-flex justify-content-start align-items-center">
                                                <h6 class="text-white"> Whatsapp <br> fale <br> conosco</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <br>
                <div class="row mb-2">
                    <div class="col">
                        <h2 class="text-conecta" style="font-weight: 400;">Formulário do <span style="font-weight: 700;">SAC</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col-md-8 col-12 p-3">
                        <div class="card p-4 d-flex justify-content-center shadow">

                            <iframe src="https://form.jotform.com/GRUPOFIX/SACIntext" style="width: 100%; height: 100vh; border: none;" frameborder="0"></iframe>

                        </div>
                    </div>
                </div>




            </div>
        </div>



        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>