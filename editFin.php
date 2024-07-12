<?php include("php/head_index.php");

require_once 'includes/dbh.inc.php';

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {

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
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 justify-content-start" id="titulo-pag">
                        <div class="d-flex">
                            <div class="col-sm-1"><?php include_once 'php/back.php';
                                                    define_button_color('white'); ?></div>
                            <div class="col-sm-11 pt-2 row-padding-2">
                                <div class="row px-3">
                                    <h2>Informações do Plano Financeiro</h2>
                                </div>
                            </div>
                        </div>
                        <!-- <h2>Informações do Produto</h2> -->
                        <br>
                        <div class="card">

                            <div class="card-body">
                                <?php

                                $ret = mysqli_query($conn, "SELECT * FROM planosfinanceiros WHERE finId='" . $_GET['id'] . "';");
                                while ($row = mysqli_fetch_array($ret)) { ?>
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="content-panel">
                                                        <p class="alert-warning"></p>

                                                        <form class="prodForm" action="includes/financeiro.inc.php" method="post">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="finId">Prod ID</label>
                                                                    <input type="text" class="form-control" id="finId" name="finId" value="<?php echo $row['finId']; ?>" required>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="modalidade">Modalidade</label>
                                                                    <input type="text" class="form-control" id="modalidade" name="modalidade" value="<?php echo $row['finModalidade']; ?>"  style="text-transform:uppercase" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="txtFinanceiro">Kit Dr</label>
                                                                    <textarea class="form-control" name="txtFinanceiro" id="txtFinanceiro" rows="3" required><?php echo $row['finTexto']; ?></textarea>
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


    ?>finId