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

                        <div class="d-flex justify-content-between align-items-center d-print-none">
                            <div class="col-1">
                                <a href="relatorioplan">
                                    <div class="btn btn-light text-conecta"><i class="fas fa-arrow-left"></i></div>
                                </a>
                            </div>
                            <div class="col">
                                <h2 class="text-conecta" style="font-weight: 400;"> Atividades Diárias <span style="font-weight: 700;">
                                        dos Técnicos </span></h2>
                            </div>
                            <div class="col-5 d-flex justify-content-end align-items-center">
                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                    <form class="w-100" action="relatorioplan_1" method="POST">
                                        <div class="form-row d-flex justify-content-center align-items-center">

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="data">Data</label>
                                                <input class="form-control" type="date" name="data" id="data" <?php if ($data != 0) echo ' value="' . $data . '"'; ?>>
                                            </div>

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="tecnico">Técnico</label>
                                                <select name="tecnico" class="form-control" id="tecnico" required>
                                                    <option value="">Selecione uma opção</option>
                                                    <option value="todos" <?php if ($tecnico == 'todos') echo ' selected="selected"'; ?>>Todos</option>
                                                    <?php
                                                    $retTecnico = mysqli_query($conn, "SELECT * FROM responsavelagenda r INNER JOIN users u ON r.responsavelagendaNome = u.usersUid ORDER BY `u`.`usersName` ASC;");
                                                    while ($rowTecnico = mysqli_fetch_array($retTecnico)) {
                                                        $firstName = getPrimeiroNome($rowTecnico['usersName']);
                                                    ?>
                                                        <option value="<?php echo $rowTecnico['responsavelagendaNome']; ?>" <?php if ($tecnico == $rowTecnico['responsavelagendaNome']) echo ' selected="selected"'; ?>>
                                                            <?php echo $firstName; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md d-flex justify-content-center text-center align-items-end p-0 m-0">

                                                <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="search-addon" type="search" value="search" name="search">
                                                    <i class="fas fa-search"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                <?php } else if ($_SESSION["userperm"] == 'Planejador(a)') {
                                ?>
                                    <form class="w-100" action="quadrotecnicos" method="POST" hidden>
                                        <div class="form-row d-flex justify-content-center align-items-center">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="mes">Mês</label>
                                                <select name="mes" class="form-control" id="mes" required>
                                                    <option value="<?php echo date('m'); ?>" selected="selected"><?php echo date('m'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="tecnico">Técnico</label>
                                                <select name="tecnico" class="form-control" id="tecnico" required>
                                                    <option value="<?php echo $_SESSION["useruid"]; ?>" selected="selected"><?php echo $_SESSION["useruid"]; ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="status">Fluxo</label>
                                                <select name="status" class="form-control" id="status" required>
                                                    <option value="PROD" selected="selected">Produção</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md d-flex justify-content-center text-center align-items-end p-0 m-0">

                                                <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="search-addon" type="search" value="search" name="search">
                                                    <i class="fas fa-search"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                    <button class="btn btn-conecta" type="button" id="verify" onclick="gotoProdutividade()">Verificar Produtividade</button>
                                    <script>
                                        function gotoProdutividade() {
                                            var button = `#search-addon`;
                                            $(button).trigger('click');
                                        }
                                    </script>
                                <?php
                                } ?>
                            </div>
                        </div>

                        <hr style="border: 1px solid #ee7624" class="d-print-none">

                        <br>

                        <div class="container-fluid card shadow" style="overflow: scroll;">
                            <div class="row">
                                <div class="col">

                                    <?php
                                    if (isset($_POST["search"])) {

                                        //get the post value
                                        $data = $_POST["data"];
                                        $tecnico = $_POST["tecnico"];

                                        if ($tecnico == 'todos') {
                                            $q = "SELECT z.*, 
                                            p.*,
                                            z.przHora as hora
                                            FROM prazoproposta z
                                            LEFT JOIN pedido p ON z.przNumProposta = p.pedNumPedido
                                            WHERE z.przData = '$data'
                                            ORDER BY z.przHora DESC";
                                        } else {

                                            $q = "SELECT z.*, 
                                            p.*,
                                            z.przHora as hora
                                            FROM prazoproposta z
                                            LEFT JOIN pedido p ON z.przNumProposta = p.pedNumPedido
                                            WHERE p.pedTecnico LIKE '%$tecnico%' 
                                            AND z.przData = '$data'
                                            ORDER BY z.przHora DESC";
                                        }

                                        $query = mysqli_query($conn, $q) or die("Aconteceu algo errado!");
                                        // print_r($q);

                                        //left join com a tabela prazospropostas e pegar todos os que são prod no mes escolhido na data de prazo proposta

                                        $count =  mysqli_num_rows($query);

                                        if ($count == 0) {
                                    ?>
                                            <div class="row card-body d-flex justify-content-center p-4 m-4">
                                                <span class="alert alert-warning">Nenhum item encontrado com esse filtro</span>
                                            </div>

                                        <?php
                                        } else {

                                        ?>
                                            <div class="row d-none d-print-block">
                                                <h3 class="text-conecta"><b>Performace do Técnico - Diária </b></h3>
                                                <hr>
                                            </div>
                                            <div class="row p-4 d-flex justify-content-between">
                                                <h4 class="text-muted"><b> <?php if ($tecnico != "todos") { echo getNomeRep($conn, $tecnico) . ": " . dateFormat2($data); } else{ echo "Todos: " . dateFormat2($data); }; ?></b></h4>
                                                <div class="d-print-none d-flex justify-content-center">
                                                    <button class="btn btn-primary m-2" onclick="window.print();return false;"><i class="fa-solid fa-print"></i> Imprimir</button>
                                                </div>
                                            </div>

                                            <div class="card w-100 my-2 border-0">

                                                <div class="card-body d-flex justify-content-center">
                                                    <div class="container-fluid m-0 p-0">
                                                        <div class="row m-0 p-0">
                                                            <div class="col">
                                                                <?php
                                                                if ($tecnico == 'todos') {
                                                                ?>
                                                                    <table id="tableDesempenhoTodos" class="table table-striped table-advance table-hover">
                                                                    <?php } else { ?>
                                                                        <table id="tableDesempenho" class="table table-striped table-advance table-hover">
                                                                        <?php } ?>
                                                                    <thead class="text-center">
                                                                        <th></th>
                                                                        <th>Ped.</th>
                                                                        <?php
                                                                        if ($tecnico == 'todos') {
                                                                        ?>
                                                                            <th>Técnico</th>
                                                                        <?php } ?>
                                                                        <th>Dr(a)</th>
                                                                        <th>Prod.</th>
                                                                        <th>Hora Início</th>
                                                                        <th>Status</th>

                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $count = 1;
                                                                        $valorTotal = 0;
                                                                        while ($rowFaq = mysqli_fetch_array($query)) {
                                                                            $id = $rowFaq['pedId'];
                                                                            $tipoProduto = $rowFaq['pedTipoProduto'];
                                                                            $numPed = $rowFaq['pedNumPedido'];
                                                                            $dr = $rowFaq["pedNomeDr"];
                                                                            $dr = explode(" ", $dr);
                                                                            $dr = $dr[0] . " " . $dr[1];

                                                                            $uidtecnico = $rowFaq['pedTecnico'];

                                                                            $hora = $rowFaq["hora"];

                                                                            $status = $rowFaq["przStatus"];

                                                                            $nomeFluxo = getFullNomeFluxoPed($conn, $status);
                                                                            $corFluxo = getFullCorFluxoPed($conn, $status);


                                                                        ?>
                                                                            <tr>
                                                                                <td class="text-center d-flex">
                                                                                    <?php
                                                                                    if ($nomeFluxo == 'Avaliar Projeto') {
                                                                                    ?>
                                                                                        <a disabled>
                                                                                            <button class="btn text-muted"><i class="fas fa-edit fa-sm"></i></button></a>
                                                                                        <a disabled>
                                                                                            <button class="btn text-muted"><i class="fas fa-eye fa-sm"></i></button></a>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <a href="update-caso?id=<?php echo $id; ?>" target="_blank">
                                                                                            <button class="btn text-secondary"><i class="fas fa-edit fa-sm"></i></button>
                                                                                        </a>
                                                                                        <form class="w-100" action="historicopedido" method="POST" target="_blank" hidden>
                                                                                            <div class="col d-flex justify-content-end">
                                                                                                <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui um pedido..." aria-label="Pesquise aqui um pedido..." aria-describedby="search-addon" value="<?php echo $numPed; ?>" />
                                                                                                <div class="px-2 d-flex justify-content-center align-items-center">
                                                                                                    <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="submit<?php echo $numPed; ?>" type="search" value="search" name="search">
                                                                                                        <i class="fas fa-search"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>

                                                                                        <button id="gotohistory" class="btn text-verde" onclick="gotoHistory(<?php echo $numPed; ?>)">
                                                                                            <i class="fas fa-list-ul fa-sm"></i>
                                                                                        </button>

                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td style="font-size: 12px; text-align: center;"><?php echo $numPed; ?></td>
                                                                                <?php
                                                                                if ($tecnico == 'todos') {
                                                                                ?>
                                                                                    <td style="font-size: 12px; "><?php echo $uidtecnico; ?></td>
                                                                                <?php } ?>
                                                                                <td style="font-size: 12px; "><?php echo $dr; ?></td>
                                                                                <td style="font-size: 12px; text-align: center;"><?php echo $tipoProduto; ?></td>
                                                                                <td style="font-size: 12px; text-align: center;"><?php echo $hora; ?></td>

                                                                                <td class="text-center"><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- FIM CARTÃO FORUM -->
                                                                        <?php
                                                                            $count++;
                                                                        }
                                                                        ?>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    <?php
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
                
                $('#tableDesempenhoTodos').DataTable({
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
                        [5, "asc"]
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