<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["useruid"] == 'rayana.ketlen'))) {
    include("php/head_tables.php");
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
    </style>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        include_once 'includes/functions.inc.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Ordem de Serviço foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço foi criada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "senteerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao enviar Ordem de Serviço!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center align-items-center p-4">
                    <div class="col-sm-10 d-flex justify-content-start">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <h2 class="text-conecta" style="font-weight: 400;">Dados do <span style="font-weight: 700;">Dr(a)</span></h2>

                                    <form class="w-100" action="userdados" method="POST">
                                        <div class="col d-flex justify-content-end">
                                            <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui um Dr(a)..." aria-label="Pesquise aqui um Dr(a)..." aria-describedby="search-addon" />
                                            <div class="px-2 d-flex justify-content-center align-items-center">
                                                <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="search-addon" type="search" value="search" name="search">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <hr style="border: 1px solid #ee7624">


                            <div class="row p-4">
                                <div class="col">

                                    <?php
                                    if (isset($_POST["search"])) {

                                        //get the post value
                                        $valorPesquisado = $_POST["searchInput"];

                                        $valorPesquisado = preg_replace("#[^0-9a-z]#i", "", $valorPesquisado);
                                        $query = mysqli_query($conn, "SELECT * FROM users WHERE usersUid LIKE '%$valorPesquisado%' OR usersName LIKE '%$valorPesquisado%' ORDER BY usersId DESC") or die("Aconteceu algo errado!");
                                        $count =  mysqli_num_rows($query);

                                        if ($count == 0) {
                                    ?>
                                            <div class="container-fluid py-4">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="alert alert-warning text-center" role="alert">
                                                            Nenhum resultado encontrado!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            while ($rowFaq = mysqli_fetch_array($query)) {

                                                $id = $rowFaq['usersId'];
                                                $nome = $rowFaq['usersName'];
                                                $email = $rowFaq['usersEmail'];
                                                $uid = $rowFaq['usersUid'];
                                                $perm = getPermissionNome($conn, $rowFaq['usersPerm']);
                                                $aprov = $rowFaq['usersAprov'];
                                                $fone = $rowFaq['usersFone'];
                                                $uf = $rowFaq['usersUf'];
                                                $crm = $rowFaq['usersCrm'];
                                                $espec = $rowFaq['usersEspec'];
                                                $paiscidade = $rowFaq['usersPaisCidade'];
                                                $cel = $rowFaq['usersCel'];
                                                $cpf = $rowFaq['usersCpf'];
                                                $ufdr = $rowFaq['usersUfDr'];

                                                if ($aprov == 'AGRDD') {
                                                    $aprov = 'Aguardando';
                                                } else if ($aprov == 'APROV') {
                                                    $aprov = 'Aprovado';
                                                } else if ($aprov == 'BLOQD') {
                                                    $aprov = 'Bloqueado';
                                                }

                                                if ($perm == "Doutor(a)") {
                                            ?>
                                                    <!-- INICIO CARTÃO FORUM -->

                                                    <div class="card w-100 my-2">
                                                        <div class="card-body">
                                                            <div class="container">
                                                                <div class="py-2 row d-flex justify-content-between align-items-center">
                                                                    <div class="col">
                                                                        <div class="d-flex align-items-center">
                                                                            <h2 class="pb-2 text-conecta" style="font-weight: bold;">Dr(a) <?php echo $uid; ?> <?php if ($_SESSION["userperm"] == 'Administrador') { ?><a class="btn text-info btn-xs" href="update-profile?id=<?php echo $id; ?>" target="_blank"><i class="far fa-edit"></i></a><?php } ?></h2>
                                                                        </div>
                                                                        <div class="row d-flex">
                                                                            <div class="col">
                                                                                <p>
                                                                                    <b>Dr(a):</b> <?php echo $nome; ?>
                                                                                    <br>
                                                                                    <b>E-mail:</b> <?php echo $email; ?>
                                                                                    <br>
                                                                                    <b>Cel:</b> <?php echo $cel; ?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col">
                                                                                <p>
                                                                                    <b>CR:</b> <?php echo $crm; ?>
                                                                                    <br>
                                                                                    <b>Espec:</b> <?php echo $espec; ?>
                                                                                    <br>
                                                                                    <b>UF:</b> <?php echo $uf; ?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col">
                                                                                <p>
                                                                                    <b>Fone:</b> <?php echo $fone; ?>
                                                                                    <br>
                                                                                    <b>Permissão Sistema:</b> <?php echo $perm; ?>
                                                                                    <br>
                                                                                    <b>Status Login:</b> <?php echo $aprov; ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- FIM CARTÃO FORUM -->
                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
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
                        [1, "desc"]
                    ]
                });

            });
        </script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>