<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    include("php/head_index.php");
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        require_once 'includes/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM produtos");
        $cnt = 1;
        ?>

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto cadastrado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <h2 class="py-2">Relatórios</h2>

                        <div class="card">
                            <div class="card-body">
                                <div class="content-panel">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active px-3 py-1 text-black" id="home-tab" data-toggle="tab" href="#chart1" role="tab" aria-controls="chart1" aria-selected="true">Geral</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-3 py-1 text-black" id="profile-tab" data-toggle="tab" href="#chart2" role="tab" aria-controls="chart2" aria-selected="false">CMF</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-3 py-1 text-black" id="contact-tab" data-toggle="tab" href="#chart3" role="tab" aria-controls="chart3" aria-selected="false">Crânio</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="chart1" role="tabpanel" aria-labelledby="chart1-tab">
                                            <h2 class="text-black p-2">Geral</h2>
                                            <canvas id="realchart1" style="width: 100%; height: 40vh;"></canvas>
                                        </div>

                                        <div class="tab-pane fade" id="chart2" role="tabpanel" aria-labelledby="chart2-tab">
                                            <h2 class="text-black p-2">CMF</h2>
                                            <canvas id="realchart2" style="width: 100%; height: 40vh;"></canvas>
                                        </div>

                                        <div class="tab-pane fade" id="chart3" role="tabpanel" aria-labelledby="chart3-tab">
                                            <h2 class="text-black p-2">Crânio</h2>
                                            <canvas id="realchart3" style="width: 100%; height: 40vh;"></canvas>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>

                </div>

            </div>
        </div>
        <script>
            var ctx1 = document.getElementById('realchart1').getContext('2d');
            var myChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['CRÂNIO', 'CMF', 'ATA', 'BIOMODELO', 'COLUNA'],
                    datasets: [{
                        label: 'Nº de Propostas',
                        data: [12, 19, 3, 5, 2],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('realchart2').getContext('2d');
            var myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['CustomLIFE', 'Smartmold', 'ATM', 'Resconstruções', 'Mesh4U'],
                    datasets: [{
                        label: 'Nº de Propostas',
                        data: [20, 18, 5, 10, 2],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx3 = document.getElementById('realchart3').getContext('2d');
            var myChart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['FastMold', 'FastCMF', 'Crânio em Peek', 'Crânio Titânio'],
                    datasets: [{
                        label: 'Nº de Propostas',
                        data: [5, 10, 14, 8],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>