<?php
session_start();

if (!empty($_GET)) {

    ob_start();
    include("php/head_prop.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

    $idProp = addslashes($_GET['id']);

    // // decrypt to get again $plaintext
    // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
    // $parts = explode(':', $idProp);
    // $idProp = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, base64_decode($parts[1]));

    $idProp = deshashItemNatural($idProp);

    $temKit = '';
    $temTxtAcompanha  = '';
    $txtImposto = '';
    $imposto = null;


    $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idProp . "';");

    while ($row = mysqli_fetch_array($ret)) {
        $user = $row['propUserCriacao'];
        $status = $row['propStatus'];

        $total = $row['propValorSomaTotal'];
        $porcDesconto = $row['propDesconto'];
        $valorDesconto = $row['propoValorDesconto'];

        $txtReprovada = $row['propTxtReprov'];
        $planovenda = $row['propPlanoVenda'];

        $cnpjcpf = $row['propCnpjCpf'];
        
        $tipoProduto = $row['propTipoProd'];
    }


    if (($_SESSION["userperm"] == 'Distribuidor(a)') ||  ($_SESSION["userperm"] == 'Dist. Comercial')) {
        $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
        while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
            $cnpjUser = $rowCnpj['usersCnpj'];
        }
    } else {
        $retCnpj = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
        while ($rowCnpj = mysqli_fetch_array($retCnpj)) {
            $cnpjUser = $rowCnpj['usersCpf'];
        }
    }

    if (($cnpjUser == $cnpjcpf) && (($status == "PROP. ENVIADA") || ($status == "APROVADO"))) {

        // if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Doutor(a)') || ($_SESSION["userperm"] == 'Distribuidor(a)') || ($_SESSION["userperm"] == 'Clínica') || ($_SESSION["userperm"] == 'Residente') || ($_SESSION["userperm"] == 'Paciente') || ($_SESSION["userperm"] == 'Internacional'))) {

        $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $idProp . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $dataEHoraProp = explode(" ", $row['propDataCriacao']);
            $dataProp = $dataEHoraProp[0];

            $total = $row['propValorSomaTotal'];

            $email = $row['propEmailEnvio'];

            $cnpjcpf = $row['propCnpjCpf'];

            if (strlen($cnpjcpf) === 18) {
                $temcnpj = true;
                $temcpf = false;
            } else {
                $temcnpj = false;
                $temcpf = true;
            }


            $userCriador = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $row['propUserCriacao'] . "';");
            while ($rowUserCriador = mysqli_fetch_array($userCriador)) {
                $empresa = $rowUserCriador['usersEmpr'];
                $ufUser = $rowUserCriador['usersUf'];

                $rep = $row['propRepresentante'];

                $retRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $rep . "';");
                while ($rowRep = mysqli_fetch_array($retRep)) {
                    $representante = $rowRep['usersName'];
                    $representante = explode(" ", $representante);
                    $representante = $representante[0];
                    $representanteFone = $rowRep['usersCel'];
                }
            }

            function calcularEntrada($valorprop, $porcentagem)
            {
                $valorprop = floatval($valorprop);

                $valorapagar = $porcentagem * $valorprop;
                return $valorapagar;
            }

            function calcularRestante($valorEntrada, $needle, $planovenda, $valorprop, $qtdparcelas)
            {

                if (strpos($planovenda, $needle) !== false) {
                    $valorprop = floatval($valorprop);
                    $valorEntrada = floatval($valorEntrada);



                    $restanteValor = $valorprop - $valorEntrada;
                    $restanteValor = $restanteValor / $qtdparcelas;

                    $restanteValor = number_format($restanteValor, 2, ',', '.');
                    $restanteValor = 'R$ ' . $restanteValor;

                    // $item = $needle . " dias - " . $restanteValor;
                    if ($needle == "50") {
                        $item = $needle . "% No ato da entrega - " . $restanteValor;
                    } else {
                        $item = $needle . "% - " . $restanteValor;
                    }
                }

                return $item;
            }

            $retRep = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $rep . "';");
            while ($rowRep = mysqli_fetch_array($retRep)) {
                $representante = $rowRep['usersName'];
                $representante = explode(" ", $representante);
                $representante = $representante[0];
                $representanteFone = $rowRep['usersCel'];
            }

            $valorprop = $row['propValorPosDesconto'];
            $planovenda = $row['propPlanoVenda'];


            $needle = '20%';

            $arrayRestante = array();

            if (strpos($planovenda, $needle) !== false) {
                $porcentagem = 0.2;
                $typeEntrada = '20%';

                $valorapagar = calcularEntrada($valorprop, $porcentagem);


                $segundoneedle = "30";
                $qtdparcelas = 2;
                $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                array_push($arrayRestante, $itemArray);

                $segundoneedle = "60";
                $qtdparcelas = 2;
                $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                array_push($arrayRestante, $itemArray);
            } else {
                $needle = '30%';
                if (strpos($planovenda, $needle) !== false) {
                    $porcentagem = 0.3;
                    $typeEntrada = '30%';

                    $valorapagar = calcularEntrada($valorprop, $porcentagem);

                    $segundaetapa = explode(" + ", $planovenda);
                    $segundaetapa = $segundaetapa[1];

                    $tiponeedle = "30";
                    if (strpos($segundaetapa, $tiponeedle) !== false) {

                        $segundoneedle = "30";
                        $qtdparcelas = 2;
                        $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                        array_push($arrayRestante, $itemArray);
                        $segundoneedle = "60";
                        $qtdparcelas = 2;
                        $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                        array_push($arrayRestante, $itemArray);
                    } else {

                        $segundoneedle = "28";
                        $qtdparcelas = 3;
                        $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                        array_push($arrayRestante, $itemArray);
                        $segundoneedle = "56";
                        $qtdparcelas = 3;
                        $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                        array_push($arrayRestante, $itemArray);
                        $segundoneedle = "84";
                        $qtdparcelas = 3;
                        $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                        array_push($arrayRestante, $itemArray);
                    }
                } else {
                    $needle = '50%';
                    if (strpos($planovenda, $needle) !== false) {
                        $porcentagem = 0.5;
                        $typeEntrada = '50%';

                        $valorapagar = calcularEntrada($valorprop, $porcentagem);
                        $segundaetapa = explode(" + ", $planovenda);
                        $segundaetapa = $segundaetapa[1];

                        $tiponeedle = "30";
                        if (strpos($segundaetapa, $tiponeedle) !== false) {

                            $segundoneedle = "30";
                            $qtdparcelas = 2;
                            $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                            array_push($arrayRestante, $itemArray);
                            $segundoneedle = "60";
                            $qtdparcelas = 2;
                            $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                            array_push($arrayRestante, $itemArray);
                        } else {

                            $segundoneedle = "50";
                            $qtdparcelas = 1;
                            $itemArray = calcularRestante($valorapagar, $segundoneedle, $planovenda, $valorprop, $qtdparcelas);
                            array_push($arrayRestante, $itemArray);
                        }
                    } else {
                        $porcentagem = 1;
                        $typeEntrada = "100%";
                        $valorapagar = calcularEntrada($valorprop, $porcentagem);
                    }
                }
            }


            $valorapagar = number_format($valorapagar, 2, ',', '.');
            $valorapagar = 'R$ ' . $valorapagar;

            $valorprop = number_format($valorprop, 2, ',', '.');
            $valorprop = 'R$ ' . $valorprop;

?>
            <style media="print">
                @page {
                    size: auto;
                    margin: 0;
                }
            </style>

            <style>
                #printOnly {
                    display: none;
                }

                @media print {
                    #printOnly {
                        display: block;
                    }

                    * {
                        -webkit-print-color-adjust: exact !important;
                        color-adjust: exact !important;
                    }
                }

                .conecta-icon {

                    background-image: url("https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_f8c738a66e66454b52c58395991cf3f1.png");
                    background-repeat: no-repeat;
                    background-size: 70vh;
                    background-position: center;
                }
            </style>

            <body class="bg-light-gray2">

                <div class="faixaRoxa d-print-none py-2">
                    <div class="conatiner">
                        <div class="row d-flex">
                            <div class="col d-flex justify-content-center align-items-center">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($status == "APROVADO") {
                    $retAceiteProp = mysqli_query($conn, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $idProp . "';");
                    while ($rowAceiteProp = mysqli_fetch_array($retAceiteProp)) {
                ?>
                        <div class='my-2 pb-0 alert alert-success pt-3 text-center'>
                            <p style="line-height: 1.5rem;">Essa proposta foi aprovada pelo usuário <?php echo $rowAceiteProp['apropNomeUsuario']; ?> no IP <?php echo $rowAceiteProp['apropIp']; ?> às <?php echo $rowAceiteProp['apropData']; ?></p>
                        </div>
                <?php
                    }
                }
                ?>
                <div class="conecta-icon">

                    <div class="container">
                        <div class="row">
                            <div class="col p-3 d-flex">
                                <div class="col-4 d-flex justify-content-start align-items-center">
                                    <!-- <h3>Proposta Comercial</h3> -->
                                    <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0906db058ec5ee8cc4bcd93d25503562.png" alt="CPMH Digital" style="width: 20vw;">
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <h6>Proposta Nº <?php echo $row['propId'] ?></h6>
                                </div>
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <h6><?php echo $dataProp ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col p-3 d-flex">
                                <div class="col-8 d-flex justify-content-start px-2">


                                    <h6><b>negocios@cpmh.com.br</b></h6>
                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    <h6><b>Validade:</b> 30 dias</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col p-3 d-flex">
                                <div class="col-3 d-flex justify-content-start">
                                    <span><b>E-mail: </b><?php echo " " . $email ?></span>

                                </div>

                                <div class="col-3 d-flex justify-content-start">
                                    <?php
                                    if ($temcnpj) {
                                    ?>
                                        <span><b>CNPJ</b><?php echo " " . $cnpjcpf ?></span>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($temcpf) {
                                    ?>
                                        <span><b>CPF</b><?php echo " " . $cnpjcpf ?></span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-3 d-flex justify-content-start">
                                    <?php
                                    if ($empresa != null) {
                                    ?>
                                        <span><b>Empresa</b><?php echo " " . $empresa ?></span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <span><b>Repres.</b><?php echo " " . $representante . " " . $representanteFone; ?></span>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col p-3 d-flex">
                                <div class="col-3 d-flex justify-content-start">
                                    <span><b>Dr(a)</b><?php echo " " . $row['propNomeDr'] ?></span>
                                </div>
                                <div class="col-3 d-flex justify-content-start">
                                    <span><b>Paciente</b><?php echo " " . $row['propNomePac'] ?></span>

                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <span><b>Convênio</b><?php if ($row['propConvenio'] != '') echo " " . $row['propConvenio']; ?></span>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>

                    <div class="container">
                        <table id="tableProp" class="table table-striped table-advance table-hover shadow">

                            <thead>
                                <tr style="background-color: #ee7624; color: #000;">
                                    <th><b> Cod.</b></th>
                                    <th><b>Produto</b></th>
                                    <th><b>NCM</b></th>
                                    <th><b>Qtd</b></th>
                                    <th><b>Anvisa</b></th>
                                    <th><b>Valor Unitário</b></th>
                                    <th><b>Valor Final</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $propListaItens = $row['propListaItens'];
                                $listaItens = explode(",", $propListaItens);

                                $qtdParafuso = 0;
                                $sumValoresProdutos = 0;

                                $tamListaItens = sizeof($listaItens);
                                // for ($i = 0; $i < $tamListaItens; $i++) {

                                $retProd = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $idProp . "';");
                                while ($rowProd = mysqli_fetch_array($retProd)) {
                                    $propTipoProd = $rowProd['itemNome'];
                                    $propTipoProd = explode(' ', $propTipoProd);
                                    $propTipoProd = $propTipoProd[0];

                                    $retProdDB = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $rowProd['itemCdg'] . "';");
                                    while ($rowProdDB = mysqli_fetch_array($retProdDB)) {
                                        $prodNCM = $rowProdDB["prodNCM"];
                                    }
                                ?>

                                    <tr>
                                        <td><?php echo $rowProd['itemCdg']; ?></td>
                                        <td><?php echo $rowProd['itemNome']; ?></td>
                                        <td><?php echo $prodNCM; ?></td>
                                        <td><?php echo $rowProd['itemQtd']; ?></td>
                                        <td><?php echo $rowProd['itemAnvisa']; ?></td>
                                        <?php if ($_SESSION["userperm"] == 'Dist. Comercial') { ?>
                                            <td>-</td>
                                            <td>-</td>
                                        <?php } else { ?>
                                            <td><?php echo "R$ " . number_format($rowProd['itemValorBase'], 2, ",", "."); ?></td>
                                            <td><?php echo "R$ " . number_format($rowProd['itemValor'], 2, ",", "."); ?></td>
                                        <?php } ?>
                                    </tr>
                            <?php
                                    $retProdDB = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $rowProd['itemCdg'] . "';");
                                    while ($rowProdDB = mysqli_fetch_array($retProdDB)) {

                                        if ($rowProdDB['prodKitDr'] != null) {
                                            $temKit = $temKit . htmlspecialchars_decode($rowProdDB['prodKitDr']);
                                        }
                                        if ($rowProdDB['prodTxtAcompanha'] != null) {
                                            $temTxtAcompanha = $temTxtAcompanha . '<p style="line-height: 1.5rem;"><b>' . $propTipoProd . '</b></p>' . htmlspecialchars_decode($rowProdDB['prodTxtAcompanha']) . '<br>';
                                        }

                                        if ($rowProdDB['prodImposto'] != null) {
                                            $imposto = $rowProdDB['prodImposto'];

                                            $txtImposto = $txtImposto . 'Produto ' . $propTipoProd . ' tem imposto de ' . $imposto . '%.<br>';
                                        }
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>

                        <?php

                        $valorTotalProp = $total;
                        ?>
                    </div>
                    <br>
                    <br>


                    <div class="container py-3 my-2">
                        <table id="tabelaTotal" class="table table-advance">

                            <tbody>
                                <?php
                                if ($porcDesconto != 0) {
                                    $total = $total - $valorDesconto;
                                ?>
                                    <tr class="d-flex justify-content-end">
                                        <th style="font-weight: bold;">Desconto (<?php if ($_SESSION["userperm"] == 'Dist. Comercial') {
                                                                                        echo '-';
                                                                                    } else {
                                                                                        echo $porcDesconto . "%";
                                                                                    } ?>)</th>
                                        <?php if ($_SESSION["userperm"] == 'Dist. Comercial') { ?>
                                            <th>-</th>
                                        <?php } else { ?>
                                            <th><?php echo number_format($valorDesconto, 2, ',', '.'); ?></th>
                                        <?php } ?>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr class="d-flex justify-content-end">
                                    <th style="font-weight: bold;">Total</th>
                                    <?php if ($_SESSION["userperm"] == 'Dist. Comercial') { ?>
                                        <th>-</th>
                                    <?php } else { ?>
                                        <th><?php echo number_format($total, 2, ',', '.'); ?></th>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="container p-2 my-2">
                        <div class="row">
                            <div class="card shadow w-100">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row p-2">
                                            <div class="col">
                                                <?php

                                                if ($temKit != null) {
                                                    echo '<h5><b>Kit Dr(a):</b></h5>';
                                                    echo '<p style="line-height: 1.5rem;">' . $temKit . '</p>';
                                                    echo '</hr>';
                                                }
                                                ?>
                                                <?php

                                                if ($temTxtAcompanha != null) {
                                                    echo '<h5><b>Kit Acompanha: </b></h5>';
                                                    echo '<p style="line-height: 1.5rem;">' . $temTxtAcompanha . '</p>';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container p-2 my-2">
                        <div class="row">
                            <div class="card shadow w-100">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <?php if ($imposto != null) { ?>
                                            <div class="row p-2">
                                                <div class="col">
                                                    <p style="line-height: 1.5rem;"><?php echo $txtImposto; ?></p>

                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="row p-2">
                                            <div class="col">
                                                <h6><b>Plano de Venda</b></h6>
                                                <p style="line-height: 1.5rem;"><?php echo $planovenda; ?></p>
                                                <?php if ($_SESSION["userperm"] == 'Dist. Comercial') { ?>

                                                <?php } else { ?>
                                                    <?php
                                                        if ($planovenda == "6x") {
                                                            $typeEntrada = "6x ";
                                                            $valorapagar = $total / 6;
                                                            $valorapagar = number_format($valorapagar, 2, ',', '.');
                                                        }
                                                    ?>
                                                    <p style="line-height: 1.5rem;"><?php echo $typeEntrada . " - " . $valorapagar; ?></p>

                                                <?php
                                                    foreach ($arrayRestante as &$item) {
                                                        echo "<p style='line-height: 1.5rem;'>" . $item . "</p>";
                                                    }
                                                } ?>

                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col">
                                                <h6><b>Dados Bancários</b></h6>
                                                <p style="line-height: 1.5rem;">033 Santander<br>
                                                    Agência: 4515<br>
                                                    Conta: 13.004.277-9<br>
                                                    CNPJ: 13.532.259/0001-25<br>
                                                    Chave PIX (CNPJ): 13.532.259/0001-25</p>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col">
                                                <h6><b>Política de Cancelamento Pedido Após Orçamento Aprovado</b></h6><br>
                                                <p style="line-height: 1.5rem;">- Necessário aviso prévio de 48H e será cobrado 50% do valor do pedido.
                                                </p>
                                                <h6><b>Condições de pagamento</b></h6><br>
                                                <p style="line-height: 1.5rem;">
                                                    Prazo de pagamento conta a partir data da aprovação da proposta, e pode haver alterações após análise de crédito*
                                                    <br>
                                                    * Em caso de inadimplência será cobrado juros, 1% a.m e multa 10%.
                                                    <br>
                                                    Observação:
                                                    <br>
                                                    ***Ressaltamos que por se tratar de produto customizado, pode haver alterações do tipo de produto, quantidade e consequentemente de valores, após o planejamento.
                                                </p>

                                                <!--<h6><b>ATA HOF ou Smartmold facial - Produto acompanha:</b></h6><br>
                                                <p style="line-height: 1.5rem;">
                                                    Realização de 01 video técnica para demonstração do projeto e possibilidades de alterações que serão enviadas por e-mail o novo projeto.
                                                    <br>
                                                    Caso solicite novas alterações além da realizada na primeira vídeo, será necessário novo agendamento da video técnica com adiconal de taxa extra do técnico R$ 500,00.
                                                    <br>
                                                    Pedimos para não envolver o paciente em videos para maior agilidade e fluxo de finalização do projeto.
                                                    <br>
                                                </p>-->
                                                
                                                <?php if ($tipoProduto == 'ATM') { ?>
                                                <h6><b>Prótese de ATM</b></h6><br>
                                                <p style="line-height: 1.5rem;">
                                                    Para o agendamento de instrumentador para a prótese de ATM, é necessário no mínimo <b>15 dias (úteis)</b> de antecedência da data da cirurgia. Após este período, o distribuidor arcará com os custos do deslocamento e hospedagem. Para realizar o agendamento, basta preencher o link: <a href="https://form.jotform.com/GRUPOFIX/agendamento" target="_blank"> https://form.jotform.com/GRUPOFIX/agendamento</a>
                                                    <br>
                                                    Caso a cirurgia for reagendada e a passagem já estiver emitida, o distribuidor deverá arcar com os custos supracitados.
                                                    <br>
                                                    <br>
                                                    Dúvidas: <a href="tel:+6130288863" target="_blank"> (61) 3028-8863</a> ou <a href="mailto:relacionamento@cpmh.com.br" target="_blank"> relacionamento@cpmh.com.br</a>
                                                </p>
                                            <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col">
                                                <h6><b>Frete</b></h6>
                                                <p style="line-height: 1.5rem;">ATENÇÃO! Frete: Responsabilidade cliente.</p>
                                            </div>
                                        </div>
                                        <?php if ($tipoProduto == 'CUSTOMLIFE') { ?>
                                        <div class="row p-2">
                                            <div class="col">
                                                <h6><b>Importante!</b></h6>
                                                <p style="line-height: 1.5rem;">CustomLIFE - Produto reservado para uso exclusivo de Drs credenciados na técnica.</p>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>

                                        <div class="row">
                                            <div id="printOnly">
                                                <div class="container p-4 my-2">
                                                    <div class="row">
                                                        <div class="col">
                                                            <?php
                                                            date_default_timezone_set('UTC');
                                                            $dtz = new DateTimeZone("America/Sao_Paulo");
                                                            $dt = new DateTime("now", $dtz);
                                                            $data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

                                                            $localIP = getHostByName(getHostName());

                                                            $userAceite = $_SESSION["useruid"];
                                                            $dataAceite = $data_criacao;
                                                            $ipAceite = $localIP;
                                                            ?>
                                                            <!--Arquivo gerado pelo usuário <?php echo $userAceite; ?> às <?php echo $data_criacao; ?> pelo IP: <?php echo $localIP; ?>-->
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


                    <!--<?php
                        if ($txtReprovada != null) {
                        ?>
                    <div class="container p-2 my-2">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <h5 style="font-weight: bold; color: red;">TC REPROVADA</h5>
                                    <?php echo $txtReprovada; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                ?>-->
                </div>




                <br>

                <div class="d-print-none d-flex justify-content-center">
                    <button class="btn btn-primary m-2" onclick="window.print();return false;">Imprimir</button>
                    <?php
                    if ($status == "PROP. ENVIADA") {
                        // // cryptographic key of a binary string 16 bytes long (because AES-128 has a key size of 16 bytes)
                        // $encryption_key = '58adf8c78efef9570c447295008e2e6e'; // example
                        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                        // $encrypted = openssl_encrypt($idProp, 'aes-256-cbc', $encryption_key, OPENSSL_RAW_DATA, $iv);
                        // $encrypted = $encrypted . ':' . base64_encode($iv);
                        // $encrypted = urlencode($encrypted);
                        $encrypted = hashItemNatural($idProp);
                    ?>
                        <a href="aceiteproposta?id=<?php echo $encrypted; ?>">
                            <button class="btn btn-success m-2"><i class="bi bi-check-circle"></i> Aceitar </button>
                        </a>
                        <!--<a href="propaceite.php?id=<?php echo $idProp; ?>&user=<?php echo $userAceite; ?>&data=<?php echo $dataAceite; ?>&ip=<?php echo $ipAceite; ?>">
                        <button class="btn btn-success m-2" onClick="return confirm('Eu declaro aceitar a proposta listada aqui!');"><i class="bi bi-check-circle"></i> Aceitar </button>
                    </a>-->
                    <?php
                    }
                    ?>

                </div>
        <?php


        include_once 'php/footer_index.php';
    } else {
        header("location: minhassolicitacoes");
        exit();
    }
} else {
    header("location: index");
    exit();
}
        ?>