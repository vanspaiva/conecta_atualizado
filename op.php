<?php
session_start();

if (!empty($_GET)) {

    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Planejador(a)')) || (($_SESSION["userperm"] == 'Planej. Ortognática')) || ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {

        ob_start();
        include("php/head_prop.php");
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';
        $idPed = addslashes($_GET['id']);


        $idPed = deshashItemNatural($idPed);

        $query = mysqli_query($conn, "SELECT * FROM pedido WHERE pedId = '$idPed'");
        while ($row = mysqli_fetch_array($query)) {
            $produto = $row["pedTipoProduto"];
            $codigosRaw = $row["pedProduto"];
            $numPed = $row["pedNumPedido"];
            $dr = $row["pedNomeDr"];
            $pac = $row["pedNomePac"];
            $loteop = $row["loteop"];
            $prop = $row["pedPropRef"];
            $tecnico = $row["pedTecnico"];
        }

        $codigos = explode("/", $codigosRaw);
        $codigosList = [];
        $anvisas = [];
        $descricoes = [];
        $allacompanha = [];
        $qtds = [];

        foreach ($codigos as $key => $value) {
            $codigo = $value;
            array_push($codigosList, $codigo);

            $qtd = getQtdFromCodigoAndProp($conn, $codigo, $prop);
            array_push($qtds, $qtd);

            $anvisa = getAnvisaFromCodigo($conn, $codigo);
            array_push($anvisas, $anvisa);

            $descricaoAnvisa = getDescricaoAnvisaFromCodigo($conn, $codigo);
            array_push($descricoes, $descricaoAnvisa);

            $acompanha = getAcompanhaFromCodigo($conn, $codigo);
            // $txt = "<b>" . $codigo . ":</b>" . $acompanha;
            array_push($allacompanha, $acompanha);

            //echo $key . "<br>Código: " . $codigo . "<br>Anvisa: " . $anvisa .  "<br>Acompanha: " . $acompanha .  "<br>Descrição: " . $descricaoAnvisa .  "<br><br>";
        }

        // $anvisa = getAnvisaFromCodigo($conn, $codigo);
        // $acompanha = getAcompanhaFromCodigo($conn, $codigo);
        // $descricaoAnvisa = getDescricaoAnvisaFromCodigo($conn, $codigo);

        $codigosList = implode("<br>", $codigosList);
        $qtds = implode("<br>", $qtds);
        $anvisas = implode("<br>", $anvisas);
        $descricoes = implode("<br>", $descricoes);
        $allacompanha = implode("", $allacompanha);

        $dtaceite = getDataAceite($conn, $numPed);
        $arquivo = getLinkArquivo($conn, $numPed);

?>
        <style>
            <?php
            echo require_once 'css/styleOP.css';
            ?>
        </style>

        <div class="container-fluid m-0 p-0 overflow-hidden">
            <div class="row w-100 m-0 p-0">
                <div class="col m-0 p-0">
                    <div class="bannerImpressao d-print-none d-flex justify-content-center p-3">
                        <button class="btn btn-light m-2" onclick="window.print();return false;"> <i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="op">
                        <div class="op-header row">
                            <div class="logo">
                                <!-- <h3>CPMH</h3> -->
                                <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0906db058ec5ee8cc4bcd93d25503562.png" alt="CPMH Digital" style="width: 15vw;">
                            </div>
                            <div class="titulo">
                                <h3>Procedimento do Sistema de Gestão da Qualidade</h3>

                                <p>
                                    FRM.PRO.001
                                    <br>
                                    ORDEM DE PRODUÇÃO (RHP)
                                </p>
                            </div>
                            <div class="revisao">
                                <p>
                                    Revisão: 1.0
                                    <br>
                                    Página. 1 de 1
                                </p>
                            </div>
                        </div>

                        <div class="op-cabecalho">
                            <div class="linha">
                                <div class="item-codigo">
                                    <div class="itemName">Código</div>
                                    <div class="itemDescricao"><?php echo $codigosList; ?></div>
                                </div>
                                <div class="item-produto">
                                    <div class="itemName">PRODUTO</div>
                                    <div class="itemDescricao"><?php echo $descricoes; ?></div>
                                </div>
                                <div class="item-anvisa">
                                    <div class="itemName">Registro ANVISA</div>
                                    <div class="itemDescricao"><?php echo $anvisas; ?></div>
                                </div>
                                <div class="item-qtd">
                                    <div class="itemName">QTD.</div>
                                    <div class="itemDescricao"><?php echo $qtds; ?></div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="item-lote">
                                    <div class="itemName">Lote</div>
                                    <div class="itemDescricao"><?php echo $loteop; ?></div>
                                </div>
                                <div class="item-npedido">
                                    <div class="itemName">Nº Pedido</div>
                                    <div class="itemDescricao"><?php echo $numPed; ?></div>
                                </div>
                            </div>
                            <div class="linha-2">
                                <div class="item-titulos-juntos">
                                    <div class="itemName2">Doutor(a): </div>
                                    <div class="itemName2">Paciente: </div>
                                </div>
                                <div class="item-descricoes-juntas">
                                    <div class="itemDescricao2"><?php echo $dr; ?></div>
                                    <div class="itemDescricao2"><?php echo $pac; ?></div>
                                </div>
                                <div class="item-titulos-juntos pl-2">
                                    <div class="itemName2">Dt Aceite: </div>
                                    <div class="itemName2">Arquivo: </div>
                                </div>
                                <div class="item-descricoes-juntas">
                                    <div class="itemDescricao2"><?php echo $dtaceite; ?></div>
                                    <div class="itemDescricao2"><?php echo $numPed; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="op-acompanha pb-4">
                            <div class="titulo-acompanha">
                                <h3>REGISTRO DE ITENS OP</h3>
                            </div>
                            <br>
                            <p class="p-2"><?php echo htmlspecialchars_decode($allacompanha); ?></p>

                        </div>

                        <div class="op-atividades table-responsive">
                            <div class="titulo-atividades">
                                <h3>REGISTRO DAS ETAPAS DE PRODUÇÃO</h3>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>N</th>
                                        <th>Processo</th>
                                        <th>Data</th>
                                        <th>Início</th>
                                        <th>Término</th>
                                        <th>Qtd.</th>
                                        <th>Responsável</th>
                                        <!-- <th>Parâmetros</th> -->
                                        <th>Disposição</th>
                                    </tr>
                                </thead>
                                <?php
                                $arrayStatus = [];
                                $query2 = mysqli_query($conn, "SELECT * FROM prazoproposta WHERE przNumProposta LIKE '%$numPed%' ORDER BY przId ASC") or die("Aconteceu algo errado!");
                                while ($rowFaq2 = mysqli_fetch_array($query2)) {
                                    $nomeFluxo = getFullNomeFluxoPed($conn, $rowFaq2['przStatus']);
                                    $dataFluxo = dateFormat2($rowFaq2['przData']);
                                    $horaFluxo = $rowFaq2['przHora'];
                                    $corFluxoFull = getFullCorFluxoPed($conn, $rowFaq2['przStatus']);
                                    $userFluxo = getNomeTecnicodoPedido($conn, $numPed);
                                    $item = [
                                        "Fluxo" => $nomeFluxo,
                                        "Data" => $dataFluxo,
                                        "Hora" => $horaFluxo,
                                        "Cor" => $corFluxoFull,
                                        "User" => $userFluxo,
                                    ];

                                    array_push($arrayStatus, $item);
                                }



                                ?>

                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    $thistermino = null;
                                    foreach ($arrayStatus as $chave => $valor) {
                                        $chaveParametro = $chave + 1;
                                        if (array_key_exists($chaveParametro, $arrayStatus)) {
                                            $thistermino = $arrayStatus[$chaveParametro]["Hora"];
                                        } else {
                                            $thistermino = "__/__/__";
                                        }


                                        // $arr[3] será atualizado com cada valor de $arr...
                                        foreach ($valor as $chave2 => $valor2) {
                                            $thisstatus = $valor['Fluxo'];
                                            $thiscor = $valor['Cor'];
                                            $thisdata = $valor['Data'];
                                            $thishora = $valor['Hora'];
                                            $thisuser = $valor['User'];
                                        }
                                        // $fluxosDesejados = ['Planejando', 'Projetando PDF', 'Projetando Produção', 'Projeto Aceito', 'Solicitação de Alteração', 'Pausado'];
                                        $fluxosDesejados = ['Planejando', 'Projetando PDF', 'Projetando Produção', 'Pré Planejamento', 'Segmentação'];
                                        if (in_array($thisstatus, $fluxosDesejados)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td class="txt-status"><?php echo $thisstatus; ?></td>
                                                <td><?php echo $thisdata; ?></td>
                                                <td><?php echo $thishora; ?></td>
                                                <td><?php echo $thistermino; ?></td>
                                                <td>1</td>
                                                <td><?php echo $thisuser; ?></td>
                                                <!-- <td></td> -->
                                                <td>Aprovado ✅</td>
                                            </tr>
                                    <?php
                                            $cnt++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="op-assinatura">
                            <p>
                                __________________________________
                                <br>
                                <b><?php echo getAllDataFromRep($conn, $tecnico)["usersName"]; ?></b>
                            </p>

                        </div>

                    </div>
                </div>
            </div>
        </div>

<?php

    } else {
        header("location: index");
        exit();
    }
} else {
    header("location: index");
    exit();
}


?>