<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_tables.php");
    include("includes/functions.inc.php");
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
                    if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Proposta foi deletada!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <h2 class="text-conecta" style="font-weight: 400;">Laudos Tomograficos <span style="font-weight: 700;"> de Propostas</span></h2>
                        <hr style="border-color: #ee7624;">
                        <br>

                        <div class="card shadow" style="overflow: scroll;">
                            <div class="card-body">
                                <!--Tabs for large devices-->
                                <!--Protocolar - Protocolado - Pendente - Geral-->
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link active text-tab" id="pills-protocolar-tab" data-toggle="pill" href="#pills-protocolar" role="tab" aria-controls="pills-protocolar" aria-selected="true">Protocolar</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-protocolado-tab" data-toggle="pill" href="#pills-protocolado" role="tab" aria-controls="pills-protocolado" aria-selected="true">Protocolado</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-pendente-tab" data-toggle="pill" href="#pills-pendente" role="tab" aria-controls="pills-pendente" aria-selected="false">Pendente</a>
                                        </li>
                                        <li class="nav-item px-3" role="presentation">
                                            <a class="nav-link text-tab" id="pills-geral-tab" data-toggle="pill" href="#pills-geral" role="tab" aria-controls="pills-geral" aria-selected="false">Geral</a>
                                        </li>

                                    </ul>
                                </div>

                                <!-- Tabs for smaller devices -->
                                <div class="d-flex justify-content-center">
                                    <ul class="nav nav-pills mb-3 " id="pills-tab-small" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center active text-tab" id="pills-protocolar-tab" data-toggle="pill" href="#pills-protocolar" role="tab" aria-controls="pills-protocolar" aria-selected="true"><i class="fas fa-clipboard-list fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-protocolado-tab" data-toggle="pill" href="#pills-protocolado" role="tab" aria-controls="pills-protocolado" aria-selected="true"><i class="fas fa-clipboard-check fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-pendente-tab" data-toggle="pill" href="#pills-pendente" role="tab" aria-controls="pills-pendente" aria-selected="false"><i class="fas fa-clock fa-2x"></i></a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-center text-tab" id="pills-geral-tab" data-toggle="pill" href="#pills-geral" role="tab" aria-controls="pills-geral" aria-selected="false"><i class="fas fa-archive fa-2x"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-protocolar" role="tabpanel" aria-labelledby="pills-protocolar-tab">
                                        <h4 class="text-black py-2"><b>Protocolar</b></h4>
                                        <div class="content-panel">
                                            <table id="table1" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Dt Ped</th>
                                                        <th>Nº Ped</th>
                                                        <th>Nº Transação</th>
                                                        <th>Status</th>
                                                        <th>Pac</th>
                                                        <th>Dr(a)</th>
                                                        <th>Produto</th>
                                                        <th>Laudo TC</th>
                                                        <th>Anv Dr(a)</th>
                                                        <th>Anv Pac</th>
                                                        <th>Representante</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM laudostomograficos WHERE laudoStatus = 'Protocolar';");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $idprop = $row["laudoNumProp"];
                                                        $datalaudo = $row["laudoDataDocumento"];
                                                        $laudoStatus = $row["laudoStatus"];

                                                        $sqlQuery = "SELECT * FROM propostas p 
                                                                        INNER JOIN pedido d ON d.pedNumPedido = p.propPedido
                                                                        INNER JOIN laudostomograficos l ON p.propId = l.laudoNumProp
                                                                        WHERE p.propStatus ='PEDIDO' AND p.propId = " . $idprop . ";";

                                                        $retProp = mysqli_query($conn, $sqlQuery);
                                                        // SELECT P.nome, P.preco, C.nome as Categoria FROM produto P INNER JOIN categoria_produto C ON P.id_categoria = C.id                                                   while ($rowProp = mysqli_fetch_array($retProp)) {

                                                        while ($rowProp = mysqli_fetch_array($retProp)) {
                                                            $statusTC = $rowProp['propStatusTC'];
                                                            $nomedr = $rowProp['propNomeDr'];
                                                            $nomepac = $rowProp['propNomePac'];
                                                            $produto = $rowProp['propTipoProd'];
                                                            $numPed = $rowProp['propPedido'];
                                                            $dataPedido = $rowProp['pedDtCriacaoPed'];
                                                            $dataRaw = explode(" ", $dataPedido);
                                                            $dataPedido = $dataRaw[0];

                                                            $statusQualidade = $rowProp['laudoStatus'];
                                                            $numTransacao = $rowProp['NTransacao'];
                                                            $datalaudo = $rowProp['DataLaudoTC'];
                                                            $anvdr = $rowProp['DataAnvisaDr'];
                                                            $anvpac = $rowProp['DataAnvisaPac'];
                                                            $representante = $rowProp['propRepresentante'];
                                                            // $dataPedido = dateFormat2($dataPedido);

                                                            if (strpos($rowProp['propStatusTC'], 'APROVADA')) {
                                                                $moodStatus = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                if (strpos($rowProp['propStatusTC'], 'REPROVADA')) {
                                                                    $moodStatus = "bg-danger";
                                                                } else {
                                                                    $moodStatus = "bg-secondary";
                                                                }
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                    <a href="verificacaolaudo?id=<?php echo $idprop; ?>" target="_blank">
                                                                        <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <button class="btn text-success btn-xs" data-toggle="modal" data-target="#view" onclick="populate(<?php echo $idprop; ?>)"><i class="far fa-eye"></i></button>
                                                                </td>
                                                                <td><?php echo $dataPedido; ?></td>
                                                                <td><?php echo $numPed; ?></td>
                                                                <td><?php echo $numTransacao; ?></td>
                                                                <td><?php echo $statusQualidade; ?></td>
                                                                <td><?php echo $nomepac; ?></td>
                                                                <td><?php echo $nomedr; ?></td>
                                                                <td><?php echo $produto; ?></td>
                                                                <td><?php echo dateFormat3($datalaudo); ?></td>
                                                                <td><?php echo dateFormat3($anvdr); ?></td>
                                                                <td><?php echo dateFormat3($anvpac); ?></td>
                                                                <td><?php echo $representante; ?></td>

                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-protocolado" role="tabpanel" aria-labelledby="pills-protocolado-tab">
                                        <h4 class="text-black py-2"><b>Protocolado</b></h4>
                                        <div class="content-panel">
                                            <table id="table2" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Dt Ped</th>
                                                        <th>Nº Ped</th>
                                                        <th>Nº Transação</th>
                                                        <th>Status</th>
                                                        <th>Pac</th>
                                                        <th>Dr(a)</th>
                                                        <th>Produto</th>
                                                        <th>Laudo TC</th>
                                                        <th>Anv Dr(a)</th>
                                                        <th>Anv Pac</th>
                                                        <th>Representante</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM laudostomograficos WHERE laudoStatus = 'Protocolado';");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $idprop = $row["laudoNumProp"];
                                                        $datalaudo = $row["laudoDataDocumento"];
                                                        $laudoStatus = $row["laudoStatus"];

                                                        $sqlQuery = "SELECT * FROM propostas p 
                                                                        INNER JOIN pedido d ON d.pedNumPedido = p.propPedido
                                                                        INNER JOIN laudostomograficos l ON p.propId = l.laudoNumProp
                                                                        WHERE p.propStatus ='PEDIDO' AND p.propId = " . $idprop . ";";

                                                        $retProp = mysqli_query($conn, $sqlQuery);
                                                        // SELECT P.nome, P.preco, C.nome as Categoria FROM produto P INNER JOIN categoria_produto C ON P.id_categoria = C.id                                                   while ($rowProp = mysqli_fetch_array($retProp)) {

                                                        while ($rowProp = mysqli_fetch_array($retProp)) {
                                                            $statusTC = $rowProp['propStatusTC'];
                                                            $nomedr = $rowProp['propNomeDr'];
                                                            $nomepac = $rowProp['propNomePac'];
                                                            $produto = $rowProp['propTipoProd'];
                                                            $numPed = $rowProp['propPedido'];
                                                            $dataPedido = $rowProp['pedDtCriacaoPed'];
                                                            $dataRaw = explode(" ", $dataPedido);
                                                            $dataPedido = $dataRaw[0];

                                                            $statusQualidade = $rowProp['laudoStatus'];
                                                            $numTransacao = $rowProp['NTransacao'];
                                                            $datalaudo = $rowProp['DataLaudoTC'];
                                                            $anvdr = $rowProp['DataAnvisaDr'];
                                                            $anvpac = $rowProp['DataAnvisaPac'];
                                                            $representante = $rowProp['propRepresentante'];
                                                            // $dataPedido = dateFormat2($dataPedido);

                                                            if (strpos($rowProp['propStatusTC'], 'APROVADA')) {
                                                                $moodStatus = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                if (strpos($rowProp['propStatusTC'], 'REPROVADA')) {
                                                                    $moodStatus = "bg-danger";
                                                                } else {
                                                                    $moodStatus = "bg-secondary";
                                                                }
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                    <a href="verificacaolaudo?id=<?php echo $idprop; ?>" target="_blank">
                                                                        <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <button class="btn text-success btn-xs" data-toggle="modal" data-target="#view" onclick="populate(<?php echo $idprop; ?>)"><i class="far fa-eye"></i></button>
                                                                </td>
                                                                <td><?php echo $dataPedido; ?></td>
                                                                <td><?php echo $numPed; ?></td>
                                                                <td><?php echo $numTransacao; ?></td>
                                                                <td><?php echo $statusQualidade; ?></td>
                                                                <td><?php echo $nomepac; ?></td>
                                                                <td><?php echo $nomedr; ?></td>
                                                                <td><?php echo $produto; ?></td>
                                                                <td><?php echo dateFormat3($datalaudo); ?></td>
                                                                <td><?php echo dateFormat3($anvdr); ?></td>
                                                                <td><?php echo dateFormat3($anvpac); ?></td>
                                                                <td><?php echo $representante; ?></td>

                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-pendente" role="tabpanel" aria-labelledby="pills-pendente-tab">
                                        <h4 class="text-black py-2"><b>Pendente</b></h4>
                                        <div class="content-panel">
                                            <table id="table3" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Dt Ped</th>
                                                        <th>Nº Ped</th>
                                                        <th>Nº Transação</th>
                                                        <th>Status</th>
                                                        <th>Pac</th>
                                                        <th>Dr(a)</th>
                                                        <th>Produto</th>
                                                        <th>Laudo TC</th>
                                                        <th>Anv Dr(a)</th>
                                                        <th>Anv Pac</th>
                                                        <th>Representante</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM laudostomograficos WHERE laudoStatus = 'Pendente';");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $idprop = $row["laudoNumProp"];
                                                        $datalaudo = $row["laudoDataDocumento"];
                                                        $laudoStatus = $row["laudoStatus"];

                                                        $sqlQuery = "SELECT * FROM propostas p 
                                                                        INNER JOIN pedido d ON d.pedNumPedido = p.propPedido
                                                                        INNER JOIN laudostomograficos l ON p.propId = l.laudoNumProp
                                                                        WHERE p.propStatus ='PEDIDO' AND p.propId = " . $idprop . ";";

                                                        $retProp = mysqli_query($conn, $sqlQuery);
                                                        // SELECT P.nome, P.preco, C.nome as Categoria FROM produto P INNER JOIN categoria_produto C ON P.id_categoria = C.id                                                   while ($rowProp = mysqli_fetch_array($retProp)) {

                                                        while ($rowProp = mysqli_fetch_array($retProp)) {
                                                            $statusTC = $rowProp['propStatusTC'];
                                                            $nomedr = $rowProp['propNomeDr'];
                                                            $nomepac = $rowProp['propNomePac'];
                                                            $produto = $rowProp['propTipoProd'];
                                                            $numPed = $rowProp['propPedido'];
                                                            $dataPedido = $rowProp['pedDtCriacaoPed'];
                                                            $dataRaw = explode(" ", $dataPedido);
                                                            $dataPedido = $dataRaw[0];

                                                            $statusQualidade = $rowProp['laudoStatus'];
                                                            $numTransacao = $rowProp['NTransacao'];
                                                            $datalaudo = $rowProp['DataLaudoTC'];
                                                            $anvdr = $rowProp['DataAnvisaDr'];
                                                            $anvpac = $rowProp['DataAnvisaPac'];
                                                            $representante = $rowProp['propRepresentante'];
                                                            // $dataPedido = dateFormat2($dataPedido);

                                                            if (strpos($rowProp['propStatusTC'], 'APROVADA')) {
                                                                $moodStatus = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                if (strpos($rowProp['propStatusTC'], 'REPROVADA')) {
                                                                    $moodStatus = "bg-danger";
                                                                } else {
                                                                    $moodStatus = "bg-secondary";
                                                                }
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                    <a href="verificacaolaudo?id=<?php echo $idprop; ?>" target="_blank">
                                                                        <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <button class="btn text-success btn-xs" data-toggle="modal" data-target="#view" onclick="populate(<?php echo $idprop; ?>)"><i class="far fa-eye"></i></button>
                                                                </td>
                                                                <td><?php echo $dataPedido; ?></td>
                                                                <td><?php echo $numPed; ?></td>
                                                                <td><?php echo $numTransacao; ?></td>
                                                                <td><?php echo $statusQualidade; ?></td>
                                                                <td><?php echo $nomepac; ?></td>
                                                                <td><?php echo $nomedr; ?></td>
                                                                <td><?php echo $produto; ?></td>
                                                                <td><?php echo dateFormat3($datalaudo); ?></td>
                                                                <td><?php echo dateFormat3($anvdr); ?></td>
                                                                <td><?php echo dateFormat3($anvpac); ?></td>
                                                                <td><?php echo $representante; ?></td>

                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-geral" role="tabpanel" aria-labelledby="pills-geral-tab">
                                        <h4 class="text-black py-2"><b>Geral</b></h4>
                                        <div class="content-panel">
                                            <table id="table4" class="table table-striped table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Dt Ped</th>
                                                        <th>Nº Ped</th>
                                                        <th>Nº Transação</th>
                                                        <th>Status</th>
                                                        <th>Pac</th>
                                                        <th>Dr(a)</th>
                                                        <th>Produto</th>
                                                        <th>Laudo TC</th>
                                                        <th>Anv Dr(a)</th>
                                                        <th>Anv Pac</th>
                                                        <th>Representante</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'includes/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM laudostomograficos;");

                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $idprop = $row["laudoNumProp"];
                                                        $datalaudo = $row["laudoDataDocumento"];
                                                        $laudoStatus = $row["laudoStatus"];

                                                        $sqlQuery = "SELECT * FROM propostas p 
                                                                        INNER JOIN pedido d ON d.pedNumPedido = p.propPedido
                                                                        INNER JOIN laudostomograficos l ON p.propId = l.laudoNumProp
                                                                        WHERE p.propStatus ='PEDIDO' AND p.propId = " . $idprop . ";";

                                                        $retProp = mysqli_query($conn, $sqlQuery);
                                                        // SELECT P.nome, P.preco, C.nome as Categoria FROM produto P INNER JOIN categoria_produto C ON P.id_categoria = C.id                                                   while ($rowProp = mysqli_fetch_array($retProp)) {

                                                        while ($rowProp = mysqli_fetch_array($retProp)) {
                                                            $statusTC = $rowProp['propStatusTC'];
                                                            $nomedr = $rowProp['propNomeDr'];
                                                            $nomepac = $rowProp['propNomePac'];
                                                            $produto = $rowProp['propTipoProd'];
                                                            $numPed = $rowProp['propPedido'];
                                                            $dataPedido = $rowProp['pedDtCriacaoPed'];
                                                            $dataRaw = explode(" ", $dataPedido);
                                                            $dataPedido = $dataRaw[0];

                                                            $statusQualidade = $rowProp['laudoStatus'];
                                                            $numTransacao = $rowProp['NTransacao'];
                                                            $datalaudo = $rowProp['DataLaudoTC'];
                                                            $anvdr = $rowProp['DataAnvisaDr'];
                                                            $anvpac = $rowProp['DataAnvisaPac'];
                                                            $representante = $rowProp['propRepresentante'];
                                                            // $dataPedido = dateFormat2($dataPedido);

                                                            if (strpos($rowProp['propStatusTC'], 'APROVADA')) {
                                                                $moodStatus = "bg-success";
                                                                $colorText = "";
                                                            } else {
                                                                if (strpos($rowProp['propStatusTC'], 'REPROVADA')) {
                                                                    $moodStatus = "bg-danger";
                                                                } else {
                                                                    $moodStatus = "bg-secondary";
                                                                }
                                                            }

                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                                    <a href="verificacaolaudo?id=<?php echo $idprop; ?>" target="_blank">
                                                                        <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <button class="btn text-success btn-xs" data-toggle="modal" data-target="#view" onclick="populate(<?php echo $idprop; ?>)"><i class="far fa-eye"></i></button>
                                                                </td>
                                                                <td><?php echo $dataPedido; ?></td>
                                                                <td><?php echo $numPed; ?></td>
                                                                <td><?php echo $numTransacao; ?></td>
                                                                <td><?php echo $statusQualidade; ?></td>
                                                                <td><?php echo $nomepac; ?></td>
                                                                <td><?php echo $nomedr; ?></td>
                                                                <td><?php echo $produto; ?></td>
                                                                <td><?php echo dateFormat3($datalaudo); ?></td>
                                                                <td><?php echo dateFormat3($anvdr); ?></td>
                                                                <td><?php echo dateFormat3($anvpac); ?></td>
                                                                <td><?php echo $representante; ?></td>

                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
            //table1
            $(document).ready(function() {
                $('#table1').DataTable({
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
                        "zeroRecords": "Nenhum documento encontrado"
                    },
                    "order": [
                        [1, "desc"]
                    ]
                });
                $('#table2').DataTable({
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
                        "zeroRecords": "Nenhum documento encontrado"
                    },
                    "order": [
                        [1, "desc"]
                    ]
                });
                $('#table3').DataTable({
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
                        "zeroRecords": "Nenhum documento encontrado"
                    },
                    "order": [
                        [1, "desc"]
                    ]
                });
                $('#table4').DataTable({
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
                        "zeroRecords": "Nenhum documento encontrado"
                    },
                    "order": [
                        [1, "desc"]
                    ]
                });
            });
        </script>
        <!-- Modal View -->
        <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black">Informações do Pedido <span id="viewnpedTopo"></span> - <span class="badge badge-warning">
                                <span id="viewstatus" name="viewstatus"></span>
                            </span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row" hidden>
                            <div class="form-group col-md">
                                <h5 class="text-conecta" for="viewid">Nº Proposta</h5>
                                <p id="viewid" name="viewid"></p>
                            </div>
                        </div>

                        <div class="form-row">
                            <table class="table table-striped">
                                <thead class="table-secondary">
                                    <th class="text-center"><b>Dr(a)</b></th>
                                    <th class="text-center"><b>Pac</b></th>
                                    <th class="text-center"><b>Produto</b></th>
                                    <th class="text-center"><b>Rep</b></th>
                                </thead>
                                <tbody>
                                    <td class="text-center">
                                        <p id="viewdr"></p>
                                    </td>
                                    <td class="text-center">
                                        <p id="viewpac"></p>
                                    </td>
                                    <td class="text-center">
                                        <p id="viewprod"></p>
                                    </td>
                                    <td class="text-center">
                                        <p id="viewrep"></p>
                                    </td>
                                </tbody>
                            </table>

                        </div>

                        <div class="form-row d-flex justify-content-center">
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewnped">Nº Pedido</h5>
                                <p class="text-center" id="viewnped" name="viewnped"></p>
                            </div>
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewdtped">Dt Pedido</h5>
                                <p class="text-center" id="viewdtped" name="viewdtped"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row d-flex justify-content-center">
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewntransacao">Nº Transação</h5>
                                <b>
                                    <p class="text-center" id="viewntransacao" name="viewntransacao"></p>
                                </b>
                            </div>
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewnexpedicao">Nº Expedição</h5>
                                <b>
                                    <p class="text-center" id="viewnexpedicao" name="viewnexpedicao"></p>
                                </b>
                            </div>
                        </div>

                        <div class="form-row d-flex justify-content-center">
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewlaudotc">Laudo TC</h5>
                                <b>
                                    <p class="text-center" id="viewlaudotc" name="viewlaudotc"></p>
                                </b>
                            </div>
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewanvdr">Anv Dr(a)</h5>
                                <b>
                                    <p class="text-center" id="viewanvdr" name="viewanvdr"></p>
                                </b>
                            </div>
                            <div class="form-group col-md">
                                <h5 class="text-conecta text-center" for="viewanvpac">Anv Pac</h5>
                                <b>
                                    <p class="text-center" id="viewanvpac" name="viewanvpac"></p>
                                </b>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
        <script>
            function populate(id) {
                //Recuperar o valor do campo
                var pesquisa = id;
                // console.log(pesquisa);

                //Verificar se há algo digitado
                if (pesquisa != '') {
                    var dados = {
                        id: pesquisa
                    }
                    $.post('pesq_idlaudo.php', dados, function(retorna) {
                        // console.log(retorna);
                        //Mostra dentro da ul os resultado obtidos 
                        var array = retorna.split(',');
                        // $result = $laudoNumProp . ',' . $laudoStatus . ',' . $laudoDataDocumento . ',' . $laudoDataExame . ',' . $DataLaudoTC . ',' . $DataAnvisaDr . ',' . $DataAnvisaPac . ',' . $NTransacao . ',' . $NExpedicao . ',' . $propNomeDr . ',' . $propNomePac . ',' . $propRepresentante. ',' . $propPedido. ',' . $propTipoProd;
                        console.log(array);

                        var laudoNumProp = array[0];
                        var laudoStatus = array[1];
                        var laudoDataDocumento = array[2];
                        var laudoDataExame = array[3];
                        var DataLaudoTC = array[4];
                        var DataAnvisaDr = array[5];
                        var DataAnvisaPac = array[6];
                        var NTransacao = array[7];
                        var NExpedicao = array[8];
                        var propNomeDr = array[9];
                        var propNomePac = array[10];
                        var propRepresentante = array[11];
                        var propPedido = array[12];
                        var propTipoProd = array[13];
                        var pedDtCriacaoPed = array[14];

                        document.getElementById('viewid').innerHTML = laudoNumProp;
                        document.getElementById('viewnped').innerHTML = propPedido;
                        document.getElementById('viewnpedTopo').innerHTML = propPedido;
                        document.getElementById('viewdtped').innerHTML = formatarData(pedDtCriacaoPed);
                        document.getElementById('viewntransacao').innerHTML = NTransacao;
                        document.getElementById('viewnexpedicao').innerHTML = NExpedicao;
                        document.getElementById('viewstatus').innerHTML = laudoStatus;

                        document.getElementById('viewdr').innerHTML = propNomeDr;
                        document.getElementById('viewpac').innerHTML = propNomePac;
                        document.getElementById('viewprod').innerHTML = propTipoProd;
                        document.getElementById('viewrep').innerHTML = propRepresentante;

                        document.getElementById('viewlaudotc').innerHTML = formatarData(DataLaudoTC);
                        document.getElementById('viewanvdr').innerHTML = formatarData(DataAnvisaDr);
                        document.getElementById('viewanvpac').innerHTML = formatarData(DataAnvisaPac);


                        // console.log(retorna);
                    });
                }

                function formatarData(data) {
                    const dataPartes = data.split(" ");
                    const dataPartesData = dataPartes[0].split("-");
                    const dataFormatada = `${dataPartesData[2]}/${dataPartesData[1]}/${dataPartesData[0]}`;
                    return dataFormatada;
                }
            }
        </script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js" defer></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>