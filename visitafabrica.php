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
                <div class="row mb-2">
                    <div class="col">
                        <h2 class="text-conecta" style="font-weight: 400;">Visita a <span style="font-weight: 700;">Fábrica</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col-md-8 col-12 p-3">
                        <div class="card p-4 d-flex justify-content-center shadow">

                            <iframe src="https://form.jotform.com/GRUPOFIX/Formularios_div" style="width: 100%; height: 100vh; border: none;" frameborder="0"></iframe>

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