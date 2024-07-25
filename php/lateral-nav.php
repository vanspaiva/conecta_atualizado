<style>
    .btn-link-conecta {
        font-weight: 400;
        color: var(--orange);
        text-decoration: none;
        background-color: transparent;
    }

    .btn-link-conecta:hover {
        color: var(--orange);
        text-decoration: underline;
    }

    .btn-link-conecta:focus,
    .btn-conecta.focus {
        text-decoration: underline;
    }

    .btn-link-conecta:disabled {
        color: #947a72;
        pointer-events: none;
    }

    details summary::-webkit-details-marker,
    details summary::marker {
        display: none;
        content: "";
    }

    Plan a {
        font-size: small !important;
    }

    .flag {
        transform: scale(0.8);
        transition: ease all 0.4s;
    }

    .flag:hover {
        transform: scale(1);
    }
</style>

<div id="mySidenav" class="sidenav shadow font-montserrat" style="z-index: 1030;">
    <div class="container-fluid">
        <div class="row text-center mt-5">
            <a href="javascript:void(10)" class="closebtn mt-5 pt-3" onclick="closeNav()" style="font-weight: 700; color: #ee7624; font-size: 10pt;">
                x
            </a>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-around align-items-center">
                <span class="bg-orange-conecta p-1 mx-2" style="border-radius: 5px;"> <?php include_once("assets/img/favicon-conecta-bigger.svg") ?></span>
                <div>
                    <small class="p-0" style="font-weight: 700; color: #ee7624; font-size: 10pt;">Portal Conecta</small>
                    <br>
                    <small style="font-weight: 400; color: silver;">Powered by CPMH</small>
                </div>
            </div>
        </div>

    </div>
    <div class="">
        <div class="row" id="user-box">
            <?php
            require_once 'includes/dbh.inc.php';
            $user = $_SESSION["useruid"];
            ?>
            <div class="col d-flex justify-content-center py-2">
                <?php
                if (isset($_SESSION["useruid"])) {
                    //echo "<h5 style='color: #373342;'>" .  $_SESSION["userfirstname"] . "</h5>";
                    echo "<span class='badge badge-gray'>" . $_SESSION["userperm"] . "</span>";
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Use CSS to replace link text with flag icons -->
    <ul class="translation-links d-flex justify-content-around align-items-center p-1 mt-2" style="width: 100%; background-color: #f0f1f3;">
        <li><button class="lang-en lang-select px-2 btn flag" style="border: 0px !important;" id="btnEn"><img alt="United States" src="https://img.icons8.com/color/48/null/usa-circular.png" style="width: auto; height: 30px; border: 0px; outline: none;" /></button></li>
        <li><button class="lang-es lang-select px-2 btn flag" style="border: 0px !important;" id="btnEs"><img alt="Espanha" src="https://img.icons8.com/color/48/null/spain2-circular.png" style="width: auto; height: 30px; border: 0px; outline: none;" /></button></li>
        <li><button class="lang-pt lang-select px-2 btn flag" style="border: 0px !important;" id="btnPt"><img alt="Brazil" src="https://img.icons8.com/color/48/null/brazil-circular.png" style="width: auto; height: 30px; border: 0px; outline: none;" /></button></li>
        <li><button class="lang-fr lang-select px-2 btn flag" style="border: 0px !important;" id="btnFr"><img alt="França" src="https://img.icons8.com/color/48/null/france-circular.png" style="width: auto; height: 30px; border: 0px; outline: none;" /></button></li>
    </ul>

    <a href="index"> <i class="fas fa-home fa-1x"></i> Início</a>
    <a href="perfil"> <i class="far fa-id-badge"></i> Meu Perfil</a>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    ?>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-user-lock"></i> <b> Adm</b></span>
            </summary>
            <div>
                <a href='users'> <i class='fas fa-user fa-1x'></i> Usuários</a>
                <a href='mudarsenha'> <i class="fas fa-unlock-alt fa-1x mr-1"></i> Mudar Senha</a>
                <a href='adicionarlink'> <i class="fas fa-link fa-1x mr-1"></i> Add Link Drive</a>
                <a href='representantes'> <i class='fas fa-user-tie fa-1x mr-1'></i> Representantes</a>
                <a href="confereaceiteprop"><i class="fa-solid fa-award fa-1x mr-1"></i> Aceite Prop</a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x mr-1'></i> Histórico de Pedidos</a>
                <a href='mudarpedido'> <i class="fas fa-sync-alt fa-1x mr-1"></i> Mudar Nº Pedido</a>
                <a href="userdados"> <i class="fas fa-address-book fa-1x mr-1"></i> Dados Dr(a)</a>
                <a href='usuariosrepresentante'> <i class='fas fa-bookmark fa-1x'></i> Clientes</a>
                <a href='setores'> <i class='fas fa-house-user fa-1x'></i> Setores</a>
                <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
                <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>
                <a href='gersuporte'><i class='fas fa-list fa-1x'></i> Gerenciamento Suporte</a>
                <a href='gernotificacoes'> <i class='fas fa-bell fa-1x'></i> Notificações </a>
                <!-- <a href='emails'> <i class='fas fa-envelope-open-text fa-1x'></i> Caixa de Envios </a> -->
                <a href='gerusuarios'><i class="fas fa-user-shield"></i> Gestão de Usuários</a>
                <a href='gercadastro'><i class='fas fa-cog fa-1x'></i> Config. de Cadastro</a>
                <a href='gercomercial'><i class='fas fa-cog fa-1x'></i> Config. de Propostas</a>
                <a href='gerpedido'><i class='fas fa-cog fa-1x'></i> Config. de Pedidos</a>
                <a href='gerfinanceiro'><i class='fas fa-cog fa-1x'></i> Configurações Financeiro</a>
                <a href='logatividades'> <i class='fas fa-history fa-1x'></i> Log Atividades</a>
                <a href='logatividadesped'> <i class='fas fa-history fa-1x'></i> Log Pedidos</a>
                <a href='bi'><i class="bi bi-file-bar-graph"></i> BI</a>
            </div>
        </details>


        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-shopping-cart"></i> <b> Comercial</b></span>
            </summary>
            <div>
                <a href='comercial'> <i class='fas fa-clipboard-list fa-1x'></i> Propostas</a>
                <a href='pedidosantecipacao'><i class='fas fa-shipping-fast fa-1x'></i> Pedidos de Antecipação</a>
                <a href='produtos'> <i class='fas fa-boxes fa-1x'></i> Produtos</a>
                <a href='imagens-produtos'> <i class='far fa-image fa-1x'></i> Imagens dos Produtos</a>
                <a href='relatorios'><i class='fas fa-chart-line fa-1x'></i> Relatórios Comercial</a>
                <a href='convenios'><i class='fas fa-university fa-1x'></i> Convênios</a>
                <!--<a href='bi'><i class="bi bi-file-bar-graph"></i> BI</a>-->
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-desktop"></i> <b> Planejamento</b></span>
            </summary>
            <div>
                <a href='planejamento'> <i class='fas fa-clipboard-list fa-1x'></i> Análises de TC</a>
                <a href='casos'><i class='bi bi-collection fa-1x'></i> Casos</a>
                <a href='tecnicos'><i class="fas fa-user-astronaut fa-1x"></i> Técnicos</a>
                <a href='quadrotecnicos'><i class="fas fa-th fa-1x"></i> Quadro de Técnicos</a>
                <!--<a href='lista-casos'><i class='fas fa-list fa-1x'></i> Gerenciamento de Casos</a>-->
                <!-- //aparece so pra tecnico -->
                <a href='minhaagenda'><i class="fas fa-map-marked fa-1x"></i> Agenda Geral Téc.</a>
                <a href='relatorioplan'><i class='fas fa-chart-line fa-1x'></i> Relatórios Planejamento</a>
            </div>
        </details>


        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-award"></i> <b> Qualidade</b></span>
            </summary>
            <div>
                <a href='escolhaqualidade'> <i class='fas fa-clipboard-list fa-1x'></i> Prop./Ped.</a>
                <a href='conferenciaaceite'> <i class='fas fa-history fa-1x'></i> Histórico de Aceites</a>
                <a href='qualificacaocliente'> <i class="fas fa-flag"></i> Qualificação Cliente</a>
                <a href='laudos'> <i class="fas fa-file-contract fa-1x"></i> Laudos Tomograficos</a>
                <a href='documentos'> <i class="fas fa-file-alt fa-1x"></i> Documentos Anvisa</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-money-check-alt"></i> <b> Financeiro</b></span>
            </summary>
            <div>
                <a href='aceitesfinanceiros'><i class='fas fa-university fa-1x'></i> Aceites Propostas</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-bullhorn"></i> <b> Marketing</b></span>
            </summary>
            <div>
                <a href='cadastromidias'><i class='fas fa-photo-video fa-1x'></i> Cadastro de Mídias</a>
                <a href='certificados'><i class="bi bi-patch-check"></i> Certificados</a>
            </div>
        </details>

        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-caret-down"></i> <b> Representante</b></span>
            </summary>
            <div>
                <a href='solicitacoesrep'> <i class='fas fa-clipboard-list fa-1x'></i> Solicitações Clientes </a>
                <a href='usuariosrepresentante'> <i class='fas fa-bookmark fa-1x'></i> Lista Clientes</a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-link"></i> <b> Outros Links</b></span>
            </summary>
            <div>
                <a href='dadosproduto'> <i class='fas fa-clipboard-list fa-1x'></i> Formulários </a>
                <a href='materiais'> <i class='fas fa-photo-video fa-1x'></i> Materiais de Apoio </a>
                <a href='tecnicacir'> <i class='fas fa-microscope fa-1x'></i> Técnica Cirúrgica </a>
                <a href='sac'> <i class='fas fa-comments fa-1x'></i> SAC </a>
                <a href='https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda' target='_blank'> <i class='fas fa-hands-helping fa-1x'></i> Suporte </a>
                <a href='visitafabrica'> <i class='fas fa-map-marker-alt fa-1x'></i> Visita a Fábrica </a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Comercial')) {
    ?>
        <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
        <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-shopping-cart"></i> <b> Comercial</b></span>
            </summary>
            <div>
                <a href='comercial'> <i class='fas fa-clipboard-list fa-1x'></i> Propostas </a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
                <a href='mudarpedido'> <i class="fas fa-sync-alt fa-1x mr-1"></i> Mudar Nº Pedido</a>
                <a href='pedidosantecipacao'><i class='fas fa-shipping-fast fa-1x'></i> Pedidos de Antecipação</a>
                <a href='produtos'> <i class='fas fa-boxes fa-1x'></i> Produtos</a>
                <a href='imagens-produtos'> <i class='far fa-image fa-1x'></i> Imagens dos Produtos</a>
                <a href='relatorios'><i class='fas fa-chart-line fa-1x'></i> Relatórios</a>
                <a href='convenios'><i class='fas fa-university fa-1x'></i> Convênios</a>
                <!--<a href='bi'><i class="bi bi-file-bar-graph"></i> BI</a>-->
            </div>
        </details>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Adm Comercial')) {
    ?>


        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-caret-down"></i> <i class="fas fa-user-lock"></i> <b> Adm</b></span>
            </summary>
            <div>
                <a href='users'> <i class='fas fa-user fa-1x'></i> Usuários</a>
                <a href='mudarsenha'> <i class="fas fa-unlock-alt fa-1x mr-1"></i> Mudar Senha</a>
                <a href='representantes'> <i class='fas fa-user-tie fa-1x'></i> Representantes</a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
                <a href='mudarpedido'> <i class="fas fa-sync-alt fa-1x mr-1"></i> Mudar Nº Pedido</a>
                <a href='gercomercial'><i class='fas fa-cog fa-1x'></i> Config. de Propostas</a>
                <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
                <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>
            </div>
        </details>


        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>


    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Representante')) {
    ?>
        <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
        <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-caret-down"></i> <b> Representante</b></span>
            </summary>
            <div>
                <a href='solicitacoes'> <i class='fas fa-clipboard-list fa-1x'></i> Solicitações Clientes </a>
                <a href='usuariosrepresentante'> <i class='fas fa-bookmark fa-1x'></i> Lista Clientes</a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-link"></i> <b> Outros Links</b></span>
            </summary>
            <div>
                <a href='dadosproduto'> <i class='fas fa-clipboard-list fa-1x'></i> Formulários </a>
                <a href='materiais'> <i class='fas fa-photo-video fa-1x'></i> Materiais de Apoio </a>
                <a href='tecnicacir'> <i class='fas fa-microscope fa-1x'></i> Técnica Cirúrgica </a>
                <a href='sac'> <i class='fas fa-comments fa-1x'></i> SAC </a>
                <a href='https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda' target='_blank'> <i class='fas fa-hands-helping fa-1x'></i> Suporte </a>
                <a href='visitafabrica'> <i class='fas fa-map-marker-alt fa-1x'></i> Visita a Fábrica </a>
            </div>
        </details>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Analista Dados')) {
    ?>
        <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
        <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-chart-line"></i> <b> Análise</b></span>
            </summary>
            <div>
                <a href='solicitacoes'> <i class='fas fa-clipboard-list fa-1x'></i> Solicitações Clientes </a>
                <a href='usuariosrepresentante'> <i class='fas fa-bookmark fa-1x'></i> Lista Clientes</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-link"></i> <b> Outros Links</b></span>
            </summary>
            <div>
                <a href='dadosproduto'> <i class='fas fa-clipboard-list fa-1x'></i> Formulários </a>
                <a href='materiais'> <i class='fas fa-photo-video fa-1x'></i> Materiais de Apoio </a>
                <a href='tecnicacir'> <i class='fas fa-microscope fa-1x'></i> Técnica Cirúrgica </a>
                <a href='sac'> <i class='fas fa-comments fa-1x'></i> SAC </a>
                <a href='https://api.whatsapp.com/send?phone=5561999468880&text=Ol%C3%A1!%20Vim%20do%20Conecta%202.0%2C%20estou%20precisando%20de%20ajuda' target='_blank'> <i class='fas fa-hands-helping fa-1x'></i> Suporte </a>
                <a href='visitafabrica'> <i class='fas fa-map-marker-alt fa-1x'></i> Visita a Fábrica </a>
            </div>
        </details>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Planejador(a)') || $_SESSION["useruid"] == "lenicomercial" || $_SESSION["useruid"] == "lenirodrigues" || $_SESSION["useruid"] == "thaissa" || $_SESSION["useruid"] == "samuel900") {
    ?>
        <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
        <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-desktop"></i> <b> Planejamento</b></span>
            </summary>
            <div>
                <?php
                if ($_SESSION["useruid"] == "rayana.ketlen") {
                ?>
                    <a href="userdados"> <i class="fas fa-address-book fa-1x mr-1"></i> Dados Dr(a)</a>
                <?php
                }
                ?>
                <a href='planejamento'> <i class='fas fa-clipboard-list fa-1x'></i> Análises de TC</a>
                <a href='casos'><i class='bi bi-collection fa-1x'></i> Casos</a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
                <a href='quadrotecnicos'><i class="fas fa-th fa-1x"></i> Quadro de Técnicos</a>
                <!-- <a href='gerenciamento-agenda'><i class='fas fa-calendar-alt fa-1x'></i> Gerenciamento de Agenda</a> -->


                <?php
                $userAtual = $_SESSION["useruid"];
                $ret = mysqli_query($conn, "SELECT * FROM responsavelagenda WHERE responsavelagendaNome='$userAtual';");

                if (($ret) && ($ret->num_rows != 0)) { ?>
                    <a href='minhaagenda'><i class="fas fa-map-marked fa-1x"></i> Minha Agenda</a>
                <?php
                }
                ?>
            </div>
        </details>


        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Qualidade')) { ?>
        <a href='suporteconecta'> <i class='fas fa-question-circle fa-1x'></i> Suporte Conecta</a>
        <a href='forumsuporte'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-award"></i> <b> Qualidade</b></span>
            </summary>
            <div>
                <a href='escolhaqualidade'> <i class='fas fa-clipboard-list fa-1x'></i> Prop./Ped.</a>
                <a href="confereaceiteprop"><i class="fa-solid fa-award fa-1x mr-1"></i> 1 - Aceite Prop</a>
                <a href='conferenciaaceite'> <i class="fa-solid fa-award fa-1x mr-1"></i> 2 - Aceite Ped </a>
                <a href='produtos'> <i class='fas fa-boxes fa-1x'></i> Produtos</a>
                <a href='qualificacaocliente'> <i class="fas fa-flag"></i> Qualificação Cliente</a>
                <a href='laudos'> <i class="fas fa-file-contract fa-1x"></i> Laudos Tomograficos</a>
                <a href='documentos'> <i class="fas fa-file-alt fa-1x"></i> Documentos Anvisa</a>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
            </div>
        </details>


        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Distribuidor(a)')) {
    ?>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-caret-down"></i> <b> Dist. Adm</b></span>
            </summary>
            <div>
                <a href='meususuarios'> <i class='fas fa-user fa-1x'></i> Usuários</a>
                <a href='meusdoutores'> <i class='fas fa-user-tie fa-1x'></i> Doutores</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Financeiro')) {
    ?>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-money-check-alt"></i> <b> Financeiro</b></span>
            </summary>
            <div>
                <a href='aceitesfinanceiros'><i class='fas fa-university fa-1x'></i> Aceites Propostas</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Marketing')) {
    ?>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-bullhorn"></i> <b> Marketing</b></span>
            </summary>
            <div>
                <a href='cadastromidias'><i class='fas fa-photo-video fa-1x'></i> Cadastro de Mídias</a>
                <a href='certificados'><i class="bi bi-patch-check"></i> Certificados</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Fábrica')) {
    ?>
        <!--<hr style="border-color: #ee7624; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #ee7624; font-size: 10pt;' class="px-3"> <i class="fas fa-industry"></i> <b> Fábrica </b></span>
            </summary>
            <div>
                <a href='historicopedido'> <i class='fas fa-history fa-1x'></i> Histórico de Pedidos</a>
                <a href='materiais'><i class='fas fa-photo-video fa-1x'></i> Materiais de Apoio</a>
            </div>
        </details>

        <!--<hr style="border-color: #ee7624; width: 100px;">-->

    <?php
    }
    ?>

    <?php
    if ((isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Doutor(a)')) || ($_SESSION["userperm"] == 'Distribuidor(a)') || ($_SESSION["userperm"] == 'Clínica') || ($_SESSION["userperm"] == 'Residente') || ($_SESSION["userperm"] == 'Paciente') || ($_SESSION["userperm"] == 'Dist. Comercial'))) {
    ?>
        <a href='minhassolicitacoes'> <i class='fas fa-clipboard-list fa-1x'></i> Minhas Solicitações</a>

        <?php
        $userAtual = $_SESSION["useruid"];
        $statuPed = 'PEDIDO';
        $retCasos = mysqli_query($conn, "SELECT * FROM propostas WHERE propStatus='$statuPed' AND propUserCriacao='$userAtual' OR propDrUid='$userAtual';");

        if (($retCasos) && ($retCasos->num_rows != 0)) { ?>
            <a href='meuscasos'> <i class='bi bi-collection fa-1x'></i> Meus Casos</a>
        <?php
        }
        ?>

        <a href='financeiro'><i class='fas fa-university fa-1x'></i> Financeiro</a>
        <a href='antecipacao'><i class='fas fa-shipping-fast fa-1x'></i> Antecipação</a>



        <!--<hr style="border-color: #ee7624; width: 100px;">-->
    <?php
    }
    ?>


    <a href="includes/logout.inc.php" style="bottom: 0; position: relative;" class="sairbtn"><i class="fas fa-sign-out-alt"></i> Sair</a>




</div>

<!-- Code provided by Google -->
<div id="google_translate_element" class="d-none"></div>
<script type="text/javascript">
    function googleTranslateElementInit() {
        return new google.translate.TranslateElement({
            pageLanguage: 'pt',
            includedLanguages: 'en,pt,es,fr',
            layout: google.translate.TranslateElement.InlineLayout,
            autoDisplay: false,
        }, "google_translate_element"); //remove the layout
    }

    function setLanguage(lang) {
        var languageSelect = document.querySelector('.goog-te-combo')

        // Define o novo idioma selecionado
        var options = languageSelect.options
        for (var i = 0; i < options.length; i++) {
            if (options[i].value == lang) {
                languageSelect.selectedIndex = i;
                languageSelect.dispatchEvent(new Event('change'));
                break;
            }
        }


    }

    document.getElementById("btnPt").addEventListener("click", function() {
        setLanguage('pt');
    });

    document.getElementById("btnEn").addEventListener("click", function() {
        setLanguage('en');
    });

    document.getElementById("btnEs").addEventListener("click", function() {
        setLanguage('es');
    });

    document.getElementById("btnFr").addEventListener("click", function() {
        setLanguage('fr');
    });
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript" defer></script>