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
                        <h2 class="text-conecta" style="font-weight: 400;">Técnica <span style="font-weight: 700;">Cirúrgica</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="text-center">Não tem pedido e está com alguma dúvida técnica?</h5>
                                <div class="col m-3 d-flex justify-content-center align-items-center">
                                    <a class="text-black btn btn-conecta" target="_blank" href="agendartecnicacir">
                                        <h6 class="text-white"><i class="far fa-calendar-alt"></i></i> Agendar Vídeo</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card p-4 d-flex justify-content-center shadow">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-black px-4" id="cmf-tab" data-toggle="tab" href="#cmf" role="tab" aria-controls="cmf" aria-selected="true">CMF</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="cranio-tab" data-toggle="tab" href="#cranio" role="tab" aria-controls="cranio" aria-selected="false">CRÂNIO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="ortopedia-tab" data-toggle="tab" href="#ortopedia" role="tab" aria-controls="ortopedia" aria-selected="false">ORTOPEDIA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="descartaveis-tab" data-toggle="tab" href="#descartaveis" role="tab" aria-controls="descartaveis" aria-selected="false">DESCARTÁVEIS</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!--TAB CONTENT CMF-->
                                <div class="tab-pane fade show active" id="cmf" role="tabpanel" aria-labelledby="cmf-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="fas fa-pencil-ruler"></i> Instruções de Uso</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Pr%C3%B3tese-de-ATM-Rev.02.pdf">
                                                        <h5>IU ATM sob medida</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Placa-de-Fixa%C3%A7%C3%A3o-Buco-Maxilo-Facial-Rev.-01.pdf">
                                                        <h5>IU Placa fixação buco-maxilo-facial</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Placa-de-Reconstru%C3%A7%C3%A3o-Maxilo-Facial-Rev.-02.pdf">
                                                        <h5>IU Placa reconstrução buco-maxilo-facial</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Smartmold.pdf">
                                                        <h5>IU Smartmold</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="fas fa-ambulance"></i> Técnica cirúrgica</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/tecnica-cirurgica-atm-rev5.pdf">
                                                        <h5>ATM</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=_lkjKGJ_aX4&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>ATM</h5>
                                                        <small class="text-muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/etapas-recebimento-ATM-rev4.pdf">
                                                        <h5>ATM - ítens enviados</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/09/tecnica-cirurgica-customlife_v4-9-21.pdf">
                                                        <h5>Maxila atrófica - CustomLIFE</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/Protocolo-Guia-e-Tc-customlife-rev-2-1.pdf">
                                                        <h5>Maxila atrófica - CustomLIFE</h5>
                                                        <small class="text-muted">Protocolo de exame</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/smartmold-passo-a-passo/">
                                                        <h5>Passo a Passo - Smartmold</h5>
                                                        <small class="text-muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <!--TAB CONTENT CRÂNIO-->
                                <div class="tab-pane fade" id="cranio" role="tabpanel" aria-labelledby="cranio-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="fas fa-pencil-ruler"></i> Instruções de Uso</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Calota-em-PEEK-Rev.-02.pdf">
                                                        <h5>IU Calota em PEEK</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Calota-em-Tit%C3%A2nio-Rev.-02.pdf">
                                                        <h5>IU Calota em titânio</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Fastmold.pdf">
                                                        <h5>IU Fastmold</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                    </div>
                                </div>

                                <!--TAB CONTENT ORTOPEDIA-->
                                <div class="tab-pane fade" id="ortopedia" role="tabpanel" aria-labelledby="ortopedia-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="fas fa-pencil-ruler"></i> Instruções de Uso</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2019/03/Instru%C3%A7%C3%B5es-de-Uso-Fixadores-Externos-EST%C3%89REIS.pdf">
                                                        <h5>IU Fixador externo estéril</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2019/03/Instru%C3%A7%C3%B5es-de-Uso-Fixadores-Externos-nao-estereis.pdf">
                                                        <h5>IU Fixador externo não estéril</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="fas fa-ambulance"></i> Técnica cirúrgica</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/BETAFIX-TRILHO.pptx.pdf">
                                                        <h5>Fixador BETAFIX Trilho</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/ALFAFIX-PLATAFORMA-T%C3%89CNICA.pptx.pdf">
                                                        <h5>Fixador ALFAFIX plafatorma</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/ALFAFIX-COTOVELO-T%C3%89CNICA.pptx-1.pdf">
                                                        <h5>Fixador ALFAFIX cotovelo</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/ZETAFIX-PUNHO.pptx.pdf">
                                                        <h5>Fixador ZETAFIX punho</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/PERTROCANT%C3%89RICO-F%C3%8AMUR-PROXIMAL.pptx.pdf">
                                                        <h5>Fixador PERTROCANTÉRICO fêmur</h5>
                                                        <small class="text-muted">Técnica cirúrgica</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT DESCARTÁVEIS-->
                                <div class="tab-pane fade" id="descartaveis" role="tabpanel" aria-labelledby="descartaveis-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="fas fa-pencil-ruler"></i> Instruções de Uso</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-INSERT.pdf">
                                                        <h5>IU Insert Piezo</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Instrumentais-Articulados-Cortantes-80859840003-1.pdf">
                                                        <h5>IU Instrumentais articulados cortantes</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Instrumentais-Articulados-N%C3%A3o-Cortantes-80859840010-1.pdf">
                                                        <h5>IU Instrumentais articulados não cortantes</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Instrumentais-NAC-Brocas-80859840116-e-80859840016-1.pdf">
                                                        <h5>IU Brocas</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Guia-Cir%C3%BArgico-Est%C3%A9ril.pdf">
                                                        <h5>IU Guia cirúrgico estéril</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/IU-Guia-Cir%C3%BArgico.pdf">
                                                        <h5>IU Guia cirúrgico não estéril</h5>
                                                        <small class="text-muted">Instruções de Uso</small>
                                                    </a>
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
    header("location: login");
    exit();
}

    ?>