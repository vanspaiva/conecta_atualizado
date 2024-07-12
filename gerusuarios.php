<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
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

                <div class="row py-4 d-flex justify-content-start">
                    <div class="col-sm justify-content-start">
                        <h2 class="text-conecta" style="font-weight: 400;">Gestão de <span style="font-weight: 700;">Usuários</span></h2>
                        <hr style="border: 1px solid #ee7624">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-head">
                                <h3 class="p-4 text-conecta">Adicionar Permissão</h3>
                                <hr>

                            </div>
                            <div class="card-body px-4">
                                <form class="p-4" action="managePermissao.php" method="POST">
                                    <div class="form-row mb-3">
                                        <label for="Usuário" class="form-label">Usuário</label>
                                        <select class="form-select" aria-label="Default select example" id="usuario" name="usuario">
                                            <option value="0">selecione um usuário</option>
                                            <?php
                                            $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersAprov = 'APROV' ORDER BY usersUid ASC;");
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $user = $row['usersUid'];
                                            ?>
                                                <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label for="Código" class="form-label">Código</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo">
                                    </div>

                                    <div class="form-row mb-3">
                                        <label for="Descrição" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao">
                                    </div>

                                    <div class="form-row mb-3 d-flex justify-content-center">

                                        <button id="salvarnovo" name="salvarnovo" type="submit" class="btn btn-primary">Salvar</button>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-head">
                                <h3 class="p-4 text-conecta">Lista de Permissões</h3>
                                <hr>
                            </div>
                            <div class="card-body">
                                <table id="usersTable" class="display table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>Usuário</th>
                                            <th>Código</th>
                                            <th>Descrição</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = mostrarTodosPermissoesExtras($conn);
                                        foreach ($ret as $key => $value) {
                                            
                                        ?>
                                            <tr>
                                                <td><?php echo $value['usuario'];; ?></td>
                                                <td><?php echo $value['permissao']; ?></td>
                                                <td><?php echo $value['descricao']; ?></td>
                                                <td>
                                                    <a href="update-permissao?id=<?php echo $value['id']; ?>">
                                                        <button class="btn text-primary btn-xs"><i class="far fa-edit"></i></button></a>
                                                    <?php if ($_SESSION["userperm"] != 'Adm Comercial') { ?>
                                                        <a href="managePermissao?id=<?php echo $value['id']; ?>">
                                                            <button class="btn text-danger btn-xs" onClick="return confirm('Você realmente deseja apagar esse usuário?');"><i class="far fa-trash-alt"></i></button></a>
                                                    <?php } ?>
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


        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable({
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
                    }
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