<?php
session_start();
if (!empty($_GET)) {
    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Comercial')) || ($_SESSION["userperm"] == 'Administrador'))) {
        ob_start();
        include("php/head_updateprop.php");
        require_once 'includes/dbh.inc.php';
?>

        <body class="bg-conecta">
            <?php
            include_once 'php/navbar.php';
            include_once 'php/lateral-nav.php';

            $ret = mysqli_query($conn, "SELECT * FROM propostas WHERE propId='" . $_GET['id'] . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $lista = $row['propListaItens'];
                $convenio = $row['propConvenio'];

                //Foto 1
                $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplana WHERE imgplanNumProp='" . $_GET['id'] . "';");

                if (($retPic) && ($retPic->num_rows != 0)) {
                    while ($rowPic = mysqli_fetch_array($retPic)) {
                        $temanexo = true;
                    }
                } else {
                    $temanexo = false;
                }

                //Foto 2
                $retPic2 = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $_GET['id'] . "';");

                if (($retPic2) && ($retPic2->num_rows != 0)) {
                    while ($rowPic2 = mysqli_fetch_array($retPic2)) {
                        $temanexo = true;
                    }
                } else {
                    $temanexo = false;
                }
            ?>

                <div id="main">
                    <div>
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "stmfailed") {
                                echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                            } else if ($_GET["error"] == "deleted") {
                                echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Item excluido da proposta!</p></div>";
                            }
                        }
                        ?>
                    </div>

                    <div class="container-fluid d-flex justify-content-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3" style="color: #fff">
                                            <h2>Informações da Proposta - <?php echo $_GET['id'] ?> </h2>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="d-flex">
                                    <div class="row">
                                        <div class="card col-md mr-1 my-1">
                                            <div class="card-body">
                                                <section id="main-content">
                                                    <section class="wrapper">
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="content-panel">
                                                                    <form class="form-horizontal style-form" id="formprop" name="formprop" method="POST">
                                                                        <!--<div class="form-horizontal style-form" id="formprop" name="formprop" >-->
                                                                        <!--<form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/updateprop.inc.php" method="POST">-->
                                                                        <div class="form-row" hidden>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="propid">Prop ID</label>
                                                                                <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                                                <small class="text-muted">ID não é editável</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="container-fluid pt-0 mt-0">
                                                                            <h6 style="color: silver;">Ações da Proposta</h6>
                                                                            <div class="row justify-content-around aling-items-center py-1">
                                                                                <div class="col-md d-flex justify-content-center mt-1">
                                                                                    <span class="btn-prop bg-pink bg-hover-sm w-100" data-toggle="modal" data-target="#trocaproprietario"><i class="fas fa-exchange-alt"></i> Trocar Proposta</span>
                                                                                </div>
                                                                                <div class="col-md d-flex justify-content-center mt-1">
                                                                                    <span class="btn-prop bg-purple bg-hover-sm w-100" data-toggle="modal" data-target="#trocadoutor"><i class="fas fa-user-md"></i> Definir Doutor</span>
                                                                                </div>
                                                                                <div class="col-md d-flex justify-content-center mt-1">
                                                                                    <a class="btn-prop bg-warning bg-hover-sm w-100" href="reanalisartc.php?id=<?php echo $row['propId']; ?>"><span><i class="fas fa-redo"></i> Reanalisar TC</span></a>
                                                                                </div>
                                                                                <div class="col-md d-flex justify-content-center mt-1">
                                                                                    <a class="btn-prop bg-success bg-hover-sm w-100" href="downloadjson.php?id=<?php echo $row['propId']; ?>"><span><i class="fas fa-file-download"></i> Baixar JSON</span></a>
                                                                                </div>
                                                                                <div class="col-md d-flex justify-content-center mt-1">
                                                                                    <a class="btn-prop bg-danger bg-hover-sm w-100" href="sendnotifrep.php?id=<?php echo $row['propId']; ?>"><span><i class="fas fa-exclamation-triangle"></i> Chamar Atenção</span></a>
                                                                                </div>
                                                                                <?php
                                                                                //if ($temanexo) {
                                                                                ?>
                                                                                <div class="col-md d-flex justify-content-center mt-1">
                                                                                    <span class="btn-prop bg-info bg-hover-sm w-100" data-toggle="modal" data-target="#veranexo"><i class="bi bi-eye"></i> Ver Anexo</span>
                                                                                </div>
                                                                                <?php
                                                                                //}
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="form-row p-2 mb-3 border" style="border-style: dashed !important; border-color: #e9ecef; border-width: 2px !important; border-radius: 8px">
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="empresa">Empresa</label>
                                                                                <input type="text" class="form-control" id="empresa" name="empresa" value="<?php echo $row['propEmpresa']; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="cnpj">CNPJ</label>
                                                                                <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?php echo $row['propCnpjCpf']; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="status">Status</label>
                                                                                <select name="status" class="form-control" id="status" onchange="watchStatus(this)">
                                                                                    <?php
                                                                                    $retStatus = mysqli_query($conn, "SELECT * FROM statuscomercial ORDER BY stcomIndiceFluxo ASC;");
                                                                                    while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowStatus['stcomNome']; ?>" <?php if ($row['propStatus'] == $rowStatus['stcomNome']) echo ' selected="selected"'; ?>> <?php echo $rowStatus['stcomNome']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md pedido" <?php if ($row['propPedido'] == null) echo 'hidden'; ?>>
                                                                                <label class="form-label text-black" for="status" <?php if ($row['propPedido'] == null) echo 'style="color: red; "'; ?>>Nº Pedido</label>
                                                                                <input type="text" class="form-control" id="pedido" name="pedido" value="<?php echo $row['propPedido']; ?>" <?php if ($row['propPedido'] != null) echo 'readonly'; ?>>
                                                                            </div>
                                                                            <div class="form-group col-md drrespuid" <?php if ($row['propPedido'] == null) echo 'hidden'; ?>>
                                                                                <label class="form-label text-black" for="status" <?php if ($row['propPedido'] == null) echo 'style="color: red; "'; ?>>Uid Dr(a)</label>
                                                                                <select name="drrespuid" class="form-control" id="drrespuid" <?php if ($row['propPedido'] != null) echo 'readonly'; ?>>
                                                                                    <option selected> Escolha um Dr(a)</option>
                                                                                    <?php
                                                                                    $retDrResp = mysqli_query($conn, "SELECT * FROM users WHERE usersPerm='3DTR' ORDER BY usersName ASC;");
                                                                                    while ($rowDrResp = mysqli_fetch_array($retDrResp)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowDrResp['usersUid']; ?>" <?php if ($row['propDrUid'] == $rowDrResp['usersUid']) echo ' selected="selected"'; ?>> <?php echo $rowDrResp['usersName']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="statustc">Status TC</label>
                                                                                <input type="text" class="form-control" id="statustc" name="statustc" value="<?php echo $row['propStatusTC']; ?>" readonly>
                                                                            </div>
                                                                            <div class="form-group col-md" hidden>
                                                                                <label class="form-label text-black" for="userCriador">User Criador</label>
                                                                                <input type="text" class="form-control" id="userCriador" name="userCriador" value="<?php echo $row['propUserCriacao']; ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--<div class="form-row p-2 mb-2 d-flex align-items-center" style="background-color: #f7f7f7; border-radius: 8px">
                                                                            <div class="col-md coment">
                                                                                <h6 class="form-label text-black" for="status">Comentário TC</h6>
                                                                                <span name="textReprov" id="textReprov"><?php echo $row['propTxtReprov']; ?></span>
                                                                            </div>
                                                                            <?php
                                                                            if ($temanexo) {
                                                                            ?>
                                                                                <div class="col-md-2">
                                                                                    <span class="btn btn-sm btn-conecta" data-toggle="modal" data-target="#veranexo"><i class="bi bi-eye"></i> Ver Anexo</span>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <div class="d-flex m-2 justify-content-around aling-items-center">
                                                                                <div class="col-md">
                                                                                    <span class="btn btn-sm btn-success" data-toggle="modal" data-target="#trocaproprietario"><i class="fas fa-exchange-alt"></i> Trocar Prop</span>
                                                                                </div>
                                                                                <div class="col-md">
                                                                                    <span class="btn btn-sm btn-warning" data-toggle="modal" data-target="#trocadoutor"><i class="fas fa-exchange-alt"></i> Definir Doutor</span>
                                                                                </div>
                                                                                <div class="col-md">
                                                                                    <a href="downloadjson.php?id=<?php echo $row['propId']; ?>"><span class="btn btn-sm text-success"><i class="fas fa-file-download"></i> </span></a>
                                                                                </div>
                                                                            </div>

                                                                        </div>-->
                                                                        <!--<div class="form-row p-2 mb-2" style="background-color: #f7f7f7; border-radius: 8px">
                                                                            <div class="form-group col-md coment">
                                                                                <h6 class="form-label text-black" for="status">Comentário Representante</h6>
                                                                                <span name="textReprov" id="textReprov"><?php echo $row['propTxtRepresentante']; ?></span>
                                                                            </div>
                                                                        </div>-->

                                                                        <!--<div class="form-row p-2 mb-2" style="background-color: #f7f7f7; border-radius: 8px">
                                                                <div class="form-group col-md coment">
                                                                    <h6 class="form-label text-black" for="status">Comentário Laudo</h6>
                                                                    <span name="textLaudo" id="textLaudo"><?php echo $row['propTxtLaudo']; ?></span>
                                                                </div>
                                                            </div>-->
                                                                        <!--<div class="form-row p-2 mb-2" style="background-color: #f7f7f7; border-radius: 8px">
                                                                            <div class="form-group col-md coment">
                                                                                <h6 class="form-label text-black" for="status">Comentário Comercial</h6>
                                                                                <input class="form-control" name="textComercial" id="textComercial" value="<?php echo $row['propTxtComercial']; ?>" />
                                                                            </div>
                                                                        </div>-->
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-4">
                                                                                <label class="form-label text-black" for="nomedr">Dr(a)</label>
                                                                                <input type="text" class="form-control" id="nomedr" name="nomedr" value="<?php echo $row['propNomeDr']; ?>" required>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="form-label text-black" for="crm">Nº Conselho Dr(a)</label>
                                                                                <input type="text" class="form-control" id="crm" name="crm" value="<?php echo $row['propNConselhoDr']; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="form-label text-black" for="telefone">Telefone Dr(a)</label>
                                                                                <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $row['propTelefoneDr']; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row ">
                                                                            <div class="form-group col-md-6">
                                                                                <label class="form-label text-black" for="emaildr">E-mail Dr(a)</label>
                                                                                <input type="email" class="form-control" id="emaildr" name="emaildr" value="<?php echo $row['propEmailDr']; ?>" required>
                                                                            </div>
                                                                            <div class="form-group col-md-6 ">
                                                                                <label class="form-label text-black" for="emailenvio">E-mail Envio</label>
                                                                                <input type="email" class="form-control" id="emailenvio" name="emailenvio" value="<?php echo $row['propEmailEnvio']; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label class="form-label text-black" for="nomepac">Paciente</label>
                                                                                <input type="text" class="form-control" id="nomepac" name="nomepac" value="<?php echo $row['propNomePac']; ?>" required>
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="convenio">Convênio</label>
                                                                                <?php
                                                                                $convenio = str_replace(' ', '', $convenio);
                                                                                ?>
                                                                                <select name="convenio" class="form-control" id="convenio" onchange="checkforothers()">
                                                                                    <?php
                                                                                    $retConvenio = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName ASC;");
                                                                                    while ($rowConvenio = mysqli_fetch_array($retConvenio)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowConvenio['convName']; ?>" <?php if ($convenio == $rowConvenio['convName']) {
                                                                                                                                                    echo ' selected="selected"';
                                                                                                                                                } ?>> <?php echo $rowConvenio['convName']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label class="form-label text-black" for="tipoProd">Tipo do Produto</label>
                                                                                <select name="tipoProd" class="form-control" id="tipoProd">
                                                                                    <?php
                                                                                    $retTipoProduto = mysqli_query($conn, "SELECT * FROM produtosproposta ORDER BY prodpropNome ASC;");
                                                                                    while ($rowTipoProduto = mysqli_fetch_array($retTipoProduto)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowTipoProduto['prodpropNome']; ?>" <?php if ($row['propTipoProd'] == $rowTipoProduto['prodpropNome']) echo ' selected="selected"'; ?>> <?php echo $rowTipoProduto['prodpropNome']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label class="form-label text-black" for="validade">Validade</label>
                                                                                <div class="input-group ">
                                                                                    <input type="number" class="form-control rounded-start" id="validade" name="validade" value="<?php echo $row['propValidade'] ?>" required>
                                                                                    <span class="input-group-text">dias</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="ufProp" class="form-label text-black">UF</label>
                                                                                <select name="ufProp" class="form-control" id="ufProp" onchange="checkUF(this)">
                                                                                    <option>Escolha uma UF</option>
                                                                                    <?php
                                                                                    $retEstados = mysqli_query($conn, "SELECT * FROM estados;");
                                                                                    while ($rowEstados = mysqli_fetch_array($retEstados)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $rowEstados['ufAbreviacao']; ?>" <?php if ($row['propUf'] == $rowEstados['ufAbreviacao']) echo ' selected="selected"'; ?>><?php echo $rowEstados['ufAbreviacao']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label class="form-label text-black" for="representante">Representante</label>
                                                                                <input type="text" class="form-control" id="representante" name="representante" value="<?php echo $row['propRepresentante']; ?>" required readonly>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        // if ($row['propNomeEnvio'] != null) {
                                                                        ?>
                                                                        <div class="form-row ">
                                                                            <div class="form-group col-md-6">
                                                                                <label class="form-label text-black" for="nomeenvio">Nome Envio</label>
                                                                                <input type="text" class="form-control" id="nomeenvio" name="nomeenvio" value="<?php echo $row['propNomeEnvio']; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-6 ">
                                                                                <label class="form-label text-black" for="telenvio">Celular Envio</label>
                                                                                <input type="text" class="form-control" id="telenvio" name="telenvio" value="<?php echo $row['propTelEnvio']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        // }
                                                                        ?>
                                                                        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                                                                        <script>
                                                                            function checkUF(elem) {
                                                                                //Recuperar o valor do campo
                                                                                var pesquisa = elem.value;

                                                                                //Verificar se há algo digitado
                                                                                if (pesquisa != '') {
                                                                                    var dados = {
                                                                                        uf: pesquisa
                                                                                    }
                                                                                    $.post('proc_pesq_uf.php', dados, function(retorna) {
                                                                                        //Mostra dentro da ul os resultado obtidos 
                                                                                        var array = retorna.split('/');
                                                                                        var representante = array[2];

                                                                                        document.getElementById("representante").value = representante;

                                                                                    });
                                                                                }
                                                                            }
                                                                        </script>
                                                                        <hr>

                                                                        <h5 style="color: gray" class="p-2">Produtos</h5>
                                                                        <div class="container-fluid">
                                                                            <div class="row w-100">
                                                                                <div class="col">
                                                                                    <table id="tableProp" class="table table-striped table-advance table-hover">
                                                                                        <thead>
                                                                                            <tr style="background-color: #ee7624; color: #fff; font-size: 7pt;" class="text-center">
                                                                                                <th style="font-size: 7pt;">ID</th>
                                                                                                <th style="font-size: 7pt;">Cod.</th>
                                                                                                <th style="width: 150px; font-size: 7pt;">Produto</th>
                                                                                                <th style="width: 90px; font-size: 7pt;">Qtd</th>
                                                                                                <th style="font-size: 7pt;">Anvisa</th>
                                                                                                <th style="font-size: 7pt;">Valor Unidade</th>
                                                                                                <th style="font-size: 7pt;">Valor Itens</th>
                                                                                                <th style="font-size: 7pt;"></th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody class="tbody">
                                                                                            <?php
                                                                                            $retProd = mysqli_query($conn, "SELECT * FROM itensproposta WHERE itemPropRef='" . $_GET['id'] . "';");
                                                                                            while ($rowProd = mysqli_fetch_array($retProd)) {
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="text" class="form-control text-center itemId" id="itemId" name="itemId" value="' . $rowProd["itemId"] . '" readonly>' ?></td>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="text" class="form-control text-center itemCdg" id="itemCdg" name="itemCdg" value="' . $rowProd["itemCdg"] . '" readonly>' ?></td>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="text" class="form-control" id="itemNome" name="itemNome" value="' . $rowProd["itemNome"] . '" readonly>' ?></td>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="number" class="form-control text-center itemQtd" id="itemQtd" name="itemQtd" value="' . $rowProd["itemQtd"] . '" onchange="remultiplicarItens(this)" >' ?></td>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="text" class="form-control text-center" id="itemAnvisa" name="itemAnvisa" value="' . $rowProd["itemAnvisa"] . '" readonly>' ?></td>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="text" class="form-control text-center itemValorUnidade" id="itemValorUnidade" name="itemValorUnidade" value="' . number_format($rowProd["itemValorBase"], 2, ",", ".") . '" onchange="resomarItens()" >' ?></td>
                                                                                                    <td><?php echo '<input style="font-size: 7pt;" type="text" class="form-control text-center itemValor" id="itemValor" name="itemValor" value="' . number_format($rowProd["itemValor"], 2, ",", ".") . '" onchange="resomarItens()">' ?></td>
                                                                                                    <td><a href="excluirItem?item=<?php echo $rowProd['itemId']; ?>&id=<?php echo $_GET['id']; ?>"><span class="btn" onclick="return confirm('Você realmente deseja apagar esse item?')"><i class="bi bi-x-lg" style="color: red;"></i></span></a></td>
                                                                                                </tr>
                                                                                            <?php
                                                                                            }
                                                                                            ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="container px-5">
                                                                            <div class="row d-flex justify-content-end">
                                                                                <span class="btn btn-primary mx-2" data-toggle="modal" data-target="#addproduto" name="adicionar" id="adicionar">+</span>
                                                                            </div>
                                                                        </div>


                                                                        <script>
                                                                            function checkCdgProd(elem) {
                                                                                //Recuperar o valor do campo
                                                                                var pesquisa = elem.value;

                                                                                //Verificar se há algo digitado
                                                                                if (pesquisa != '') {
                                                                                    var dados = {
                                                                                        cdg: pesquisa
                                                                                    }
                                                                                    $.post('proc_pesq_cdg_prod.php', dados, function(retorna) {
                                                                                        //Mostra dentro da ul os resultado obtidos 
                                                                                        // document.getElementById("result").value = retorna;
                                                                                        document.querySelector("#result").innerHTML = '';
                                                                                        document.querySelector("#result").insertAdjacentHTML("afterbegin", retorna);

                                                                                    });
                                                                                }
                                                                            }
                                                                        </script>

                                                                        <div class="form-row">
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="valorTotalItens">Valor Itens</label>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text">R$</span>
                                                                                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="valorTotalItens" name="valorTotalItens" value="<?php echo number_format($row['propValorSomaItens'], 2, ',', '.'); ?>" required onchange="calculos()">
                                                                                </div>
                                                                                <small class="text-muted">Favor utilizar vírgula como separador de casa decimal.</small>
                                                                            </div>

                                                                            <!--removido valor parafuso-->

                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="valorTotal">Valor Total</label>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text">R$</span>
                                                                                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="valorTotal" name="valorTotal" value="<?php echo number_format($row['propValorSomaTotal'], 2, ',', '.'); ?>" required onchange="calculos()">
                                                                                </div>
                                                                                <small class="text-muted">Favor utilizar vírgula como separador de casa decimal.</small>
                                                                            </div>
                                                                        </div>

                                                                        <hr style="border-style: dashed;">

                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-4">
                                                                                <label class="form-label text-black" for="porcentagemDesconto">Desconto</label>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="porcentagemDesconto" name="porcentagemDesconto" value="<?php echo $row['propDesconto']; ?>" required onchange="calculos()">
                                                                                    <span class="input-group-text">%</span>
                                                                                </div>
                                                                                <small class="text-muted">Favor inserir um numero inteiro entre 0-20.</small>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="form-label text-black" for="valorDesconto">Valor Desconto</label>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text">R$</span>
                                                                                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="valorDesconto" name="valorDesconto" value="<?php echo $row['propoValorDesconto']; ?>" required readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="form-label text-black" for="valorTotalPosDesconto">Valor Total (com desconto)</label>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text">R$</span>
                                                                                    <input type="text" class="form-control" aria-describedby="basic-addon1" id="valorTotalPosDesconto" name="valorTotalPosDesconto" value="<?php echo number_format($row['propValorPosDesconto'], 2, ',', '.'); ?>" required>
                                                                                </div>
                                                                                <small class="text-muted">Favor utilizar vírgula como separador de casa decimal.</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-row" hidden>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="listaIdsItens">IDs Itens</label>
                                                                                <input type="text" class="form-control" id="listaIdsItens" name="listaIdsItens">
                                                                            </div>

                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="listaItens">Lista Itens</label>
                                                                                <input type="text" class="form-control" id="listaItens" name="listaItens">
                                                                            </div>

                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="listaValoresItens">Valores Itens</label>
                                                                                <input type="text" class="form-control" id="listaValoresItens" name="listaValoresItens">
                                                                            </div>

                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="listaQtdsItens">Quantidades Itens</label>
                                                                                <input type="text" class="form-control" id="listaQtdsItens" name="listaQtdsItens">
                                                                            </div>

                                                                        </div>

                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                calculos();
                                                                                populateItensInput();

                                                                            });

                                                                            function populateItensInput() {
                                                                                var listaIdsItens = [];
                                                                                var listaItens = [];
                                                                                var listaValoresItens = [];
                                                                                var listaQtdsItens = [];

                                                                                $.each($('.itemId'), function(index, result) {
                                                                                    result = result.value;
                                                                                    listaIdsItens.push(result);

                                                                                });

                                                                                $.each($('.itemCdg'), function(index, result) {
                                                                                    result = result.value;
                                                                                    listaItens.push(result);

                                                                                });

                                                                                $.each($('.itemValor'), function(index, result) {
                                                                                    result = result.value;
                                                                                    result = result.replace('.', '');
                                                                                    result = result.replace(',', '.');

                                                                                    listaValoresItens.push(result);

                                                                                });

                                                                                $.each($('.itemQtd'), function(index, result) {
                                                                                    result = result.value;
                                                                                    listaQtdsItens.push(result);

                                                                                });


                                                                                listaIdsItens = listaIdsItens.join('/');
                                                                                listaItens = listaItens.join('/');
                                                                                listaValoresItens = listaValoresItens.join('/');
                                                                                listaQtdsItens = listaQtdsItens.join('/');

                                                                                document.getElementById('listaIdsItens').value = listaIdsItens;
                                                                                document.getElementById('listaItens').value = listaItens;
                                                                                document.getElementById('listaValoresItens').value = listaValoresItens;
                                                                                document.getElementById('listaQtdsItens').value = listaQtdsItens;
                                                                            }

                                                                            var inputTotalItens = document.getElementById("valorTotalItens");


                                                                            function calculos() {
                                                                                let desc = document.getElementById("porcentagemDesconto").value;
                                                                                desc = parseInt(desc);


                                                                                let valorTotalInput = document.getElementById("valorTotal").value;
                                                                                valorTotalInput = valorTotalInput.replace('.', '');
                                                                                valorTotalInput = valorTotalInput.replace(',', '.');
                                                                                valorTotalInput = parseFloat(valorTotalInput);


                                                                                let valorItens = document.getElementById("valorTotalItens").value;
                                                                                valorItens = valorItens.replace('.', '');
                                                                                valorItens = valorItens.replace(',', '.');
                                                                                valorItens = parseFloat(valorItens);


                                                                                // let valorParafusos = document.getElementById("valorTotalParafusos").value;
                                                                                // valorParafusos = valorParafusos.replace('.', '');
                                                                                // valorParafusos = valorParafusos.replace(',', '.');
                                                                                // valorParafusos = parseFloat(valorParafusos);


                                                                                valorTotalInput = valorItens;
                                                                                // console.log("valorItens: " + valorItens);

                                                                                let valorDesconto = (desc / 100) * valorTotalInput;
                                                                                let valorPosDesconto = valorTotalInput - valorDesconto;
                                                                                // console.log("valorPosDesconto: " + valorPosDesconto);

                                                                                // valorTotalInput = new Intl.NumberFormat('de-DE').format(valorTotalInput);
                                                                                // valorDesconto = new Intl.NumberFormat('de-DE').format(valorDesconto);
                                                                                // valorPosDesconto = new Intl.NumberFormat('de-DE').format(valorPosDesconto);

                                                                                valorTotalInput = valorTotalInput.toLocaleString('pt-br', {
                                                                                    minimumFractionDigits: 2
                                                                                });
                                                                                valorDesconto = valorDesconto.toLocaleString('pt-br', {
                                                                                    minimumFractionDigits: 2
                                                                                });
                                                                                valorPosDesconto = valorPosDesconto.toLocaleString('pt-br', {
                                                                                    minimumFractionDigits: 2
                                                                                });

                                                                                document.getElementById("valorTotal").value = valorTotalInput;
                                                                                document.getElementById("valorDesconto").value = valorDesconto;
                                                                                document.getElementById("valorTotalPosDesconto").value = valorPosDesconto;
                                                                                populateItensInput();

                                                                            }

                                                                            var totalItensGlobal = 0;
                                                                            $.each($('.itemValor'), function(index, result) {

                                                                                result = result.value;
                                                                                result = result.replace('.', '');
                                                                                result = result.replace(',', '.');

                                                                                result = parseFloat(result);
                                                                                totalItensGlobal = totalItensGlobal + result;
                                                                                calculos();
                                                                            });


                                                                            totalItensGlobal = totalItensGlobal.toLocaleString('pt-br', {
                                                                                minimumFractionDigits: 2
                                                                            });
                                                                            inputTotalItens.value = totalItensGlobal;

                                                                            function remultiplicarItens(elem) {
                                                                                var inputValorItem = elem.parentElement.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild;
                                                                                var valorItem = elem.parentElement.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
                                                                                valorItem = valorItem.replace('.', '');
                                                                                valorItem = valorItem.replace(',', '.');
                                                                                valorItem = parseFloat(valorItem);

                                                                                elem = elem.value;
                                                                                elem = parseInt(elem);

                                                                                var novoValor = elem * valorItem;
                                                                                // console.log(novoValor);

                                                                                novoValor = novoValor.toLocaleString('pt-br', {
                                                                                    minimumFractionDigits: 2
                                                                                });
                                                                                inputValorItem.value = novoValor;
                                                                                resomarItens();
                                                                                calculos();

                                                                            }

                                                                            function resomarItens() {
                                                                                totalItensGlobal = 0;
                                                                                $.each($('.itemValor'), function(index, result) {
                                                                                    result = result.value;
                                                                                    result = result.replace('.', '');
                                                                                    result = result.replace(',', '.');

                                                                                    result = parseFloat(result);
                                                                                    // value = parseFloat(value.value);
                                                                                    totalItensGlobal = totalItensGlobal + result;
                                                                                });


                                                                                // console.log("novo valor total: " + totalItensGlobal);
                                                                                totalItensGlobal = totalItensGlobal.toLocaleString('pt-br', {
                                                                                    minimumFractionDigits: 2
                                                                                });
                                                                                // totalItensGlobal = new Intl.NumberFormat('de-DE').format(totalItensGlobal);
                                                                                inputTotalItens.value = totalItensGlobal;
                                                                                calculos();
                                                                            }

                                                                            function adicionar() {
                                                                                const newTr = `
                                                                        <tr id="trNew">
                                                                            <td><input type="text" class="form-control" id="itemCdg" name="itemCdg"></td>
                                                                            <td><input type="text" class="form-control" id="itemNome" name="itemNome"></td>
                                                                            <td><input type="text" class="form-control text-center" id="itemQtd" name="itemQtd"></td>
                                                                            <td><input type="text" class="form-control text-center" id="itemAnvisa" name="itemAnvisa"></td>
                                                                            <td><input type="text" class="form-control text-center itemValor" id="itemValor" name="itemValor" onchange="resomarItens()"></td>
                                                                            <td><span class="btn" onclick="apagarLinha(this)"><i class="bi bi-x-lg" style="color: red;"></i></span></td>
                                                                        </tr>
                                                                    `;

                                                                                document.querySelector(".tbody").insertAdjacentHTML("beforeend", newTr);

                                                                                var element = document.getElementById("trNew");
                                                                                var closest = element.closest(".prodSelectSec");
                                                                                // console.log(closest);

                                                                                var options = $("#prodSelect > option").clone();
                                                                                $(closest).append(options);

                                                                            }

                                                                            function adicionarnalista(elem) {

                                                                                // console.log(elem);
                                                                                var parentElement1 = elem.parentElement;
                                                                                parentElement1 = parentElement1.parentElement;
                                                                                var childNode = parentElement1.firstChild.nextSibling.firstChild.value;

                                                                                var idProposta = document.getElementById('propid').value;
                                                                                // console.log(idProposta);


                                                                                // var closest = $("#itemCdg").find("input").val();
                                                                                // console.log(closest);

                                                                                //Mandar elemento pra tabela de registro de itens
                                                                                if (childNode != '') {
                                                                                    var dados = {
                                                                                        idprop: idProposta,
                                                                                        cdg: childNode
                                                                                    }
                                                                                    $.post('proc_pesq_add_prod.php', dados, function(retorna) {

                                                                                        document.querySelector(".tbody").insertAdjacentHTML("beforeend", retorna);
                                                                                    });
                                                                                    // document.location.reload(true);
                                                                                }
                                                                                // $('#addproduto').modal('hide');
                                                                                $('#addproduto').click();
                                                                                refresh(idProposta);
                                                                            }

                                                                            function refresh(idProposta) {
                                                                                window.location.assign(`update-proposta?id=${idProposta}`);
                                                                            }

                                                                            function watchStatus(value) {

                                                                                var status = value.value;
                                                                                var pedidoInput = document.querySelector('.pedido');
                                                                                var drInput = document.querySelector('.drrespuid');

                                                                                if (status == "PEDIDO") {
                                                                                    pedidoInput.hidden = false;
                                                                                    drInput.hidden = false;
                                                                                } else {
                                                                                    pedidoInput.hidden = true;
                                                                                    drInput.hidden = true;
                                                                                }

                                                                            }
                                                                        </script>

                                                                        <hr>
                                                                        <h5 style="color: gray" class="p-2">Plano de Vendas</h5>

                                                                        <div class="container">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md">
                                                                                    <select name="planovendas" class="form-control" id="planovendas">
                                                                                        <option>Selecione uma opção</option>
                                                                                        <?php
                                                                                        $retSelect = mysqli_query($conn, "SELECT * FROM planosfinanceiros;");
                                                                                        while ($rowSelect = mysqli_fetch_array($retSelect)) {
                                                                                        ?>
                                                                                            <option value="<?php echo $rowSelect['finModalidade']; ?>" <?php if ($row['propPlanoVenda'] == $rowSelect['finModalidade']) echo ' selected="selected"'; ?>> <?php echo $rowSelect['finModalidade']; ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr>

                                                                        <script>
                                                                            function sendForm() {


                                                                                //Recuperar o valor do campo

                                                                                // var propid = document.getElementsByName("propid")[0].value;
                                                                                // var empresa = document.getElementsByName("empresa")[0].value;
                                                                                // var cnpj = document.getElementsByName("cnpj")[0].value;
                                                                                // var status = document.getElementsByName("status")[0].value;
                                                                                // var userCriador = document.getElementsByName("userCriador")[0].value;
                                                                                // var nomedr = document.getElementsByName("nomedr")[0].value;
                                                                                // var crm = document.getElementsByName("crm")[0].value;
                                                                                // var telefone = document.getElementsByName("telefone")[0].value;
                                                                                // var emaildr = document.getElementsByName("emaildr")[0].value;
                                                                                // var emailenvio = document.getElementsByName("emailenvio")[0].value;
                                                                                // var nomepac = document.getElementsByName("nomepac")[0].value;
                                                                                // var convenio = document.getElementsByName("convenio")[0].value;
                                                                                // var tipoProd = document.getElementsByName("tipoProd")[0].value;
                                                                                // var validade = document.getElementsByName("validade")[0].value;
                                                                                // var ufProp = document.getElementsByName("ufProp")[0].value;
                                                                                // var representante = document.getElementsByName("representante")[0].value;
                                                                                // var pedido = document.getElementsByName("pedido")[0].value;
                                                                                // var listaIdsItens = document.getElementsByName("listaIdsItens")[0].value;
                                                                                // var listaItens = document.getElementsByName("listaItens")[0].value;
                                                                                // var listaValoresItens = document.getElementsByName("listaValoresItens")[0].value;
                                                                                // var planovendas = document.getElementsByName("planovendas")[0].value;
                                                                                // var listaQtdsItens = document.getElementsByName("listaQtdsItens")[0].value;
                                                                                // var valorTotalItens = document.getElementsByName("valorTotalItens")[0].value;
                                                                                // // var valorTotalParafusos = document.getElementById("formprop").elements.namedItem("valorTotalParafusos").value;
                                                                                // var valorTotal = document.getElementsByName("valorTotal")[0].value;
                                                                                // var porcentagemDesconto = document.getElementsByName("porcentagemDesconto")[0].value;
                                                                                // var valorDesconto = document.getElementsByName("valorDesconto")[0].value;
                                                                                // var valorTotalPosDesconto = document.getElementsByName("valorTotalPosDesconto")[0].value;
                                                                                // //var textComercial = document.getElementsByName("textComercial")[0].value;
                                                                                // var nomeenvio = document.getElementsByName("nomeenvio")[0].value;
                                                                                // var telenvio = document.getElementsByName("telenvio")[0].value;
                                                                                // var drrespuid = document.getElementsByName("drrespuid")[0].value;

                                                                                var propid = document.getElementById("formprop").elements.namedItem("propid").value;
                                                                                var empresa = document.getElementById("formprop").elements.namedItem("empresa").value;
                                                                                var cnpj = document.getElementById("formprop").elements.namedItem("cnpj").value;
                                                                                var status = document.getElementById("formprop").elements.namedItem("status").value;
                                                                                var userCriador = document.getElementById("formprop").elements.namedItem("userCriador").value;
                                                                                var nomedr = document.getElementById("formprop").elements.namedItem("nomedr").value;
                                                                                var crm = document.getElementById("formprop").elements.namedItem("crm").value;
                                                                                var telefone = document.getElementById("formprop").elements.namedItem("telefone").value;
                                                                                var emaildr = document.getElementById("formprop").elements.namedItem("emaildr").value;
                                                                                var emailenvio = document.getElementById("formprop").elements.namedItem("emailenvio").value;
                                                                                var nomepac = document.getElementById("formprop").elements.namedItem("nomepac").value;
                                                                                var convenio = document.getElementById("formprop").elements.namedItem("convenio").value;
                                                                                var tipoProd = document.getElementById("formprop").elements.namedItem("tipoProd").value;
                                                                                var validade = document.getElementById("formprop").elements.namedItem("validade").value;
                                                                                var ufProp = document.getElementById("formprop").elements.namedItem("ufProp").value;
                                                                                var representante = document.getElementById("formprop").elements.namedItem("representante").value;
                                                                                var pedido = document.getElementById("formprop").elements.namedItem("pedido").value;
                                                                                var listaIdsItens = document.getElementById("formprop").elements.namedItem("listaIdsItens").value;
                                                                                var listaItens = document.getElementById("formprop").elements.namedItem("listaItens").value;
                                                                                var listaValoresItens = document.getElementById("formprop").elements.namedItem("listaValoresItens").value;
                                                                                var planovendas = document.getElementById("formprop").elements.namedItem("planovendas").value;
                                                                                var listaQtdsItens = document.getElementById("formprop").elements.namedItem("listaQtdsItens").value;
                                                                                var valorTotalItens = document.getElementById("formprop").elements.namedItem("valorTotalItens").value;
                                                                                // var valorTotalParafusos = document.getElementById("formprop").elements.namedItem("valorTotalParafusos").value;
                                                                                var valorTotal = document.getElementById("formprop").elements.namedItem("valorTotal").value;
                                                                                var porcentagemDesconto = document.getElementById("formprop").elements.namedItem("porcentagemDesconto").value;
                                                                                var valorDesconto = document.getElementById("formprop").elements.namedItem("valorDesconto").value;
                                                                                var valorTotalPosDesconto = document.getElementById("formprop").elements.namedItem("valorTotalPosDesconto").value;
                                                                                //var textComercial = document.getElementById("formprop").elements.namedItem("textComercial").value;
                                                                                var nomeenvio = document.getElementById("formprop").elements.namedItem("nomeenvio").value;
                                                                                var telenvio = document.getElementById("formprop").elements.namedItem("telenvio").value;
                                                                                var drrespuid = document.getElementById("formprop").elements.namedItem("drrespuid").value;

                                                                                valorTotalItens = valorTotalItens.replace('.', '');
                                                                                valorTotalItens = valorTotalItens.replace(',', '.');

                                                                                // valorTotalParafusos = valorTotalParafusos.replace('.', '');
                                                                                // valorTotalParafusos = valorTotalParafusos.replace(',', '.');

                                                                                valorTotal = valorTotal.replace('.', '');
                                                                                valorTotal = valorTotal.replace(',', '.');

                                                                                valorDesconto = valorDesconto.replace('.', '');
                                                                                valorDesconto = valorDesconto.replace(',', '.');

                                                                                valorTotalPosDesconto = valorTotalPosDesconto.replace('.', '');
                                                                                valorTotalPosDesconto = valorTotalPosDesconto.replace(',', '.');
                                                                                
                                                                                if (empresa == '') {
                                                                                    empresa = null;
                                                                                }

                                                                                
                                                                                // Verificar se há algo digitado
                                                                                if (propid != '') {

                                                                                    var dados = {
                                                                                        id: propid,
                                                                                        empresa: empresa,
                                                                                        cnpj: cnpj,
                                                                                        status: status,
                                                                                        userCriador: userCriador,
                                                                                        nomedr: nomedr,
                                                                                        crm: crm,
                                                                                        telefone: telefone,
                                                                                        emaildr: emaildr,
                                                                                        emailenvio: emailenvio,
                                                                                        nomepac: nomepac,
                                                                                        convenio: convenio,
                                                                                        tipoProd: tipoProd,
                                                                                        validade: validade,
                                                                                        ufProp: ufProp,
                                                                                        representante: representante,
                                                                                        pedido: pedido,
                                                                                        listaIdsItens: listaIdsItens,
                                                                                        listaItens: listaItens,
                                                                                        listaValoresItens: listaValoresItens,
                                                                                        planovendas: planovendas,
                                                                                        listaQtdsItens: listaQtdsItens,
                                                                                        valorTotalItens: valorTotalItens,
                                                                                        // valorTotalParafusos: valorTotalParafusos,
                                                                                        valorTotal: valorTotal,
                                                                                        porcentagemDesconto: porcentagemDesconto,
                                                                                        valorDesconto: valorDesconto,
                                                                                        valorTotalPosDesconto: valorTotalPosDesconto,
                                                                                        //textComercial: textComercial,
                                                                                        drrespuid: drrespuid,
                                                                                        nomeenvio: nomeenvio,
                                                                                        telenvio: telenvio
                                                                                    }
                                                                                    // alert(dados);


                                                                                    $.post('proc_update_prop.php', dados, function(retorna) {
                                                                                        // console.log(retorna);
                                                                                        //alert(retorna);
                                                                                        refresh(propid);

                                                                                    });
                                                                                }
                                                                            }
                                                                        </script>

                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="submit" name="update" id="update" class="btn btn-primary" onclick="sendForm()">Salvar</button>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </section>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="card col-md-3 mr-1 my-1">
                                            <div class="card-body container-fluid">
                                                <div class="row d-flex">
                                                    <div class="col-md">
                                                        <div>
                                                            <?php
                                                            if (isset($_GET["error"])) {
                                                                if ($_GET["error"] == "sent") {
                                                                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Feedback enviado!</p></div>";
                                                                }
                                                            }
                                                            ?>
                                                            <div>
                                                                <h5 style="color: silver; text-align: center;">Comentários</h5>
                                                                <div class="rounded">

                                                                    <?php
                                                                    $idProjeto = $_GET['id'];
                                                                    $retMsg = mysqli_query($conn, "SELECT * FROM comentariosproposta WHERE comentVisNumProp='$idProjeto' ORDER BY comentVisId ASC");


                                                                    while ($rowMsg = mysqli_fetch_array($retMsg)) {
                                                                        $msg = $rowMsg['comentVisText'];
                                                                        $owner = $rowMsg['comentVisUser'];
                                                                        $timer = $rowMsg['comentVisHorario'];
                                                                        $tipoUsuario = $rowMsg['comentVisTipoUser'];

                                                                        $timer = explode(" ", $timer);
                                                                        $data = $timer[0];
                                                                        // $dataAmericana = explode("-", $date);
                                                                        // $ano = str_split($dataAmericana[0]);
                                                                        // $ano = $ano[0] . $ano[1];
                                                                        // $data = $dataAmericana[2] . '/' . $dataAmericana[1] . '/' . $ano;


                                                                        $hora = $timer[1];
                                                                        // $horaEnvio = explode(":", $hour);
                                                                        // $hora = 'às ' . $horaEnvio[0] . ':' . $horaEnvio[1];
                                                                        $horario = $data . ' às ' . $hora;


                                                                        switch ($tipoUsuario) {
                                                                            case 'Administrador':
                                                                                $ownerColor = 'darkred';
                                                                                $hourColor = "#fff";
                                                                                break;

                                                                            case 'Representante':
                                                                                $ownerColor = 'darkpink';
                                                                                $hourColor = "#fff";
                                                                                break;

                                                                            case 'Comercial':
                                                                                $ownerColor = 'darkblue';
                                                                                $hourColor = "#fff";
                                                                                break;

                                                                            case 'Planejador(a)':
                                                                                $ownerColor = 'darkpurple';
                                                                                $hourColor = "#fff";
                                                                                break;

                                                                            case 'Financeiro':
                                                                                $ownerColor = 'darkgreen';
                                                                                $hourColor = "#fff";
                                                                                break;

                                                                            case 'Qualidade ':
                                                                                $ownerColor = 'brown';
                                                                                $hourColor = "#fff";
                                                                                break;

                                                                            default:
                                                                                $ownerColor = 'orange';
                                                                                $hourColor = "#874214";
                                                                                break;
                                                                        }

                                                                    ?>
                                                                        <?php
                                                                        if ($_SESSION['useruid'] == $owner) {


                                                                        ?>
                                                                            <div class="row py-1">
                                                                                <div class="col d-flex justify-content-end w-50">
                                                                                    <div class="bg-secondary bg-gradient text-white rounded rounded-3 px-2 py-1">
                                                                                        <h6><b><?php echo $owner; ?>:</b></h6>
                                                                                        <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 200px;"><?php echo $msg; ?></p>
                                                                                        <small style="color: #323236;"><?php echo $horario; ?></small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <div class="row py-1">
                                                                                <div class="col d-flex justify-content-start w-50">
                                                                                    <div class="bg-<?php echo $ownerColor; ?>-conecta text-white rounded rounded-3 px-2 py-1">
                                                                                        <h6><b><?php echo $owner; ?>:</b></h6>
                                                                                        <p class="text-white text-wrap" style="font-size: 0.8rem; max-width: 300px;"><?php echo $msg; ?></p>
                                                                                        <small style="color: <?php echo $hourColor; ?>;"><?php echo $horario; ?></small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="row d-flex justify-content-center">
                                                                    <div class="col-sm px-2 py-3">
                                                                        <form action="includes/comentproposta.inc.php" method="post">
                                                                            <div class="container" hidden>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <label for="nprop">Nº Pedido</label>
                                                                                        <input type="text" class="form-control" name="nprop" id="nprop" value="<?php echo $idProjeto; ?>" readonly>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="user">Usuário</label>
                                                                                        <input type="text" class="form-control" name="user" id="user" value="<?php echo $_SESSION['useruid']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div class="col d-flex justify-content-around align-items-start">
                                                                                        <div class="p-1">
                                                                                            <textarea class="form-control color-bg-dark color-txt-wh" style="font-size: 0.8rem;" name="coment" id="coment" rows="1" onkeyup="limite_textarea(this.value)" maxlength="300"></textarea><br><br>
                                                                                            <div class="row d-flex justify-content-start p-0 m-0">
                                                                                                <small class="pl-2 text-muted" style="margin-top: -40px !important;"><small class="text-muted" id="cont">300</small> Caracteres restantes</small>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="p-1">
                                                                                            <button type="submit" name="submitcoment" class="btn btn-primary" style="font-size: small;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                limite_textarea(document.getElementById("coment").value);
                                                            });

                                                            function limite_textarea(valor) {
                                                                quant = 300;
                                                                total = valor.length;
                                                                if (total <= quant) {
                                                                    resto = quant - total;
                                                                    document.getElementById('cont').innerHTML = resto;
                                                                } else {
                                                                    document.getElementById('coment').value = valor.substr(0, quant);
                                                                }
                                                            }
                                                        </script>

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


                <!-- Modal Anexo-->
                <div class="modal fade" id="veranexo" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-black">Anexos da Proposta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row d-flex">
                                        <div class="col-md">
                                            <?php
                                            $retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplana WHERE imgplanNumProp='" . $row['propId'] . "';");

                                            if (($retPic) && ($retPic->num_rows != 0)) {
                                                while ($rowPic = mysqli_fetch_array($retPic)) {
                                                    $picPathA = $rowPic['imgplanPathImg'];
                                                }
                                            } else {
                                                $picPathA = "none";
                                            }
                                            ?>

                                            <script>
                                                $(document).ready(function() {
                                                    var elem = document.getElementById("cdnurl1").value;
                                                    if (elem != "none") {

                                                        create_titulo();
                                                        create_imgA(elem);
                                                    }

                                                });


                                                function create_titulo(elem) {
                                                    var titulo = document.createElement('h4');
                                                    titulo.innerHTML = 'Imagem referência (um caso bom)';
                                                    // img.classList.add("thumbnail");
                                                    document.getElementById('titulo-preview1').appendChild(titulo);
                                                }

                                                function create_imgA(elem) {
                                                    var img = document.createElement('img');
                                                    img.src = elem;
                                                    img.classList.add("thumbnail");
                                                    document.getElementById('image-preview1').appendChild(img);
                                                }
                                            </script>
                                            <div class="card rounded shadow">
                                                <div class="card-body">
                                                    <div class="col ">
                                                        <iframe src="<?php echo $picPathA; ?>/gallery/-/nav/thumbs/-/fit/cover/-/loop/true/-/allowfullscreen/native/-/thumbwidth/100/" width="100%" height="600" allowfullscreen="true" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="py-4" hidden>
                                                <div class="row">
                                                    <div class="form-group d-inline-block flex-fill">
                                                        <label class="control-label" style="color:black;" for="cdnurl1">Cdn Url</label>
                                                        <input class="form-control" name="cdnurl1" id="cdnurl1" type="text" value="<?php echo $picPathA; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md">
                                            <?php
                                            $retPic2 = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $row['propId'] . "';");

                                            if (($retPic2) && ($retPic2->num_rows != 0)) {
                                                while ($rowPic2 = mysqli_fetch_array($retPic2)) {
                                                    $picPathB = $rowPic2['imgplanPathImg'];
                                                }
                                            } else {
                                                $picPathB = "none";
                                            }
                                            ?>

                                            <script>
                                                $(document).ready(function() {
                                                    var elem = document.getElementById("cdnurl2").value;
                                                    if (elem != "none") {

                                                        create_titulo2();
                                                        create_imgB(elem);
                                                    }

                                                });


                                                function create_titulo2(elem) {
                                                    var titulo = document.createElement('h4');
                                                    titulo.innerHTML = 'Imagem referência (um caso bom)';
                                                    // img.classList.add("thumbnail");
                                                    document.getElementById('titulo-preview2').appendChild(titulo);
                                                }

                                                function create_imgB(elem) {
                                                    var img = document.createElement('img');
                                                    img.src = elem;
                                                    img.classList.add("thumbnail");
                                                    document.getElementById('image-preview2').appendChild(img);
                                                }
                                            </script>
                                            <div class="card rounded shadow">
                                                <div class="card-body">
                                                    <div class="col ">
                                                        <iframe src="<?php echo $picPathB; ?>/gallery/-/nav/thumbs/-/fit/cover/-/loop/true/-/allowfullscreen/native/-/thumbwidth/100/" width="100%" height="600" allowfullscreen="true" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="py-4" hidden>
                                                <div class="row">
                                                    <div class="form-group d-inline-block flex-fill">
                                                        <label class="control-label" style="color:black;" for="cdnurl2">Cdn Url</label>
                                                        <input class="form-control" name="cdnurl2" id="cdnurl2" type="text" value="<?php echo $picPathB; ?>" readonly>
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

                <!-- Modal Add Tipos de Produtos-->
                <div class="modal fade" id="addproduto" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-black">Pesquise aqui o novo produto pelo código</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md">
                                        <label class="text-black" for="cdg">Código Callisto</label>
                                        <input type="text" class="form-control" id="cdg" name="cdg" onkeyup="checkCdgProd(this)">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <table id="tableProp" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr style="background-color: #ee7624; color: #fff;" class="text-center">
                                                <th>Cod.</th>
                                                <th>Produto</th>
                                                <th>Qtd</th>
                                                <th>Anvisa</th>
                                                <th>Valor</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody" id="result">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Trocar Proprietário-->
                <div class="modal fade" id="trocaproprietario" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-black">Trocar Proprietário</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row d-flex">
                                        <div class="col-md">
                                            <form class="form-horizontal style-form" action="includes/trocarprop.inc.php" method="POST">
                                                <div class="form-row" hidden>
                                                    <div class="form-group col-md">
                                                        <label class="form-label text-black" for="propid">Prop ID</label>
                                                        <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                        <small class="text-muted">ID não é editável</small>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label class="form-label text-black" for="novousuario">Novo Usuário</label>
                                                    <input type="text" class="form-control" id="novousuario" name="novousuario">
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" name="submituser" id="submit" class="btn btn-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Trocar Doutor-->
                <div class="modal fade" id="trocadoutor" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-black">Definir Doutor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row d-flex">
                                        <div class="col-md">
                                            <form class="form-horizontal style-form" action="includes/trocardoutor.inc.php" method="POST">
                                                <div class="form-row" hidden>
                                                    <div class="form-group col-md">
                                                        <label class="form-label text-black" for="propid">Prop ID</label>
                                                        <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
                                                        <small class="text-muted">ID não é editável</small>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label class="form-label text-black" for="status">Doutor Responsável</label>
                                                    <select name="doutoruid" class="form-control" id="doutoruid" <?php if ($row['propPedido'] != null) echo 'readonly'; ?>>
                                                        <option selected> Escolha um Dr(a)</option>
                                                        <?php
                                                        $retDrResp = mysqli_query($conn, "SELECT * FROM users WHERE usersPerm='3DTR' ORDER BY usersName ASC;");
                                                        while ($rowDrResp = mysqli_fetch_array($retDrResp)) {
                                                        ?>
                                                            <option value="<?php echo $rowDrResp['usersUid']; ?>" <?php if ($row['propDrUid'] == $rowDrResp['usersUid']) echo ' selected="selected"'; ?>> <?php echo $rowDrResp['usersName']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <?php
                include_once 'php/footer_updateprop.php';
            }
        } else {

            header("location: index");
            exit();
        }
    } else {
        header("location: index");
        exit();
    }
    ?>