<?php
session_start();
if (!empty($_GET)) {
    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Planejador(a)')) || (($_SESSION["userperm"] == 'Planej. Ortognática')) || ($_SESSION["userperm"] == 'Administrador'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';

        $idPerm = addslashes($_GET['id']);

?>
        <!-- Add jQuery 1.8 or later to your page, 33 KB -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Get Fotorama from CDNJS, 19 KB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>


        <body class="bg-light-gray2">
            <style>
                .pointer:hover {
                    cursor: pointer;
                }

                .thumbnail {
                    position: relative;
                    width: 300px;
                    height: 300px;
                    border-radius: 10px;
                    overflow: hidden;
                }

                .thumbnail img {
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    height: 100%;
                    width: auto;
                    -webkit-transform: translate(-50%, -50%);
                    -ms-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);
                }

                .thumbnail img.portrait {
                    width: 100%;
                    height: auto;
                }

                .box-overall1,
                .box-overall2 {
                    z-index: 999;
                    background-color: #48484838;
                    position: absolute;

                }

                .change-color-on-hover:hover {
                    color: #323236 !important;
                }
            </style>

            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $ret = mostrarEspecificosPermissoesExtras($conn, $idPerm);

            foreach ($ret as $key => $value) {
                $user1 = $ret['usuario'];
                $codigo = $ret['permissao'];
                $descricao = $ret['descricao'];
                $id = $ret['id'];
            }
            ?>

            <div id="main" class="font-montserrat">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        } else if ($_GET["error"] == "deleted") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Item excluido da proposta!</p></div>";
                        } else if ($_GET["error"] == "pastacriada") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Pasta da proposta criada!</p></div>";
                        }
                    }
                    ?>
                </div>

                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm">
                            <div class="row d-flex justify-content-center">
                                <div class="col d-flex justify-content-center">
                                    <div class="col-md-3">
                                        <div class="card shadow mr-1 my-2 rounded w-100 p-2" style="border-top: #ee7624 7px solid;">
                                            <div class="card-body container-fluid">
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
                                                                <option value="<?php echo $user; ?>" <?php if ($user == $user1) echo ' selected="selected"'; ?>><?php echo $user; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-row mb-3">
                                                        <label for="ID" class="form-label">ID</label>
                                                        <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
                                                    </div>

                                                    <div class="form-row mb-3">
                                                        <label for="Código" class="form-label">Código</label>
                                                        <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo; ?>">
                                                    </div>

                                                    <div class="form-row mb-3">
                                                        <label for="Descrição" class="form-label">Descrição</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $descricao; ?>">
                                                    </div>

                                                    <div class="form-row mb-3 d-flex justify-content-center">

                                                        <button id="update" name="update" type="submit" class="btn btn-primary">Salvar</button>
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

            </div>

            </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="js/standart.js"></script>

        </body>

        </html>


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