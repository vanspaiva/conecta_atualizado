<?php

session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
    require_once 'dashboard/counterHelpers/counterTecnicos.php';

    if (isset($_POST["search"])) {
        $data = $_POST["data"];
        $tecnico = $_POST["tecnico"];
    } else {
        $data = 0;
        $tecnico = 0;
    }
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <style>
            #span-img {
                background-color: #645a82 !important;
                padding: 10px !important;
                border: 2px solid #645a82 !important;
                border-radius: 10px !important;
                height: auto !important;
            }

            .bg-amarelo {
                background-color: #FAF53D;
            }

            .bg-verde-claro {
                background-color: #9FFFD2;
            }

            .bg-verde {
                background-color: #34B526;
            }

            .bg-rosa {
                background-color: #FAA4B5;
            }

            .bg-vermelho {
                background-color: #FA242A;
            }

            .bg-vermelho-claro {
                background-color: #FA6069;
            }

            .bg-roxo {
                background-color: #C165FF;
            }

            .bg-azul {
                background-color: #42A1DB;
            }

            .bg-cinza {
                background-color: #cfcfcf;
            }

            .bg-lilas {
                background-color: #8665E6;
            }

            .text-darkgray {
                color: #4b535a;
            }
        </style>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col">
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "statusatualizado") {
                                echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Novo status salvo com sucesso!</p></div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">

                        <div class="d-flex justify-content-between d-print-none">
                            <h2 class="text-conecta" style="font-weight: 400;"> Relatórios do <span style="font-weight: 700;">
                                    Planejamento </span></h2>

                        </div>

                        <hr style="border: 1px solid #ee7624" class="d-print-none">

                        <br>

                        <div class="container-fluid card shadow" style="overflow: scroll;">
                            <div class="row py-4">
                                <div class="col d-flex justify-content-around align-items-center">
                                    <a href="relatorioplan_1"><button type="submit" class="btn btn-conecta">Atividade Diária dos Técnicos</button></a>
                                </div>
                            </div>

                            <div class="row py-4">
                                <div class="col d-flex justify-content-around align-items-center">
                                    <a href="relatorioplan_2"><button type="submit" class="btn btn-conecta">Pedidos Liberados</button></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>



        <script>
            $(document).ready(function() {
                $('#tableDesempenho').DataTable({
                    "lengthMenu": [
                        [20, 40, 80, -1],
                        [20, 40, 80, "Todos"],
                    ],
                    "language": {
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        "lengthMenu": "Mostrar _MENU_ itens",
                        "zeroRecords": "Nenhuma proposta encontrada"
                    },
                    "order": [
                        [4, "asc"]
                    ]
                });

            });

            function gotoHistory(elem) {
                var button = `#submit${elem}`;
                $(button).trigger('click');
            }
        </script>

    <?php
    include_once 'php/footer_index.php';
} else {
    header("Location: login");
    exit();
}

    ?>