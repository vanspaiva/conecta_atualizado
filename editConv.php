<?php
session_start();
if (isset($_GET["id"])) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
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
                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Convenio editado com sucesso!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="row row-3">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 justify-content-start" id="titulo-pag">
                            <div class="d-flex">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2 row-padding-2">
                                    <div class="row px-3">
                                        <h2>Informações do Convênio</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- <h2>Informações do Produto</h2> -->
                            <br>
                            <div class="card">

                                <div class="card-body">
                                    <?php

                                    $ret = mysqli_query($conn, "SELECT * FROM convenios WHERE convId='" . $id . "';");
                                    while ($row = mysqli_fetch_array($ret)) { ?>
                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="content-panel">
                                                            <p class="alert-warning"></p>

                                                            <form class="prodForm" action="includes/convenio.inc.php" method="post">
                                                                <div class="form-row" hidden>
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="convId">Convênio ID</label>
                                                                        <input type="text" class="form-cntrol" id="convId" name="convId" value="<?php echo $row['convId']; ?>" required>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['convName']; ?>" style="text-transform:uppercase" required>
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
                        <div class="col-sm-3"></div>

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