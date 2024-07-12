<?php
session_start();

if (isset($_GET["id"])) {

    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Representante')) || ($_SESSION["userperm"] == 'Administrador'))) {
        include("php/head_index.php");
        require_once 'includes/dbh.inc.php';

        $id = addslashes($_GET['id']);
?>


        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar-dash.php';
            include_once 'php/lateral-nav.php';

            $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedId='" . $id . "';");
            while ($row = mysqli_fetch_array($ret)) {

                $numFluxo = $row['pedPosicaoFluxo'];
                $numFluxo = intval($numFluxo);
                $numFluxo = $numFluxo * 20;

                $andamento = $row['pedStatus'];

                switch ($andamento) {
                    case 'CRIADO':
                        $nomeFluxo = 'Pedido Criado';
                        break;
                    case 'PLAN':
                        $nomeFluxo = 'Planejamento';
                        break;
                    case 'VIDEO':
                        $nomeFluxo = 'Aguardando Vídeo';
                        break;
                    case 'ACEITE':
                        $nomeFluxo = 'Aguardando Aceite';
                        break;
                    case 'PROD':
                        $nomeFluxo = 'Em Produção';
                        break;
                    case 'ENVIADO':
                        $nomeFluxo = 'Pedido Enviado';
                        break;

                    default:
                        $nomeFluxo = '';
                        break;
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
                            }
                        }
                        ?>
                    </div>
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-10 " id="titulo-pag">
                                <div class="d-flex">
                                    <div class="col-sm-1">
                                        <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                            <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-11 pt-2 row-padding-2">
                                        <div class="row px-3" style="color: #fff">
                                            <h2>Informações do Pedido - <?php echo $_GET['id'] ?> </h2>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="card">

                                    <div class="card-body">

                                        <section id="main-content">
                                            <section class="wrapper">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="content-panel">
                                                            <form class="form-horizontal style-form" name="form1">
                                                                <div class="form-row p-2 mb-2 border border-secondary" style="padding-top: 10px; border-radius: 8px">
                                                                    <div class="container">
                                                                        <div class="row d-flex justify-content-center">
                                                                            <h4 style="text-align: center;">Fluxo</h4>
                                                                        </div>
                                                                        <div class="row d-flex justify-content-center">
                                                                            <div class="col-md d-flex justify-content-center">
                                                                                <p class="mt-2"><span class="badge bg-secondary" style="color: #ffffff;"><?php echo $nomeFluxo; ?></span></p>
                                                                            </div>
                                                                            <div class="col-md py-2">
                                                                                <div class="progress">
                                                                                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: <?php echo $numFluxo; ?>%" aria-valuenow="<?php echo $numFluxo; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <h6 class="form-label text-black" for="nomedr">Dr(a)</h6>
                                                                        <p><?php echo $row['pedNomeDr']; ?></p>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <h6 class="form-label text-black" for="nomepac">Paciente</h6>
                                                                        <p><?php echo $row['pedNomePac']; ?></p>
                                                                    </div>

                                                                    <div class="form-group col-md">
                                                                        <h6 class="form-label text-black" for="representante">Representante</h6>
                                                                        <p><?php echo $row['pedRep']; ?></p>
                                                                    </div>

                                                                    <div class="form-group col-md">
                                                                        <h6 class="form-label text-black" for="representante">N° Pedido</h6>
                                                                        <p><?php echo $row['pedNumPedido']; ?></p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md p-2" style="border: 1px solid #ee7624; border-radius: 10px;">
                                                                        <h5 class="form-label text-black d-flex justify-content-center" for="tipoProd"><b>Produto</b></h6>
                                                                            <p class="d-flex justify-content-center" style="color: #ee7624;"><b><?php echo $row['pedTipoProduto']; ?></b></p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col"><b>Cdg</b></th>
                                                                                <th scope="col"><b>Descrição</b></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $lista = $row['pedProduto'];
                                                                            $itens = explode('/', $lista);

                                                                            foreach ($itens as &$item) {
                                                                                $retItens = mysqli_query($conn, "SELECT * FROM produtos WHERE prodCodCallisto='" . $item . "';");
                                                                                while ($rowItens = mysqli_fetch_array($retItens)) {
                                                                            ?>
                                                                                    <tr>
                                                                                        <td><?php echo $rowItens['prodCodCallisto']; ?></td>
                                                                                        <td><?php echo $rowItens['prodDescricao']; ?></td>
                                                                                    </tr>
                                                                            <?php

                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <hr>


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