<?php
session_start();
if (!empty($_GET) && isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática' ) || ($_SESSION["userperm"] == 'Comercial') )) {
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
            $loteop = $row['loteop'];

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
                        <div class="container-fluid">
                            <div class="row d-flex align-items-center">
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
                                        <p class="text-muted"> Os formulários abaixo são independentes, atente-se para salvá-los separadamente.</p>
                                    </div>
                                </div>
                            </div>
                            <hr style="border: 1px solid #ee7624">
                            <br>
                            <div class="row d-flex justify-content-center mb-2">
                                <div class="col-8">
                                    <div class="card shadow h-100">
                                        <div class="card-header">
                                            <h5 class="text-muted">Edição de Informações</h5>
                                        </div>
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
                                                                    </div>-->

                                                                        <div class="form-group col-md-4">
                                                                            <label class="form-label text-black" for="tecnico">Técnico</label>
                                                                            <select name="tecnico" class="form-control" id="tecnico" required>
                                                                                <?php
                                                                                $retTecnico = mysqli_query($conn, "SELECT * FROM responsavelagenda r INNER JOIN users u ON r.responsavelagendaNome = u.usersUid ORDER BY `u`.`usersName` ASC;");
                                                                                while ($rowTecnico = mysqli_fetch_array($retTecnico)) {
                                                                                    $firstName = getPrimeiroNome($rowTecnico['usersName']);
                                                                                ?>
                                                                                    <option value="<?php echo $rowTecnico['responsavelagendaNome']; ?>" <?php if ($row['pedTecnico'] == $rowTecnico['responsavelagendaNome']) echo ' selected="selected"'; ?>><?php echo $firstName; ?></option>
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
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="observacao">Observação</label>
                                                                            <input type="tel" class="form-control" id="observacao" name="observacao" value="<?php echo $observacao; ?>">
                                                                        </div>
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="loteop">Lote (OP)</label>
                                                                            <input type="tel" class="form-control" id="loteop" name="loteop" value="<?php echo $loteop; ?>">
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

                                        </div>
                                    </div>
                                </div>


                                <div class="col-4">
                                    <div class="card shadow h-100">
                                        <div class="card-header">
                                            <h5 class="text-muted">Mudança de Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <section id="main-content">
                                                <section class="wrapper">
                                                    <div class="row d-flex justify-content-center">
                                                        <div>
                                                            <?php
                                                            if (isset($_GET["error"])) {
                                                                if ($_GET["error"] == "statusatualizado") {
                                                                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Novo status salvo com sucesso!</p></div>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
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
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="ped">Num Ped</label>
                                                                            <input type="number" class="form-control" id="ped" name="ped" value="<?php echo $row['pedNumPedido']; ?>" required readonly>
                                                                            <small class="text-muted">ID não é editável</small>
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="status">Fluxo</label>
                                                                            <!--<select name="status" class="form-control" id="status" onchange="liberarAbas(this)" required>-->
                                                                            <!--    <option value="PCP" <?php if ($row['pedStatus'] == 'PCP') echo ' selected="selected"'; ?>>PCP</option>-->
                                                                            <!--    <option value="CRIADO" <?php if ($row['pedStatus'] == 'CRIADO') echo ' selected="selected"'; ?>>Projetista Próximo</option>-->
                                                                            <!--    <option value="PLAN" <?php if ($row['pedStatus'] == 'PLAN') echo ' selected="selected"'; ?>>Planejando</option>-->
                                                                            <!--    <option value="Avaliar Projeto" <?php if ($row['pedStatus'] == 'Avaliar Projeto') echo ' selected="selected"'; ?>>Avaliar Projeto</option>-->
                                                                            <!--    <option value="VIDEO" <?php if ($row['pedStatus'] == 'VIDEO') echo ' selected="selected"'; ?>>Aguardando Vídeo</option>-->
                                                                            <!--    <option value="Video Agendada" <?php if ($row['pedStatus'] == 'Video Agendada') echo ' selected="selected"'; ?>>Vídeo Agendada</option>-->
                                                                            <!--    <option value="PDF" <?php if ($row['pedStatus'] == 'PDF') echo ' selected="selected"'; ?>>Projetando PDF</option>-->
                                                                            <!--    <option value="ACEITE" <?php if ($row['pedStatus'] == 'ACEITE') echo ' selected="selected"'; ?>>Aguardando Aceite</option>-->
                                                                            <!--    <option value="PROJ" <?php if ($row['pedStatus'] == 'PROJ') echo ' selected="selected"'; ?>>Projetando Produção</option>-->
                                                                            <!--    <option value="PROD" <?php if ($row['pedStatus'] == 'PROD') echo ' selected="selected"'; ?>>Produção</option>-->
                                                                            <!--    <option value="ENVIADO" <?php if ($row['pedStatus'] == 'ENVIADO') echo ' selected="selected"'; ?>>Expedição</option>-->
                                                                            <!--    <option value="Arquivado (+90 dias)" <?php if ($row['pedStatus'] == 'Arquivado (+90 dias)') echo ' selected="selected"'; ?>>Arquivado (+90 dias)</option>-->
                                                                            <!--    <option value="Aguardando info/Docs" <?php if ($row['pedStatus'] == 'Aguardando info/Docs') echo ' selected="selected"'; ?>>Aguardando info/Docs</option>-->
                                                                            <!--    <option value="Projeto Aceito" <?php if ($row['pedStatus'] == 'Projeto Aceito') echo ' selected="selected"'; ?>>Projeto Aceito</option>-->
                                                                            <!--    <option value="Solicitação de Alteração" <?php if ($row['pedStatus'] == 'Solicitação de Alteração') echo ' selected="selected"'; ?>>Solicitação de Alteração</option>-->
                                                                            <!--    <option value="IBMF" <?php if ($row['pedStatus'] == 'IBMF') echo ' selected="selected"'; ?>>IBMF</option>-->
                                                                            <!--</select>-->
                                                                            <select name="status" class="form-control" id="status" onchange="liberarAbas(this)" required>
                                                                            <?php
                                                                                $retStatus = mysqli_query($conn, "SELECT * FROM statuspedido ORDER BY stpedNome ASC");
                                                                                while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                                ?>
                                                                                <option value="<?php echo $rowStatus['stpedValue']; ?>" <?php if ($row['pedStatus'] == $rowStatus['stpedValue']) echo ' selected="selected"'; ?>><?php echo $rowStatus['stpedNome']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row" id="escolhadocs" <?php if (($row['pedDocsFaltantes'] == null) || ($row['pedStatus'] != 'Aguardando info/Docs')) echo ' hidden'; ?>>
                                                                        <div class="form-group col-md">
                                                                            <label class="form-label text-black" for="docsfaltantes">Documentos que faltam</label>
                                                                            <select name="docsfaltantes" class="form-control" id="docsfaltantes">
                                                                                <option value="0">Escolha uma opção</option>
                                                                                <?php
                                                                                $retTecnico = mysqli_query($conn, "SELECT * FROM docspedido ORDER BY docsNome ASC");
                                                                                while ($rowTecnico = mysqli_fetch_array($retTecnico)) {
                                                                                ?>
                                                                                    <option value="<?php echo $rowTecnico['docsNome']; ?>" <?php if ($row['pedDocsFaltantes'] == $rowTecnico['docsNome']) echo ' selected="selected"'; ?>><?php echo $rowTecnico['docsNome']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
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
                                                                            var docsComboBox = document.getElementById('escolhadocs');
                                                                            var docsComboBoxVar = document.getElementById('docsfaltantes');
                                                                            docsComboBox.hidden = true;
                                                                            docsComboBoxVar.required = false;

                                                                            switch (elem) {
                                                                                case 'PCP':
                                                                                    uncheckAll();
                                                                                    break;

                                                                                case 'CRIADO':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    break;

                                                                                case 'PLAN':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    break;

                                                                                case 'Avaliar Projeto':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    relatorio.checked = false;
                                                                                    break;

                                                                                case 'VIDEO':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    agenda.checked = true;
                                                                                    break;

                                                                                case 'Video Agendada':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    agenda.checked = true;
                                                                                    break;

                                                                                case 'PDF':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    break;

                                                                                case 'ACEITE':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    aceite.checked = true;
                                                                                    break;

                                                                                case 'PROJ':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    visualizacao.checked = true;
                                                                                    break;

                                                                                case 'PROD':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    visualizacao.checked = true;
                                                                                    break;

                                                                                case 'ENVIADO':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    visualizacao.checked = true;
                                                                                    break;

                                                                                case 'Arquivado (+90 dias)':
                                                                                    uncheckAll();
                                                                                    break;

                                                                                case 'Aguardando info/Docs':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    docsComboBox.hidden = false;
                                                                                    docsComboBoxVar.required = true;
                                                                                    break;

                                                                                case 'Projeto Aceito':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    visualizacao.checked = true;
                                                                                    break;

                                                                                case 'Solicitação de Alteração':
                                                                                    uncheckAll();
                                                                                    documentos.checked = true;
                                                                                    visualizacao.checked = true;
                                                                                    aceite.checked = true;
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
                                                                    <div class="form-row d-none">
                                                                        <div class="form-group col-md p-2">
                                                                            <label class="text-black">Liberar Abas</label>
                                                                            <div class="row d-block rounded py-2">
                                                                                <div class="col d-block">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" id="documentos" name="documentos" value="liberado" <?php if ($row['pedAbaDocumentos'] == 'liberado') {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo '';
                                                                                                                                                                                            } ?> />
                                                                                        <label class="form-check-label text-black" for="documentos">Docs Anvisa</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col d-block">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" id="agenda" name="agenda" value="liberado" <?php if ($row['pedAbaAgenda'] == 'liberado') {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo '';
                                                                                                                                                                                    } ?> />
                                                                                        <label class="form-check-label text-black" for="agenda">Agendar Vídeo</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col d-block">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" id="aceite" name="aceite" value="liberado" <?php if ($row['pedAbaAceite'] == 'liberado') {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo '';
                                                                                                                                                                                    } ?> />
                                                                                        <label class="form-check-label text-black" for="aceite">Aceite Projeto</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col d-block">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" id="relatorio" name="relatorio" value="liberado" <?php if ($row['pedAbaRelatorio'] == 'liberado') {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo '';
                                                                                                                                                                                            } ?> />
                                                                                        <label class="form-check-label text-black" for="relatorio">Relatórios</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col d-block">
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
                                                                        <div class="form-group col-md p-2">
                                                                            <div class="d-flex justify-content-center">
                                                                                <button type="submit" name="mudarstatus" id="mudarstatus" class="btn btn-primary">Salvar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="py-4 col d-flex justify-content-center">
                                                                        <img src="assets/img/loading.gif" alt="Carregando" style="width: 30px;" id="loading" hidden>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-4">
                                                        <div class="col">
                                                            <hr>
                                                            <div class="form-row">
                                                                <div class="form-group col-md p-2">
                                                                    <div class="d-flex justify-content-center">
                                                                        <a href="reabriraceite?id=<?php echo $row['pedNumPedido']; ?>" class="btn btn-outline-conecta" type="">
                                                                            Reabrir Aceite
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </section>
                                            </section>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row d-flex justify-content-center mb-2">
                                <div class="col-5">

                                    <div class="card shadow h-100">
                                        <div class="card-header" style="background-color: #ee7624;">
                                            <h5 class="text-white">Avaliação Interna</h5>
                                        </div>
                                        <div class="card-body bg-visualizar d-flex">
                                            <div class="container-fluid">
                                                <?php
                                                $retAvaliacao = mysqli_query($conn, "SELECT * FROM avaliacaopedido WHERE avNumPed= '" . $numeroCaso . "';");

                                                if (($retAvaliacao) && ($retAvaliacao->num_rows != 0)) {
                                                    while ($rowAvaliacao = mysqli_fetch_array($retAvaliacao)) {

                                                        //avId avNumPed avStatus avObservacao avUserObs avData avHora

                                                        $statusav = $rowAvaliacao['avStatus'];
                                                        if ($statusav == 0) {
                                                            $statusav = "Sol. Alteração";
                                                            $color = "warning text-dark";
                                                        } else {
                                                            $statusav = "Liberado";
                                                            $color = "success text-white";
                                                        }

                                                        $obs = $rowAvaliacao['avObservacao'];
                                                        $user = $rowAvaliacao['avUserObs'];
                                                        $data = $rowAvaliacao['avData'];
                                                        $hora = $rowAvaliacao['avHora'];
                                                ?>
                                                        <div class="row d-flex p-4 m-2 w-100 py-4 rounded" style="background-color: #f0f1f3;">
                                                            <div class="col col-sm col-xs d-flex justify-content-start align-items-center">
                                                                <div>
                                                                    <span class="px-2 badge rounded-pill bg-<?php echo $color; ?>"><?php echo $statusav; ?></span>

                                                                    <h4 class="forum-link py-2 text-black"><?php echo $obs; ?></h4>

                                                                    <p>comentário de <b><?php echo $user; ?></b></p>
                                                                    <p><small><?php echo dateFormat2($data); ?> às <?php echo hourFormat2($hora); ?> </small></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                } else {

                                                    ?>
                                                    <div class="col d-flex justify-content-center text-center">
                                                        <h5 class="px-2 alert rounded-pill text-dark">Nenhum comentário adicionado</h5>

                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-3">

                                    <div class="card shadow h-100">
                                        <div class="card-header" style="background-color: #ee7624;">
                                            <h5 class="text-white">Avaliação Doutor(a)</h5>
                                        </div>
                                        <div class="card-body d-flex">
                                            <div class="container-fluid">
                                                <?php
                                                $retAvaliacao = mysqli_query($conn, "SELECT * FROM aceite WHERE aceiteNumPed= '" . $numeroCaso . "';");

                                                if (($retAvaliacao) && ($retAvaliacao->num_rows != 0)) {
                                                    while ($rowAvaliacao = mysqli_fetch_array($retAvaliacao)) {

                                                        //avId avNumPed avStatus avObservacao avUserObs avData avHora

                                                        // $statusav = $rowAvaliacao['aceiteStatus'];
                                                        $statusav = "Obs do Formulário";
                                                        $obs = $rowAvaliacao['aceiteObs'];
                                                ?>
                                                        <div class="row d-flex m-2 w-100 rounded p-4" style="background-color: #f0f1f3;">
                                                            <div class="col col-sm col-xs d-flex justify-content-start align-items-center">
                                                                <div>
                                                                    <span class="px-2 badge rounded-pill bg-secondary text-white"><?php echo $statusav; ?></span>

                                                                    <h4 class="forum-link py-2 text-black"><?php echo $obs; ?></h4>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                } else {

                                                    ?>
                                                    <div class="col d-flex justify-content-center text-center">
                                                        <h5 class="px-2 alert rounded-pill text-dark">Nenhum comentário adicionado</h5>

                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="card shadow h-100">
                                        <div class="card-header">
                                            <h5 class="text-muted">Liberar Abas</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="container-fluid d-flex">
                                                <div class="row d-flex" style="width: 100%;">
                                                    <div class="col-6 d-flex">
                                                        <form class="form-horizontal style-form" name="form1" action="includes/liberarabas.inc.php" method="post">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="casoId">Caso ID</label>
                                                                    <input type="number" class="form-control" id="casoId" name="casoId" value="<?php echo $row['pedId']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="ped">Num Ped</label>
                                                                    <input type="number" class="form-control" id="ped" name="ped" value="<?php echo $row['pedNumPedido']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>

                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md p-2">
                                                                    <label class="text-black">Liberar Abas</label>
                                                                    <div class="row d-block rounded py-2">
                                                                        <div class="col d-block">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" id="documentos2" name="documentos2" value="liberado" <?php if ($row['pedAbaDocumentos'] == 'liberado') {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo '';
                                                                                                                                                                                        } ?> />
                                                                                <label class="form-check-label text-black" for="documentos2">Docs Anvisa</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col d-block">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" id="agenda2" name="agenda2" value="liberado" <?php if ($row['pedAbaAgenda'] == 'liberado') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo '';
                                                                                                                                                                                } ?> />
                                                                                <label class="form-check-label text-black" for="agenda2">Agendar Vídeo</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col d-block">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" id="aceite2" name="aceite2" value="liberado" <?php if ($row['pedAbaAceite'] == 'liberado') {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo '';
                                                                                                                                                                                } ?> />
                                                                                <label class="form-check-label text-black" for="aceite2">Aceite Projeto</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col d-block">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" id="relatorio2" name="relatorio2" value="liberado" <?php if ($row['pedAbaRelatorio'] == 'liberado') {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo '';
                                                                                                                                                                                    } ?> />
                                                                                <label class="form-check-label text-black" for="relatorio2">Relatórios</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col d-block">
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" id="visualizacao2" name="visualizacao2" value="liberado" <?php if ($row['pedAbaVisualizacao'] == 'liberado') {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo '';
                                                                                                                                                                                            } ?> />
                                                                                <label class="form-check-label text-black" for="visualizacao2">Visualização Projeto</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md p-2">
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="submit" name="liberaraba" id="liberaraba" class="btn btn-primary">Salvar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="py-4 col d-flex justify-content-center">
                                                                <img src="assets/img/loading.gif" alt="Carregando" style="width: 30px;" id="loading2" hidden>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-4 d-flex justify-content-center">
                                                        <div class="">
                                                            <a href="op?id=<?php echo hashItemNatural($idPed); ?>" target="_blank" style="text-decoration: none;"><span class="btn btn-outline-conecta"> Abrir OP </span></a>
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

                </div>

            </div>
            <script>
                $('#mudarstatus').click(function() {

                    document.getElementById("mudarstatus").hidden = true;
                    document.getElementById("loading").hidden = false;
                });
                
                $('#liberaraba').click(function() {

                    document.getElementById("liberaraba").hidden = true;
                    document.getElementById("loading2").hidden = false;
                });
            </script>
            </div>
        <?php } ?>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>