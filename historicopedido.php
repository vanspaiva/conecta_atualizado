<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática') || ($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Fábrica') || ($_SESSION["userperm"] == 'Qualidade'))) {
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
                                    <h2 class="text-conecta" style="font-weight: 400;">Histórico de <span style="font-weight: 700;">Pedidos</span></h2>

                                    <form class="w-100" action="historicopedido" method="POST">
                                        <div class="col d-flex justify-content-end">
                                            <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui um pedido..." aria-label="Pesquise aqui um pedido..." aria-describedby="search-addon" />
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
                                        $query = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido LIKE '%$valorPesquisado%' ORDER BY pedDtCriacaoPed DESC") or die("Aconteceu algo errado!");
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
                                                $arrayStatus = [];
                                                $query2 = mysqli_query($conn, "SELECT * FROM prazoproposta WHERE przNumProposta LIKE '%$valorPesquisado%' ORDER BY przId DESC") or die("Aconteceu algo errado!");
                                                while ($rowFaq2 = mysqli_fetch_array($query2)) {
                                                    $nomeFluxo = getFullNomeFluxoPed($conn, $rowFaq2['przStatus']);
                                                    $dataFluxo = dateFormat2($rowFaq2['przData']);
                                                    $horaFluxo = $rowFaq2['przHora'];
                                                    $corFluxoFull = getFullCorFluxoPed($conn, $rowFaq2['przStatus']);
                                                    $item = [
                                                        "Fluxo" => $nomeFluxo,
                                                        "Data" => $dataFluxo,
                                                        "Hora" => $horaFluxo,
                                                        "Cor" => $corFluxoFull
                                                    ];

                                                    array_push($arrayStatus, $item);
                                                }
                                                $id = $rowFaq['pedPropRef'];
                                                $numped = $rowFaq['pedNumPedido'];
                                                $solicitante = $rowFaq['pedUserCriador'];
                                                $produto = $rowFaq['pedTipoProduto'];
                                                $statusTC = null;
                                                $status = $rowFaq['pedStatus'];

                                                $dr = $rowFaq['pedNomeDr'];
                                                $pac = $rowFaq['pedNomePac'];

                                                $timestamp = $rowFaq['pedDtCriacaoPed'];
                                                $timestamp = explode(" ", $timestamp);
                                                $timestampData = $timestamp[0];
                                                $timestampHora = $timestamp[1];

                                                $timestampData = explode("-", $timestampData);
                                                $data = $timestampData[2] . '/' . $timestampData[1] . '/' . $timestampData[0];

                                                $timestampHora = explode(":", $timestampHora);
                                                $hora = $timestampHora[0] . ':' . $timestampHora[1];

                                                $timestamp = $data . ' ' . $hora;

                                                $rep = $rowFaq['pedRep'];

                                                $nomeFluxoAtual = getNomeFluxoPed($conn, $numped);
                                                $corFluxo = getCorFluxoPed($conn, $numped);
                                                $propID = $rowFaq['pedPropRef'];

                                                $id = $rowFaq['pedId'];
                                                $tipoProd = $rowFaq['pedTipoProduto'];
                                                $nomedr = $rowFaq['pedNomeDr'];
                                                $nomepac = $rowFaq['pedNomePac'];

                                            ?>
                                                <!-- INICIO CARTÃO FORUM -->

                                                <div class="card w-100">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="py-2 row d-flex justify-content-between align-items-center">
                                                                <div class="col">
                                                                    <div class="d-flex align-items-center">
                                                                        <h2 class="pb-2 text-conecta" style="font-weight: bold;">Pedido <?php echo $numped; ?> - <?php echo $tipoProd; ?></h2>
                                                                        <a class="px-2 text-conecta" href="dados_proposta?id=<?php echo $propID; ?>" target="_blank">
                                                                            <h4 class="forum-link py-2"><i class="fas fa-link"></i></h4>
                                                                        </a>
                                                                    </div>
                                                                    <p>
                                                                        <b>Dr(a):</b> <?php echo $nomedr; ?>
                                                                        <br>
                                                                        <b>Pac:</b> <?php echo $nomepac; ?>
                                                                        <br>
                                                                        <b>Rep:</b> <?php echo getNomeRep($conn, $rep); ?>
                                                                    </p>
                                                                </div>


                                                                <div class="col d-flex justify-content-end">
                                                                    <p>
                                                                        Início do Projeto: <?php echo $timestamp; ?>
                                                                        <br>
                                                                        Status Atual: <span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxoAtual; ?>
                                                                    </p>

                                                                </div>
                                                            </div>

                                                            <div class="row py-2">
                                                                <div class="col">
                                                                    <h4 class="text-muted">Referente a Proposta <?php echo $propID; ?></h4>
                                                                    <div class="form-row">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col"><b>#</b></th>
                                                                                    <th scope="col"><b>Cdg</b></th>
                                                                                    <th scope="col"><b>Descrição</b></th>
                                                                                    <th scope="col"><b>Qtd</b></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $i = 1;
                                                                                $retItens = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $propID . "';");
                                                                                while ($rowItens = mysqli_fetch_array($retItens)) {
                                                                                ?>
                                                                                    <tr>
                                                                                        <th><?php echo $i ?></th>
                                                                                        <td><?php echo $rowItens['itemCdg']; ?></td>
                                                                                        <td><?php echo $rowItens['itemNome']; ?></td>
                                                                                        <td><?php echo $rowItens['itemQtd']; ?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>

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
                                    ?>

                                </div>
                                <div class="col-3">
                                    <div class="card text-black">
                                        <div class="card-body">
                                            <div class="col">

                                                <?php
                                                foreach ($arrayStatus as $chave => $valor) {
                                                    // $arr[3] será atualizado com cada valor de $arr...
                                                    foreach ($valor as $chave2 => $valor2) {
                                                        $thisstatus = $valor['Fluxo'];
                                                        $thiscor = $valor['Cor'];
                                                        $thisdata = $valor['Data'];
                                                        $thishora = $valor['Hora'];
                                                    }
                                                ?>
                                                    <div class="px-4 py-3 my-2 shadow rounded justify-content-between" style="border: 1px solid #f7f5f5;">
                                                        <div><span class="badge <?php echo $thiscor; ?>"> <?php echo $thisstatus; ?> </span> </div>
                                                        <br>
                                                        <div> <?php echo $thisdata . ' ' . $thishora; ?></div>
                                                    </div>


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