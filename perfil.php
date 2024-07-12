<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'includes/dbh.inc.php';

    $user = $_SESSION["useruid"];
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <?php include_once 'php/back.php';
                        define_button_color('orange'); ?>
                    </div>
                    <div class="col-sm-10">
                        <h2 class="text-conecta" style="font-weight: 400;">Meu <span style="font-weight: 700;">Perfil</span></h2>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="card shadow">

                            <div class="card-body">
                                <?php

                                $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $user . "';");
                                while ($row = mysqli_fetch_array($ret)) {
                                    $userName = $row['usersName'];
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
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="content-panel">
                                                        <div class="nav">
                                                            <div class="col-sm-7 p-4" id="coluna-info">
                                                                <div>
                                                                    <?php
                                                                    if (isset($_GET["error"])) {
                                                                        if ($_GET["error"] == "emptyerror") {
                                                                            echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Todos os campos são obrigatórios!</p></div>";
                                                                        } else if ($_GET["error"] == "stmtfailed") {
                                                                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                        } else if ($_GET["error"] == "edit") {
                                                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Informações do usuário foram alteradas com sucesso!</p></div>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <h5 style="color: #ee7624;" class="text-align-center">Informações do Usuário</h5>
                                                                <p class="text-align-center text-small p-0 m-0">Utilize os campos abaixo para editar seus dados. </p>
                                                                <p class="text-align-center text-small p-0 m-0">Ao finalizar o preenchimento certifique-se de salvar!</p>
                                                                <br>

                                                                <form class="form-horizontal style-form mt-4 p-4" name="form1" action="includes/updateuserUser.inc.php" method="post">
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
                                                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['usersEmail']; ?>" required readonly>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label text-black" for="uid">Usuário</label>
                                                                            <input type="text" class="form-control" id="uid" name="uid" value="<?php echo $row['usersUid']; ?>" required readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label text-black" for="celular">Celular</label>
                                                                            <input type="tel" class="form-control" id="celular" name="celular" value="<?php echo $row['usersCel']; ?>" placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label text-black" for="telefone">Telefone</label>
                                                                            <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $row['usersFone']; ?>" placeholder='(xx) xxxx-xxxx' maxlength='14' onkeyup='maskTelefone()' required>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                    <?php
                                                                    if ($tipoUsuario == 'Dist. Comercial') {
                                                                        $cnpjDistComercial = $row['usersCnpj'];
                                                                        $retDistCom = mysqli_query($conn, "SELECT * FROM users WHERE usersCnpj = '$cnpjDistComercial' AND usersPerm = '4DTB'");
                                                                        while ($rowDistCom = mysqli_fetch_array($retDistCom)) {
                                                                            $nomeEmpresa = $rowDistCom["usersUid"];
                                                                    ?>
                                                                            <div class='form-row py-2'>
                                                                                <div class='form-group col-md'>
                                                                                    <label class='text-muted form-label text-black'>Usuário ADM:</label>
                                                                                    <span class='text-white px-2 btn btn-conecta'><b><?php echo $nomeEmpresa; ?></b></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class='form-row'>
                                                                                <div class='form-group col-md-6'>
                                                                                    <label class='form-label text-black'>E-mail Empresa </label>
                                                                                    <input class='form-control' name='emailempresa' id='emailempresa' type='email' value="<?php echo $row['usersEmailEmpresa']; ?>" required readonly>
                                                                                </div>
                                                                                <div class='form-group col-md-6'>
                                                                                    <label class='form-label text-black'>CNPJ </label>
                                                                                    <input class='form-control' name='cnpj' id='cnpj' type='text' value="<?php echo $row['usersCnpj']; ?>" required readonly>
                                                                                </div>
                                                                            </div>

                                                                            <div class='form-row'>
                                                                                <div class='form-group col-md'>
                                                                                    <label class='form-label text-black'>Empresa </label>
                                                                                    <input class='form-control' name='empresa' id='empresa' type='text' value="<?php echo  $row['usersEmpr']; ?>" required readonly>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($tipoUsuario == 'Distribuidor(a)') {

                                                                    ?>
                                                                        <div class='form-row py-2'>
                                                                            <div class='form-group col-md'>
                                                                                <span class='text-conecta'><b> Usuário ADM</b></span>
                                                                            </div>
                                                                        </div>

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
                                                                    }

                                                                    ?>

                                                                    <?php

                                                                    if ($tipoUsuario == 'Doutor(a)') {
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
                                                                    <?php }
                                                                    if ($tipoUsuario == 'Paciente') { ?>

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
                                                                    <?php }
                                                                    if ($tipoUsuario == 'Internacional') { ?>
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
                                                                    if ($tipoUsuario == 'Representante') {
                                                                    ?>
                                                                        <div class='form-row'>
                                                                            <div class='form-group col-md'>
                                                                                <label class='form-label text-black text-muted'>Responsável Pelos Estados</label>

                                                                                <div class='d-block p-1'>
                                                                                    <?php
                                                                                    $sessionUser = $_SESSION["useruid"];
                                                                                    $retUF = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='$sessionUser';");
                                                                                    while ($rowUF = mysqli_fetch_array($retUF)) {
                                                                                        if ($rowUF['repUF'] != null) {
                                                                                    ?>
                                                                                            <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowUF['repUF']; ?></span>
                                                                                    <?php
                                                                                        }
                                                                                    }

                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="submit" name="update" class="btn btn-primary">Atualizar Dados</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div class="col-sm-5 justify-content-center p-4" id="coluna-senha">
                                                                <div>
                                                                    <?php
                                                                    if (isset($_GET["error"])) {
                                                                        if ($_GET["error"] == "pwderror") {
                                                                            echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Senhas não são iguais!</p></div>";
                                                                        } else if ($_GET["error"] == "stmtfailed") {
                                                                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                        } else if ($_GET["error"] == "none") {
                                                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Senha alterada com sucesso!</p></div>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <h5 style="color: #ee7624;" class="text-align-center">Redefinir Senha</h5>
                                                                <p class="text-align-center text-small p-0 m-0">Utilize os campos abaixo para redefinir sua senha. </p>
                                                                <p class="text-align-center text-small p-0 m-0">Ao finalizar o preenchimento certifique-se de salvar!</p>
                                                                <br>
                                                                <br>
                                                                <form class="form p-4" name="form1" method="post" action="includes/updatePwd.inc.php">
                                                                    <div class="form-row">
                                                                        <div class="form-group flex-fill" hidden>
                                                                            <label class="form-label" style="color:black;">Usuário</label>
                                                                            <input type="text" class="form-control" name="user" value="<?php echo $row['usersUid']; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group flex-fill">
                                                                            <label class="form-label" style="color:black;">Nova Senha</label>
                                                                            <!-- <input type="password" class="form-control" name="pwd"> -->
                                                                            <div class="input-group mb-3">
                                                                                <input id="senha" class="form-control" name="pwd" type="password" aria-describedby="basic-addon2">
                                                                                <div class="input-group-append">
                                                                                    <button onclick="showPass('pwd')" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group flex-fill">
                                                                            <label class="form-label" style="color:black;">Confirme Senha</label>
                                                                            <!-- <input type="password" class="form-control" name="confirmpwd"> -->
                                                                            <div class="input-group mb-3">
                                                                                <input id="confirmeSenha" class="form-control" name="confirmpwd" type="password" aria-describedby="basic-addon2">
                                                                                <div class="input-group-append">
                                                                                    <button onclick="showPass('confirme')" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-row justify-content-center mt-3">
                                                                        <input type="submit" name="newpwd" value="Alterar Senha" class="btn btn-primary" style="margin-left: 30px;">
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>

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
                    <div class="col-sm-1"></div>

                </div>

            </div>
        </div>
        <script>
            function showPass(tipo) {
                event.preventDefault();

                if (tipo == 'pwd') {
                    var passInput = document.getElementById('senha');
                    if (passInput.type == 'password') {
                        passInput.type = 'text';
                    } else {
                        passInput.type = 'password';
                    }
                } else {
                    var passInput = document.getElementById('confirmeSenha');
                    if (passInput.type == 'password') {
                        passInput.type = 'text';
                    } else {
                        passInput.type = 'password';
                    }
                }



            }

            // function maskCel() {
            //     var cel = document.getElementById("celular");

            //     //(61) 9xxxx-xxxx
            //     //'(' nas posições -> 0
            //     //')' nas posições -> 3
            //     //' ' nas posições -> 4
            //     //'-' nas posições -> 10

            //     if (cel.value.length == 1) {
            //         cel.value = '(' + cel.value;
            //     }

            //     if (cel.value.length == 3) {
            //         cel.value += ') ';
            //     } else if (cel.value.length == 10) {
            //         cel.value += '-';
            //     }

            // }

            function maskTelefone() {
                var tel = document.getElementById("telefone");

                //(61) xxxx-xxxx
                //'(' nas posições -> 0
                //')' nas posições -> 3
                //' ' nas posições -> 4
                //'-' nas posições -> 10

                if (tel.value.length == 1) {
                    tel.value = '(' + tel.value;
                }

                if (tel.value.length == 3) {
                    tel.value += ') ';
                } else if (tel.value.length == 9) {
                    tel.value += '-';
                }

            }

            // function maskCNPJ() {
            //     var cnpj = document.getElementById("cnpj");

            //     //39.376.870/0001-03
            //     //'.' nas posições -> 2,6
            //     //'/' nas posições -> 10
            //     //'-' nas posições -> 15

            //     if (cnpj.value.length == 2 || cnpj.value.length == 6) {
            //         cnpj.value += '.';
            //     } else if (cnpj.value.length == 10) {
            //         cnpj.value += '/';
            //     } else if (cnpj.value.length == 15) {
            //         cnpj.value += '-';
            //     }

            // }

            // function maskCRM() {
            //     var crm = document.getElementById("crm");

            //     //CRX-UF-0000
            //     //'-' nas posições -> 3,6

            //     if (crm.value.length == 3 || crm.value.length == 6) {
            //         crm.value += '-';
            //     }

            // }
        </script>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>