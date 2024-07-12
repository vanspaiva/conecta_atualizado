<?php
session_start();
if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Adm Comercial') || ($_SESSION["userperm"] == 'Comercial')) {
    include("php/head_index.php");
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';

        require_once 'includes/dbh.inc.php';
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
                    } else if ($_GET["error"] == "atualizado") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Propostas Atualizadas!</p></div>";
                    }
                }
                ?>
            </div>

            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-conecta" style="font-weight: 400;">Representantes</h2>
                            <div class="div">
                                <!--<a href="trocarrepresentante" class="btn btn-secondary"><i class="fas fa-exchange-alt"></i> atualizar</a>-->
                                <button class="btn btn-conecta" data-toggle="modal" data-target="#adduf" style="background-color: #ee7624; color:#fff;"><i class="far fa-plus-square"></i> novo</button>
                            </div>
                        </div>
                        <hr style="border: 1px solid #ee7624">
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-10">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md">

                                            <?php
                                            $arrayRep = array();

                                            $retRep = mysqli_query($conn, "SELECT * FROM representantes GROUP BY repUid");
                                            while ($rowRep = mysqli_fetch_array($retRep)) {
                                                array_push($arrayRep, $rowRep['repUid']);
                                            }

                                            foreach ($arrayRep as &$rep) {
                                            ?>
                                                <!-- Representante -->
                                                <div class="row w-100 p-3 bg-light rounded my-4">
                                                    <div class="d-flex justify-content-between p-1 align-items-center">
                                                        <?php
                                                        //pegar nome
                                                        $retNome = mysqli_query($conn, "SELECT * FROM users WHERE usersUid = '$rep';");
                                                        while ($rowNome = mysqli_fetch_array($retNome)) {
                                                            $name = $rowNome['usersName'];
                                                        }
                                                        ?>
                                                        <h5 class="text-conecta"><?php echo $name; ?></h5>
                                                    </div>
                                                    <hr style="border-color: #ee7624;">
                                                    <div class="col p-1">
                                                        <?php
                                                        $retUF = mysqli_query($conn, "SELECT * FROM representantes WHERE repUid='$rep';");
                                                        while ($rowUF = mysqli_fetch_array($retUF)) {
                                                            if ($rowUF['repUF'] != null) {
                                                        ?>
                                                                <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowUF['repUF']; ?> <a href="manageRepresentante?id=<?php echo $rowUF['repID']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                        <?php
                                                            }
                                                        }


                                                        ?>

                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                            <!-- Modal Add UF-->
                                            <div class="modal fade" id="adduf" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Nova UF</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/addufrepresentante.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="rep">Representante</label>

                                                                        <select name="rep" class="form-control" id="rep" onchange="checkRep(this)">
                                                                            <option>Escolha um representante</option>
                                                                            <?php
                                                                            $userPermRep = '7VDN';
                                                                            $retNomeRep = mysqli_query($conn, "SELECT * FROM users WHERE usersPerm='$userPermRep';");
                                                                            while ($rowNomeRep = mysqli_fetch_array($retNomeRep)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowNomeRep['usersName']; ?>"><?php echo $rowNomeRep['usersName']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                                                                    <script>
                                                                        function checkRep(elem) {
                                                                            //Recuperar o valor do campo
                                                                            var pesquisa = elem.value;

                                                                            //Verificar se há algo digitado
                                                                            if (pesquisa != '') {
                                                                                var dados = {
                                                                                    nome: pesquisa
                                                                                }
                                                                                $.post('proc_pesq_rep.php', dados, function(retorna) {
                                                                                    //Mostra dentro da ul os resultado obtidos 
                                                                                    var array = retorna.split('/');
                                                                                    var email = array[0];
                                                                                    var fone = array[1];
                                                                                    var user = array[2];

                                                                                    document.getElementById("email").value = email;
                                                                                    document.getElementById("fone").value = fone;
                                                                                    document.getElementById("user").value = user;
                                                                                });
                                                                            }
                                                                        }
                                                                    </script>

                                                                    <div class="form-group col-md" hidden>
                                                                        <label class="text-black" for="user">Usuário</label>
                                                                        <input type="text" class="form-control" id="user" name="user" required readonly>
                                                                    </div>

                                                                    <div class="form-group col-md" >
                                                                        <label class="text-black" for="email">E-mail</label>
                                                                        <input type="email" class="form-control" id="email" name="email" required readonly>
                                                                    </div>

                                                                    <div class="form-group col-md" >
                                                                        <label class="text-black" for="fone">Fone</label>
                                                                        <input type="text" class="form-control" id="fone" name="fone" required readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="uf">UF</label>
                                                                        <select name="uf" class="form-control" id="uf" onchange="checkUF(this)">
                                                                            <option>Escolha uma UF</option>
                                                                            <?php
                                                                            $retEstados = mysqli_query($conn, "SELECT * FROM estados;");
                                                                            while ($rowEstados = mysqli_fetch_array($retEstados)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowEstados['ufAbreviacao']; ?>"><?php echo $rowEstados['ufAbreviacao']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md" >
                                                                        <label class="text-black" for="estado">Estado</label>
                                                                        <input type="text" class="form-control" id="estado" name="estado" required readonly>
                                                                    </div>
                                                                    <div class="form-group col-md" >
                                                                        <label class="text-black" for="regiao">Região</label>
                                                                        <input type="text" class="form-control" id="regiao" name="regiao" required readonly>
                                                                    </div>
                                                                </div>
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
                                                                                var nome = array[0];
                                                                                var regiao = array[1];

                                                                                document.getElementById("estado").value = nome;
                                                                                document.getElementById("regiao").value = regiao;
                                                                            });
                                                                        }
                                                                    }
                                                                </script>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="add" class="btn btn-primary">Adicionar</button>
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