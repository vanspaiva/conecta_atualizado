<?php

session_start();
if (!empty($_GET)) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Qualidade'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';
?>

        <body class="bg-light-gray2">
            <style>
                .smallOnHover {
                    transition: ease-in-out 0.2s;
                }

                .smallOnHover:hover {
                    transform: scale(0.9);
                }
            </style>
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $id = addslashes($_GET['id']);

            $ret = mysqli_query($conn, "SELECT * FROM qualificacaocliente WHERE qualiId='" . $id . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $id = $row["qualiId"];
                $dtchegada = $row["qualiDtChegada"];
                $usuario = $row["qualiUsuario"];
                $status = $row["qualiStatus"];
                $resultado = $row["qualiResultado"];
                $razaosocial = $row["qualiRazaoSocial"];
                $preenchidopor = $row["qualiPreenchidoPor"];
                $funcao = $row["qualiFuncao"];
                $uf = $row["qualiUF"];
                $cnpj = $row["qualiCNPJ"];
                $idform = $row["qualiIDForm"];
                $dtpreenchimento = $row["qualiDtPreenchimento"];
                $msg = $row["qualiMsg"];
            ?>

                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center py-4">
                            <div class="col-10 justify-content-start">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3">
                                            <h2 class="text-conecta" style="font-weight: 400;">Qualificação de <span style="font-weight: 700;"> Cliente nº <?php echo $id ?> </span></h2>
                                        </div>

                                    </div>
                                </div>
                                <hr style="border-color: #ee7624;">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center py-4">
                            <div class="col-10 justify-content-start">
                                <div class="container-fluid">
                                    <div class="row pb-4">
                                        <div class="col">
                                            <div class="card shadow">
                                                <div class="card-header">
                                                    <h4 style="color: silver; text-align: center;">Qualificar</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="content-panel">
                                                                    <form class="form-horizontal style-form" action="includes/verificaqualificacao.inc.php" method="post" enctype="multipart/form-data">
                                                                        <div class="form-row" hidden>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="id">Prop ID</label>
                                                                                <input type="number" class="form-control" id="id" name="id" value="<?php echo $id; ?>" required readonly>
                                                                                <small class="text-muted">ID não é editável</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="comentario"><b>Comentário</b></label>
                                                                                <input type="text" class="form-control" id="comentario" name="comentario" value="<?php echo $msg; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-3">
                                                                                <label class="form-label text-black" for="status"><b>Status</b></label>
                                                                                <select name="status" class="form-control" id="status">
                                                                                    <?php
                                                                                    $retStatus = mysqli_query($conn, "SELECT * FROM statusqualificacao ORDER BY stquaIndiceFluxo ASC;");
                                                                                    while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowStatus['stquaNome']; ?>" <?php if ($status == $rowStatus['stquaNome']) echo ' selected="selected"'; ?>> <?php echo $rowStatus['stquaNome']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card shadow h-100">
                                                <div class="card-header">
                                                    <h4 style="color: silver; text-align: center;">Dados Cliente</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="content-panel">
                                                                    <?php  //Get all users info  
                                                                    $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $usuario . "';");
                                                                    while ($rowUser = mysqli_fetch_array($retUser)) {
                                                                        $userNome = $rowUser["usersName"];
                                                                        $userEmail = $rowUser["usersEmail"];
                                                                        // $userPermissao = $rowUser["usersPerm"];
                                                                        $userPermissao = getPermission($conn, $rowUser);
                                                                        $userTelefone = $rowUser["usersFone"];
                                                                        $userUf = $rowUser["usersUf"];
                                                                        $userEmpresa = $rowUser["usersEmpr"];
                                                                        $userCNPJ = $rowUser["usersCnpj"];
                                                                        $userEmailEmpresa = $rowUser["usersEmailEmpresa"];
                                                                    }
                                                                    ?>
                                                                    <div class="row px-3 d-flex justify-content-center">
                                                                        <div class="col-md">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomedr">Usuário</h6>
                                                                                    <p><?php echo $usuario; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomepac">Nome</h6>
                                                                                    <p><?php echo $userNome; ?></p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="emailenvio">Contato</h6>
                                                                                    <p><?php echo $userEmail; ?></p>
                                                                                    <p><?php echo $userTelefone; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="representante">Permissão</h6>
                                                                                    <p><?php echo $userPermissao; ?></p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="emailenvio">Empresa</h6>
                                                                                    <p><?php echo $userEmpresa; ?></p>
                                                                                    <p><?php echo $userCNPJ; ?></p>
                                                                                    <p><?php echo $userUf; ?></p>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="representante">Contato Empresa</h6>
                                                                                    <p><?php echo $userEmailEmpresa; ?></p>
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

                                        <div class="col-4">
                                            <div class="card shadow h-100">
                                                <div class="card-header">
                                                    <h4 style="color: silver; text-align: center;">Dados Preenchidos</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="content-panel">
                                                                    <?php  //Get all form info  
                                                                    // $razaosocial;
                                                                    // $preenchidopor;
                                                                    // $funcao;
                                                                    // $uf;
                                                                    // $cnpj;
                                                                    // $idform;
                                                                    // $dtpreenchimento;
                                                                    ?>
                                                                    <div class="row px-3 d-flex justify-content-center">
                                                                        <div class="col-md">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomedr">Razão Social</h6>
                                                                                    <?php
                                                                                    if (empty($razaosocial)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $razaosocial; ?></p>
                                                                                    <?php
                                                                                    }
                                                                                    ?>

                                                                                    <?php
                                                                                    if (empty($cnpj)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $cnpj; ?></p>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomepac">Preenchido Por</h6>
                                                                                    <?php
                                                                                    if (empty($preenchidopor)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $preenchidopor; ?></p>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="emailenvio">Função</h6>
                                                                                    <?php
                                                                                    if (empty($funcao)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $funcao; ?></p>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="representante">UF</h6>
                                                                                    <?php
                                                                                    if (empty($uf)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $uf; ?></p>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="emailenvio">Data Preenchimento</h6>
                                                                                    <?php
                                                                                    if (empty($dtpreenchimento)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $dtpreenchimento; ?></p>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="representante">ID Form</h6>
                                                                                    <?php
                                                                                    if (empty($idform)) {
                                                                                    ?>
                                                                                        <p style="font-style: italic; color: silver;">vazio</p>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <p><?php echo $idform; ?></p>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="card shadow h-100">
                                                <div class="card-header">
                                                    <h4 style="color: silver; text-align: center;">Outros</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="content-panel">
                                                                    <?php  //Get all propostas, preenchimentos e envios  
                                                                    $qtdPropostas = 0;
                                                                    $arrayPropostas = array();
                                                                    $retProp = mysqli_query($conn, "SELECT * FROM propostas WHERE propUserCriacao='" . $usuario . "';");
                                                                    while ($rowProp = mysqli_fetch_array($retProp)) {
                                                                        array_push($arrayPropostas, $rowProp["propId"]);
                                                                        $qtdPropostas++;
                                                                    }

                                                                    $arrayProduto = array();
                                                                    $retProduto = mysqli_query($conn, "SELECT DISTINCT propTipoProd FROM propostas WHERE propUserCriacao='" . $usuario . "';");
                                                                    while ($rowProduto = mysqli_fetch_array($retProduto)) {
                                                                        array_push($arrayProduto, $rowProduto["propTipoProd"]);
                                                                    }

                                                                    $qtdRegistroEnvio = 0;
                                                                    $arrayRegistroEnvio = array();
                                                                    $retRegistroEnvio = mysqli_query($conn, "SELECT * FROM registroenvioqualificacao WHERE regEnvUsuario='" . $usuario . "';");
                                                                    while ($rowRegistroEnvio = mysqli_fetch_array($retRegistroEnvio)) {
                                                                        array_push($arrayRegistroEnvio, $rowRegistroEnvio["regEnvData"]);
                                                                        $qtdRegistroEnvio++;
                                                                    }

                                                                    $qtdRegistroPreenchimento = 0;
                                                                    $arrayRegistroPreenchimento = array();
                                                                    $retRegistroPreenchimento = mysqli_query($conn, "SELECT * FROM registropreenchimentoqualificacao WHERE regPreUsuario='" . $usuario . "';");
                                                                    while ($rowRegistroPreenchimento = mysqli_fetch_array($retRegistroPreenchimento)) {
                                                                        array_push($arrayRegistroPreenchimento, $rowRegistroPreenchimento["regPreId"]);
                                                                        $qtdRegistroPreenchimento++;
                                                                    }
                                                                    ?>
                                                                    <div class="row px-3 d-flex justify-content-center">
                                                                        <div class="col-md">
                                                                            <h4 class="text-primary py-2"><i class="fas fa-file-invoice-dollar"></i> <b>Propostas</b></h4>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomedr">Propostas</h6>
                                                                                    <?php
                                                                                    foreach ($arrayPropostas as &$valor) {
                                                                                    ?>
                                                                                        <span class="badge px-2 py-1 mx-1" style="background-color: #ee7624; color: white;"><?php echo $valor; ?></span>
                                                                                    <?php
                                                                                    }
                                                                                    ?>

                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomepac">Qtd Propostas</h6>
                                                                                    <span class="badge badge-secondary px-2 py-1 mx-1"><?php echo $qtdPropostas; ?></span>
                                                                                </div>
                                                                                <div class="form-group col-md-12">
                                                                                    <h6 class="form-label text-black" for="nomepac">Produtos</h6>
                                                                                    <?php
                                                                                    foreach ($arrayProduto as &$valor) {
                                                                                    ?>
                                                                                        <span class="badge px-2 py-1 mx-1" style="background-color: #ee7624; color: white;"><?php echo $valor; ?></span>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                            <h4 class="text-info py-2"><i class="bi bi-flag"></i> <b>Preenchimentos</b></h4>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomedr">Preenchimentos</h6>
                                                                                    <?php
                                                                                    foreach ($arrayRegistroPreenchimento as &$valor) {
                                                                                    ?>
                                                                                        <span class="badge badge-info px-2 py-1 mx-1"><?php echo $valor; ?></span>
                                                                                    <?php
                                                                                    }
                                                                                    ?>

                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomepac">Qtd Preenchimentos</h6>
                                                                                    <span class="badge badge-secondary px-2 py-1 mx-1"><?php echo $qtdRegistroPreenchimento; ?></span>
                                                                                </div>
                                                                            </div>

                                                                            <h4 class="text-success py-2"><i class="fas fa-paper-plane"></i> <b>Envios</b></h4>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomedr">Envios</h6>
                                                                                    <?php
                                                                                    foreach ($arrayRegistroEnvio as &$valor) {
                                                                                    ?>
                                                                                        <span class="badge badge-success px-2 py-1 mx-1"><?php echo $valor; ?></span>
                                                                                    <?php
                                                                                    }
                                                                                    ?>

                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <h6 class="form-label text-black" for="nomepac">Qtd Envios</h6>
                                                                                    <span class="badge badge-secondary px-2 py-1 mx-1"><?php echo $qtdRegistroEnvio; ?></span>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


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