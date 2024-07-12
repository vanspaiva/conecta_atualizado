<?php
session_start();
if (isset($_SESSION["useruid"])) {
    if (isset($_GET["form"])) {
        include("php/head_index.php");
?>

        <body class="bg-light-gray2">

            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $form = addslashes($_GET['form']);

            switch ($form) {
                case 'atm':
                    $existe = true;
                    $titulo = 'ATM Sob Medida';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-protese-de-atm';
                    break;
                case 'ortognatica':
                    $existe = true;
                    $titulo = 'Ortognática sob medida';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-ortognatica';
                    break;
                case 'reconstrucao':
                    $existe = true;
                    $titulo = 'Reconstrução sob medida (Titânio e PEEK)';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-rec-facial-peek-titanio';
                    break;
                case 'smartmold':
                    $existe = true;
                    $titulo = 'Smartmold Facial Implante / PMMA';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-smartmold';
                    break;
                case 'surgicalguide':
                    $existe = true;
                    $titulo = 'Surgicalguide';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-surgicalguide';
                    break;
                case 'reconstrucaomax':
                    $existe = true;
                    $titulo = 'Reconstrução de maxilares atróficos';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-maxilares-atroficos';
                    break;
                case 'mesh4u':
                    $existe = true;
                    $titulo = 'Mesh4U – Malha de reconstrução';
                    $url = '';
                    break;
                case 'cranio':
                    $existe = true;
                    $titulo = 'Crânio (PEEK ou Titânio)';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-cranio-peek-ou-titanio';
                    break;
                case 'guiavertebra':
                    $existe = true;
                    $titulo = 'Guia vertebral';
                    $url = 'https://form.jotform.com/GRUPOFIX/formulario-guia-vertebra';
                    break;
                case 'anexoipaciente':
                    $existe = true;
                    $titulo = '04 - ANVISA Anexo I – Personalizados - Dados do Paciente; Termo de Responsabilidade do Paciente';
                    $url = 'https://form.jotform.com/GRUPOFIX/q-anexos-anvisa-paciente';
                    break;
                case 'anexoidr':
                    $existe = true;
                    $titulo = '01 - ANVISA Anexo I – Personalizados - Dados do Dr(a); Termo de Responsabilidade do Dr(a); Laudo e CID';
                    $url = 'https://form.jotform.com/GRUPOFIX/q-anexos-anvisa-dra';
                    break;
                case 'anexoii':
                    $existe = true;
                    $titulo = '02 - ANVISA Anexo II – Personalizados - Laudo e CID';
                    $url = 'https://form.jotform.com/GRUPOFIX/anexo-ii-anvisa-laudo-cirurgico';
                    break;
                case 'anexoiiipaciente':
                    $existe = true;
                    $titulo = '05 - ANVISA Anexo III – Personalizados - Dados - Paciente';
                    $url = 'https://form.jotform.com/GRUPOFIX/anexo-iii-anvisa-paciente';
                    break;
                case 'anexoiiidr':
                    $existe = true;
                    $titulo = '03 - ANVISA Anexo III – Personalizados - Dados - Dr(a)';
                    $url = 'https://form.jotform.com/GRUPOFIX/anexo-iii-anvisa-dra';
                    break;
                default:
                    $existe = false;
                    $titulo = 'Desculpe, esse formulário não existe!';
                    $url = 'https://www.fmpalmeira.com.br/uploads/default/notfound.png';
                    break;
            }

            ?>

            <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
            <div id="main" class="font-montserrat">
                <div class="container-fluid">
                    <div class="row py-4 d-flex justify-content-center">
                        <div class="col-8">
                            <h2 class="text-conecta" style="font-weight: 400;">Formulários: <span style="font-weight: 700;"><?php echo $titulo ?></span></h2>
                            <hr style="border-color: #ee7624;">
                        </div>
                    </div>
                    <div class="row py-4 d-flex justify-content-center">
                        <div class="col-8">
                            <div class="card p-3">
                                <div class="d-flex justify-content-center">
                                    <?php
                                    if ($existe) {
                                    ?>
                                        <iframe src="<?php echo $url ?>" frameborder="0" style="width: 100%; height: 100vh">
                                        </iframe>
                                    <?php
                                    } else {
                                    ?>
                                        <img src="<?php echo $url ?>" alt="Imagem Não Encontrada">
                                    <?php
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
        header("location: dadosproduto");
        exit();
    }
} else {
    header("location: index");
    exit();
}

    ?>