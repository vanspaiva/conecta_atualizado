<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Analista Dados'))) {
    include("php/head_tables.php");
    $user = $_SESSION["useruid"];

?>
    <style>
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

        .text-roxo {
            color: #9B44C9;
        }

        .dataTables_length label,
        .dataTables_length select,
        .dataTables_filter label,
        .dataTables_filter label input:focus,
        .dataTables_filter label input {
            color: white;
        }
    </style>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Proposta editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "stmfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                    } else if ($_GET["error"] == "commenterror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Alguma coisa deu errado! Comentário não enviado!</p></div>";
                    } else if ($_GET["error"] == "commentesent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Comentário enviado com sucesso!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm" id="titulo-pag">
                        <h2 class="text-conecta" style="font-weight: 400;">Solicitação de <span style="font-weight: 800;"> Clientes</span></h2>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                                    <!--Tabs for large devices-->
                                    <div class="d-flex justify-content-center">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item px-3" role="presentation">
                                                <a class="nav-link active text-tab" id="pills-propostas-tab" data-toggle="pill" href="#pills-propostas" role="tab" aria-controls="pills-propostas" aria-selected="true">Propostas</a>
                                            </li>
                                            <!--<li class="nav-item px-3" role="presentation">
                                                <a class="nav-link text-tab" id="pills-pedidos-tab" data-toggle="pill" href="#pills-pedidos" role="tab" aria-controls="pills-pedidos" aria-selected="true">Pedidos</a>
                                            </li>-->
                                        </ul>
                                    </div>

                                    <!-- Tabs for smaller devices -->
                                    <div class="d-flex justify-content-center">
                                        <ul class="nav nav-pills mb-3 " id="pills-tab-small" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link d-flex justify-content-center active text-tab" id="pills-propostas-tab" data-toggle="pill" href="#pills-propostas" role="tab" aria-controls="pills-propostas" aria-selected="true"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>
                                            </li>
                                            <!--<li class="nav-item" role="presentation">
                                                <a class="nav-link d-flex justify-content-center text-tab" id="pills-pedidos-tab" data-toggle="pill" href="#pills-pedidos" role="tab" aria-controls="pills-pedidos" aria-selected="true"><i class="fas fa-laptop fa-2x"></i></a>
                                            </li>-->
                                        </ul>
                                    </div>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-propostas" role="tabpanel" aria-labelledby="pills-propostas-tab">
                                            <div class="row">
                                                <div class="col">
                                                    <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                                                    <!--Tabs for large devices-->
                                                    <div class="d-flex justify-content-center">
                                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                            <li class="nav-item px-3" role="presentation">
                                                                <a class="nav-link active text-tab" id="pills-analisar-tab" data-toggle="pill" href="#pills-analisar" role="tab" aria-controls="pills-analisar" aria-selected="true">Analisar</a>
                                                            </li>
                                                            <li class="nav-item px-3" role="presentation">
                                                                <a class="nav-link text-tab" id="pills-todas-propostas-tab" data-toggle="pill" href="#pills-todas-propostas" role="tab" aria-controls="pills-todas-propostas" aria-selected="true">Todas</a>
                                                            </li>
                                                            <li class="nav-item px-3" role="presentation">
                                                                <a class="nav-link text-tab" id="pills-enviadas-tab" data-toggle="pill" href="#pills-enviadas" role="tab" aria-controls="pills-enviadas" aria-selected="true">Enviadas</a>
                                                            </li>
                                                            <li class="nav-item px-3" role="presentation">
                                                                <a class="nav-link text-tab" id="pills-aprovadas-tab" data-toggle="pill" href="#pills-aprovadas" role="tab" aria-controls="pills-aprovadas" aria-selected="false">Aprovadas</a>
                                                            </li>
                                                            <li class="nav-item px-3" role="presentation">
                                                                <a class="nav-link text-tab" id="pills-proppedidos-tab" data-toggle="pill" href="#pills-proppedidos" role="tab" aria-controls="pills-proppedidos" aria-selected="false">Pedidos</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Tabs for smaller devices -->
                                                    <div class="d-flex justify-content-center">
                                                        <ul class="nav nav-pills mb-3 " id="pills-tab-small" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link d-flex justify-content-center active text-tab" id="pills-analisar-tab" data-toggle="pill" href="#pills-analisar" role="tab" aria-controls="pills-analisar" aria-selected="true"><i class="fas fa-clock fa-2x"></i></a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link d-flex justify-content-center text-tab" id="pills-todas-propostas-tab" data-toggle="pill" href="#pills-todas-propostas" role="tab" aria-controls="pills-todas-propostas" aria-selected="true"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link d-flex justify-content-center text-tab" id="pills-enviadas-tab" data-toggle="pill" href="#pills-enviadas" role="tab" aria-controls="pills-enviadas" aria-selected="true"><i class="fas fa-file-import fa-2x"></i></a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link d-flex justify-content-center text-tab" id="pills-aprovadas-tab" data-toggle="pill" href="#pills-aprovadas" role="tab" aria-controls="pills-aprovadas" aria-selected="false"><i class="fas fa-clipboard-check fa-2x"></i></a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link d-flex justify-content-center text-tab" id="pills-proppedidos-tab" data-toggle="pill" href="#pills-proppedidos" role="tab" aria-controls="pills-proppedidos" aria-selected="false"><i class="fas fa-boxes fa-2x"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="tab-content" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="pills-analisar" role="tabpanel" aria-labelledby="pills-analisar-tab">
                                                            <h4 class="text-conecta py-2"><b>Propostas para Analisar</b></h4>
                                                            <div class="content-panel">
                                                                <table id="tableProp2" class="table table-striped table-advance table-hover bg-white rounded">
                                                                    <thead class="text-conecta">
                                                                        <tr>
                                                                            <th>Nº</th>
                                                                            <th>Data Chegada</th>
                                                                            <th>Status</th>
                                                                            <th>Status TC</th>
                                                                            <th>Empresa</th>
                                                                            <th>Dr(a)</th>
                                                                            <th>Paciente</th>
                                                                            <th>E-mail</th>
                                                                            <th>Usuário Criador</th>
                                                                            <th>Produto</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="background-color: white;">
                                                                        <?php
                                                                        require_once 'includes/dbh.inc.php';

                                                                        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PENDENTE%'");
                                                                        while ($row = mysqli_fetch_array($ret)) {
                                                                            if ($row['propRepresentante'] == $_SESSION["useruid"]) {
                                                                                $retFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                                                if (($retFin) && ($retFin->num_rows != 0)) {
                                                                                    $temFin = true;
                                                                                } else {
                                                                                    $temFin = false;
                                                                                }


                                                                                $dataCompleta = $row['propDataCriacao'];
                                                                                $dataArray = explode(" ", $dataCompleta);
                                                                                $data = $dataArray[0];

                                                                                //Cores Status TC
                                                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                                                    $moodStatus = "bg-success";
                                                                                    $colorText = "";
                                                                                } else {

                                                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                                                        $moodStatus = "bg-danger";
                                                                                    } else {
                                                                                        $moodStatus = "bg-amarelo text-dark";
                                                                                    }
                                                                                }


                                                                                //Cores Status Comercial
                                                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                                                    $moodStatusComercial = "bg-amarelo";
                                                                                } else {

                                                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                                                        $moodStatusComercial = "bg-verde-claro";
                                                                                    } else {
                                                                                        if ($row['propStatus'] == 'APROVADO') {
                                                                                            $moodStatusComercial = "bg-verde text-white";
                                                                                        } else {
                                                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                                                $moodStatusComercial = "bg-roxo text-white";
                                                                                            } else {
                                                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                                                } else {
                                                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                                                        $moodStatusComercial = "bg-rosa";
                                                                                                    } else {
                                                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                                                        } else {
                                                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                                                            } else {
                                                                                                                $moodStatusComercial = "bg-amarelo";
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if ($row['propEmpresa'] != null) {
                                                                                    $empresa = $row['propEmpresa'];
                                                                                    $classEmpresa = '';
                                                                                } else {
                                                                                    $empresa = '-';
                                                                                    $classEmpresa = 'class="text-center"';
                                                                                }

                                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                                // $encrypted = urlencode($encrypted);

                                                                                $encrypted = hashItem($row['propId']);
                                                                        ?>

                                                                                <tr>
                                                                                    <td><?php echo $row['propId']; ?></td>
                                                                                    <td><?php echo $data; ?></td>
                                                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                                                    <td><?php echo $row['propTipoProd']; ?></td>

                                                                                    <td class="d-flex justify-content-around">

                                                                                        <!--<span class="btn text-roxo" data-toggle="modal" data-target="#adicionarcomentario" onclick="populateNumProposta(<?php echo $row['propId']; ?>, '<?php echo $row['propTxtRepresentante']; ?>')"><i class="bi bi-chat-text-fill"></i></span>-->

                                                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>

                                                                                        <!--<a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                                            <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>-->

                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                        <div class="tab-pane fade" id="pills-todas-propostas" role="tabpanel" aria-labelledby="pills-todas-propostas-tab">
                                                            <h4 class="text-conecta py-2"><b>Propostas Em Andamento</b></h4>
                                                            <div class="content-panel">
                                                                <table id="tableProp" class="table table-striped table-advance table-hover bg-white rounded">
                                                                    <thead class="text-conecta">
                                                                        <tr>
                                                                            <th>Nº</th>
                                                                            <th>Data Chegada</th>
                                                                            <th>Status</th>
                                                                            <th>Status TC</th>
                                                                            <th>Empresa</th>
                                                                            <th>Dr(a)</th>
                                                                            <th>Paciente</th>
                                                                            <th>E-mail</th>
                                                                            <th>Usuário Criador</th>
                                                                            <th>Produto</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="background-color: white;">
                                                                        <?php
                                                                        require_once 'includes/dbh.inc.php';

                                                                        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE NOT propStatus LIKE '%PEDIDO%'");
                                                                        while ($row = mysqli_fetch_array($ret)) {
                                                                            if ($row['propRepresentante'] == $_SESSION["useruid"]) {
                                                                                $retFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                                                if (($retFin) && ($retFin->num_rows != 0)) {
                                                                                    $temFin = true;
                                                                                } else {
                                                                                    $temFin = false;
                                                                                }


                                                                                $dataCompleta = $row['propDataCriacao'];
                                                                                $dataArray = explode(" ", $dataCompleta);
                                                                                $data = $dataArray[0];

                                                                                //Cores Status TC
                                                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                                                    $moodStatus = "bg-success";
                                                                                    $colorText = "";
                                                                                } else {

                                                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                                                        $moodStatus = "bg-danger";
                                                                                    } else {
                                                                                        $moodStatus = "bg-amarelo text-dark";
                                                                                    }
                                                                                }


                                                                                //Cores Status Comercial
                                                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                                                    $moodStatusComercial = "bg-amarelo";
                                                                                } else {

                                                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                                                        $moodStatusComercial = "bg-verde-claro";
                                                                                    } else {
                                                                                        if ($row['propStatus'] == 'APROVADO') {
                                                                                            $moodStatusComercial = "bg-verde text-white";
                                                                                        } else {
                                                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                                                $moodStatusComercial = "bg-roxo text-white";
                                                                                            } else {
                                                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                                                } else {
                                                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                                                        $moodStatusComercial = "bg-rosa";
                                                                                                    } else {
                                                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                                                        } else {
                                                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                                                            } else {
                                                                                                                $moodStatusComercial = "bg-amarelo";
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if ($row['propEmpresa'] != null) {
                                                                                    $empresa = $row['propEmpresa'];
                                                                                    $classEmpresa = '';
                                                                                } else {
                                                                                    $empresa = '-';
                                                                                    $classEmpresa = 'class="text-center"';
                                                                                }

                                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                                // $encrypted = urlencode($encrypted);

                                                                                $encrypted = hashItem($row['propId']);
                                                                        ?>

                                                                                <tr>
                                                                                    <td><?php echo $row['propId']; ?></td>
                                                                                    <td><?php echo $data; ?></td>
                                                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                                                    <td><?php echo $row['propTipoProd']; ?></td>

                                                                                    <td class="d-flex justify-content-around">
                                                                                        <!--<span class="btn text-roxo" data-toggle="modal" data-target="#adicionarcomentario" onclick="populateNumProposta(<?php echo $row['propId']; ?>, '<?php echo $row['propTxtRepresentante']; ?>')"><i class="bi bi-chat-text-fill"></i></span>-->
                                                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>
                                                                                        <!--<a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                                            <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>-->

                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-enviadas" role="tabpanel" aria-labelledby="pills-enviadas-tab">
                                                            <h4 class="text-conecta py-2"><b>Propostas Enviadas</b></h4>
                                                            <div class="content-panel">
                                                                <table id="tableEnviada" class="table table-striped table-advance table-hover bg-white">
                                                                    <thead class="text-conecta">
                                                                        <tr>
                                                                            <th>Nº</th>
                                                                            <th>Data Chegada</th>
                                                                            <th>Status</th>
                                                                            <th>Status TC</th>
                                                                            <th>Empresa</th>
                                                                            <th>Dr(a)</th>
                                                                            <th>Paciente</th>
                                                                            <th>E-mail</th>
                                                                            <th>Usuário Criador</th>
                                                                            <th>Produto</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="background-color: white;">
                                                                        <?php
                                                                        require_once 'includes/dbh.inc.php';
                                                                        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PROP. ENVIADA%'");
                                                                        while ($row = mysqli_fetch_array($ret)) {
                                                                            if ($row['propRepresentante'] == $_SESSION["useruid"]) {
                                                                                $retFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                                                if (($retFin) && ($retFin->num_rows != 0)) {
                                                                                    $temFin = true;
                                                                                } else {
                                                                                    $temFin = false;
                                                                                }

                                                                                $dataCompleta = $row['propDataCriacao'];
                                                                                $dataArray = explode(" ", $dataCompleta);
                                                                                $data = $dataArray[0];

                                                                                //Cores Status TC
                                                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                                                    $moodStatus = "bg-success";
                                                                                    $colorText = "";
                                                                                } else {

                                                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                                                        $moodStatus = "bg-danger";
                                                                                    } else {
                                                                                        $moodStatus = "bg-amarelo text-dark";
                                                                                    }
                                                                                }


                                                                                //Cores Status Comercial
                                                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                                                    $moodStatusComercial = "bg-amarelo";
                                                                                } else {

                                                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                                                        $moodStatusComercial = "bg-verde-claro";
                                                                                    } else {
                                                                                        if ($row['propStatus'] == 'APROVADO') {
                                                                                            $moodStatusComercial = "bg-verde text-white";
                                                                                        } else {
                                                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                                                $moodStatusComercial = "bg-roxo text-white";
                                                                                            } else {
                                                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                                                } else {
                                                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                                                        $moodStatusComercial = "bg-rosa";
                                                                                                    } else {
                                                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                                                        } else {
                                                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                                                            } else {
                                                                                                                $moodStatusComercial = "bg-amarelo";
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if ($row['propEmpresa'] != null) {
                                                                                    $empresa = $row['propEmpresa'];
                                                                                    $classEmpresa = '';
                                                                                } else {
                                                                                    $empresa = '-';
                                                                                    $classEmpresa = 'class="text-center"';
                                                                                }

                                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                                // $encrypted = urlencode($encrypted);

                                                                                $encrypted = hashItem($row['propId']);
                                                                        ?>

                                                                                <tr>
                                                                                    <td><?php echo $row['propId']; ?></td>
                                                                                    <td><?php echo $data; ?></td>
                                                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                                                    <td><?php echo $row['propTipoProd']; ?></td>

                                                                                    <td class="d-flex justify-content-around">
                                                                                        <!--<span class="btn text-roxo" data-toggle="modal" data-target="#adicionarcomentario" onclick="populateNumProposta(<?php echo $row['propId']; ?>, '<?php echo $row['propTxtRepresentante']; ?>')"><i class="bi bi-chat-text-fill"></i></span>-->
                                                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>
                                                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                                                        <!--<a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                                            <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>-->

                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-aprovadas" role="tabpanel" aria-labelledby="pills-aprovadas-tab">
                                                            <h4 class="text-conecta py-2"><b>Propostas Aprovadas Pelos Clientes</b></h4>
                                                            <div class="content-panel">
                                                                <table id="tableAprov" class="table table-striped table-advance table-hover bg-white">
                                                                    <thead class="text-conecta">
                                                                        <tr>
                                                                            <th>Nº</th>
                                                                            <th>Data Chegada</th>
                                                                            <th>Status</th>
                                                                            <th>Status TC</th>
                                                                            <th>Empresa</th>
                                                                            <th>Dr(a)</th>
                                                                            <th>Paciente</th>
                                                                            <th>E-mail</th>
                                                                            <th>Usuário Criador</th>
                                                                            <th>Produto</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="background-color: white;">
                                                                        <?php
                                                                        require_once 'includes/dbh.inc.php';
                                                                        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%APROVADO%'");
                                                                        while ($row = mysqli_fetch_array($ret)) {
                                                                            if ($row['propRepresentante'] == $_SESSION["useruid"]) {
                                                                                $retFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                                                if (($retFin) && ($retFin->num_rows != 0)) {
                                                                                    $temFin = true;
                                                                                } else {
                                                                                    $temFin = false;
                                                                                }

                                                                                $dataCompleta = $row['propDataCriacao'];
                                                                                $dataArray = explode(" ", $dataCompleta);
                                                                                $data = $dataArray[0];

                                                                                //Cores Status TC
                                                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                                                    $moodStatus = "bg-success";
                                                                                    $colorText = "";
                                                                                } else {

                                                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                                                        $moodStatus = "bg-danger";
                                                                                    } else {
                                                                                        $moodStatus = "bg-amarelo text-dark";
                                                                                    }
                                                                                }


                                                                                //Cores Status Comercial
                                                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                                                    $moodStatusComercial = "bg-amarelo";
                                                                                } else {

                                                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                                                        $moodStatusComercial = "bg-verde-claro";
                                                                                    } else {
                                                                                        if ($row['propStatus'] == 'APROVADO') {
                                                                                            $moodStatusComercial = "bg-verde text-white";
                                                                                        } else {
                                                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                                                $moodStatusComercial = "bg-roxo text-white";
                                                                                            } else {
                                                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                                                } else {
                                                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                                                        $moodStatusComercial = "bg-rosa";
                                                                                                    } else {
                                                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                                                        } else {
                                                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                                                            } else {
                                                                                                                $moodStatusComercial = "bg-amarelo";
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if ($row['propEmpresa'] != null) {
                                                                                    $empresa = $row['propEmpresa'];
                                                                                    $classEmpresa = '';
                                                                                } else {
                                                                                    $empresa = '-';
                                                                                    $classEmpresa = 'class="text-center"';
                                                                                }

                                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                                // $encrypted = urlencode($encrypted);

                                                                                $encrypted = hashItem($row['propId']);
                                                                        ?>

                                                                                <tr>
                                                                                    <td><?php echo $row['propId']; ?></td>
                                                                                    <td><?php echo $data; ?></td>
                                                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                                                    <td><?php echo $row['propTipoProd']; ?></td>

                                                                                    <td class="d-flex justify-content-around">
                                                                                        <!--<span class="btn text-roxo" data-toggle="modal" data-target="#adicionarcomentario" onclick="populateNumProposta(<?php echo $row['propId']; ?>, '<?php echo $row['propTxtRepresentante']; ?>')"><i class="bi bi-chat-text-fill"></i></span>-->
                                                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>
                                                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                                                        <!--<a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                                            <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>-->

                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-proppedidos" role="tabpanel" aria-labelledby="pills-proppedidos-tab">
                                                            <h4 class="text-conecta py-2"><b>Pedidos (Propostas que viraram pedidos)</b></h4>
                                                            <div class="content-panel">
                                                                <table id="tablePropPed" class="table table-striped table-advance table-hover bg-white">
                                                                    <thead class="text-conecta">
                                                                        <tr>
                                                                            <th>Nº</th>
                                                                            <th>Data Chegada</th>
                                                                            <th>Status</th>
                                                                            <th>Status TC</th>
                                                                            <th>Empresa</th>
                                                                            <th>Dr(a)</th>
                                                                            <th>Paciente</th>
                                                                            <th>E-mail</th>
                                                                            <th>Usuário Criador</th>
                                                                            <th>Produto</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="background-color: white;">
                                                                        <?php
                                                                        require_once 'includes/dbh.inc.php';
                                                                        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PEDIDO%'");
                                                                        while ($row = mysqli_fetch_array($ret)) {
                                                                            if ($row['propRepresentante'] == $_SESSION["useruid"]) {
                                                                                $retFin = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                                                if (($retFin) && ($retFin->num_rows != 0)) {
                                                                                    $temFin = true;
                                                                                } else {
                                                                                    $temFin = false;
                                                                                }

                                                                                $dataCompleta = $row['propDataCriacao'];
                                                                                $dataArray = explode(" ", $dataCompleta);
                                                                                $data = $dataArray[0];

                                                                                //Cores Status TC
                                                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                                                    $moodStatus = "bg-success";
                                                                                    $colorText = "";
                                                                                } else {

                                                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                                                        $moodStatus = "bg-danger";
                                                                                    } else {
                                                                                        $moodStatus = "bg-amarelo text-dark";
                                                                                    }
                                                                                }


                                                                                //Cores Status Comercial
                                                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                                                    $moodStatusComercial = "bg-amarelo";
                                                                                } else {

                                                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                                                        $moodStatusComercial = "bg-verde-claro";
                                                                                    } else {
                                                                                        if ($row['propStatus'] == 'APROVADO') {
                                                                                            $moodStatusComercial = "bg-verde text-white";
                                                                                        } else {
                                                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                                                $moodStatusComercial = "bg-roxo text-white";
                                                                                            } else {
                                                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                                                } else {
                                                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                                                        $moodStatusComercial = "bg-rosa";
                                                                                                    } else {
                                                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                                                        } else {
                                                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                                                            } else {
                                                                                                                $moodStatusComercial = "bg-amarelo";
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if ($row['propEmpresa'] != null) {
                                                                                    $empresa = $row['propEmpresa'];
                                                                                    $classEmpresa = '';
                                                                                } else {
                                                                                    $empresa = '-';
                                                                                    $classEmpresa = 'class="text-center"';
                                                                                }

                                                                                // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                                // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                                // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                                // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                                // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                                // $encrypted = urlencode($encrypted);

                                                                                $encrypted = hashItem($row['propId']);
                                                                        ?>

                                                                                <tr>
                                                                                    <td><?php echo $row['propId']; ?></td>
                                                                                    <td><?php echo $data; ?></td>
                                                                                    <td><span class="badge <?php echo $moodStatusComercial; ?>"><?php echo $row['propStatus']; ?> <?php if ($row['propPedido'] != null) echo ' - ' . $row['propPedido']; ?></span></td>
                                                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['propStatusTC']; ?></span></td>
                                                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                                                    <td><?php echo $row['propNomePac']; ?></td>
                                                                                    <td><?php echo $row['propEmailEnvio']; ?></td>
                                                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                                                    <td><?php echo $row['propTipoProd']; ?></td>

                                                                                    <td class="d-flex justify-content-around">
                                                                                        <!--<span class="btn text-roxo" data-toggle="modal" data-target="#adicionarcomentario" onclick="populateNumProposta(<?php echo $row['propId']; ?>, '<?php echo $row['propTxtRepresentante']; ?>')"><i class="bi bi-chat-text-fill"></i></span>-->
                                                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>
                                                                                        <a href="proposta?id=<?php echo $row['propId']; ?>">
                                                                                            <button class="btn text-warning"><i class="fas fa-file-pdf"></i></button></a>
                                                                                        <!--<a href="reenviotc?id=<?php echo $encrypted; ?>">
                                                                                            <button class="btn text-success btn-xs"><i class="bi bi-file-earmark-arrow-up-fill"></i></button></a>-->

                                                                                    </td>
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
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="pills-pedidos" role="tabpanel" aria-labelledby="pills-pedidos-tab">
                                            <h4 class="text-conecta py-2"><b>Casos (Pedidos)</b></h4>
                                            <div class="content-panel">
                                                <table id="tablePed" class="table table-striped table-advance table-hover bg-white rounded">
                                                    <thead class="text-conecta">
                                                        <tr>
                                                            <th>ID Proposta</th>
                                                            <th>Num Pedido</th>
                                                            <th>Dt Criacação</th>
                                                            <th>Planejamento</th>
                                                            <th>Nome Dr</th>
                                                            <th>Paciente</th>
                                                            <th>Produto</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="background-color: white;">
                                                        <?php

                                                        $ret = mysqli_query($conn, "SELECT * FROM propostas INNER JOIN pedido ON propostas.propId = pedido.pedId;");
                                                        // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus LIKE '%PEDIDO%' AND propBdDtCriacao > CURRENT_DATE - INTERVAL 30 DAY");

                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            if ($row['propRepresentante'] == $user) {
                                                                $dataCompleta = $row['pedDtCriacaoPed'];
                                                                $dataArray = explode(" ", $dataCompleta);
                                                                $dataRaw = $dataArray[0];
                                                                $dataRaw = explode("-", $dataRaw);
                                                                $data = $dataRaw[2] . "/" . $dataRaw[1] . "/" . $dataRaw[0];


                                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                                    $moodStatus = "bg-success";
                                                                    $colorText = "";
                                                                } else {
                                                                    if ($row['propStatusTC'] == "TC REPROVADA") {
                                                                        $moodStatus = "bg-danger";
                                                                    } else {
                                                                        $moodStatus = "bg-secondary";
                                                                    }
                                                                }
                                                        ?>

                                                                <tr>
                                                                    <td><?php echo $row['propId']; ?></td>
                                                                    <td><?php echo $row['pedNumPedido']; ?></td>
                                                                    <td><?php echo $data; ?></td>
                                                                    <td><span class="badge <?php echo $moodStatus; ?>" style="color:#fff;"><?php echo $row['pedStatus']; ?></span></td>
                                                                    <td><?php echo $row['pedNomeDr']; ?></td>
                                                                    <td><?php echo $row['pedNomePac']; ?></td>
                                                                    <td><?php echo $row['pedTipoProduto']; ?></td>

                                                                    <td>
                                                                        <?php
                                                                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                                                                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                                                                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                                                                        // $encrypted = openssl_encrypt($row['propId'], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                                                                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                                                                        // $encrypted = urlencode($encrypted);

                                                                        $encrypted = hashItem($row['propId']);

                                                                        ?>
                                                                        <!--<span class="btn text-roxo" data-toggle="modal" data-target="#adicionarcomentario" onclick="populateNumProposta(<?php echo $row['propId']; ?>, '<?php echo $row['propTxtRepresentante']; ?>')"><i class="bi bi-chat-text-fill"></i></span>-->
                                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>
                                                                    </td>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal Adicionar Comentário
        <div class="modal fade" id="adicionarcomentario" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        //<h5 class="modal-title text-black">Adicionar comentário sobre a proposta</h5>
                        <h5 class="modal-title text-black">Comentários</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        //<div class="container-fluid">
                            <div class="row d-flex">
                                <div class="col-md">
                                    <form class="form-horizontal style-form" action="includes/addcomentpropostarepresentante.inc.php" method="POST">
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="propid">Nº Proposta</label>
                                                <input type="number" class="form-control" id="propid" name="propid" required readonly>
                                                <small class="text-muted">ID não é editável</small>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="comentario">Comentário</label>
                                                <textarea name="comentario" id="comentario" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div class="form-group col-md d-flex justify-content-end">
                                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Enviar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="col-md">
                                <div>
                                    <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "sent") {
                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Feedback enviado!</p></div>";
                                        }
                                    }
                                    ?>
                                    <div>
                                        <h5 style="color: silver; text-align: center;">Comentários</h5>
                                        <div class="rounded">

                                            <?php
                                            // $idProjeto = $_GET['id'];
                                            // $retMsg = mysqli_query($conn, "SELECT * FROM comentariosproposta WHERE comentVisNumProp='$idProjeto' ORDER BY comentVisId ASC");


                                            // while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                            //     $msg = $rowMsg['comentVisText'];
                                            //     $owner = $rowMsg['comentVisUser'];
                                            //     $timer = $rowMsg['comentVisHorario'];

                                            //     $timer = explode(" ", $timer);
                                            //     $data = $timer[0];
                                            //     // $dataAmericana = explode("-", $date);
                                            //     // $ano = str_split($dataAmericana[0]);
                                            //     // $ano = $ano[0] . $ano[1];
                                            //     // $data = $dataAmericana[2] . '/' . $dataAmericana[1] . '/' . $ano;


                                            //     $hora = $timer[1];
                                            //     // $horaEnvio = explode(":", $hour);
                                            //     // $hora = 'às ' . $horaEnvio[0] . ':' . $horaEnvio[1];
                                            //     $horario = $data . ' às ' . $hora;


                                            ?>
                                                <?php
                                                // if ($_SESSION['useruid'] == $owner) {


                                                ?>
                                                    <div class="row py-1">
                                                        <div class="col d-flex justify-content-end w-50">
                                                            <div class="bg-secondary bg-gradient text-white rounded rounded-3 px-2 py-1">
                                                                <h6><b><?php //echo $owner; ?>:</b></h6>
                                                                <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 200px;"><?php// echo $msg; ?></p>
                                                                <small style="color: #323236;"><?php// echo $horario; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                // } else {
                                                ?>
                                                    <div class="row py-1">
                                                        <div class="col d-flex justify-content-start w-50">
                                                            <div class="bg-orange-conecta text-white rounded rounded-3 px-2 py-1">
                                                                <h6><b><?php //echo $owner; ?>:</b></h6>
                                                                <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 300px;"><?php// echo $msg; ?></p>
                                                                <small style="color: #874214;"><?php// echo $horario; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                            //     }
                                            // }
                                            ?>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-sm px-2 py-3">
                                                <form action="includes/comentproposta.inc.php" method="post">
                                                    <div class="container" >
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="nprop">Nº Pedido</label>
                                                                <input type="text" class="form-control" name="nprop" id="nprop"  readonly>
                                                            </div>
                                                            <div class="col">
                                                                <label for="user">Usuário</label>
                                                                <input type="text" class="form-control" name="user" id="user" value="<?php //echo $_SESSION['useruid']; ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col d-flex justify-content-around align-items-start">
                                                                <div class="p-1">
                                                                    <textarea class="form-control color-bg-dark color-txt-wh" style="font-size: 0.8rem;" name="coment" id="coment" rows="1" onkeyup="limite_textarea(this.value)" maxlength="300"></textarea><br><br>
                                                                    <div class="row d-flex justify-content-start p-0 m-0">
                                                                        <small class="pl-2 text-muted" style="margin-top: -40px !important;"><small class="text-muted" id="cont">300</small> Caracteres restantes</small>
                                                                    </div>
                                                                </div>
                                                                <div class="p-1">
                                                                    <button type="submit" name="submit" class="btn btn-primary" style="font-size: small;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        limite_textarea(document.getElementById("descricao").value);
                                    });

                                    function limite_textarea(valor) {
                                        quant = 300;
                                        total = valor.length;
                                        if (total <= quant) {
                                            resto = quant - total;
                                            document.getElementById('cont').innerHTML = resto;
                                        } else {
                                            document.getElementById('texto').value = valor.substr(0, quant);
                                        }
                                    }
                                </script>

                            </div>
                        </div>//
                    </div>
                </div>
            </div>
        </div>-->

        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    $('#tableProp').DataTable({
                        "responsive": true,
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
                            [0, "desc"]
                        ]
                    });
                    $('#tableProp2').DataTable({
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
                            [0, "desc"]
                        ]
                    });
                    $('#tableEnviada').DataTable({
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
                            [0, "desc"]
                        ]
                    });
                    $('#tableAprov').DataTable({
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
                            [0, "desc"]
                        ]
                    });
                    $('#tablePropPed').DataTable({
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
                            [0, "desc"]
                        ]
                    });
                });

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
                        [0, "desc"]
                    ]
                });

            });

            function populateNumProposta(id, texto) {
                document.getElementById("nprop").value = id;
                // alert(id);
                document.getElementById("comentario").value = texto;
            }
        </script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>