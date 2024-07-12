<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Comercial')) || ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_tables.php");
    require_once 'includes/dbh.inc.php';
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col d-flex justify-content-center">
                        <iframe src="https://fixgrupo.us.qlikcloud.com/single/?appid=f409268f-34f5-473b-aec0-793b545ee218&sheet=6c79fa68-6d8b-4f53-949c-d1b2f4648f78&lang=pt-BR&theme=horizon&opt=ctxmenu,currsel" style="border:none;width:90vw;height:120vh;"></iframe>
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