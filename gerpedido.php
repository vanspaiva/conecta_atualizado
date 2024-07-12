<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Pedido')) {
    include("php/head_index.php");
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        ?>


        <style>
            .invalid-input {
                border: 2px solid red;
            }
        </style>
        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Caso editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Caso foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-8 justify-content-start w-100" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Configurações de <span style="font-weight: 700;">Pedidos</span></h2>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                        <br>
                        <div class="card shadow" style="overflow: scroll;">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md ">
                                            <!-- Status Pedido -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Status Pedido</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addstatuspedido"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <table id="tablestatus" class="table table-striped table-hover">

                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Nome</th>
                                                                <th>Ordem</th>
                                                                <th>Value</th>
                                                                <th>Posição</th>
                                                                <th>Andamento</th>
                                                                <th>Calc Dt Prazo</th>
                                                                <th>Cor BG</th>
                                                                <th>Cor Txt</th>
                                                                <th></th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $retPedido = mysqli_query($conn, "SELECT * FROM statuspedido ORDER BY stpedIndiceFluxo ASC");
                                                            while ($rowPedido = mysqli_fetch_array($retPedido)) {
                                                                $nomeFluxo = getFullNomeFluxoPed($conn, $rowPedido['stpedValue']);
                                                                $corFluxo = getFullCorFluxoPed($conn, $rowPedido['stpedValue']);
                                                            ?>
                                                                <tr>
                                                                    <!-- <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowPedido['stpedValue'] . ') ' . $rowPedido['stpedNome']; ?> <a href="manageConfigPedido?deletestped=<?php echo $rowPedido['stpedId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span> -->
                                                                    <td>
                                                                        <?php echo $rowPedido['stpedId']; ?>
                                                                        <button class="btn text-info btn-xs" data-toggle="modal" data-target="#editstatus" onclick="populate(<?php echo $rowPedido['stpedId']; ?>)"><i class="far fa-edit"></i></button>
                                                                    </td>
                                                                    <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                                    <td><?php echo $rowPedido['stpedIndiceFluxo']; ?></td>
                                                                    <td><?php echo $rowPedido['stpedValue']; ?></td>
                                                                    <td><?php echo $rowPedido['stpedPosicao']; ?></td>
                                                                    <td><?php echo $rowPedido['stpedAndamento']; ?></td>
                                                                    <td><?php echo $rowPedido['stpedCalcularDtPrazo']; ?></td>
                                                                    <td><?php echo $rowPedido['stpedCorBg']; ?></td>
                                                                    <td><?php echo $rowPedido['stpedCorTexto']; ?></td>
                                                                    <td></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>

                                            <!-- Modal Add Status Pedido-->
                                            <div class="modal fade" id="addstatuspedido" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Status Pedido</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- <th>ID</th>
                                                                <th>Nome</th>
                                                                <th>Índice</th>
                                                                <th>Value</th>
                                                                <th>Posição</th>
                                                                <th>Andamento</th>
                                                                <th>Calc Dt Prazo</th>
                                                                <th>Cor BG</th>
                                                                <th>Cor Txt</th>
                                                                <th></th> -->

                                                            <form class="prodForm" action="includes/configpedido.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" onchange="copyToValue(this)" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="indexFluxo">Ordem</label>
                                                                        <input type="number" class="form-control" id="indexFluxo" name="indexFluxo" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="value">Value</label>
                                                                        <input type="text" class="form-control" id="value" name="value" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="posicao">Posição</label>
                                                                        <input type="number" class="form-control" id="posicao" name="posicao" min="1" max="5" onchange="validateNumber()" required>
                                                                        <small class="text-muted">1-5</small>
                                                                        <small class="badge alert-danger" id="alertposicao" hidden> Número precisa estar entre 1 a 5</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="andamento">Andamento</label>
                                                                        <select name="andamento" class="form-control" id="andamento" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="ABERTO">ABERTO</option>
                                                                            <option value="FINALIZADO">FINALIZADO</option>
                                                                            <option value="ARQUIVADO">ARQUIVADO</option>
                                                                            <option value="PENDENTE">PENDENTE</option>
                                                                        </select>

                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="calcdtprazo">Calc Dt Prazo</label>
                                                                        <select name="calcdtprazo" class="form-control" id="calcdtprazo" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="true">Sim</option>
                                                                            <option value="false">Não</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="corbg">Cor BG</label>
                                                                        <select name="corbg" class="form-control" id="corbg" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="bg-cinza">bg-cinza</option>
                                                                            <option value="bg-amarelo">bg-amarelo</option>
                                                                            <option value="bg-verde-claro">bg-verde-claro</option>
                                                                            <option value="bg-verde">bg-verde</option>
                                                                            <option value="bg-lilas">bg-lilas</option>
                                                                            <option value="bg-roxo">bg-roxo</option>
                                                                            <option value="bg-vermelho">bg-vermelho</option>
                                                                            <option value="bg-rosa">bg-rosa</option>
                                                                            <option value="bg-azul">bg-azul</option>
                                                                            <option value="bg-gray">bg-gray</option>
                                                                            <option value="bg-amarelo">bg-amarelo</option>
                                                                            <option value="bg-laranja">bg-laranja</option>
                                                                            <option value="bg-marrom">bg-marrom</option>

                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="cortxt">Cor TXT</label>
                                                                        <select name="cortxt" class="form-control" id="cortxt" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="text-white">text-white</option>
                                                                            <option value="text-black">text-black</option>
                                                                            <option value="text-danger">text-danger</option>
                                                                            <option value="text-cinza">text-cinza</option>
                                                                            <option value="text-amarelo">text-amarelo</option>
                                                                            <option value="text-verde-claro">text-verde-claro</option>
                                                                            <option value="text-verde">text-verde</option>
                                                                            <option value="text-lilas">text-lilas</option>
                                                                            <option value="text-roxo">text-roxo</option>
                                                                            <option value="text-vermelho">text-vermelho</option>
                                                                            <option value="text-rosa">text-rosa</option>
                                                                            <option value="text-azul">text-azul</option>
                                                                            <option value="text-gray">text-gray</option>
                                                                            <option value="text-amarelo">text-amarelo</option>
                                                                            <option value="text-laranja">text-laranja</option>
                                                                            <option value="text-marrom">text-marrom</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novostped" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit Status -->
                                            <div class="modal fade" id="editstatus" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Editar Status</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configpedido.inc.php" method="post">
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editid">Id</label>
                                                                        <input type="text" class="form-control" id="editid" name="editid" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editnome">Nome</label>
                                                                        <input type="text" class="form-control" id="editnome" name="editnome" onchange="copyToValue2(this)" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editindexFluxo">Ordem</label>
                                                                        <input type="number" class="form-control" id="editindexFluxo" name="editindexFluxo" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editvalue">Value</label>
                                                                        <input type="text" class="form-control" id="editvalue" name="editvalue" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editposicao">Posição</label>
                                                                        <input type="number" class="form-control" id="editposicao" name="editposicao" min="1" max="5" onchange="validateNumber()" required>
                                                                        <small class="text-muted">1-5</small>
                                                                        <small class="badge alert-danger" id="alertposicao" hidden> Número precisa estar entre 1 a 5</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editandamento">Andamento</label>
                                                                        <select name="editandamento" class="form-control" id="editandamento" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="ABERTO">ABERTO</option>
                                                                            <option value="FINALIZADO">FINALIZADO</option>
                                                                            <option value="ARQUIVADO">ARQUIVADO</option>
                                                                            <option value="PENDENTE">PENDENTE</option>
                                                                        </select>

                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editcalcdtprazo">Calc Dt Prazo</label>
                                                                        <select name="editcalcdtprazo" class="form-control" id="editcalcdtprazo" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="true">Sim</option>
                                                                            <option value="false">Não</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editcorbg">Cor BG</label>
                                                                        <select name="editcorbg" class="form-control" id="editcorbg" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="bg-cinza">bg-cinza</option>
                                                                            <option value="bg-amarelo">bg-amarelo</option>
                                                                            <option value="bg-verde-claro">bg-verde-claro</option>
                                                                            <option value="bg-verde">bg-verde</option>
                                                                            <option value="bg-lilas">bg-lilas</option>
                                                                            <option value="bg-roxo">bg-roxo</option>
                                                                            <option value="bg-vermelho">bg-vermelho</option>
                                                                            <option value="bg-rosa">bg-rosa</option>
                                                                            <option value="bg-azul">bg-azul</option>
                                                                            <option value="bg-gray">bg-gray</option>
                                                                            <option value="bg-amarelo">bg-amarelo</option>
                                                                            <option value="bg-laranja">bg-laranja</option>
                                                                            <option value="bg-marrom">bg-marrom</option>

                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="editcortxt">Cor TXT</label>
                                                                        <select name="editcortxt" class="form-control" id="editcortxt" required>
                                                                            <option value="">Escolha uma opção</option>
                                                                            <option value="text-white">text-white</option>
                                                                            <option value="text-black">text-black</option>
                                                                            <option value="text-danger">text-danger</option>
                                                                            <option value="text-cinza">text-cinza</option>
                                                                            <option value="text-amarelo">text-amarelo</option>
                                                                            <option value="text-verde-claro">text-verde-claro</option>
                                                                            <option value="text-verde">text-verde</option>
                                                                            <option value="text-lilas">text-lilas</option>
                                                                            <option value="text-roxo">text-roxo</option>
                                                                            <option value="text-vermelho">text-vermelho</option>
                                                                            <option value="text-rosa">text-rosa</option>
                                                                            <option value="text-azul">text-azul</option>
                                                                            <option value="text-gray">text-gray</option>
                                                                            <option value="text-amarelo">text-amarelo</option>
                                                                            <option value="text-laranja">text-laranja</option>
                                                                            <option value="text-marrom">text-marrom</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="editstped" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tipo de Docs Pedido -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Info Falta Docs Pedido</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#adddocspedido"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retPedido = mysqli_query($conn, "SELECT * FROM docspedido ORDER BY docsId ASC");
                                                    while ($rowPedido = mysqli_fetch_array($retPedido)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowPedido['docsNome']; ?> <a href="manageConfigPedido?deletedocs=<?php echo $rowPedido['docsId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- Modal Add Tipo de Docs Pedido-->
                                            <div class="modal fade" id="adddocspedido" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Info Falta Docs Pedido</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configpedido.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novodocs" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>



                                    </div>
                                    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                                    <script>
                                        function populate(id) {
                                            //Recuperar o valor do campo
                                            var pesquisa = id;
                                            // console.log(pesquisa);

                                            //Verificar se há algo digitado
                                            if (pesquisa != '') {
                                                var dados = {
                                                    id: pesquisa
                                                }
                                                $.post('pesq_idstatus.php', dados, function(retorna) {

                                                    var array = retorna.split('|');

                                                    var id = array[0];
                                                    var nome = array[1];
                                                    var indicefluxo = array[2];
                                                    var value = array[3];
                                                    var posicao = array[4];
                                                    var andamento = array[5];
                                                    var dtprazo = array[6];
                                                    var corbg = array[7];
                                                    var cortexto = array[8];

                                                    console.log(array);


                                                    document.getElementById('editid').value = id;
                                                    document.getElementById('editnome').value = nome;
                                                    document.getElementById('editindexFluxo').value = indicefluxo;
                                                    document.getElementById('editvalue').value = value;
                                                    document.getElementById('editposicao').value = posicao;
                                                    document.getElementById('editandamento').value = andamento;
                                                    document.getElementById('editcalcdtprazo').value = dtprazo;
                                                    document.getElementById('editcorbg').value = corbg;
                                                    document.getElementById('editcortxt').value = cortexto;


                                                });
                                            }
                                        }

                                        function show(elem) {
                                            elem = elem.text;
                                            var tabAgenda = document.getElementById("v-pills-home");
                                            var tabConfig = document.getElementById("v-pills-settings");
                                            var linkAgenda = document.getElementById("v-pills-home-tab");
                                            var linkConfig = document.getElementById("v-pills-settings-tab");

                                            switch (elem) {
                                                case 'Agenda':
                                                    tabAgenda.classList.add('show', 'active');
                                                    tabConfig.classList.remove('show', 'active');
                                                    linkAgenda.classList.add('active');
                                                    linkConfig.classList.remove('active');
                                                    break;

                                                case 'Configurações':
                                                    tabAgenda.classList.remove('show', 'active');
                                                    tabConfig.classList.add('show', 'active');
                                                    linkAgenda.classList.remove('active');
                                                    linkConfig.classList.add('active');
                                                    break;

                                                default:
                                                    console.log('erro');
                                            }


                                        }

                                        function validateNumber() {
                                            var input = document.getElementById('posicao');
                                            var isValid = input.checkValidity();

                                            console.log(input);

                                            if (!isValid) {
                                                input.classList.add('invalid-input');
                                                document.getElementById('alertposicao').hidden = false;
                                            } else {
                                                input.classList.remove('invalid-input');
                                                document.getElementById('alertposicao').hidden = true;
                                            }
                                        }

                                        function copyToValue(elem) {
                                            elem = elem.value;
                                            document.getElementById('value').value = elem;

                                        }

                                        function copyToValue2(elem) {
                                            elem = elem.value;
                                            document.getElementById('editvalue').value = elem;

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

        <script>
            $(document).ready(function() {
                $('#tablestatus').DataTable({
                    "lengthMenu": [
                        [20, 40, 80, -1],
                        [20, 40, 80, "Todos"],
                    ],
                    "language": {
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        "lengthMenu": "Mostrar _MENU_ itens",
                        "zeroRecords": "Nenhum caso encontrado"
                    },
                    "order": [
                        [2, "asc"]
                    ]
                });
            });
        </script>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>