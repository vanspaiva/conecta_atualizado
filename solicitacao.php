<?php

session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Distribuidor(a)') || ($_SESSION["userperm"] == 'Dist. Comercial') || ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Doutor(a)')) {

    ob_start();
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Nova Proposta criada</p></div>";
                    } else if ($_GET["error"] == "fileerror") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Erro ao fazer upload do arquivo. Tente novamente!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">

                <div class="col-sm-12 mx-2 justify-content-start">
                    <div class="card shadow rounded">
                        <div class="card-head"></div>
                        <div class="card-body">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-sm-1" style="color: #212529;"><?php include_once 'php/back.php';
                                                                                define_button_color('special'); ?></div>
                                <div class="col-sm pt-2">
                                    <div class="row px-3">
                                        <div>
                                            <h4 style="font-weight: 400;">Solicitação de <span style="font-weight: 800;"> Proposta</span></h4>
                                            <p style="color: #ee7624; text-align: center;">Atenção! Certifique-se de adicionar a TC <span style="text-decoration: underline; font-weight: bold;">antes</span> de enviar sua proposta!</p>
                                        </div>

                                    </div>
                                </div>
                                <!--<div class="col-sm-7 pt-2 row-padding-2">
                                     <div class="progress">
                                        <div id="formCaseProgress" class="progress-bar progress-bar-striped active progress-bar-animated" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                                    </div> 

                                </div>-->
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 mx-2 py-4 justify-content-start">
                    <div class="card shadow rounded p-2">
                        <div class="card-body">
                            <div id="card-new-case"></div>
                            <?php include_once "php/form.casos.php" ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        </div>


        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/setProdutoComplemento.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/menu.js"></script>






    </body>

    </html>


<?php

} else {
    header("location: index");
    exit();
}

?>