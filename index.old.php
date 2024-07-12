<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (isset($_SESSION["useruid"])) {
    $user = $_SESSION["useruid"];
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    include("php/head_index.php");


?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .dataTables_length label,
        .dataTables_length select,
        .dataTables_filter label,
        .dataTables_filter label input:focus,
        .dataTables_filter label input {
            color: white;
        }
    </style>

    <body class="bg-conecta">

        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">

                <?php
                $openMsgQualificacao = 0;
                $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiUsuario='$user'");
                if (($ret) && ($ret->num_rows != 0)) {
                    //verifica status
                    $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiUsuario='$user'");
                    while ($row = mysqli_fetch_array($ret)) {
                        $statusQualificacao = $row['qualiStatus'];
                        $msgQualificacao = $row['qualiMsg'];
                    }

                    $propLink = getPropFromUser($conn, $user);


                    switch ($statusQualificacao) {
                        case 'Enviado':
                            $openMsgQualificacao = 1;
                            break;

                        case 'Analisar':
                            $openMsgQualificacao = 2;
                            break;

                        case 'Qualificado':
                            //Nada
                            break;
                        case 'Recusado':
                            $openMsgQualificacao = 3;
                            break;
                        default:
                            $openMsgQualificacao = 0;
                            break;
                    }
                }

                if ($openMsgQualificacao == 1) {
                ?>
                    <div class='my-2 pb-0 alert alert-warning pt-3 text-center'>
                        <p>Caro cliente, estamos aguardando o seu preenchimento do Formulário de Qualificação. <a style="color: blue;" href="https://form.jotform.com/GRUPOFIX/qualificao-de-clientes?id=<?php echo $propLink; ?>" target="_blank">Clique aqui</a> para acessar.</p>
                    </div>
                <?php
                } else if ($openMsgQualificacao == 2) {
                ?>
                    <div class='my-2 pb-0 alert alert-success pt-3 text-center'>
                        <p>Caro cliente, seu Formulário de Qualificação foi recebido e está em análise. Em breve retornaremos.</p>
                    </div>
                <?php
                } else if ($openMsgQualificacao == 3) {
                ?>
                    <div class='my-2 pb-0 alert alert-warning pt-3 text-center'>
                        <p>ATENÇÃO! Formulário Qualificação: <b><?php echo $msgQualificacao; ?></b>
                        </p>
                        <p>Para preencher novamente <a style="color: blue;" href="https://form.jotform.com/GRUPOFIX/qualificao-de-clientes?id=<?php echo $propLink; ?>" target="_blank">Clique aqui</a> e acesse o formulário.</p>
                    </div>
                <?php
                }
                ?>

                <?php
                if ($_SESSION["userperm"] == 'Representante') {
                    $rep = $_SESSION["useruid"];

                    $contagemPropEmAnalise = 0;
                    $contagemPedPendentes = 0;
                    $contagemPropPed = 0;

                    // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propRepresentante='$rep';");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     if (strpos($row['propStatus'], 'PEDIDO') !== true) {
                    //         $contagemPropEmAnalise++;
                    //     }
                    // }

                    // $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedRep='$rep';");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     $contagemPropPed++;
                    // }

                    // $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedRep='$rep' AND pedStatus <> 'PROD';");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     $contagemPedPendentes++;
                    // }

                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propRepresentante='$rep' AND propStatus = 'PENDENTE' OR propStatus = 'EM ANÁLISE' OR propStatus = 'AGUARD. INFOS ADICIO' OR propStatus = 'AGUARD. QUALIFICAÇÃO' OR propStatus = 'CLIENTE QUALIFICADO';");
                    while ($row = mysqli_fetch_array($ret)) {
                        $contagemPropEmAnalise++;
                    }

                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propRepresentante='$rep' AND propStatus = 'PROP. ENVIADA' OR propStatus = 'APROVADO';");
                    while ($row = mysqli_fetch_array($ret)) {
                        $contagemPropPed++;
                    }

                    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propRepresentante='$rep' AND propStatus = 'PEDIDO';");
                    while ($row = mysqli_fetch_array($ret)) {
                        $contagemPedPendentes++;
                    }

                ?>

                    <div class="row py-3 d-flex justify-content-center">

                        <div class="col-sm-8 d-flex justify-content-center">
                            <form class="w-100" action="pesquisaitens" method="POST">
                                <div class="col d-flex justify-content-center">
                                    <div class="input-group rounded">
                                        <div class="px-2">
                                            <select name="tipo" id="tipo" class="form-select p-2">
                                                <option value="propostas">Proposta</option>
                                                <option value="pedido">Pedido</option>
                                            </select>
                                        </div>
                                        <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui uma proposta ou pedido..." aria-label="Pesquise aqui uma proposta ou pedido..." aria-describedby="search-addon" />
                                        <div class="px-2 d-flex justify-content-center align-items-center">
                                            <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="search-addon" type="search" value="search" name="search">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="row p-4 d-flex justify-content-center">

                        <div class="col-md-10 mb-4 p-4">
                            <div class="card border-left-primary shadow py-2 px-4">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                Responsável pelos Estados </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <div class='d-block p-1'>
                                                    <?php
                                                    $sessionUser = $_SESSION["useruid"];
                                                    $retUF = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='$sessionUser';");
                                                    while ($rowUF = mysqli_fetch_array($retUF)) {
                                                        if ($rowUF['repUF'] != null) {
                                                    ?>
                                                            <span class="badge bg-secondary my-1" style="font-size: 1rem; color:#fff;"> <?php echo $rowUF['repUF']; ?></span>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-search-location fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row p-4 d-flex justify-content-center">

                        <!-- Cadastros Total -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Propostas Em Análise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropEmAnalise; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-clipboard-list fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cadastros Pendentes -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Propostas enviadas p/ Cliente</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropPed; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bi bi-collection fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cadastros Aprovados -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pedidos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPedPendentes; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                <?php
                }
                if ($_SESSION["userperm"] == 'Analista Dados') {
                    // $rep = $_SESSION["useruid"];

                    // $contagemPropEmAnalise = 0;
                    // $contagemPedPendentes = 0;
                    // $contagemPropPed = 0;

                    // $ret = mysqli_query($conn, "SELECT * FROM propostas;");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     if (strpos($row['propStatus'], 'PEDIDO') !== true) {
                    //         $contagemPropEmAnalise++;
                    //     }
                    // }

                    // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'PENDENTE' OR propStatus = 'EM ANÁLISE' OR propStatus = 'AGUARD. INFOS ADICIO' OR propStatus = 'AGUARD. QUALIFICAÇÃO' OR propStatus = 'CLIENTE QUALIFICADO';");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     $contagemPropEmAnalise++;
                    // }

                    // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'PROP. ENVIADA' OR propStatus = 'APROVADO';");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     $contagemPropPed++;
                    // }

                    // $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'PEDIDO';");
                    // while ($row = mysqli_fetch_array($ret)) {
                    //     $contagemPedPendentes++;
                    // }

                    //Contagem Prop PENDENTE
                    $resPropPendente = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'PENDENTE';");
                    $contagemPropPendente = mysqli_num_rows($resPropPendente);

                    //Contagem Prop EM ANÁLISE
                    $resPropEmAnalise = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'EM ANÁLISE';");
                    $contagemPropEmAnalise = mysqli_num_rows($resPropEmAnalise);

                    //Contagem Prop AGUARD. INFOS ADICIO
                    $resPropAguardInfosAdicio = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'AGUARD. INFOS ADICIO';");
                    $contagemPropAguardInfosAdicio = mysqli_num_rows($resPropAguardInfosAdicio);

                    //Contagem Prop AGUARD. QUALIFICAÇÃO
                    $resPropAguardQualificacao = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'AGUARD. QUALIFICAÇÃO';");
                    $contagemPropAguardQualificacao = mysqli_num_rows($resPropAguardQualificacao);

                    //Contagem Prop AGUARD. QUALIFICAÇÃO
                    $resPropClienteQualificado = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'AGUARD. QUALIFICAÇÃO';");
                    $contagemPropClienteQualificado = mysqli_num_rows($resPropClienteQualificado);

                    //Contagem TODAS EM ANÁLISE
                    $contagemPropEmAnaliseTOTAL = $contagemPropPendente + $contagemPropEmAnalise + $contagemPropAguardInfosAdicio + $contagemPropAguardQualificacao + $contagemPropClienteQualificado;

                    //Contagem Prop PROP. ENVIADA
                    $resPropEnviada = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'PROP. ENVIADA';");
                    $contagemPropEnviada = mysqli_num_rows($resPropEnviada);

                    //Contagem Prop APROVADO
                    $resPropAprovada = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'APROVADO';");
                    $contagemPropAprovada = mysqli_num_rows($resPropAprovada);

                    //Contagem TODAS ENVIADAS
                    $contagemPropEnviadasTOTAL = $contagemPropEnviada + $contagemPropAprovada;

                    //Contagem Prop PEDIDO
                    $resPropPedido = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'PEDIDO';");
                    $contagemPropPedido = mysqli_num_rows($resPropPedido);

                    //Contagem Prop CANCELADO
                    $resPropCancelado = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'CANCELADO';");
                    $contagemPropCancelado = mysqli_num_rows($resPropCancelado);

                    //Contagem Prop JÁ COTADO
                    $resPropJaCotado = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'JÁ COTADO';");
                    $contagemPropJaCotado = mysqli_num_rows($resPropJaCotado);

                    //Contagem Prop NÃO COTAR
                    $resPropNaoCotar = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'NÃO COTAR';");
                    $contagemPropNaoCotar = mysqli_num_rows($resPropNaoCotar);

                    //Contagem Prop COTADO OUTRO DIST
                    $resPropCotadoOutroDist = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'COTADO OUTRO DIST';");
                    $contagemPropCotadoOutroDist = mysqli_num_rows($resPropCotadoOutroDist);

                    //Contagem Prop DPS
                    $resPropDPS = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus = 'DPS';");
                    $contagemPropDPS = mysqli_num_rows($resPropDPS);

                    //Contagem TODAS OUTRAS
                    $contagemPropOutrasTOTAL = $contagemPropCancelado + $contagemPropJaCotado + $contagemPropNaoCotar + $contagemPropCotadoOutroDist + $contagemPropDPS;

                ?>

                    <div class="row py-3 d-flex justify-content-center">

                        <div class="col-sm-8 d-flex justify-content-center">
                            <form class="w-100" action="pesquisaitens" method="POST">
                                <div class="col d-flex justify-content-center">
                                    <div class="input-group rounded">
                                        <div class="px-2">
                                            <select name="tipo" id="tipo" class="form-select p-2">
                                                <option value="propostas">Proposta</option>
                                                <option value="pedido">Pedido</option>
                                            </select>
                                        </div>
                                        <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui uma proposta ou pedido..." aria-label="Pesquise aqui uma proposta ou pedido..." aria-describedby="search-addon" />
                                        <div class="px-2 d-flex justify-content-center align-items-center">
                                            <button class="btn btn-primary input-group-text border-0 p-2 text-white" id="search-addon" type="search" value="search" name="search">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!--<div class="row p-4 d-flex justify-content-center">

                        <div class="col-md-10 mb-4 p-4">
                            <div class="card border-left-primary shadow py-2 px-4">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                Responsável pelos Estados </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <div class='d-block p-1'>
                                                    <?php
                                                    $sessionUser = $_SESSION["useruid"];
                                                    $retUF = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='$sessionUser';");
                                                    while ($rowUF = mysqli_fetch_array($retUF)) {
                                                        if ($rowUF['repUF'] != null) {
                                                    ?>
                                                            <span class="badge bg-secondary my-1" style="font-size: 1rem; color:#fff;"> <?php echo $rowUF['repUF']; ?></span>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-search-location fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>-->
                    <div class="row p-4 d-flex justify-content-center">

                        <!-- Cadastros Total 
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Propostas Em Análise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropEmAnalise; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-clipboard-list fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!-- Propostas Em Análise -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Em Análise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropEmAnaliseTOTAL; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <hr style="border-color: #dfdfdf;" class="pt-4">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="d-flex justify-content-between px-3">
                                                <p>PENDENTE</p>
                                                <p><?php echo $contagemPropPendente; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>EM ANÁLISE</p>
                                                <p><?php echo $contagemPropEmAnalise; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>AGUARD. INFOS ADICIO</p>
                                                <p><?php echo $contagemPropAguardInfosAdicio; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>AGUARD. QUALIFICAÇÃO</p>
                                                <p><?php echo $contagemPropAguardQualificacao; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>CLIENTE QUALIFICADO</p>
                                                <p><?php echo $contagemPropClienteQualificado; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cadastros Pendentes
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Propostas enviadas p/ Cliente</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropPed; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bi bi-collection fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!-- Propostas Enviadas -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Enviadas p/ Cliente</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropEnviadasTOTAL; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-import fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <hr style="border-color: #dfdfdf;" class="pt-4">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="d-flex justify-content-between px-3">
                                                <p>PROP. ENVIADA</p>
                                                <p><?php echo $contagemPropEnviada; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>APROVADO</p>
                                                <p><?php echo $contagemPropAprovada; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cadastros Aprovados 
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pedidos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPedPendentes; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!-- Propostas viraram Pedido -->
                        <div class="col-xl-3 col-md-3 mb-4 p-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pedidos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPropPedido; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='fas fa-boxes fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                    <hr style="border-color: #dfdfdf;" class="pt-4">
                                    <h6 class="text-muted pb-1">Outros Status (Propostas)</h6>
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="d-flex justify-content-between px-3">
                                                <p>CANCELADO</p>
                                                <p><?php echo $contagemPropCancelado; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>JÁ COTADO</p>
                                                <p><?php echo $contagemPropJaCotado; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>NÃO COTAR</p>
                                                <p><?php echo $contagemPropNaoCotar; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>COTADO OUTRO DIST</p>
                                                <p><?php echo $contagemPropCotadoOutroDist; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>DPS</p>
                                                <p><?php echo $contagemPropDPS; ?></p>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between px-3">
                                                <p>Total (Outros Status)</p>
                                                <p><?php echo $contagemPropOutrasTOTAL; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                    //array Tipos de Produtos das propostas
                    $arrayTipoProdutos = array();

                    //array Quantidade de cada Tipos de Produtos das propostas
                    $arrayQtdeTipoProdutos = array();

                    //insere Tipos de Produtos no array
                    $searchProd = mysqli_query($conn, "SELECT DISTINCT propTipoProd FROM propostas;");
                    while ($rowProd = mysqli_fetch_array($searchProd)) {

                        array_push($arrayTipoProdutos, $rowProd["propTipoProd"]);
                    }


                    foreach ($arrayTipoProdutos as &$produto) {
                        //Contagem cada tipo produto
                        $res = mysqli_query($conn, "SELECT * FROM propostas WHERE propTipoProd = '" . $produto . "';");
                        $contagem = mysqli_num_rows($res);

                        array_push($arrayQtdeTipoProdutos, $contagem);
                    }

                    $dataPoints = array();
                    for ($i = 0; $i < sizeof($arrayTipoProdutos); $i++) {
                        // echo $arrayOptionsName[$i] . " - " . $arrayValues[$i] . "<br>";
                        $array = array(
                            "label" => $arrayTipoProdutos[$i],
                            "y" => $arrayQtdeTipoProdutos[$i]
                        );
                        array_push($dataPoints, $array);
                    }

                    ?>

                    <div class="bg-white row p-4 d-flex justify-content-around h-100 rounded shadow">

                        <div class="col-xl-4 col-md-6">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <canvas id="myChart2" style="width: 30%; height: 10vh;"></canvas>
                        </div>
                    </div>

                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                    <script type="text/javascript">
                        window.onload = function() {

                            var chart = new CanvasJS.Chart("chartContainer", {
                                theme: "light2",
                                animationEnabled: true,
                                title: {
                                    text: ""
                                },
                                axisY: {
                                    title: "Qtd Produtos",
                                    includeZero: true,
                                },
                                data: [{
                                    type: "column",
                                    indexLabel: "{y}",
                                    indexLabelPlacement: "inside",
                                    indexLabelFontWeight: "bolder",
                                    indexLabelFontColor: "white",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                        }
                    </script>


                    <div class="content-panel row mt-2 p-4">
                        <table id="tableProp2" class="table table-striped table-advance table-hover bg-white rounded p-4">
                            <thead class="text-conecta">
                                <tr>
                                    <th>Nº</th>
                                    <th>Data Chegada</th>
                                    <th>Status</th>
                                    <th>Status TC</th>
                                    <th>Empresa</th>
                                    <th>Dr(a)</th>
                                    <th>Produto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="background-color: white;">
                                <?php
                                require_once 'includes/dbh.inc.php';

                                $ret = mysqli_query($conn, "SELECT * FROM propostas ");
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
                                            <!--<td><?php echo $row['propNomePac']; ?></td>
                                            <td><?php echo $row['propEmailEnvio']; ?></td>
                                            <td><?php echo $row['propUserCriacao']; ?></td>-->
                                            <td><?php echo $row['propTipoProd']; ?></td>

                                            <td class="d-flex justify-content-around">
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


                <?php
                }

                if (($_SESSION["userperm"] != 'Representante') && ($_SESSION["userperm"] != 'Analista Dados')) {
                ?>

                    <div class="row row-2">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 d-flex justify-content-center">
                            <a href="solicitacao"><button class="btn btn-conecta"><i class="fas fa-plus"></i> Nova Solicitação de Proposta</button></a>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                    <div class="row mt-5">

                        <div class="col col-sm">
                            <div class="container">
                                <div class="row ">

                                    <div class="indexCard col-4 col-sm-4 col-xs-6 d-flex justify-content-center align-items-center">
                                        <a class="text-decoration-none" href="dadosproduto">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="assets/img/indexIcons/i-form.svg" alt="Ícone Dados dos Produtos" class="d-block iconesIndex" />
                                                <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Formulários</b></p>
                                            </div>
                                        </a>
                                    </div>



                                    <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                        <a class="text-decoration-none" href="materiais">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="assets/img/indexIcons/i-catalogo.svg" alt="Ícone Materiais de Mídia" class="d-block iconesIndex" />
                                                <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Materiais de Apoio</b></p>
                                            </div>
                                        </a>
                                    </div>



                                    <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                        <a class="text-decoration-none" href="tecnicacir">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="assets/img/indexIcons/i-tecnica.svg" alt="Ícone Técnica Cirúrgica" class="d-block iconesIndex" />
                                                <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Técnica Cirúrgica</b></p>
                                            </div>
                                        </a>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                        <a class="text-decoration-none" href="sac">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="assets/img/indexIcons/i-sac.svg" alt="Ícone Deixe Seus Elogios Ou Reclamações" class="d-block iconesIndex" />
                                                <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>SAC</b></p>
                                            </div>
                                        </a>
                                    </div>



                                    <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">

                                        <a class="text-decoration-none" target="_blank" href="https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="assets/img/indexIcons/i-chat.svg" alt="Ícone Suporte Técnico" class="d-block iconesIndex" />
                                                <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Suporte</b></p>
                                            </div>
                                        </a>
                                    </div>



                                    <div class="indexCard col-4 col-sm-4 col-xs d-flex justify-content-center align-items-center">
                                        <a class="text-decoration-none" href="visitafabrica">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="assets/img/indexIcons/i-visita.svg" alt="Ícone Visitar a Fábrica" class="d-block iconesIndex" />
                                                <p class="d-block text-white pb-3 pt-4 px-0 text-center"><b>Visita a Fábrica</b></p>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>



        <!-- GetButton.io widget -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
        <script type="text/javascript">
            (function() {
                var options = {
                    whatsapp: "+55 61 99946-8880", // WhatsApp number
                    call_to_action: "Enviar uma mensagem", // Call to action
                    position: "right", // Position may be 'right' or 'left'
                    pre_filled_message: "Olá! Vim do Conecta 2.0, estou precisando de ajuda", // WhatsApp pre-filled message
                };
                var proto = document.location.protocol,
                    host = "getbutton.io",
                    url = proto + "//static." + host;
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = url + '/widget-send-button/js/init.js';
                s.onload = function() {
                    WhWidgetSendButton.init(host, proto, options);
                };
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            })();

            $(document).ready(function() {
                document.getElementById("mySidenav").style.width = "200px";

                $('#tableProp2').DataTable({
                    "responsive": true,
                    "lengthMenu": [
                        [10, 20, 40, 80, -1],
                        [10, 20, 40, 80, "Todos"],
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


                function getProductsForGraph() {
                    $.post('proc_get_products.php', dados, function(retorna) {

                        console.log(retorna);
                    });

                }
                getProductsForGraph();

            });
        </script>
        <!-- /GetButton.io widget -->


        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>