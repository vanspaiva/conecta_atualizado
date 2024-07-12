<?php
session_start();
if (isset($_GET["id"])) {
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

        $id = addslashes($_GET['id']);
?>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';
            ?>

            <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
            <div id="main" class="font-montserrat">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmtfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                        } else if ($_GET["error"] == "none") {
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Setor editado com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center py-4">
                        <div class="col-sm-6 justify-content-start">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-center' id='back'>
                                        <button class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm pt-2">
                                    <div>
                                        <h2 class="text-conecta" style="font-weight: 400;">Informações do <span style="font-weight: 700;">Setor</span></h2>
                                        <p class="text-muted">Edite as informações do setor</p>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-color: #ee7624;">
                            <!-- <h2>Informações do Produto</h2> -->
                            <br>
                            <div class="card shadow">

                                <div class="card-body">
                                    <?php

                                    $ret = mysqli_query($conn, "SELECT * FROM setores WHERE setId='" . $id . "';");
                                    while ($row = mysqli_fetch_array($ret)) { ?>
                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="content-panel">
                                                            <p class="alert-warning"></p>

                                                            <form class="prodForm" action="includes/setor.inc.php" method="post">
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="setId">Setor ID</label>
                                                                        <input type="text" class="form-cntrol" id="setId" name="setId" value="<?php echo $row['setId']; ?>" required>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['setNome']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                                                                </div>
                                                            </form>
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