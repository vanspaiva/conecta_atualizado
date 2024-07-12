<?php

session_start();
if (isset($_GET["id"])) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Qualidade'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

        $id = addslashes($_GET['id']);
?>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';
            ?>

            <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
            <script src="https://cdn.tiny.cloud/1/zjf2h1vx7aqnqpv1gai59eeqiqb64jvhdg2tfv34o6i9i7lm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: 'textarea',
                    plugin: 'a_tinymce_plugin',
                    a_plugin_option: true,
                    a_configuration_option: 400,
                    content_style: "body { color: black; }"
                });
            </script>

            <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
            <div id="main" class="font-montserrat">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmtfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="row row-3">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 justify-content-start" id="titulo-pag">
                            <div class="d-flex">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back text-conecta p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2 row-padding-2">
                                    <div class="row px-3">
                                        <h2 class="text-conecta">Informações do Produto</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- <h2>Informações do Produto</h2> -->
                            <br>
                            <div class="card">

                                <div class="card-body">
                                    <?php

                                    $ret = mysqli_query($conn, "SELECT * FROM produtos WHERE prodId='" . $id . "';");
                                    while ($row = mysqli_fetch_array($ret)) {
                                        if ($row['prodImposto'] != null) {
                                            $temImposto = true;
                                            $valorImposto = $row['prodImposto'];
                                        } else {
                                            $temImposto = false;
                                            $valorImposto = '';
                                        }
                                    ?>
                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="content-panel">

                                                            <p class="alert-warning"></p>

                                                            <form class="prodForm" action="includes/produtos.inc.php" method="post">
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="prodid">Prod ID</label>
                                                                        <input type="text" class="form-control" id="prodid" name="prodid" value="<?php echo $row['prodId']; ?>" required readonly>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="categoria">Categoria</label>
                                                                        <!-- <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $row['prodCategoria']; ?>" required readonly> -->
                                                                        <select class="form-control" id="categoria" name="categoria" required>
                                                                            <option value="">Selecione categoria</option>
                                                                            <option value="CMF" <?php if ($row['prodCategoria'] == "CMF") echo ' selected="selected"'; ?>>CMF</option>
                                                                            <option value="CRÂNIO" <?php if ($row['prodCategoria'] == "CRÂNIO") echo ' selected="selected"'; ?>>CRÂNIO</option>
                                                                            <option value="BIOMODELO" <?php if ($row['prodCategoria'] == "BIOMODELO") echo ' selected="selected"'; ?>>BIOMODELO</option>
                                                                            <option value="COLUNA" <?php if ($row['prodCategoria'] == "COLUNA") echo ' selected="selected"'; ?>>COLUNA</option>
                                                                            <option value="ATA" <?php if ($row['prodCategoria'] == "ATA") echo ' selected="selected"'; ?>>ATA</option>
                                                                            <option value="EXTRA" <?php if ($row['prodCategoria'] == "EXTRA") echo ' selected="selected"'; ?>>EXTRA</option>
                                                                        </select>
                                                                        <small class="text-muted">Categoria não é editável</small>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="cdg">Callisto</label>
                                                                        <input type="text" class="form-control" id="cdg" name="cdg" value="<?php echo $row['prodCodCallisto']; ?>" required <?php if (($_SESSION["userperm"] == 'Administrador') && ($_SESSION["userperm"] == 'Comercial')) {
                                                                                                                                                                                                echo ' readonly ';
                                                                                                                                                                                            } ?>>
                                                                        <small class="text-muted">Código cadastrado no Callisto</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="descricao">Descrição</label>
                                                                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $row['prodDescricao']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="descricaoAnvisa">Descrição Anvisa</label>
                                                                        <input type="text" class="form-control" id="descricaoAnvisa" name="descricaoAnvisa" value="<?php echo $row['prodDescricaoAnvisa']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <!--<div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="parafusos">Parafusos</label>
                                                                    <input type="number" class="form-control" id="parafusos" name="parafusos" value="<?php echo $row['prodParafuso']; ?>">
                                                                </div>-->
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="anvisa">Anvisa</label>
                                                                        <input type="text" class="form-control" id="anvisa" name="anvisa" value="<?php echo $row['prodAnvisa']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="preco">Preço</label>
                                                                        <input type="number" class="form-control" id="preco" name="preco" value="<?php echo $row['prodPreco']; ?>" <?php if (($_SESSION["userperm"] != 'Administrador') && ($_SESSION["userperm"] != 'Comercial')) {
                                                                                                                                                                                        echo ' readonly ';
                                                                                                                                                                                    } ?> required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="codPropPadrao">Código Prop</label>
                                                                        <input type="text" class="form-control" id="codPropPadrao" name="codPropPadrao" value="<?php echo $row['prodCodPropPadrao']; ?>" <?php if (($_SESSION["userperm"] != 'Administrador') && ($_SESSION["userperm"] != 'Comercial')) {
                                                                                                                                                                                                                echo ' readonly ';
                                                                                                                                                                                                            } ?>>
                                                                        <small class="text-muted">Código da proposta padrão no Callisto</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black">Tem Imposto?</label>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="radioImposto" id="temimposto" value="sim" onclick="showImposto(this)" <?php if ($temImposto) {
                                                                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                                                                        } ?> <?php if (($_SESSION["userperm"] != 'Administrador') && ($_SESSION["userperm"] != 'Comercial')) {
                                                                                                                                                                                                                    echo ' disabled ';
                                                                                                                                                                                                                } ?>>
                                                                            <label class="form-check-label  text-black" for="temimposto">sim</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="radioImposto" id="ntemimposto" value="não" onclick="showImposto(this)" <?php if (!$temImposto) {
                                                                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                                                                        } ?> <?php if (($_SESSION["userperm"] != 'Administrador') && ($_SESSION["userperm"] != 'Comercial')) {
                                                                                                                                                                                                                    echo ' disabled ';
                                                                                                                                                                                                                } ?>>
                                                                            <label class="form-check-label  text-black" for="ntemimposto">não</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md" id="hiddenImposto" <?php if (!$temImposto) {
                                                                                                                            echo 'hidden';
                                                                                                                        } ?>>
                                                                        <label for="imposto" class="text-black">Imposto</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="number" class="form-control" id="imposto" name="imposto" aria-describedby="porc" value="<?php if ($temImposto) {
                                                                                                                                                                                        echo $valorImposto;
                                                                                                                                                                                    } ?>" <?php if (($_SESSION["userperm"] != 'Administrador') && ($_SESSION["userperm"] != 'Comercial')) {
                                                                                                                                                                                                echo ' readonly ';
                                                                                                                                                                                            } ?>>
                                                                            <span class="input-group-text" id="porc">%</span>
                                                                        </div>
                                                                        <small>Valor em porcentagem</small>
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    function showImposto(elem) {
                                                                        elem = elem.value;

                                                                        if (elem == "sim") {
                                                                            document.getElementById("hiddenImposto").hidden = false;
                                                                        }

                                                                        if (elem == "não") {
                                                                            document.getElementById("hiddenImposto").hidden = true;
                                                                        }

                                                                    }
                                                                </script>
                                                                <hr>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="kitdr">Observação</label>
                                                                        <textarea class="form-control" name="kitdr" id="kitdr" rows="3"><?php echo $row['prodKitDr']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="txtOP">OP/Anvisa</label>
                                                                        <textarea class="form-control" name="txtOP" id="txtOP" rows="3"><?php echo $row['prodTxtOp']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="txtAcompanha">Proposta Acompanha</label>
                                                                        <textarea class="form-control" name="txtAcompanha" id="txtAcompanha" rows="3"><?php echo $row['prodTxtAcompanha']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php }

                                        ?>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                        <div class="col-sm-3"></div>

                    </div>

                </div>
            </div>

            <?php include_once 'php/footer_index.php' ?>

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