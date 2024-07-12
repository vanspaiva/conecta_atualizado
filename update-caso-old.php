<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)'))) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        $idPed = addslashes($_GET['id']);



        $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedId='" . $idPed . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $numeroCaso = $row['pedNumPedido'];
            $encrypted = hashItemNatural($numeroCaso);
            $produto = $row['pedTipoProduto'];
            $observacao = $row['pedObservacao'];

            $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propPedido=" . $numeroCaso . ";");
            while ($rowProp = mysqli_fetch_array($retProp)) {
                if ($rowProp["propEspessura"] != null) {
                    $produto = $produto . " - " . $rowProp["propEspessura"];
                }
            }

        ?>
            <div id="main" class="font-montserrat">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Salvo com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="py-4 d-flex justify-content-center">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-center' id='back'>
                                        <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="">
                                        <h2 class="text-conecta" style="font-weight: 400;">Informações do Caso <span style="font-weight: 700;"><?php echo $numeroCaso ?></span>
                                            <a href="unit?id=<?php echo $encrypted; ?>">
                                                <button class="btn text-conecta"><i class="fas fa-eye fa-2x"></i></button>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <hr style="border: 1px solid #ee7624">
                            <br>
                            <div class="row d-flex justify-content-center">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="content-panel">
                                                            <form class="form-horizontal style-form" name="form1" action="includes/updatecasos.inc.php" method="post">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="casoId">Caso ID</label>
                                                                        <input type="number" class="form-control" id="casoId" name="casoId" value="<?php echo $row['pedId']; ?>" required readonly>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                    <!--<div class="form-group col-md-4">
                                                                        <label class="form-label text-black" for="andamento">Status</label>
                                                                        <select name="andamento" class="form-control" id="andamento" onchange="verificarAndamento(this)" required>
                                                                            <option value="ABERTO" <?php if ($row['pedAndamento'] == 'ABERTO') echo ' selected="selected"'; ?> style="color: #77D45F;">ABERTO</option>
                                                                            <option value="PENDENTE" <?php if ($row['pedAndamento'] == 'PENDENTE') echo ' selected="selected"'; ?> style="color: #D64434;">PENDENTE</option>
                                                                            <option value="FINALIZADO" <?php if ($row['pedAndamento'] == 'FINALIZADO') echo ' selected="selected"'; ?> style="color: #5F8AD4;">FINALIZADO</option>
                                                                            <option value="ARQUIVADO" <?php if ($row['pedAndamento'] == 'ARQUIVADO') echo ' selected="selected"'; ?> style="color: #393D3D;">ARQUIVADO</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center align-items-start mt-4 p-2">
                                                                        <span id="bookmark" style="color: #9FA0A6;"><i class="fas fa-bookmark fa-2x"></i></span>
                                                                    </div>
                                                                -->
                                                                    <div class="form-group col-md-4">
                                                                        <label class="form-label text-black" for="tecnico">Técnico</label>
                                                                        <select name="tecnico" class="form-control" id="tecnico" required>
                                                                            <?php
                                                                            $retTecnico = mysqli_query($conn, "SELECT * FROM responsavelagenda ORDER BY responsavelagendaNome ASC");
                                                                            while ($rowTecnico = mysqli_fetch_array($retTecnico)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowTecnico['responsavelagendaNome']; ?>" <?php if ($row['pedTecnico'] == $rowTecnico['responsavelagendaNome']) echo ' selected="selected"'; ?>><?php echo $rowTecnico['responsavelagendaNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>


                                                                    <script>
                                                                        //mudar cores do bookmark
                                                                        //Verde: #5EA324
                                                                        //azul: #536DF0
                                                                        //vermelho: #F04152
                                                                        //amarelo: #F0EA59

                                                                        $(document).ready(function() {
                                                                            verificarAndamento(document.getElementById("andamento"));
                                                                        });

                                                                        function verificarAndamento(elemento) {
                                                                            var elem = elemento.value;
                                                                            var cor;
                                                                            switch (elem) {
                                                                                case 'ABERTO':
                                                                                    cor = '#5EA324';
                                                                                    break;
                                                                                case 'PENDENTE':
                                                                                    cor = '#F04152';
                                                                                    break;
                                                                                case 'FINALIZADO':
                                                                                    cor = '#536DF0';
                                                                                    break;
                                                                                case 'ARQUIVADO':
                                                                                    cor = '#F0EA59';
                                                                                    break;

                                                                                default:
                                                                                    cor = '#9FA0A6';
                                                                            }

                                                                            document.getElementById('bookmark').style.color = cor;
                                                                        }
                                                                    </script>

                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="numped">Número do Pedido</label>
                                                                        <input type="text" class="form-control" id="numped" name="numped" value="<?php echo $row['pedNumPedido']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="numprop">Número da Proposta (Ref) <a href="update-plan?id=<?php echo $row['pedPropRef']; ?>" class="text-conecta"><i class="fas fa-link"></i></a> </label>
                                                                        <input type="text" class="form-control" id="numprop" name="numprop" value="<?php echo $row['pedPropRef']; ?>" required readonly>
                                                                    </div>



                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="nomedr">Doutor(a)</label>
                                                                        <input type="text" class="form-control" id="nomedr" name="nomedr" value="<?php echo $row['pedNomeDr']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="nomepac">Paciente</label>
                                                                        <input type="text" class="form-control" id="nomepac" name="nomepac" value="<?php echo $row['pedNomePac']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="tipoproduto">Tipo Produto</label>
                                                                        <input type="tel" class="form-control" id="tipoproduto" name="tipoproduto" value="<?php echo $produto; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="especificacao">Especificação</label>
                                                                        <input type="tel" class="form-control" id="especificacao" name="especificacao" value="<?php echo $row['pedProduto']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-4">
                                                                        <label class="form-label text-black" for="status">Fluxo</label>
                                                                        <select name="status" class="form-control" id="status" onchange="liberarAbas(this)" required>
                                                                            <option value="PCP" <?php if ($row['pedStatus'] == 'PCP') echo ' selected="selected"'; ?>>PCP</option>
                                                                            <option value="CRIADO" <?php if ($row['pedStatus'] == 'CRIADO') echo ' selected="selected"'; ?>>Projetista Próximo</option>
                                                                            <option value="PLAN" <?php if ($row['pedStatus'] == 'PLAN') echo ' selected="selected"'; ?>>Planejando</option>
                                                                            <option value="VIDEO" <?php if ($row['pedStatus'] == 'VIDEO') echo ' selected="selected"'; ?>>Aguardando Vídeo</option>
                                                                            <option value="PDF" <?php if ($row['pedStatus'] == 'PDF') echo ' selected="selected"'; ?>>Projetando PDF</option>
                                                                            <option value="ACEITE" <?php if ($row['pedStatus'] == 'ACEITE') echo ' selected="selected"'; ?>>Aguardando Aceite</option>
                                                                            <option value="PROJ" <?php if ($row['pedStatus'] == 'PROJ') echo ' selected="selected"'; ?>>Projetando Produção</option>
                                                                            <option value="PROD" <?php if ($row['pedStatus'] == 'PROD') echo ' selected="selected"'; ?>>Produção</option>
                                                                            <option value="ENVIADO" <?php if ($row['pedStatus'] == 'ENVIADO') echo ' selected="selected"'; ?>>Expedição</option>
                                                                            <option value="Arquivado (+90 dias)" <?php if ($row['pedStatus'] == 'Arquivado (+90 dias)') echo ' selected="selected"'; ?>>Arquivado (+90 dias)</option>
                                                                            <option value="Aguardando info/Docs" <?php if ($row['pedStatus'] == 'Aguardando info/Docs') echo ' selected="selected"'; ?>>Aguardando info/Docs</option>
                                                                            <option value="Projeto Aceito" <?php if ($row['pedStatus'] == 'Projeto Aceito') echo ' selected="selected"'; ?>>Projeto Aceito</option>
                                                                            <option value="Solicitação de Alteração" <?php if ($row['pedStatus'] == 'Solicitação de Alteração') echo ' selected="selected"'; ?>>Solicitação de Alteração</option>
                                                                        </select>
                                                                    </div>
                                                                    <script>
                                                                        function liberarAbas(elemento) {
                                                                            console.log('entrou');
                                                                            var elem = elemento.value;
                                                                            var agenda = document.getElementById('agenda');
                                                                            var visualizacao = document.getElementById('visualizacao');
                                                                            var aceite = document.getElementById('aceite');
                                                                            var relatorio = document.getElementById('relatorio');
                                                                            var documentos = document.getElementById('documentos');

                                                                            switch (elem) {
                                                                                case 'CRIADO':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    break;
                                                                                case 'PLAN':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    break;
                                                                                case 'VIDEO':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    agenda.checked = true;
                                                                                    break;
                                                                                case 'ACEITE':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    agenda.checked = true;
                                                                                    visualizacao.checked = true;
                                                                                    aceite.checked = true;
                                                                                    break;

                                                                                case 'ENVIADO':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    agenda.checked = true;
                                                                                    aceite.checked = true;
                                                                                    relatorio.checked = true;
                                                                                    break;

                                                                                default:
                                                                                    // code block
                                                                            }

                                                                        }

                                                                        function uncheckAll() {
                                                                            var agenda = document.getElementById('agenda');
                                                                            var visualizacao = document.getElementById('visualizacao');
                                                                            var aceite = document.getElementById('aceite');
                                                                            var relatorio = document.getElementById('relatorio');
                                                                            var documentos = document.getElementById('documentos');

                                                                            agenda.checked = false;
                                                                            visualizacao.checked = false;
                                                                            aceite.checked = false;
                                                                            relatorio.checked = false;
                                                                            documentos.checked = false;

                                                                        }
                                                                    </script>
                                                                    <div class="form-group col-md p-2">
                                                                        <label class="text-black">Liberar Abas</label>
                                                                        <div class="row rounded py-2">
                                                                            <div class="col">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="documentos" name="documentos" value="liberado" <?php if ($row['pedAbaDocumentos'] == 'liberado') {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo '';
                                                                                                                                                                                        } ?> />
                                                                                    <label class="form-check-label text-black" for="documentos">Docs Anvisa</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="agenda" name="agenda" value="liberado" <?php if ($row['pedAbaAgenda'] == 'liberado') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo '';
                                                                                                                                                                                } ?> />
                                                                                    <label class="form-check-label text-black" for="agenda">Agendar Vídeo</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="aceite" name="aceite" value="liberado" <?php if ($row['pedAbaAceite'] == 'liberado') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo '';
                                                                                                                                                                                } ?> />
                                                                                    <label class="form-check-label text-black" for="aceite">Aceite Projeto</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="relatorio" name="relatorio" value="liberado" <?php if ($row['pedAbaRelatorio'] == 'liberado') {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo '';
                                                                                                                                                                                        } ?> />
                                                                                    <label class="form-check-label text-black" for="relatorio">Relatórios</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" id="visualizacao" name="visualizacao" value="liberado" <?php if ($row['pedAbaVisualizacao'] == 'liberado') {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo '';
                                                                                                                                                                                            } ?> />
                                                                                    <label class="form-check-label text-black" for="visualizacao">Visualização Projeto</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="observacao">Observação</label>
                                                                        <input type="tel" class="form-control" id="observacao" name="observacao" value="<?php echo $observacao; ?>" >
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="d-flex justify-content-center">
                                                                    <button type="submit" name="update" class="btn btn-primary">Salvar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <?php include_once 'php/footer_index.php' ?>

        <?php

    } else {
        header("location: index");
        exit();
    }


        ?>