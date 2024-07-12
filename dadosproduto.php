<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-8">
                        <h2 class="text-conecta" style="font-weight: 400;">Outros <span style="font-weight: 700;">Formulários</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col-8 p-3">
                        <div class="card p-4 d-flex justify-content-center shadow">
                            <div class="card-body">
                                <h4 class="text-center" style="color: #ee7624;">Atenção!</h4>
                                <p class="text-center">Estes formulários <span style="color: #ee7624; text-decoration: underline;"><b>NÃO</b></span> são destinados a solicitação de proposta. Utilizar apenas quando autorizado, na fase final da produção.</p>
                                <p class="text-center">Para solicitar proposta <a style="color: #ee7624;" href="solicitacao" style="text-decoration: underline;">clique aqui</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col-md-8 p-3">
                        <div class="card p-4 d-flex justify-content-center shadow">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-black px-4" id="cmf-tab" data-toggle="tab" href="#cmf" role="tab" aria-controls="cmf" aria-selected="true">CMF</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="cranio-tab" data-toggle="tab" href="#cranio" role="tab" aria-controls="cranio" aria-selected="false">CRÂNIO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="coluna-tab" data-toggle="tab" href="#coluna" role="tab" aria-controls="coluna" aria-selected="false">COLUNA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="anvisa-tab" data-toggle="tab" href="#anvisa" role="tab" aria-controls="anvisa" aria-selected="false">ANVISA</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!--TAB CONTENT CMF-->
                                <div class="tab-pane fade show active" id="cmf" role="tabpanel" aria-labelledby="cmf-tab">
                                    <div class="container">
                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=atm">
                                                        <h5>ATM</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=ortognatica">
                                                        <h5>Ortognática</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=reconstrucao">
                                                        <h5>Reconstrução (Titânio e PEEK)</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=smartmold">
                                                        <h5>Smartmold</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=surgicalguide">
                                                        <h5>Surgicalguide</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=reconstrucaomax">
                                                        <h5>Reconstrução de maxilares atróficos</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=mesh4u">
                                                        <h5>Mesh4U</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>

                                <!--TAB CONTENT CRÂNIO-->
                                <div class="tab-pane fade" id="cranio" role="tabpanel" aria-labelledby="cranio-tab">
                                    <div class="container">
                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=cranio">
                                                        <h5>Crânio (PEEK ou Titânio)</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT COLUNA-->
                                <div class="tab-pane fade" id="coluna" role="tabpanel" aria-labelledby="coluna-tab">
                                    <div class="container">
                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=guiavertebra">
                                                        <h5>Guia vertebral</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT ANVISA-->
                                <div class="tab-pane fade" id="anvisa" role="tabpanel" aria-labelledby="anvisa-tab">
                                    <div class="container">
                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=anexoidr">
                                                        <h5>01 - Anexo I - Dr(a) - Anvisa</h5>
                                                        <small>Personalizados - Dados do Dr(a); Termo de Responsabilidade do Dr(a); Laudo e CID</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=anexoipaciente">
                                                        <h5>02 - Anexo I - Paciente - Anvisa</h5>
                                                        <small>Personalizados - Dados do Paciente; Termo de Responsabilidade do Paciente</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <!-- <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=anexoii">
                                                        <h5>02 - ANVISA Anexo II</h5>
                                                        <small>Personalizados - Laudo e CID</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=anexoiiidr">
                                                        <h5>03 - ANVISA Anexo III</h5>
                                                        <small>Personalizados - Dados do Dr(a)</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" href="formularios?form=anexoiiipaciente">
                                                        <h5>05 - ANVISA Anexo III</h5>
                                                        <small>Personalizados - Dados do Paciente</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> -->

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