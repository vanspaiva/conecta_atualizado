<?php
session_start();
if (!empty($_GET)) {
    if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Planejador(a)') || ($_SESSION["userperm"] == 'Planej. Ortognática'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

        $id = addslashes($_GET['id']);
?>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $ret = mysqli_query($conn, "SELECT * FROM agenda WHERE agdId='" . $id . "';");
            while ($row = mysqli_fetch_array($ret)) {
                $idAgenda = $row['agdNumPedRef'];
                $dataBD = $row['agdData'];
                $dataBD = explode("-", $dataBD);
                $dataEscolhida = $dataBD[2] . '/' . $dataBD[1] . '/' . $dataBD[0];
            ?>



                <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
                <div id="main" class="font-montserrat">
                    <div>
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "stmfailed") {
                                echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="container-fluid">
                        <div class="row py-4 d-flex justify-content-center">

                            <div class="col-sm-8 justify-content-start" id="titulo-pag">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <a class='button-back p-0 m-0 pt-2' style="color: #ee7624;" type='button' href="gerenciamento-agenda"><i class='fas fa-chevron-left fa-2x'></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3">
                                            <h2 class="text-conecta" style="font-weight: 400;">Informações da <span style="font-weight: 700;">Video <?php if ($idAgenda != null) {
                                                                                                                                                        echo ' - ' . $idAgenda;
                                                                                                                                                    } ?></span></h2>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #ee7624">
                                <br>
                                <div class="card shadow">

                                    <div class="card-body">

                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="content-panel">
                                                            <form class="form-horizontal style-form" name="form1" action="includes/updateagenda.inc.php" method="post">
                                                                <div class="p-3">
                                                                    <h4 class="text-black"><?php echo $row['agdTipo']; ?> <?php if ($row['agdNumPedRef'] != null) {
                                                                                                                                echo ' - ' . $row['agdNumPedRef'];
                                                                                                                            } ?></h4>
                                                                    <hr style="border-bottom:1px solid #a1a1a1;">
                                                                    <div class="row">
                                                                        <p class="col">
                                                                            <span class="text-black"><i class="far fa-calendar-alt"></i> <b> Data:</b> <?php echo $dataEscolhida; ?></span>
                                                                        </p>
                                                                        <p class="col">
                                                                            <span class="text-black"><i class="far fa-clock"></i> <b> Hora:</b> <?php echo $row['agdHora']; ?></span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <p>Dr: <?php echo $row['agdNomeDr']; ?></p>
                                                                            <p>Pac: <?php echo $row['agdNomPac']; ?></p>
                                                                        </div>
                                                                        <p class="col">Produto: <?php echo $row['agdProd']; ?></p>
                                                                    </div>
                                                                    <?php
                                                                    if ($row['agdObs'] != null) {
                                                                    ?>
                                                                        <div class="row flex-column px-2">
                                                                            <h6 class="text-black">Observações</h6>

                                                                            <p><?php echo $row['agdObs']; ?></p>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                    <hr style="border-bottom:1px solid #a1a1a1;">

                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="agdId">ID Agenda </label>
                                                                        <input type="number" class="form-control" id="agdId" name="agdId" value="<?php echo $row['agdId']; ?>" required readonly>
                                                                        <small class="text-muted">ID não é editável</small>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="form-label text-black" for="status">Status</label>
                                                                        <select name="status" class="form-control" id="status">
                                                                            <option>Escolha uma opção</option>
                                                                            <?php
                                                                            $retStatus = mysqli_query($conn, "SELECT * FROM statusagenda ORDER BY statusagendaNome ASC");
                                                                            while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowStatus['statusagendaNome']; ?>" <?php if ($row['agdStatusVideo'] == $rowStatus['statusagendaNome']) echo ' selected="selected"'; ?>><?php echo $rowStatus['statusagendaNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="feedback">Feedback Pós Vídeo</label>
                                                                        <select name="feedback" class="form-control" id="feedback">
                                                                            <option>Escolha uma opção</option>
                                                                            <?php
                                                                            $retFeedback = mysqli_query($conn, "SELECT * FROM feedbackagenda ORDER BY feedbackagendaNome ASC");
                                                                            while ($rowFeedback = mysqli_fetch_array($retFeedback)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowFeedback['feedbackagendaNome']; ?>" <?php if ($row['agdFeedback'] == $rowFeedback['feedbackagendaNome']) echo ' selected="selected"'; ?>><?php echo $rowFeedback['feedbackagendaNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md">
                                                                        <label class="form-label text-black" for="responsavel">Responsável pela Vídeo</label>
                                                                        <select name="responsavel" class="form-control" id="responsavel">
                                                                            <option>Escolha uma opção</option>
                                                                            <?php
                                                                            $retResponsavel = mysqli_query($conn, "SELECT * FROM responsavelagenda ORDER BY responsavelagendaNome ASC");
                                                                            while ($rowResponsavel = mysqli_fetch_array($retResponsavel)) {
                                                                            ?>
                                                                                <option value="<?php echo $rowResponsavel['responsavelagendaNome']; ?>" <?php if ($row['agdResponsavel'] == $rowResponsavel['responsavelagendaNome']) echo ' selected="selected"'; ?>><?php echo $rowResponsavel['responsavelagendaNome']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex justify-content-center">
                                                                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        <?php } ?>
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