<?php 
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial')) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM users");
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Usuário editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário foi deletado!</p></div>";
                    } else if ($_GET["error"] == "created") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário novo criado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row p-3 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;"><span style="font-weight: 700;">Usuários</span></h2>
                            <a class="btn btn-conecta shadow" href="newuser"><i class="fas fa-plus"></i> Usuário</a>
                        </div>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="content-panel table-responsive">
                                    <table id="usersTable" class="display table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>Nome</th>
                                                <th>E-mail</th>
                                                <th>Usuário</th>
                                                <th>CPF/CNPJ</th>
                                                <th>Permissão</th>
                                                <th>Aprovação</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            while ($row = mysqli_fetch_array($ret)) {

                                                $tipoUsuario1 = '';
                                                $tipoUsuario2 = '';
                                                $userPerm = $row['usersPerm'];

                                                $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $userPerm . "';");
                                                while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
                                                    $tipoUsuario1 = $rowPerm1['tpcadexNome'];
                                                }

                                                $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $userPerm . "';");
                                                while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
                                                    $tipoUsuario2 = $rowPerm2['tpcadinNome'];
                                                }

                                                $userPerm = $tipoUsuario1 . $tipoUsuario2;


                                                if ($row['usersAprov'] == 'AGRDD') {
                                                    $aprovacao = 'Aguardando';
                                                    $aprovar = true;
                                                    $alert = 'text-warning';
                                                } else if ($row['usersAprov'] == 'APROV') {
                                                    $aprovacao = 'Aprovado';
                                                    $aprovar = false;
                                                    $alert = 'text-success';
                                                } else if ($row['usersAprov'] == 'BLOQD') {
                                                    $aprovacao = 'Bloqueado';
                                                    $aprovar = true;
                                                    $alert = 'text-danger';
                                                }

                                                $nomeCompleto = $row['usersName'];
                                                $nomeCompleto = explode(" ", $nomeCompleto);
                                                $nomeURL = $nomeCompleto[0];


                                                $emailURL = $row['usersEmail'];
                                                $usuarioURL = $row['usersUid'];
                                                $celularURL = $row['usersCel'];

                                                //resumir numero celular
                                                $celularURL = implode('', explode(' ', $celularURL));
                                                $celularURL = implode('', explode('-', $celularURL));
                                                $celularURL = implode('', explode('(', $celularURL));
                                                $celularURL = implode('', explode(')', $celularURL));
                                                $celNotification = '+55' . $celularURL;
                                                
                                                $cpf = $row["usersCpf"];
                                                $cnpj = $row["usersCnpj"];

                                                $cpfcnpj = $cnpj . $cpf;
                                                 if ($cpfcnpj == null) {
                                                    $cpfcnpj = "-";
                                                }

                                            ?>


                                                <tr>
                                                    <td><?php echo $row['usersId'];; ?></td>
                                                    <td><?php echo $row['usersName']; ?></td>
                                                    <td><?php echo $row['usersEmail']; ?></td>
                                                    <td><?php echo $row['usersUid']; ?></td>
                                                    <td><?php echo $cpfcnpj; ?></td>
                                                    <td><?php echo $userPerm; ?></td>
                                                    <!--<td><?php echo $aprovacao; ?></td>-->
                                                    <td class="d-flex justify-content-center">
                                                        <?php
                                                        if ($aprovar) {
                                                            echo '<a href="aprov-profile?id=' . $row['usersId'] . '&nome=' . $nomeURL . '&uid=' . $usuarioURL . '&email=' . $emailURL . '&celular=' . $celNotification . '"> <button class="btn ' . $alert . ' btn-xs"><i class="fas fa-clock"></i></button></a>';
                                                        } else {
                                                            echo '<button class="btn ' . $alert . ' btn-xs"><i class="fas fa-check"></i></button>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>

                                                        <a href="update-profile?id=<?php echo $row['usersId']; ?>">
                                                            <button class="btn text-primary btn-xs"><i class="far fa-edit"></i></button></a>
                                                        <?php if(($_SESSION["userperm"] != 'Adm Comercial') && ($_SESSION["userperm"] != 'Comercial')){?>
                                                        <a href="manageUsers?id=<?php echo $row['usersId']; ?>">
                                                            <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja apagar esse usuário?');"><i class="far fa-trash-alt"></i></button></a>
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                            <?php
                                               
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable({
                    "lengthMenu": [
                        [10, 20, 40, 80, -1],
                        [10, 20, 40, 80, "Todos"],
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
                        "zeroRecords": "Nenhum usuário encontrado"
                    },
                    "order": [
                        [0, "desc"]
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