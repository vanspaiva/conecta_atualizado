<?php include("php/head_index.php");

if (isset($_SESSION["useruid"])) {
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

    <body class="bg-conecta">

        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <!--<iframe src="https://docs.google.com/viewer?embedded=true&url=https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/portfolio-cpmh-resumido.pdf" style="width: 100%; height: 100vh; border: none;"></iframe>-->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        <h3 class="text-white text-center">Materiais de Apoio</h3>
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="col m-3 d-flex justify-content-center">
                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/portfolio-cpmh-resumido.pdf">
                                        <h5><i class="bi bi-file-earmark-richtext"></i> Portfolio CPMH</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card p-4 d-flex justify-content-center">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-black px-4" id="cmf-tab" data-toggle="tab" href="#cmf" role="tab" aria-controls="cmf" aria-selected="true">CMF</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="ortodontia-tab" data-toggle="tab" href="#ortodontia" role="tab" aria-controls="ortodontia" aria-selected="false">ORTODONTIA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="cranio-tab" data-toggle="tab" href="#cranio" role="tab" aria-controls="cranio" aria-selected="false">CRÂNIO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="coluna-tab" data-toggle="tab" href="#coluna" role="tab" aria-controls="coluna" aria-selected="false">COLUNA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="ortopedia-tab" data-toggle="tab" href="#ortopedia" role="tab" aria-controls="ortopedia" aria-selected="false">ORTOPEDIA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black px-4" id="radiofrequencia-tab" data-toggle="tab" href="#radiofrequencia" role="tab" aria-controls="radiofrequencia" aria-selected="false">RADIOFREQUÊNCIA</a>
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
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/12/descricao-de-produto-atm-rec-rev4.pdf">
                                                        <h5>ATM e Reconstrução</h5>
                                                        <small class="muted">Descrição do produto</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vTlpL95uANABNGNLu4qvV_ZdIFUd4hpY-oGQrY17XAdH7vfMRHD_cgIGBSzkn1Dhtm6f3o_Ba_TOpYP/pub?start=false&loop=false&delayms=3000&slide=id.g63e76a2e42_0_0">
                                                        <h5>ATM sob medida</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/10/Flyer-rec-buco-2021-desafiandolimites.pdf">
                                                        <h5>Reconstruções</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vSYu6V9u6JXmEImTo3rjmAbqdkoc5lotO7ktQThPO6EgVe3Lp6lfiQfdD9NCWw6pgEqq-XifmaUfZEt/pub?start=false&loop=false&delayms=5000&slide=id.g63f98617d9_0_0">
                                                        <h5>Reconstrução Facial</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/flyer-craniomaxilofacial.png">
                                                        <h5>Soluções CMF</h5>
                                                        <small class="muted">Flyer</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/1J5GrphFHSQ2rtTad-972J7V2FmH8B6r4rbr0p0ZOyE4/edit#slide=id.p">
                                                        <h5>Smartmold Implantes Faciais</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/flyer-implante-facial.png">
                                                        <h5>Smartmold Implantes Faciais</h5>
                                                        <small class="muted">Flyer</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vSwgRjAEUIVhHx_pJe-Z3K4jlgFEBxHWPBIzDxYgMbY4NRctoXaWUzJkq4uuhA6O-08CSkQHSqC9oJB/pub?start=false&loop=false&delayms=3000&slide=id.p">
                                                        <h5>Reconstrução atrófica - Custom Life</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/flyer-customlife-mesh4u-digital.pdf">
                                                        <h5>Reconstrução atrófica + Malha de reconstrução</h5>
                                                        <small class="muted">Flyer</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - ATM</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=PcxFlMQLM-o&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>ATM - Dr. Killian Evandro</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=_lkjKGJ_aX4&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>ATM - Técnica cirúrgica</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=vDqu-SSjUiw">
                                                        <h5>ATM - Dr. Jucélio Freitas</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Smartmold</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=1vzpkGBHF5Q&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Smartmold - Apresentação</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=mp4AtJSyMas&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Smartmold - Dra. Vanessa Castro</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=WrZBPlmKiuE">
                                                        <h5>Smartmold - Dr. Júlio Bisinotto</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Reconstruções</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/playlist?list=PL1hJupdHr03cNfjwDWAXSeFUVqBAXC0QB">
                                                        <h5>Reconstruções CMF</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/playlist?list=PL1hJupdHr03dGx6gSP6JPUMVU9bCyjIfu">
                                                        <h5>Reconstruções - Vidas transformardas</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Reconstrução atrófica</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=jeuvuLfuGKs&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>CustomLIFE - simulação em tecido</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT ORTODONTIA-->
                                <div class="tab-pane fade" id="ortodontia" role="tabpanel" aria-labelledby="ortodontia-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vT44eYXD05rm079omsP5ATaLG0S2B--rs7u5uV6MuX09owvUsJw7vG03kGUhmxhh9LypTBB4KcZzvI2/pub?start=false&loop=false&delayms=5000&slide=id.p3">
                                                        <h5>Miniplacas ortodônticas - Ancorfix</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2021/04/FICHA-TECNICA-ANCORFIX-05-04-2021.pdf">
                                                        <h5>Ficha Técnica - Ancorfix</h5>
                                                        <small class="muted">Catálogo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Ancorfix</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/playlist?list=PL1hJupdHr03eHkGdRk9bhi0habzLm9H7z">
                                                        <h5>Ancorfix - Depoimentos de profissionais</h5>
                                                        <small class="muted">Playlist</small>
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
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vRczKjIK8UdP9Df8o2PeBU9YfwUttWfeaxbzxXpEBN64dBwX7HGty7tkIp3YXv0b48x6F44TjhLpC2j/pub?start=false&loop=false&delayms=10000">
                                                        <h5>Crânioplastia</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Cranioplastia</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=sSZZl3Vo4cg&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Crânio - Calotas personalizadas CPMH</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=d6ZxudOKD_w&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Crânio - Técnica cirúrgica Fastmold</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=DfEdvjS9nw0&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Crânio - Dra. Alessandra Gorgulho</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT COLUNA-->
                                <div class="tab-pane fade" id="coluna" role="tabpanel" aria-labelledby="coluna-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vSe-R-JT7eBzhH5TBcEDuxsHkcypyYy6Ovh1gv-buHpI-od3xUEIHrUO__3YDtUZOhLyx64KyJPFHQu/pub?start=false&loop=false&delayms=5000&slide=id.g63fa04458b_0_0">
                                                        <h5>Guia vertebral</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Coluna</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=3IuiB0d4xBE">
                                                        <h5>O que é ATA Coluna?</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=BLy4xLA3OzY&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Soluções para cirurgia de coluna</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=9YOTqRZ1DG8&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>Inovações cirurgia de coluna - Dr. Gilmar Saad</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=9sUT49DYsY4&feature=emb_logo&ab_channel=CPMHDigital">
                                                        <h5>ATA Coluna - Dr. Márcio Vinhal</h5>
                                                        <small class="muted">Vídeo</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT ORTOPEDIA-->
                                <div class="tab-pane fade" id="ortopedia" role="tabpanel" aria-labelledby="ortopedia-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vRSO32fn3kHNi9zEnek5IASY1sKqNzX31BdDCkexfzv-7rA2OVJr94GKDR_bLuNdM2tUfqojrSCYLE7/pub?start=false&loop=false&delayms=5000">
                                                        <h5>Fixador Externo</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://docs.google.com/presentation/d/e/2PACX-1vSK5eV1aA_qgVzRDwDqoz_6Xf6Blh_qR74NPvDqkz4El5s6M5DzmpWKODGszUY4G5Vjs0e04VvPwAwX/pub?start=false&loop=false&delayms=3000">
                                                        <h5>Implantes personalizados</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--TAB CONTENT RADIOFREQUÊNCIA-->
                                <div class="tab-pane fade" id="radiofrequencia" role="tabpanel" aria-labelledby="radiofrequencia-tab">
                                    <div class="container">
                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/CATALOGO-RF-CPMH-2019.pdf">
                                                        <h5>Radiofrequência DIROS</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/FLYER-A4-DIROS-1.pdf">
                                                        <h5>Tratamento da dor - Diros</h5>
                                                        <small class="muted">Flyer</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="line-heading">
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-camera-video"></i> Vídeos - Radiofrequência</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.youtube.com/watch?v=w3VamevcXNY&ab_channel=CPMHDigital">
                                                        <h5>Treinamento DIROS</h5>
                                                        <small class="muted">Vídeo</small>
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
                                            <h4 class="position-absolute offset-row-2"><i class="bi bi-file-slides"></i> Apresentação</h4>
                                            <hr class="solid">
                                        </div>

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2019/04/catalogo-brocas-e-piezo.pdf">
                                                        <h5>Brocas</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2019/02/CATALOGO-PIEZO.pdf">
                                                        <h5>Ponteiras de Piezo</h5>
                                                        <small class="muted">Apresentação</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row mt-3 w-100">
                                            <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                <div class="col">
                                                    <a class="text-black" target="_blank" href="https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/Flyer-pulse-A4-cientifico.pdf">
                                                        <h5>Pulse de lavagem</h5>
                                                        <small class="muted">Apresentação</small>
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


        <footer class="footer mt-5 py-3 bg-conecta">
            <div class="container">
                <p class="text-white small text-center">&copy; Conecta 2021</p>
                <p class="text-white small text-center"> Versão 1.0</p>
            </div>
        </footer>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>