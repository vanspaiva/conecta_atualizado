<?php

session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
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

                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Lista de <span style="font-weight: 700;">Casos</span></h2>
                            <?php
                            if ($_SESSION["userperm"] == 'Administrador') {
                            ?>
                                <a href="avaliarprojeto" class="btn btn-conecta shadow">Avaliar Projetos</a>
                            <?php
                            }
                            ?>

                        </div>

                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow" style="overflow: scroll;">
                            <div class="card-body">
                                <div id="table1">
                                    <h6 style="color: #ee7624; font-weight: 400;">Pedidos</h6>
                                    <table id="tablePed" class="table table-striped table-advance table-hover bg-white rounded">

                                        <thead>
                                            <tr>
                                                <th>Situação</th>
                                                <th>Nº Callisto</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>
                                                <th>Especificação</th>
                                                <th>Fluxo</th>
                                                <th>Situação</th>
                                                <th>Data Criação</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--inicio linha de cartões-->
                                            <div class="row py-2">

                                                <?php
                                                //chamar do banco de dados todos os casos
                                                $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedStatus='IBMF' ORDER BY pedDtCriacaoPed DESC;");
                                                while ($row = mysqli_fetch_array($ret)) {
                                                    $propID = $row['pedPropRef'];
                                                    $pedID = $row['pedNumPedido'];
                                                    $tipoProd = $row['pedTipoProduto'];

                                                    $numFluxo = $row['pedPosicaoFluxo'];
                                                    $numFluxo = intval($numFluxo);
                                                    $numFluxo = $numFluxo * 20;

                                                    // $andamento = $row['pedStatus'];
                                                    $nomeFluxo = getNomeFluxoPed($conn, $pedID);
                                                    $corFluxo = getCorFluxoPed($conn, $pedID);
                                                    $contagemDias = getAndamentoForTableFluxoPed($conn, $pedID);

                                                    $andamento = $row['pedAndamento'];


                                                    switch ($andamento) {
                                                        case 'ABERTO':
                                                            $bgcor = '#5EA324';
                                                            $lettercor = '#ffffff';
                                                            break;
                                                        case 'PENDENTE':
                                                            $bgcor = '#F04152';
                                                            $lettercor = '#ffffff';
                                                            break;
                                                        case 'FINALIZADO':
                                                            $bgcor = '#536DF0';
                                                            $lettercor = '#ffffff';
                                                            break;
                                                        case 'ARQUIVADO':
                                                            $bgcor = '#F0EA59';
                                                            $lettercor = '#000000';
                                                            break;

                                                        default:
                                                            $bgcor = '#9FA0A6';
                                                            $lettercor = '#ffffff';
                                                    }

                                                    $dataBD = $row['pedDtCriacaoPed'];
                                                    $dataBD = explode(" ", $dataBD);
                                                    $date = $dataBD[0];
                                                    $date = explode("-", $date);
                                                    $data = $date[2] . '/' . $date[1] . '/' . $date[0];

                                                    //pesquisar proposta
                                                    $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='$propID';");
                                                    while ($rowProp = mysqli_fetch_array($retProp)) {
                                                        $cdgCallisto = $rowProp['propListaItens'];
                                                        $cdgCallisto = explode(',', $cdgCallisto);
                                                        $cdgImg = $cdgCallisto[0];
                                                    }

                                                    //pesquisar imagem
                                                    $retImg = mysqli_query($conn, "SELECT * FROM imagensprodutos WHERE imgprodCodCallisto='$cdgImg';");
                                                    while ($rowImg = mysqli_fetch_array($retImg)) {
                                                        $linkImg = $rowImg['imgprodLink'];
                                                        $altImg = $rowImg['imgprodNome'];
                                                        $categoria = $rowImg['imgprodCategoria'];
                                                    }
                                                    $encrypted = hashItemNatural($row['pedNumPedido']);


                                                ?>
                                                    <tr>
                                                        <td><span class="badge" style="background-color: <?php echo $bgcor; ?>; color: <?php echo $lettercor; ?>;"><?php echo $row['pedAndamento']; ?></span></td>
                                                        <td><?php echo $row['pedNumPedido']; ?></td>
                                                        <td><?php echo $row['pedNomeDr']; ?></td>
                                                        <td><?php echo $row['pedNomePac']; ?></td>
                                                        <td><?php echo $row['pedTipoProduto']; ?></td>
                                                        <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                        <td><?php echo $contagemDias; ?></td>
                                                        <td><?php echo $data; ?></td>
                                                        <td class="d-flex">
                                                            <?php
                                                            if ($row['pedStatus'] == 'Avaliar Projeto') {
                                                            ?>
                                                                <a disabled>
                                                                    <button class="btn text-muted"><i class="fas fa-edit"></i></button></a>
                                                                <a disabled>
                                                                    <button class="btn text-muted"><i class="fas fa-eye"></i></button></a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a href="update-caso?id=<?php echo $row['pedId']; ?>">
                                                                    <button class="btn text-primary"><i class="fas fa-edit"></i></button></a>
                                                                <a href="unit?id=<?php echo $encrypted; ?>">
                                                                    <button class="btn text-success"><i class="fas fa-eye"></i></button></a>
                                                                <?php
                                                                if ($_SESSION["userperm"] == 'Administrador') {
                                                                ?>
                                                                    <a href="manageCasos?id=<?php echo $row['pedId']; ?>">
                                                                        <button class="btn text-danger" onClick="return confirm('Você realmente deseja apagar esse pedido?');"><i class="far fa-trash-alt"></i></button></a>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                                <script>
                                    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
                                    triggerTabList.forEach(function(triggerEl) {
                                        var tabTrigger = new bootstrap.Tab(triggerEl)

                                        triggerEl.addEventListener('click', function(event) {
                                            event.preventDefault()
                                            tabTrigger.show()
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <script>
            $(document).ready(function() {
                $('#tablePed').DataTable({
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
                        [7, "desc"]
                    ]
                });
            });
        </script>

    <?php
    include_once 'php/footer_index.php';
} else {
    header("Location: index");
    exit();
}

    ?>