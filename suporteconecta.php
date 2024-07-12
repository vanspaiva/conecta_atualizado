<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador')) || ($_SESSION["userperm"] == 'Qualidade') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática') || ($_SESSION["userperm"] == 'Representante') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Analista Dados')) {
    ob_start();
    include("php/head_index.php");

    require_once 'includes/dbh.inc.php';

    $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $nomeCompleto = $row['usersName'];
        $user = $row['usersUid'];
        $tipoConta = $_SESSION["userperm"];
    }
?>
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        ?>

        <style>
            .btn-sac {
                padding: 5px 10px;
                background-color: #f37a23;
                border: 1px solid #f37a23;
                border-radius: 20px;
                opacity: 1;
                font-size: 1.2rem;
                font-weight: bold;
                transition: ease-in-out 0.2s;
            }

            .btn-sac:hover {
                opacity: 0.8;
                cursor: pointer;
            }

            .text-center {
                text-align: center;
            }
        </style>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "noned") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Nova Dúvida enviada. Aguarde resposta!</p></div>";
                    } else if ($_GET["error"] == "nones") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Nova Sugestão enviada. Aguarde resposta!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">
                    <div class="col-sm-6 justify-content-start">
                        <div class="d-flex">
                            <div class="col-sm py-3">
                                <h2 class="text-conecta" style="font-weight: 400;">Dúvidas e Sugestões <span style="font-weight: 700;"> de Melhoria</span></h2>
                                <p class="text-muted">Bem vindo ao SAC Interno do Portal Conecta! Este é o canal disponível para sanar todas suas dúvidas e sugerir soluções que se adequem
                                    as suas necessidades. </p>
                            </div>
                        </div>
                        <hr style="border-color: #ee7624;">

                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <section id="main-content">
                                    <section class="wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-panel">
                                                    <div class="form-row">
                                                        <div class="form-group col-md d-flex justify-content-center">
                                                            <div class="form-check form-check-inline px-2">
                                                                <input class="form-check-input" type="radio" name="sacOp" id="duvida" value="duvida" onclick="handleClick(this);" hidden>
                                                                <label class="form-check-label btn-sac text-white" for="duvida"> <i class="bi bi-question-circle"></i> Dúvida </label>
                                                            </div>
                                                            <div class="form-check form-check-inline px-2">
                                                                <input class="form-check-input" type="radio" name="sacOp" id="melhoria" value="melhoria" onclick="handleClick(this);" hidden>
                                                                <label class="form-check-label  btn-sac text-white" for="melhoria"><i class="bi bi-award"></i> Melhoria </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form class="form-horizontal style-form" action="includes/sendduvida.inc.php" method="post">
                                                        <div id="form-duvida" class="form-row p-2 d-none">
                                                            <div class="w-100 p-3" style="border: 3px dashed silver;">
                                                                <h4 style="color: silver;">Dúvidas</h4>
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="user">User</label>
                                                                        <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="tipoConta">Tipo Conta</label>
                                                                        <input type="text" class="form-control" id="tipoConta" name="tipoConta" value="<?php echo $tipoConta; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="nome">Nome Completo</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nomeCompleto; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="setor">Setor</label>
                                                                        <select name="setor" class="form-control" id="setor" required>
                                                                            <option>Escolha uma opção</option>
                                                                            <?php
                                                                            $retSetor = mysqli_query($conn, "SELECT * FROM setores ORDER BY setNome ASC;");
                                                                            while ($rowSetor = mysqli_fetch_array($retSetor)) {
                                                                                echo "<option value='" . $rowSetor['setNome'] . "'>" . $rowSetor['setNome'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="assunto">Assunto Principal</label>
                                                                        <input type="text" class="form-control" id="assunto" name="assunto" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="textoduvida">Dúvida</label>
                                                                        <textarea class="form-control" name="textoduvida" id="textoduvida" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <hr>
                                                                    <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <form class="form-horizontal style-form" action="includes/sendmelhoria.inc.php" method="post">

                                                        <div id="form-melhorias" class="form-row p-2 d-none">
                                                            <div class="w-100 p-3" style="border: 3px dashed silver;">
                                                                <h4 style="color: silver;">Melhorias</h4>
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="user">User</label>
                                                                        <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="tipoConta">Tipo Conta</label>
                                                                        <input type="text" class="form-control" id="tipoConta" name="tipoConta" value="<?php echo $tipoConta; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="nome">Nome Completo</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nomeCompleto; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="setor">Setor</label>
                                                                        <select name="setor" class="form-control" id="setor" required>
                                                                            <option>Escolha uma opção</option>
                                                                            <?php
                                                                            $retSetor = mysqli_query($conn, "SELECT * FROM setores ORDER BY setNome ASC;");
                                                                            while ($rowSetor = mysqli_fetch_array($retSetor)) {
                                                                                echo "<option value='" . $rowSetor['setNome'] . "'>" . $rowSetor['setNome'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="assunto">Assunto Principal</label>
                                                                        <input type="text" class="form-control" id="assunto" name="assunto" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="textomelhoria">Sugestão de Melhoria</label>
                                                                        <textarea class="form-control" name="textomelhoria" id="textomelhoria" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <hr>
                                                                    <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <!-- <div class="d-flex justify-content-end" hidden>
                                                            <hr>
                                                            <button type="submit" name="new" class="btn btn-primary" hidden>Criar</button>
                                                        </div> -->


                                                    <script>
                                                        function handleClick(elem) {
                                                            elem = elem.value;
                                                            if (elem == 'duvida') {
                                                                document.getElementById("form-melhorias").classList.add("d-none");
                                                                document.getElementById("form-duvida").classList.remove("d-none");
                                                            } else if (elem == 'melhoria') {
                                                                document.getElementById("form-melhorias").classList.remove("d-none");
                                                                document.getElementById("form-duvida").classList.add("d-none");
                                                            } else {
                                                                document.getElementById("form-melhorias").classList.add("d-none");
                                                                document.getElementById("form-duvida").classList.add("d-none");
                                                            }

                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <a href="forumsuporte" class="text-black" style="text-align: center;">Voltar ao Fórum</a>
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