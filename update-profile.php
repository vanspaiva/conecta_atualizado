<?php
session_start();
if (!empty($_GET)) {
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial')) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

        $id = addslashes($_GET['id']);
?>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersId='" . $id . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $userPerm = $row['usersPerm'];
                $tipoUsuario1 = '';
                $tipoUsuario2 = '';

                $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $userPerm . "';");
                while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
                    $tipoUsuario1 = $rowPerm1['tpcadexNome'];
                }

                $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $userPerm . "';");
                while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
                    $tipoUsuario2 = $rowPerm2['tpcadinNome'];
                }

                $tipoUsuario = $tipoUsuario1 . $tipoUsuario2;

            ?>



                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">
                    <div>
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "stmfailed") {
                                echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center py-4">
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2">
                                        <div class="row px-3">
                                            <h2 class="text-conecta" style="font-weight: 400;">Informações do <span style="font-weight: 700;">Usuário - <?php echo $tipoUsuario ?></span></h2>
                                            <p class="text-muted">Edite as informações do usuário</p>
                                        </div>
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
                                                            <form class="form-horizontal style-form" name="form1" action="includes/updateuser.inc.php" method="post">

                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="usersid">User ID</label>
                                                                        <input type="number" class="form-control" id="usersid" name="usersid" value="<?php echo $row['usersId']; ?>" required readonly>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="nome">Nome Completo</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['usersName']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="uf">UF</label>
                                                                        <select name="uf" class="form-control" id="uf">
                                                                            <?php
                                                                            $retUf = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                                            while ($rowUf = mysqli_fetch_array($retUf)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowUf['ufAbreviacao']; ?>" <?php if ($row['usersUf'] == $rowUf['ufAbreviacao']) echo ' selected="selected"'; ?>><?php echo $rowUf['ufAbreviacao']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="email">E-mail</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['usersEmail']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="uid">Usuário</label>
                                                                        <input type="text" class="form-control" id="uid" name="uid" value="<?php echo $row['usersUid']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="celular">Celular</label>
                                                                        <input type="tel" class="form-control" id="celular" name="celular" value="<?php echo $row['usersCel']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="telefone">Telefone</label>
                                                                        <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $row['usersFone']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="aprov">Aprovação</label>
                                                                        <select name="aprov" class="form-control" id="aprov">
                                                                            <option value="APROV" <?php if ($row['usersAprov'] == 'APROV') echo ' selected="selected"'; ?>>Aprovado</option>
                                                                            <option value="AGRDD" <?php if ($row['usersAprov'] == 'AGRDD') echo ' selected="selected"'; ?>>Aguardando</option>
                                                                            <option value="BLOQD" <?php if ($row['usersAprov'] == 'BLOQD') echo ' selected="selected"'; ?>>Bloqueado</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="form-label text-black" for="perm">Permissão</label>
                                                                        <select name="perm" class="form-control" id="perm">
                                                                            <?php
                                                                            $retPermIn = mysqli_query($conn, "SELECT * FROM tipocadastrointerno ORDER BY tpcadinNome ASC");
                                                                            while ($rowPermIn = mysqli_fetch_array($retPermIn)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowPermIn['tpcadinCodCadastro']; ?>" <?php if ($row['usersPerm'] == $rowPermIn['tpcadinCodCadastro']) echo ' selected="selected"'; ?>><?php echo $rowPermIn['tpcadinNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                            $retPermEx = mysqli_query($conn, "SELECT * FROM tipocadastroexterno ORDER BY tpcadexNome ASC");
                                                                            while ($rowPermEx = mysqli_fetch_array($retPermEx)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowPermEx['tpcadexCodCadastro']; ?>" <?php if ($row['usersPerm'] == $rowPermEx['tpcadexCodCadastro']) echo ' selected="selected"'; ?>><?php echo $rowPermEx['tpcadexNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <?php
                                                                if (($tipoUsuario == 'Distribuidor(a)') || ($tipoUsuario == 'Dist. Comercial')) {
                                                                ?>
                                                                    <div class='form-row'>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>E-mail Empresa </label>
                                                                            <input class='form-control' name='emailempresa' id='emailempresa' type='email' value="<?php echo $row['usersEmailEmpresa']; ?>" required>
                                                                        </div>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>CNPJ </label>
                                                                            <input class='form-control' name='cnpj' id='cnpj' type='text' value="<?php echo $row['usersCnpj']; ?>" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class='form-row'>
                                                                        <div class='form-group col-md'>
                                                                            <label class='form-label text-black'>Empresa </label>
                                                                            <input class='form-control' name='empresa' id='empresa' type='text' value="<?php echo  $row['usersEmpr']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                } else if ($tipoUsuario == 'Doutor(a)') {
                                                                ?>
                                                                    <div class='form-row'>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>Nº do Conselho</label>
                                                                            <input class='form-control' name='crm' id='crm' type='text' value="<?php echo $row['usersCrm']; ?>" required>
                                                                        </div>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>CPF </label>
                                                                            <input class='form-control' name='cpf' id='cpf' type='text' value="<?php echo $row['usersCpf']; ?>" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class='form-row'>
                                                                        <?php
                                                                        $userEspec = $row['usersEspec'];
                                                                        $retEspec = mysqli_query($conn, "SELECT * FROM especialidades WHERE especNome='$userEspec';");

                                                                        if (($retEspec) and ($retEspec->num_rows != 0)) { ?>
                                                                            <div class='form-group col-md'>
                                                                                <label class='form-label text-black'>Especialidade</label>
                                                                                <select name='especialidade' class='form-control' id='especialidade'>
                                                                                    <?php

                                                                                    $retEspec = mysqli_query($conn, "SELECT * FROM especialidades ORDER BY especNome ASC");
                                                                                    while ($rowEspec = mysqli_fetch_array($retEspec)) {

                                                                                    ?>
                                                                                        <option value="<?php echo $rowEspec['especNome']; ?>" <?php if ($row['usersEspec'] == $rowEspec['especNome']) echo ' selected="selected"'; ?>><?php echo $rowEspec['especNome']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <div class='form-group col-md'>
                                                                                <label class='form-label text-black'>Outra Especialidade </label>
                                                                                <input class='form-control' name='especialidade' id='especialidade' type='text' value="<?php echo $row['usersEspec']; ?>" required>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } else if ($tipoUsuario == 'Paciente') { ?>

                                                                    <div class='form-row'>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>Nome Dr(a) Responsável </label>
                                                                            <input class='form-control' name='nmdrresp' id='nmdrresp' type='text' value="<?php echo $row['usersNmResp']; ?>" required>
                                                                        </div>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>CPF </label>
                                                                            <input class='form-control' name='cpf' id='cpf' type='text' value="<?php echo $row['usersCpf']; ?>" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class='form-row'>
                                                                        <div class='form-group col-md'>
                                                                            <label class='form-label text-black'>Uf Dr(a)</label>
                                                                            <select name='ufdr' class='form-control' id='ufdr'>
                                                                                <?php
                                                                                $retUfDr = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                                                while ($rowUfDr = mysqli_fetch_array($retUfDr)) {
                                                                                ?>
                                                                                    <option value="<?php echo $rowUfDr['ufAbreviacao']; ?>" <?php if ($row['usersUf'] == $rowUfDr['ufAbreviacao']) echo ' selected="selected"'; ?>><?php echo $rowUfDr['ufAbreviacao']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                <?php } else if ($tipoUsuario == 'Internacional') { ?>

                                                                    <div class='form-row'>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>Empresa </label>
                                                                            <input class='form-control' name='empresa' id='empresa' type='text' value="<?php echo $row['usersEmpr']; ?>" required>
                                                                        </div>
                                                                        <div class='form-group col-md-6'>
                                                                            <label class='form-label text-black'>País/Cidade </label>
                                                                            <input class='form-control' name='paiscidade' id='paiscidade' type='text' value="<?php echo $row['usersPaisCidade']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer"></div>
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
} else {
    header("location: index");
    exit();
}


        ?>