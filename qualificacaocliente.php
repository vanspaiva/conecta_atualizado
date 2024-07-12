<?php
session_start();
if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Qualidade')) || ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_tables.php");

?>
    <style>

    </style>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["empr"])) {
                    $empresa = $_GET["empr"];
                } else {
                    $empresa = "";
                }

                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Algo deu errado, por favor tente novamente!</p></div>";
                    } else if ($_GET["error"] == "enviado") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>E-mail enviado com sucesso para empresa " . $empresa . ".</p></div>";
                    } else if ($_GET["error"] == "excluded") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Empresa " . $empresa . " excluída</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Qualificação de <span style="font-weight: 700;"> Clientes</span></h2>
                            <span class="btn btn-conecta mx-2 p-2 px-3" data-toggle="modal" data-target="#novaqualificacao"><i class="fas fa-paper-plane mx-1"></i> Enviar Form</span>
                        </div>

                        <hr style="border-color: #ee7624;">
                        <br>

                        <div class="card shadow">
                            <div class="card-body">
                                <h4 class="text-black py-2"><b>Lista de clientes</b></h4>
                                <div class="content-panel">
                                    <table id="table1" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th style="background-color: white; z-index: 1001;"></th>
                                                <th style="background-color: white; z-index: 1001;">Empresa</th>
                                                <th style="background-color: white; z-index: 1001;">CNPJ</th>
                                                <th style="background-color: white; z-index: 1001;">Status (GERAL)</th>
                                                <th style="background-color: white; z-index: 1001;"></th>
                                                <th>Situação</th>
                                                <th>Carta de Distribuição?</th>
                                                <th><i class="fas fa-paper-plane fa-1x mx-1"></i> Envio Form</th>
                                                <th><i class="fas fa-file-contract fa-1x mx-1"></i> Lic. Funcionamento</th>
                                                <th><i class="fas fa-angle-left fa-1x mx-1"></i> Status</th>
                                                <th><i class="fas fa-file-contract fa-1x mx-1"></i> Lic. Sanitária</th>
                                                <th><i class="fas fa-angle-left fa-1x mx-1"></i> Status</th>
                                                <th>AFE</th>
                                                <th><i class="fas fa-file-contract fa-1x mx-1"></i> CRT</th>
                                                <th><i class="fas fa-angle-left fa-1x mx-1"></i> Status</th>
                                                <th>CBPF/C BPAD</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $query = "SELECT q.*,
                                            u.usersEmpr AS nomeEmpresa
                                            FROM qualificacao q
                                            LEFT JOIN (SELECT usersCnpj, MAX(usersEmpr) AS usersEmpr FROM users GROUP BY usersCnpj) u
                                            ON q.cnpj = u.usersCnpj;";
                                            $ret = mysqli_query($conn, $query);

                                            if ($ret) {
                                                while ($row = mysqli_fetch_array($ret)) {
                                                    $id = $row["id"];
                                                    $CNPJ = $row["cnpj"];
                                                    $empresa = $row["nomeEmpresa"];
                                                    $statusgeral = $row["statusgeral"];
                                                    $situacao = $row["situacao"];
                                                    $cartadistribuicao = $row["cartadistribuicao"];

                                                    $statusgeral = transformStatusGeralQualificacao($statusgeral);

                                                    //datas
                                                    $envioformqualificacao = $row["dataenvioformqualificacao"];
                                                    $licencafuncionamento = $row["licencafuncionamento"];
                                                    $licencasanitaria = $row["licencasanitaria"];
                                                    $crt = $row["crt"];

                                                    //outros
                                                    $afe = $row["afe"];
                                                    $cbpfcbpad = $row["cbpfcbpad"];

                                                    //statusDatas

                                                    $stLicencafuncionamento = getStatusFromData($licencafuncionamento);
                                                    $stLicencasanitaria = getStatusFromData($licencasanitaria);
                                                    $stCrt = getStatusFromData($crt);
                                            ?>
                                                    <tr>
                                                        <td style="background-color: white; z-index: 1001;">
                                                            <a href="includes/qualificacao.inc.php?dltqualificacao=<?php echo $id; ?>&empr=<?php echo $empresa; ?>">
                                                                <button class="btn text-danger" onClick="return confirm('Você realmente deseja deletar essa Empresa?');"><i class="fas fa-trash-alt"></i></button>
                                                            </a>
                                                        </td>
                                                        <td style="background-color: white; z-index: 1001;"><?php echo $empresa; ?></td>
                                                        <td style="background-color: white; z-index: 1001;"><?php echo $CNPJ; ?></td>
                                                        <td style="background-color: white; z-index: 1001; text-align: center;"><?php echo $statusgeral; ?></td>
                                                        <td style="background-color: white; z-index: 1001;">
                                                            <!-- MUDAR LINKS DOS BOTÕES AUXILIARES -->
                                                            <a href="editqualificacao?id=<?php echo hashItemNatural($id); ?>">
                                                                <button class="btn text-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                        </td>
                                                        <td><?php echo $situacao; ?></td>
                                                        <td><?php echo $cartadistribuicao; ?></td>
                                                        <td><?php echo cleanDate($envioformqualificacao); ?></td>
                                                        <td><?php echo cleanDate($licencafuncionamento); ?></td>

                                                        <td style="text-align: center;"><?php echo $stLicencafuncionamento; ?></td>
                                                        <td><?php echo cleanDate($licencasanitaria); ?></td>

                                                        <td style="text-align: center;"><?php echo $stLicencasanitaria; ?></td>
                                                        <td><?php echo $afe; ?></td>
                                                        <td><?php echo cleanDate($crt); ?></td>
                                                        <td style="text-align: center;"><?php echo $stCrt; ?></td>
                                                        <td><?php echo cleanDate($cbpfcbpad); ?></td>
                                                    </tr>
                                            <?php

                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>



                                <script>
                                    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
                                    triggerTabList.forEach(function(triggerEl) {
                                        var tabTrigger = new bootstrap.Tab(triggerEl)

                                        triggerEl.addEventListener('click', function(event) {
                                            event.preventDefault()
                                            tabTrigger.show()
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            function populate(id) {
                //Recuperar o valor do campo
                var pesquisa = id;
                console.log(pesquisa);
                if (pesquisa == "") {
                    document.getElementById("dadosCliente").classList.add("d-none");
                } else {
                    document.getElementById("dadosCliente").classList.remove("d-none");
                }

                //Verificar se há algo digitado
                if (pesquisa != '') {
                    var dados = {
                        id: pesquisa
                    }
                    $.post('pesq_idcliente.php', dados, function(retorna) {
                        // console.log(retorna);
                        //Mostra dentro da ul os resultado obtidos 
                        var array = retorna.split(',');
                        // $result = $ID . ',' . $empresa . ',' . $nomeUsuario . ',' . $cnpj . ',' . $uid . ',' . $email . ',' . $telefone . ',' . $celular . ',' . $uf . ',' . $representante . ',' . $permisao;

                        var id = array[0];
                        var empresa = array[1];
                        var nomeusuario = `${array[2]} (${array[4]})`;
                        var cnpj = array[3];
                        var email = array[5];
                        var telefone = array[6];
                        var celular = array[7];
                        var uf = array[8];
                        var representante = array[9];
                        var permisao = array[10];

                        document.getElementById("dtNomeEmpresa").innerHTML = empresa;
                        document.getElementById("dtCNPJ").innerHTML = cnpj;
                        document.getElementById("dtUsuario").innerHTML = nomeusuario;
                        document.getElementById("dtEmailEmpresa").innerHTML = email;
                        document.getElementById("post_emailempresa").value = email;
                        document.getElementById("dtTelefone").innerHTML = telefone;
                        document.getElementById("dtCelular").innerHTML = celular;
                        document.getElementById("dtUF").innerHTML = uf;
                        document.getElementById("dtRepresentante").innerHTML = representante;
                        document.getElementById("dtPermissao").innerHTML = permisao;

                    });
                }
            }
        </script>


        <!-- Modal -->
        <div class="modal fade" id="novaqualificacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Qualificação</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/qualificacao.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class="text-black" for="post_clienteId">Cliente <b class="text-danger">*</b></label>
                                    <select name="post_clienteId" class="form-control" id="post_clienteId" onchange="populate(this.value)" required>
                                        <option value="">Escolha uma Empresa</option>
                                        <?php
                                        $retUsers = mysqli_query($conn, "SELECT * FROM users WHERE usersPerm IN ('4DTB') ORDER BY usersEmpr ASC");
                                        while ($rowUsers = mysqli_fetch_array($retUsers)) {
                                        ?>
                                            <option value="<?php echo $rowUsers['usersId']; ?>"><?php echo $rowUsers['usersEmpr']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div id="dadosCliente" class="d-none">
                                <h4 class="text-muted"><b>Dados Cliente</b></h4>
                                <hr>
                                <div class="p-2 border rounded">
                                    <div class="form-row px-1">
                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtNomeEmpresa" style="color: #ee7624;"><b>Empresa</b></label>
                                            <span class="px-1" id="dtNomeEmpresa"></span>
                                        </div>

                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtCNPJ" style="color: #ee7624;"><b>CNPJ</b></label>
                                            <span class="px-1" id="dtCNPJ"></span>
                                        </div>

                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtUsuario" style="color: #ee7624;"><b>Usuário</b></label>
                                            <span class="px-1" id="dtUsuario"></span>
                                        </div>
                                    </div>

                                    <div class="form-row px-1">
                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtEmailEmpresa" style="color: #ee7624;"><b>E-mail Empresa</b></label>
                                            <span class="px-1" id="dtEmailEmpresa"></span>
                                            <input type="text" id="post_emailempresa" name="post_emailempresa" hidden>
                                        </div>


                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtTelefone" style="color: #ee7624;"><b>Telefone</b></label>
                                            <span class="px-1" id="dtTelefone"></span>
                                        </div>

                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtCelular" style="color: #ee7624;"><b>Celular</b></label>
                                            <span class="px-1" id="dtCelular"></span>
                                        </div>
                                    </div>

                                    <div class="form-row px-1">
                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtUF" style="color: #ee7624;"><b>UF</b></label>
                                            <span class="px-1" id="dtUF"></span>
                                        </div>

                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtRepresentante" style="color: #ee7624;"><b>Representante</b></label>
                                            <span class="px-1" id="dtRepresentante"></span>
                                        </div>

                                        <div class="form-group col-md d-flex" style="flex-direction: column;">
                                            <label for="dtPermissao" style="color: #ee7624;"><b>Permissao</b></label>
                                            <span class="px-1" id="dtPermissao"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-center mt-2 p-4">
                                    <p style="font-style: italic;"><b>Observação:</b> Notificação será enviado para e-mail descrito acima com o link do formulário para preenchimento. É de suma importância que o cliente preencha o exato link que está no corpo do e-mail. A qualidade será adicionado em cópia.</p>
                                </div>

                                <div class="form-row d-flex justify-content-center mt-2 py-4">
                                    <button type="submit" name="enviarform" class="btn btn-conecta">Enviar</button>
                                </div>

                            </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var table = $('#table1').DataTable({
                    responsive: true,
                    scrollCollapse: true,
                    scrollX: true,
                    fixedColumns: {
                        leftColumns: 4
                    },
                    lengthMenu: [
                        [10, 20, 40, -1],
                        [10, 20, 40, "Todos"],
                    ],
                    language: {
                        search: "Pesquisar:",
                        paginate: {
                            first: "Primeiro",
                            last: "Último",
                            next: "Próximo",
                            previous: "Anterior"
                        },
                        info: "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        lengthMenu: "Mostrar _MENU_ itens",
                        zeroRecords: "Nenhum documento encontrado"
                    },
                    order: [
                        [0, "desc"]
                    ]
                });

                new $.fn.dataTable.FixedColumns(table, {
                    leftColumns: 4
                });
            });
        </script>
        <?php include_once 'php/footer.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>