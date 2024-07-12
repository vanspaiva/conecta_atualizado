<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");

    function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }

?>
    <style>
        hr.solid {
            border-top: 3px solid #6c757d;
        }

        .offset-row-2 {
            margin-top: -20px;
            width: max-content;
            background-color: #fff;
            padding: 0px 15px;
            z-index: 1;
        }

        .line-heading {
            margin-top: 10vh;
            margin-bottom: 5vh;
        }
    </style>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar-dash.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <!--<iframe src="https://docs.google.com/viewer?embedded=true&url=https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/02/portfolio-cpmh-resumido.pdf" style="width: 100%; height: 100vh; border: none;"></iframe>-->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        <h2 class="text-conecta" style="font-weight: 400;">Materiais de <span style="font-weight: 700;">Apoio</span></h2>
                        <hr style="border-color: #ee7624;">
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="col m-3 d-flex justify-content-center">
                                    <a class="text-black" target="_blank" href="https://www.cpmhdigital.com.br/wp-content/uploads/2023/06/portfolio-cpmh-resumido.pdf">
                                        <h5><i class="bi bi-file-earmark-richtext"></i> Portfolio CPMH</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col p-3">
                        <div class="card p-4 d-flex justify-content-center shadow">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                                <?php
                                $retSlcAba = mysqli_query($conn, "SELECT * FROM abasmidias ORDER BY abmNome ASC");
                                $count = 0;
                                while ($rowSlcAba = mysqli_fetch_array($retSlcAba)) {
                                    $nm = $rowSlcAba['abmNome'];
                                    $nome = $rowSlcAba['abmNome'];
                                    $nm = strtolower(tirarAcentos($nm));
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($count == 0) {
                                                                echo 'active';
                                                            } ?> text-black px-4" id="<?php echo $nm; ?>-tab" data-toggle="tab" href="#<?php echo $nm; ?>" role="tab" aria-controls="<?php echo $nm; ?>" aria-selected="true"><?php echo $nome; ?></a>
                                    </li>
                                <?php
                                    $count++;
                                }
                                ?>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <?php
                                $retSlcAba = mysqli_query($conn, "SELECT * FROM abasmidias ORDER BY abmNome ASC");
                                $count = 0;
                                while ($rowSlcAba = mysqli_fetch_array($retSlcAba)) {
                                    $nm = $rowSlcAba['abmNome'];
                                    $nome = $rowSlcAba['abmNome'];
                                    $nm = strtolower(tirarAcentos($nm));
                                ?>

                                    <div class="tab-pane fade <?php if ($count == 0) {
                                                                    echo ' show active';
                                                                } ?>" id="<?php echo $nm; ?>" role="tabpanel" aria-labelledby="<?php echo $nm; ?>-tab">
                                        <div class="container">


                                            <?php

                                            $arraySessao = array();

                                            $retSessao = mysqli_query($conn, "SELECT * FROM sessaomidias GROUP BY ssmAba");
                                            while ($rowSessao = mysqli_fetch_array($retSessao)) {
                                                array_push($arraySessao, $rowSessao['ssmAba']);
                                            }

                                            foreach ($arraySessao as &$ss) {
                                                if ($nome == $ss) {
                                            ?>

                                                    <?php
                                                    $retSearchSessao = mysqli_query($conn, "SELECT * FROM sessaomidias WHERE ssmAba='$ss' ORDER BY ssmNome ASC;");
                                                    while ($rowSearchSessao = mysqli_fetch_array($retSearchSessao)) {
                                                        $nomeSessao = $rowSearchSessao['ssmNome'];
                                                    ?>
                                                        <div class="line-heading">
                                                            <h4 class="position-absolute offset-row-2"><i class="<?php echo $rowSearchSessao['ssmIcon']; ?>"></i> <?php echo $nomeSessao; ?></h4>
                                                            <hr class="solid">
                                                        </div>

                                                        <?php
                                                        $retMaterial = mysqli_query($conn, "SELECT * FROM materiaismidias WHERE mtmAba='$ss' AND mtmSessao='$nomeSessao' ORDER BY mtmRelevancia DESC;");
                                                        while ($rowMaterial = mysqli_fetch_array($retMaterial)) {
                                                            $titulo = $rowMaterial['mtmTitulo'];
                                                            $descricao = $rowMaterial['mtmDescricao'];
                                                            $link = $rowMaterial['mtmLink'];
                                                        ?>
                                                            <div class="row mt-3 w-100">
                                                                <div class="p-3 d-flex justify-content-start align-items-center w-100">
                                                                    <div class="col">
                                                                        <a class="text-black" target="_blank" href="<?php echo $link; ?>">
                                                                            <h5><?php echo $titulo; ?></h5>
                                                                            <small class="muted"><?php echo $descricao; ?></small>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        <?php
                                                        }
                                                        ?>

                                                    <?php
                                                    }
                                                    ?>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>

                                <?php
                                    $count++;
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>



        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>