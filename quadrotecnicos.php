<?php

session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Planejador(a)')) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
    require_once 'dashboard/counterHelpers/counterTecnicos.php';

    if (isset($_POST["search"])) {
        $ano = $_POST["ano"];
        $mes = $_POST["mes"];
        $tecnico = $_POST["tecnico"];
        $status = $_POST["status"];
        // $ano = date("Y");
    } else {
        // $ano = 0;
        $mes = date("m");
        $tecnico = 0;
        $status = "PROD";
        $ano = date("Y");
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
                            <h2 class="text-conecta" style="font-weight: 400;"> Agenda dos <span style="font-weight: 700;">
                                    Técnicos </span></h2>
                            <div class="col-5 d-flex justify-content-end align-items-center">
                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                    <form class="w-100" action="quadrotecnicos" method="POST">
                                        <div class="form-row d-flex justify-content-center align-items-center">
                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="mes">Mês</label>
                                                <select name="mes" class="form-control" id="mes" required>
                                                    <option value="">Selecione uma opção</option>
                                                    <?php
                                                    $retMes = mysqli_query($conn, "SELECT * FROM mesesano;");
                                                    while ($rowMes = mysqli_fetch_array($retMes)) {
                                                    ?>
                                                        <option value="<?php echo $rowMes['mesNum']; ?>" <?php if ($mes == $rowMes['mesNum']) echo ' selected="selected"'; ?>>
                                                            <?php echo $rowMes['mesAbrv']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="ano">Ano</label>
                                                <select name="ano" class="form-control" id="ano" required>
                                                    <option value="">Selecione uma opção</option>
                                                    <?php

                                                    $anoAtual = date("Y");
                                                    $anoInicial = 2023;
                                                    for ($i = $anoAtual; $i >= $anoInicial; $i--) {
                                                    ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($ano == $i) echo ' selected="selected"'; ?>>
                                                            <?php echo $i; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="tecnico">Técnico</label>
                                                <select name="tecnico" class="form-control" id="tecnico" required>
                                                    <option value="">Selecione uma opção</option>
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

                                            <div class="form-group col-md">
                                                <label class="form-label text-black" for="status">Fluxo</label>
                                                <select name="status" class="form-control" id="status" required>
                                                    <option value="">Selecione uma opção</option>
                                                    <?php
                                                    $retStatus = mysqli_query($conn, "SELECT * FROM statuspedido ORDER BY stpedNome ASC");
                                                    while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                    ?>
                                                        <option value="<?php echo $rowStatus['stpedValue']; ?>" <?php if ($status == $rowStatus['stpedValue']) echo ' selected="selected"'; ?>><?php echo $rowStatus['stpedNome']; ?></option>
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
                                                <label class="form-label text-black" for="ano">Ano</label>
                                                <select name="ano" class="form-control" id="ano" required>
                                                <option value="<?php echo date('Y'); ?>" selected="selected"><?php echo date('Y'); ?></option>
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
                            <div class="row card-body d-flex p-4 m-4 d-print-none">
                                <?php
                                $qtdarquivados = getAllArquivados($conn);
                                $qtdconcluidos = getAllConcluidos($conn);
                                $qtdplanejando = getAllPlanejando($conn);
                                $qtdpendente = getAllPendentes($conn);
                                $qtdprojProximo = getAllProjetistaProximo($conn);
                                $qtdPCP = getAllPCP($conn);
                                ?>
                                <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-dark">
                                    <div class="container-fluid card-body d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col d-flex justify-content-around align-items-center px-2" style="flex-direction: column;">
                                                <h5 class="text-white text-center" style="font-size: 12px;">PCP</h5>
                                                <h5 class="text-white"><b><?php echo $qtdPCP; ?></b></h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-warning">
                                    <div class="container-fluid card-body d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col d-flex justify-content-around align-items-center px-2" style="flex-direction: column;">
                                                <h5 class="text-darkgray text-center" style="font-size: 12px;">Proj. Próximo</h5>
                                                <h5 class="text-darkgray"><b><?php echo $qtdprojProximo; ?></b></h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-info">
                                    <div class="container-fluid card-body d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col d-flex justify-content-around align-items-center px-2" style="flex-direction: column;">
                                                <h5 class="text-white text-center" style="font-size: 12px;">Planejando</h5>
                                                <h5 class="text-white"><b><?php echo $qtdplanejando; ?></b></h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-purple">
                                    <div class="container-fluid card-body d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col d-flex justify-content-around align-items-center px-2" style="flex-direction: column;">
                                                <h5 class="text-white text-center" style="font-size: 12px;">Pendente</h5>
                                                <h5 class="text-white"><b><?php echo $qtdpendente; ?></b></h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-success">
                                    <div class="container-fluid card-body d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col d-flex justify-content-around align-items-center px-2" style="flex-direction: column;">
                                                <h5 class="text-white text-center" style="font-size: 12px;">Concluídos</h5>
                                                <h5 class="text-white"><b><?php echo $qtdconcluidos; ?></b></h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md card shadow rounded m-2 bg-danger">
                                    <div class="container-fluid card-body d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col d-flex justify-content-around align-items-center px-2" style="flex-direction: column;">
                                                <h5 class="text-white text-center" style="font-size: 12px;">Arquivados</h5>
                                                <h5 class="text-white"><b><?php echo $qtdarquivados; ?></b></h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <hr class="d-print-none">

                            <div class="row">
                                <div class="col">

                                    <?php
                                    if (isset($_POST["search"])) {

                                        // print_r($_POST);
                                        // exit();

                                        //get the post value
                                        $mes = $_POST["mes"];
                                        $ano = $_POST["ano"];
                                        $tecnico = $_POST["tecnico"];
                                        $status = $_POST["status"];

                                        // $mes = preg_replace("#[^0-9a-z]#i", "", $mes);
                                        // $tecnico = preg_replace("#[^0-9a-z]#i", "", $tecnico);
                                        // $status = preg_replace("#[^0-9a-z]#i", "", $status);

                                        $q = "SELECT DISTINCT p.pedNumPedido,
                                        p.*,
                                        p.pedDtCriacaoPed AS data_iniciopedido,
                                        z.*,
                                        z.przData AS data_ref,
                                        z.przStatus AS status_prazo
                                        FROM pedido p
                                        LEFT JOIN prazoproposta z ON p.pedNumPedido = z.przNumProposta 
                                        WHERE p.pedTecnico LIKE '%$tecnico%' 
                                        AND z.przStatus LIKE '%$status%' 
                                        AND MONTH(z.przData) = $mes
                                        AND YEAR(z.przData) = $ano
                                        ORDER BY p.pedDtCriacaoPed DESC;
                                        ";
                                        $query = mysqli_query($conn, $q) or die("Aconteceu algo errado!");
                                        // print_r($q);

                                        //left join com a tabela prazospropostas e pegar todos os que são prod no mes escolhido na data de prazo proposta

                                        $count =  mysqli_num_rows($query);

                                        if ($count == 0) {
                                    ?>
                                            <div class="row card-body d-flex justify-content-center p-4 m-4">
                                                <span class="alert alert-warning">Nenhum item encontrado com esse filtro</span>
                                            </div>
                                            <div class="row card-body d-flex justify-content-center p-4 m-4">
                                                <?php
                                                $res = countTecnicosCasosGERAL($conn);
                                                foreach ($res as $key => $value) {
                                                    $tecnico = $value['tecnico'];
                                                    $nome = $value['nome'];
                                                    $tecnicoPrimeiroNome = getPrimeiroNome($nome);
                                                    $qtd = $value['qtd'];

                                                ?>

                                                    <div class="col-xs-12 col-sm-3 col-12 card shadow rounded m-2 bg-light">
                                                        <div class="container-fluid card-body">
                                                            <div class="row d-flex justify-content-center p-2">
                                                                <div class="col d-flex justify-content-between align-items-center">
                                                                    <h3 style="color: #4b535a;">
                                                                        <b><?php echo $tecnicoPrimeiroNome; ?></b>
                                                                    </h3>
                                                                    <h3 style="color: #4b535a;"><b><?php echo $qtd; ?></b></h3>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $pedidos = getAllStatusFromTecnico($conn, $tecnico);
                                                            foreach ($pedidos as $key => $value) {
                                                                $nomeStatus = getFullNomeFluxoPed($conn, $value['status']);
                                                            ?>
                                                                <div class="row d-flex justify-content-center">
                                                                    <div class="col d-flex justify-content-between align-items-center">
                                                                        <span class="text-conecta"><?php echo $nomeStatus . ": " ?></span>
                                                                        <span class="text-conecta"><?php echo $value['qtd']; ?></span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <hr>
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col d-flex justify-content-between align-items-center">
                                                                    <h5>Concluídos</h5>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $pedidos = getAllStatusConcluidoFromTecnico($conn, $tecnico);
                                                            foreach ($pedidos as $key => $value) {
                                                                $nomeStatus = getFullNomeFluxoPed($conn, $value['status']);
                                                            ?>
                                                                <div class="row d-flex justify-content-center">
                                                                    <div class="col d-flex justify-content-between align-items-center">
                                                                        <span class="text-conecta"><?php echo $nomeStatus . ": " ?></span>
                                                                        <span class="text-conecta"><?php echo $value['qtd']; ?></span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>

                                                    </div>

                                                <?php
                                                }

                                                ?>
                                            </div>
                                        <?php
                                        } else {
                                            $retMes = mysqli_query($conn, "SELECT * FROM mesesano WHERE mesNum = $mes;");
                                            while ($rowMes = mysqli_fetch_array($retMes)) {
                                                $nomeMes = $rowMes['mesNome'];
                                            }
                                        ?>
                                            <div class="row d-none d-print-block">
                                                <h3 class="text-conecta"><b>Performace do Técnico no mês de <?php echo $nomeMes; ?></b></h3>
                                                <hr>
                                            </div>
                                            <div class="row p-4 d-flex justify-content-between">
                                                <h4 class="text-muted"><b> <?php echo getNomeRep($conn, $tecnico); ?></b></h4>
                                                <div class="d-print-none d-flex justify-content-center">
                                                    <button class="btn btn-primary m-2" onclick="window.print();return false;"><i class="fa-solid fa-print"></i> Imprimir</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="card p-4">
                                                        <h5>Limite de Horas por Produto</h5>

                                                        <ul class="p-4" style="list-style: circle;">
                                                            <li>CUSTOMLIFE | CRÂNIO EM PEEK | CRÂNIO EM TITÂNIO | MESH 4U | SMARTMOLD = até 9h (100%) / até 13h (50%) / > 13h (30%)</li>
                                                            <li>Demais Produtos = até 18h (100%) / até 27h (50%) / > 27h (30%) </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card w-100 my-2 border-0">

                                                <div class="card-body">
                                                    <div class="container m-0 p-0">
                                                        <div class="row m-0 p-0">
                                                            <div class="col">
                                                                <table id="tableDesempenho" class="table table-striped table-advance table-hover">
                                                                    <thead class="text-center">
                                                                        <th></th>
                                                                        <th>Ped.</th>
                                                                        <th>Dr(a)</th>
                                                                        <th>Prod.</th>
                                                                        <th>Dt Inicio</th>
                                                                        <th>Dt Final</th>
                                                                        <th>Dias Totais</th>
                                                                        <th>Horas Planejando</th>
                                                                        <!-- <th>Limite Horas</th> -->
                                                                        <th>Fase Atual</th>
                                                                        <th>Valor</th>
                                                                        <th>Termômetro</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $count = 1;
                                                                        $valorTotal = 0;
                                                                        while ($rowFaq = mysqli_fetch_array($query)) {
                                                                            $id = $rowFaq['pedId'];
                                                                            $tipoProduto = $rowFaq['pedTipoProduto'];
                                                                            $numPed = $rowFaq['pedNumPedido'];
                                                                            $qtdMultiplicador = getMultiplicadorPedido($conn, $numPed);
                                                                            if (strpos($tipoProduto, 'SMARTMOLD')!== false) {
                                                                                $qtdMultiplicador = 1;
                                                                            }
                                                                            
                                                                            $dr = $rowFaq["pedNomeDr"];
                                                                            $dr = explode(" ", $dr);
                                                                            $dr = $dr[0] . " " . $dr[1];
                                                                            $datainicio = dateFormat2($rowFaq['data_iniciopedido']);
                                                                            $dataFinal = dateFormat3(getDataFinalPedido($conn, $numPed));

                                                                            $nomeFluxo = getNomeFluxoPed($conn, $numPed);
                                                                            $corFluxo = getCorFluxoPed($conn, $numPed);


                                                                            $diasGastos = intval(calcularDiasUteis($datainicio, $dataFinal));

                                                                            if ($diasGastos <= 5) {
                                                                                $cor1 = "text-success";
                                                                            } else if ($diasGastos > 5 && $diasGastos < 20) {
                                                                                $cor1 = "text-warning";
                                                                            } else if ($diasGastos >= 20) {
                                                                                $cor1 = "text-danger";
                                                                            }

                                                                            //Calculo dias planejando
                                                                            $statusEntrada = "PLAN";
                                                                            $statusSaida = "Avaliar Projeto";
                                                                            // $diaEntrouPlanejando = dateFormat3(getDataDeStatusPedido($conn, $numPed, $statusEntrada));
                                                                            // $diaSaiuPlanejando = dateFormat3(getDataDeStatusPedido($conn, $numPed, $statusSaida));
                                                                            // $diasGastosPlanejando = calcularHorasPlanejamento($diaEntrouPlanejando, $diaSaiuPlanejando);
                                                                            // $diasGastosPlanejando = converterHoras(calcularHorasPlanejamento($conn, $numPed));
                                                                            $diasGastosPlanejando = getHorasPlanejando($conn, $numPed);
                                                                            $limite = verificarLimitesHoras($conn, $numPed);
                                                                            $horaTotal = converterHoras(limiteHorasPorProduto($conn, $numPed));

                                                                            $valorLimiteHoras = limiteHorasPorProduto($conn, $numPed);
                                                                            // $valorOriginal = valorOriginal($valorLimiteHoras);
                                                                            // $valorResultante = valorResultante($limite, $valorLimiteHoras);
                                                                            // $valorOriginal = $qtdMultiplicador * valorOriginal($valorLimiteHoras);
                                                                            // $valorResultante = $qtdMultiplicador * valorResultante($limite, $valorLimiteHoras);
                                                                            $valorOriginal = valorOriginal($tipoProduto);
                                                                            $valorResultante = valorResultante($limite, $valorLimiteHoras,$tipoProduto);
                                                                            $valorTotal = $valorTotal + $valorResultante;
                                                                            $valorResultante = number_format($valorResultante, 2, ",", ".");
                                                                            $valorOriginal = number_format($valorOriginal, 2, ",", ".");


                                                                            if ($limite == '0') {
                                                                                $cor2 = "text-secondary";
                                                                                $bg = "bg-secondary";
                                                                                $parametro = "1";
                                                                                $desempenho = "Inexistente";
                                                                            } else if ($limite == "Muito Bom") {
                                                                                $cor2 = "text-success";
                                                                                $bg = "bg-success";
                                                                                $parametro = "100";
                                                                                $desempenho = "Dentro do Prazo (100%)";
                                                                            } else if ($limite == "Bom") {
                                                                                $cor2 = "text-warning";
                                                                                $bg = "bg-warning";
                                                                                $parametro = "50";
                                                                                $desempenho = "Fora Prazo (50%)";
                                                                            } else if ($limite >= 'Crítico') {
                                                                                $cor2 = "text-danger";
                                                                                $bg = "bg-danger";
                                                                                $parametro = "30";
                                                                                $desempenho = "Fora do Prazo (30%)";
                                                                            }

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
                                                                                <td style="font-size: 10px; "><?php echo $numPed; ?></td>
                                                                                <td style="font-size: 10px; "><?php echo $dr; ?></td>
                                                                                <td style="font-size: 8px; "><?php echo $tipoProduto . " (" . $qtdMultiplicador . ") "; ?></td>
                                                                                <td style="font-size: 8px; "><?php echo $datainicio; ?></td>
                                                                                <td style="font-size: 8px; "><?php echo $dataFinal; ?></td>
                                                                                <td style="font-size: 10px; " class="text-center "><b><?php echo $diasGastos; ?></b></td>
                                                                                <td style="font-size: 10px; " class="text-center <?php echo $cor2; ?>"><b><?php echo $diasGastosPlanejando; ?></b></td>
                                                                                <!-- <td class="text-center"><b><?php echo $horaTotal; ?></b></td> -->
                                                                                <td class="text-center"><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span>
                                                                                </td>
                                                                                <td style="font-weight: bold; "><span style="font-size: 8px; color: silver;">
                                                                                    <?php
                                                                                    if($qtdMultiplicador == 0){
                                                                                        $qtdMultiplicador = 1;
                                                                                    }
                                                                                    echo  "R$ " . floatval($valorOriginal) * $qtdMultiplicador; ?></span> <br>
                                                                                    <?php
                                                                             
                                                                                        echo  " R$ " .  number_format(floatval($valorResultante) * $qtdMultiplicador, 2, ",", ".");
                                                                                    ?>
                                                                                 </td>
                                                                                <td>
                                                                                    <p style="line-height: 1.5rem;">

                                                                                        <b style="font-size: 8px;" class="<?php echo $cor2; ?>"><?php echo $desempenho; ?></b>
                                                                                        <br>
                                                                                    <div class="progress">
                                                                                        <div class="progress-bar <?php echo $bg; ?>" role="progressbar" style="width: <?php echo $parametro; ?>%" aria-valuenow="<?php echo $parametro; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                    </p>

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

                                                        <div class="row py-4">
                                                            <div class="col d-flex justify-content-end">
                                                                <span>________________________</span>
                                                                <h5 class="text-muted"> Valor Total: <b>R$ <?php echo number_format($valorTotal, 2, ",", "."); ?></b></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    <?php
                                    } else {
                                    ?>
                                        <div class="row card-body d-flex justify-content-center p-4 my-4">
                                            <?php
                                            $res = countTecnicosCasosGERAL($conn);
                                            foreach ($res as $key => $value) {
                                                $tecnico = $value['tecnico'];
                                                $nome = $value['nome'];
                                                $tecnicoPrimeiroNome = getPrimeiroNome($nome);
                                                $qtd = $value['qtd'];
                                            ?>

                                                <div class="col-xs-12 col-sm-3 col-12 card shadow rounded m-2 bg-light p-4">
                                                    <div class="container-fluid card-body p-2">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col d-flex justify-content-between align-items-center">
                                                                <h3 style="color: #4b535a;">
                                                                    <b><?php echo $tecnicoPrimeiroNome; ?></b>
                                                                </h3>
                                                                <h3 style="color: #4b535a;"><b><?php echo $qtd; ?></b></h3>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $pedidos = getAllStatusFromTecnico($conn, $tecnico);
                                                        foreach ($pedidos as $key => $value) {
                                                            $nomeStatus = getFullNomeFluxoPed($conn, $value['status']);
                                                        ?>
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col d-flex justify-content-between align-items-center">
                                                                    <span class="text-conecta"><?php echo $nomeStatus . ": " ?></span>
                                                                    <span class="text-conecta"><?php echo $value['qtd']; ?></span>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <hr>
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col d-flex justify-content-between align-items-center">
                                                                <h5>Concluídos</h5>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $pedidos = getAllStatusConcluidoFromTecnico($conn, $tecnico);
                                                        foreach ($pedidos as $key => $value) {
                                                            $nomeStatus = getFullNomeFluxoPed($conn, $value['status']);
                                                        ?>
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col d-flex justify-content-between align-items-center">
                                                                    <span class="text-conecta"><?php echo $nomeStatus . ": " ?></span>
                                                                    <span class="text-conecta"><?php echo $value['qtd']; ?></span>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>

                                                    </div>

                                                </div>

                                            <?php
                                            }

                                            ?>
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
                        [5, "desc"]
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