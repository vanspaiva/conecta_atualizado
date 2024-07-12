<?php
// set the default timezone to use.
date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");


$getProp = mysqli_query($conn, "SELECT * FROM propostas ORDER BY propId DESC LIMIT 1;");
$rowProp = mysqli_fetch_array($getProp);
$idProp = $rowProp['propId'];
$idProp = $idProp + 1;



$ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
while ($row = mysqli_fetch_array($ret)) {

   $tpconta_criacao = $_SESSION["userperm"];
   $user_criacao = $_SESSION["useruid"];
   $email_criador = $row['usersEmail'];
   $status_caso = 'PENDENTE';
   $empresa = $row['usersEmpr'];

   if ($tpconta_criacao == 'Doutor(a)') {
      $formNmDr = $row['usersName'];
      $formCrm = $row['usersCrm'];
      $formEmailDr = $row['usersEmail'];
      $formtelDr = $row['usersFone'];
   } else {
      $formNmDr = '';
      $formCrm = '';
      $formEmailDr = '';
      $formtelDr = '';
   }

?>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.dev.min.js" defer></script>
   <script>
      window.addEventListener("load", function(){
         var uploader = new plupload.Uploader({
            runtimes: "html5,html4",
            browse_button: "pickfiles",
            url: "upload.php",
            chunck_size: "10mb",
            init: {
               PostInit: function(){
                  document.getElementById("filelist").innerHTML = "";
               },
               FilesAdded: function(up, files){
                  plupload.each(files, function(file){
                     document.getElementById("filelist").innerHTML += `<div id="${file.id}">${file.name} (${plupload.formatSize(file.size)}) - <strong>0%</strong></div>`
                  });
                  uploader.start();
               },
               UploadProgress: function(){
                  document.querySelector(`#${file.id} strong`).innerHTML = `${file.percent} %`;
               },
               Error: function(up, err){
                  console.log(err);
               }
            }
         });
         uploader.init();
      });
   </script> -->

   <script src="php/plupload/js/plupload.full.min.js"></script>
   <script>
      window.addEventListener("load", function() {
         // var path = "php/plupload/js/`";
         var uploader = new plupload.Uploader({
            browse_button: 'pickfiles',
            container: document.getElementById('container'),
            url: 'upload.php',
            chunk_size: '100mb',
            max_retries: 2,

            // Flash settings
            flash_swf_url: '/plupload/js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url: '/plupload/js/Moxie.xap',

            init: {
               PostInit: function() {
                  document.getElementById('filelist').innerHTML = '';
               },
               FilesAdded: function(up, files) {
                  plupload.each(files, function(file) {
                     document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                  });
                  uploader.start();
               },
               UploadProgress: function(up, file) {
                  document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
               },
               Error: function(up, err) {
                  // DO YOUR ERROR HANDLING!
                  console.log(err);
               }
            }
         });
         uploader.init();
      });
   </script>

   <form action="includes/novaprop.inc.php" method="POST" enctype="multipart/form-data">
      <div hidden>
         <h4 class="text-conecta">Dados do Usuário</h4>
         <div class="d-flex d-block justify-content-around">
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">Tipo de Conta</label>
               <input class="form-control" name="tp_contacriador" id="tp_contacriador" type="text" value="<?php echo $tpconta_criacao; ?>" readonly />
            </div>
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">Usuário</label>
               <input class="form-control" name="nomecriador" id="nomecriador" type="text" value="<?php echo $user_criacao; ?>" readonly>
            </div>
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">E-mail</label>
               <input class="form-control" name="emailcriacao" id="emailcriacao" type="text" value="<?php echo $email_criador; ?>" readonly>
            </div>
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">Data Criação</label>
               <input class="form-control" name="dtcriacao" id="dtcriacao" type="text" value="<?php echo $data_criacao; ?>" readonly>
            </div>
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">Status Caso</label>
               <input class="form-control" name="statuscaso" id="statuscaso" type="text" value="<?php echo $status_caso; ?>" readonly>
            </div>
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">Id Proposta</label>
               <input class="form-control" type="text" name="idprop" id="idprop" type="text" value="<?php echo $idProp; ?>" readonly>
            </div>
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">Empresa</label>
               <input class="form-control" type="text" name="empresa" id="empresa" type="text" value="<?php echo $empresa; ?>" readonly>
            </div>
         </div>
         <hr>
      </div>


      <h4 class="text-conecta">Dados da Cirurgia</h4>
      <?php
      if ($_SESSION["userperm"] == 'Doutor(a)') {
         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Doutor <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomedr' id='nomedr' type='text' value='" . $formNmDr . "' style='text-transform: capitalize;' required>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Nº do Conselho <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='crm' id='crm' type='text' value=' " . $formCrm . "' required>";
         echo "    </div>";
         echo " </div>";

         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>E-mail Dr(a) <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='emaildr' id='emaildr' type='text' value=' " . $formEmailDr . "' required>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Telefone Dr(a) <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='teldr' id='teldr' type='text' value='" . $formtelDr . "' placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required>";
         echo "       <small>Para notificação pelo whatsapp</small>";
         echo "    </div>";
         echo " </div>";

         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill flex-wrap m-2'>";
         echo "       <label class='control-label' style='color:black;'>Nome Paciente<b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomepaciente' id='nomepaciente' type='text' maxlength='5' style='text-transform: uppercase;' required>";
         echo "       <small>Somente Iniciais</small>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label'>Convênio</label>";
         echo "       <select class='form-control' name='convenio' id='convenio'>";
         echo "          <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>";
         echo "          <option value='ALLIANZ'>ALLIANZ</option>";
         echo "          <option value='AMIL'>AMIL</option>";
         echo "          <option value='ASSEFAZ'>ASSEFAZ</option>";
         echo "          <option value='ASSIM'>ASSIM</option>";
         echo "          <option value='BRADESCO'>BRADESCO</option>";
         echo "          <option value='CARE PLUS'>CARE PLUS</option>";
         echo "          <option value='CASSEB'>CASSEB</option>";
         echo "          <option value='CASSI'>CASSI</option>";
         echo "          <option value='CEF'>CEF</option>";
         echo "          <option value='DIX'>DIX</option>";
         echo "          <option value='FOMENTO'>FOMENTO</option>";
         echo "          <option value='GEAP'>GEAP</option>";
         echo "          <option value='GOLDEN GROSS'>GOLDEN GROSS</option>";
         echo "          <option value='GREANLINE'>GREANLINE</option>";
         echo "          <option value='HAPVIDA'>HAPVIDA</option>";
         echo "          <option value='MEDSENIOR'>MEDSENIOR</option>";
         echo "          <option value='MEDSERVICE'>MEDSERVICE</option>";
         echo "          <option value='NOTREDAME'>NOTREDAME</option>";
         echo "          <option value='OMINT'>OMINT</option>";
         echo "          <option value='PARTICULAR'>PARTICULAR</option>";
         echo "          <option value='PETROBRAS'>PETROBRAS</option>";
         echo "          <option value='PORTO SEGURO'>PORTO SEGURO</option>";
         echo "          <option value='POSTAL SAUDE (correios)'>POSTAL SAUDE (correios)</option>";
         echo "          <option value='PREVENT SENIOR'>PREVENT SENIOR</option>";
         echo "          <option value='SULAMERICA'>SULAMERICA</option>";
         echo "          <option value='SUS'>SUS</option>";
         echo "          <option value='UNIMED LOCAL'>UNIMED LOCAL</option>";
         echo "          <option value='UNIMED NACIONAL (CNU)'>UNIMED NACIONAL (CNU)</option>";
         echo "       </select>";
         echo "    </div>";
         echo " </div>";
      }
      ?>

      <?php
      if (($_SESSION["userperm"] == 'Distribuidor(a)') || ($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Representante')) {
         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Doutor <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomedr' id='nomedr' type='text' style='text-transform: capitalize;' required>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>E-mail para envio da Proposta <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='emailempresa' id='emailempresa' type='text' value='" . $row['usersEmailEmpresa'] . "' required>";
         echo "    </div>";
         echo " </div>";

         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>E-mail Dr(a) <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='emaildr' id='emaildr' type='text' required>";
         echo "       <small>Para dúvidas e devolutivas</small>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Telefone Dr(a) <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='teldr' id='teldr' type='text' value='" . $formtelDr . "' placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required>";
         echo "       <small>Para notificação pelo whatsapp</small>";
         echo "    </div>";
         echo " </div>";

         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill flex-wrap m-2'>";
         echo "       <label class='control-label' style='color:black;'>Nome Paciente<b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomepaciente' id='nomepaciente' type='text' maxlength='5' style='text-transform: uppercase;' required>";
         echo "       <small>Somente Iniciais</small>";
         echo "    </div>";
         echo "   <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label'>Convênio</label>";
         echo "       <select class='form-control' name='convenio' id='convenio'>";
         echo "          <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>";
         echo "          <option value='ALLIANZ'>ALLIANZ</option>";
         echo "          <option value='AMIL'>AMIL</option>";
         echo "          <option value='ASSEFAZ'>ASSEFAZ</option>";
         echo "          <option value='ASSIM'>ASSIM</option>";
         echo "          <option value='BRADESCO'>BRADESCO</option>";
         echo "          <option value='CARE PLUS'>CARE PLUS</option>";
         echo "          <option value='CASSEB'>CASSEB</option>";
         echo "          <option value='CASSI'>CASSI</option>";
         echo "          <option value='CEF'>CEF</option>";
         echo "          <option value='DIX'>DIX</option>";
         echo "          <option value='FOMENTO'>FOMENTO</option>";
         echo "          <option value='GEAP'>GEAP</option>";
         echo "          <option value='GOLDEN GROSS'>GOLDEN GROSS</option>";
         echo "          <option value='GREANLINE'>GREANLINE</option>";
         echo "          <option value='HAPVIDA'>HAPVIDA</option>";
         echo "          <option value='MEDSENIOR'>MEDSENIOR</option>";
         echo "          <option value='MEDSERVICE'>MEDSERVICE</option>";
         echo "          <option value='NOTREDAME'>NOTREDAME</option>";
         echo "          <option value='OMINT'>OMINT</option>";
         echo "          <option value='PARTICULAR'>PARTICULAR</option>";
         echo "          <option value='PETROBRAS'>PETROBRAS</option>";
         echo "          <option value='PORTO SEGURO'>PORTO SEGURO</option>";
         echo "          <option value='POSTAL SAUDE (correios)'>POSTAL SAUDE (correios)</option>";
         echo "          <option value='PREVENT SENIOR'>PREVENT SENIOR</option>";
         echo "          <option value='SULAMERICA'>SULAMERICA</option>";
         echo "          <option value='SUS'>SUS</option>";
         echo "          <option value='UNIMED LOCAL'>UNIMED LOCAL</option>";
         echo "          <option value='UNIMED NACIONAL (CNU)'>UNIMED NACIONAL (CNU)</option>";
         echo "       </select>";
         echo "    </div>";
         echo " </div>";
      }
      ?>

      <?php
      if ($_SESSION["userperm"] == 'Paciente') {
         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Doutor(a) <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomedr' id='nomedr' type='text' value='" . $row['usersNmResp'] . "' style='text-transform: capitalize;' required>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Nº do Conselho Dr(a)<b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='crm' id='crm' type='text' required>";
         echo "    </div>";
         echo " </div>";

         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill flex-wrap m-2'>";
         echo "       <label class='control-label' style='color:black;'>Nome Paciente<b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomepaciente' id='nomepaciente' type='text' value='" . $row['usersName'] . "' required>";
         echo "       <small>Somente Iniciais</small>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label'>Convênio</label>";
         echo "       <select class='form-control' name='convenio' id='convenio'>";
         echo "          <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>";
         echo "          <option value='ALLIANZ'>ALLIANZ</option>";
         echo "          <option value='AMIL'>AMIL</option>";
         echo "          <option value='ASSEFAZ'>ASSEFAZ</option>";
         echo "          <option value='ASSIM'>ASSIM</option>";
         echo "          <option value='BRADESCO'>BRADESCO</option>";
         echo "          <option value='CARE PLUS'>CARE PLUS</option>";
         echo "          <option value='CASSEB'>CASSEB</option>";
         echo "          <option value='CASSI'>CASSI</option>";
         echo "          <option value='CEF'>CEF</option>";
         echo "          <option value='DIX'>DIX</option>";
         echo "          <option value='FOMENTO'>FOMENTO</option>";
         echo "          <option value='GEAP'>GEAP</option>";
         echo "          <option value='GOLDEN GROSS'>GOLDEN GROSS</option>";
         echo "          <option value='GREANLINE'>GREANLINE</option>";
         echo "          <option value='HAPVIDA'>HAPVIDA</option>";
         echo "          <option value='MEDSENIOR'>MEDSENIOR</option>";
         echo "          <option value='MEDSERVICE'>MEDSERVICE</option>";
         echo "          <option value='NOTREDAME'>NOTREDAME</option>";
         echo "          <option value='OMINT'>OMINT</option>";
         echo "          <option value='PARTICULAR'>PARTICULAR</option>";
         echo "          <option value='PETROBRAS'>PETROBRAS</option>";
         echo "          <option value='PORTO SEGURO'>PORTO SEGURO</option>";
         echo "          <option value='POSTAL SAUDE (correios)'>POSTAL SAUDE (correios)</option>";
         echo "          <option value='PREVENT SENIOR'>PREVENT SENIOR</option>";
         echo "          <option value='SULAMERICA'>SULAMERICA</option>";
         echo "          <option value='SUS'>SUS</option>";
         echo "          <option value='UNIMED LOCAL'>UNIMED LOCAL</option>";
         echo "          <option value='UNIMED NACIONAL (CNU)'>UNIMED NACIONAL (CNU)</option>";
         echo "       </select>";
         echo "    </div>";
         echo " </div>";
      }
      ?>

      <?php
      if ($_SESSION["userperm"] == 'Internacional') {
         echo " <div class='d-flex d-block justify-content-around'>";
         echo "    <div class='form-group d-inline-block flex-fill m-2'>";
         echo "       <label class='control-label' style='color:black;'>Doutor(a) <b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomedr' id='nomedr' type='text' style='text-transform: capitalize;' required>";
         echo "    </div>";
         echo "    <div class='form-group d-inline-block flex-fill flex-wrap m-2'>";
         echo "       <label class='control-label' style='color:black;'>Nome Paciente<b style='color: red;'>*</b></label>";
         echo "       <input class='form-control' name='nomepaciente' id='nomepaciente' type='text' maxlength='5' style='text-transform: uppercase;' required>";
         echo "       <small>Somente Iniciais</small>";
         echo "    </div>";
         echo " </div>";
      }
      ?>



      <hr style="border: 2px dashed #ccc;">
      <h4 class="text-conecta">Dados do Produto</h4>

      <div class="py-4 col d-flex justify-content-center">
         <a class="btn btn-outline-conecta" data-toggle="modal" data-target="#exampleModal" onclick="resetOptions()"><i class="fas fa-plus"></i> Adicionar Produto</a>
      </div>

      <table id="propProd" class="table table-striped">
         <thead>
            <tr>
               <th scope="col">Tipo</th>
               <th scope="col">Produto</th>
               <th scope="col">Descrição</th>
               <th scope="col"></th>
            </tr>
         </thead>
         <tbody class="tableProd"></tbody>
      </table>

      <input type="text" id="listaItens" name="listaItens" hidden />
      <input type="text" id="tipoProd" name="tipoProd" hidden />
      <div id="longListaItens" name="longListaItens" hidden></div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Novo Produto</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">


                  <div class="product-selector d-block justify-content-center text-align-center py-2">
                     <div class='d-block flex-fill m-2 mb-4 p-2 justify-content-around'>

                        <div class='form-check form-check-inline justify-content-center mx-4 p-2 mt-sm-4'>
                           <input id="cmf" type="radio" name="radio-product" value="cmf" onchange="handleProductTypeChange(this)" required />
                           <label class="product-card cmf" for="cmf" alt='CMF'></label>
                           <br>
                           <label class='opacity-text mb-n4 align-self-end position-absolute text-center h5 font-weight-bold' for="cmf">CMF</label>
                        </div>

                        <div class='form-check form-check-inline justify-content-center mx-4 p-2 mt-sm-4'>
                           <input id="cranio" type="radio" name="radio-product" value="cranio" onchange="handleProductTypeChange(this)" />
                           <label class="product-card cranio" for="cranio" alt='CRÂNIO'></label>
                           <br>
                           <label class='opacity-text mb-n4 align-self-end position-absolute text-center h5 font-weight-bold' for="cranio">CRÂNIO</label>
                        </div>

                        <div class='form-check form-check-inline justify-content-center mx-4 p-2 mt-sm-4'>
                           <input id="ata" type="radio" name="radio-product" value="ata" onchange="handleProductTypeChange(this)" />
                           <label class="product-card ata" for="ata" alt='ATA'></label>
                           <br>
                           <label class='opacity-text mb-n4 align-self-end position-absolute text-center h5 font-weight-bold' for="ata">ATA</label>
                        </div>

                        <div class='form-check form-check-inline justify-content-center mx-4 p-2 mt-sm-4'>
                           <input id="biomodelo" type="radio" name="radio-product" value="biomodelo" onchange="handleProductTypeChange(this)" />
                           <label class="product-card biomodelo" for="biomodelo" alt='BIOMODELO'></label>
                           <br>
                           <label class='opacity-text mb-n4 align-self-end position-absolute text-center h5 font-weight-bold' for="biomodelo">BIOMODELO</label>
                        </div>
                     </div>
                  </div>

                  <div class="d-block">
                     <div class="form-group d-inline-block flex-fill mx-1 py-3 w-100">
                        <select class="form-control" name="produto" id="produtoSelect" required onchange="setProdutoComplemento()" hidden>
                           <option value="0" selected style="color: #F6F7FA;">Escolha um produto</option>
                           <optgroup label="CMF" id="cmf-group" hidden>
                              <option value="ortognática">Ortognática</option>
                              <option value="atm">ATM</option>
                              <option value="reconstrução óssea">Reconstrução Óssea</option>
                              <option value="smartmold">Smartmold</option>
                              <option value="mesh4u">Mesh 4U</option>
                              <option value="customlife">CustomLife/Implantize</option>
                              <option value="guia de buco">Guia de Buco (Surgicalguide)</option>
                           </optgroup>
                           <optgroup label="Crânio" id="cranio-group" hidden>
                              <option value="crânio peek">Crânio em PEEK</option>
                              <option value="crânio titânio">Crânio em Titânio</option>
                              <option value="fastmold pmma">Fastmold PMMA</option>
                              <option value="fastcmf">FastCMF PMMA</option>
                              <!-- <option value="disposiosteo">Dispositivo Osteotomia</option>
                              <option value="biocranio">Biomodelo Cranio</option> -->
                           </optgroup>
                           <optgroup label="ATA" id="ata-group" hidden>
                              <option value="ata buco">ATA Buco</option>
                              <option value="ata coluna"> ATA Coluna</option>
                              <option value="ata hof">ATA HOF</option>
                              <option value="ata otorrino">ATA Otorrino</option>
                           </optgroup>
                           <optgroup label="Biomodelos" id="biomodelo-group" hidden>
                              <option value="biomodelo crânio">Biomodelo Crânio</option>
                              <option value="biomodelo ortognática">Biomodelo Ortognática</option>
                              <option value="biomodelo maxila">Biomodelo Maxila</option>
                              <option value="biomodelo mandíbula">Biomodelo Mandibula</option>
                              <option value="biomodelo vértebra">Biomodelo Vértebra</option>
                              <option value="biomodelo ombro ">Biomodelo Ombro</option>
                           </optgroup>
                        </select>
                     </div>

                  </div>


                  <div id="ortognatica" class="ortognatica d-none">
                     <h4>ORTOGNÁTICA PERSONALIZADA</h4>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Região</b></label>
                           <div class="d-block">
                              <select class="form-control" name="ortogSelect" id="ortogSelect" onchange="selectOrtog()">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="Maxila">Maxila</option>
                                 <option value="Mandíbula">Mandíbula</option>
                                 <option value="COMPLETA (max / mand / mento)">COMPLETA (max / mand / mento)</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="ortogImg">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="atm" class="atm d-none">
                     <h4>ATM</h4>
                     <p class="lh-base" style="text-align:justify; text-justify:initial; text-indent: 50px;">
                        No momento atual estamos com restrições da matéria prima específica do polietileno com vitamina 'E'
                        para proteses de ATM, sendo ummaterial restrito a poucos fornecedores nomundo e por motivos de devolução
                        recente de toda a importação pelo setor de Qualidade, devido ao fornecedor não estar conforme nas certificações
                        exigidas pela CPMH, diante deste imprevisto por cortinas maiores esperamos que o tempo de estabilidade seja de 3 a 4meses.
                        Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de
                        implantes seguros e eficaz, não conseguimos realizar este projeto. Mesmo assim deseja solicitar a sua proposta?
                     </p>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Região</b></label>
                           <div class="d-block">
                              <select class="form-control" name="atmRegiao" id="atmRegiao" onchange="selectAtm()">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="Direita">Direita</option>
                                 <option value="Esquerda">Esquerda</option>
                                 <option value="Bilateral">Bilateral</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Tamanho</b></label>
                           <div class="d-block">
                              <select class="form-control" name="atmTamanho" id="atmTamanho" onchange="setTamanho(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="P - Até linha média (Mento)">P - Até linha média (Mento)</option>
                                 <option value="M - Após linha média (Mento)">M - Após linha média (Mento)</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="atmImg">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="reconstrucao" class="reconstrucao d-none">
                     <h4>RECONSTRUÇÃO</h4>
                     <div class="form-group">
                        <label class="form-label pt-2"><b>Região</b></label>
                        <div class="d-block col">
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recObita" value="Orbita" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recOrbita">Orbita</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recMaxila" value="Maxila" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recMaxila">Maxila</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recMandibula" value="Mandibula" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recMandibula">Mandíbula</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recZigoma" value="Zigoma" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recZigoma">Zigoma</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recInfraorbitario" value="Infraorbitario" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recInfraorbitario">Infraorbitário</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recGlabela" value="Glabela" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recGlabela">Glabela</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recFrontal" value="Frontal" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recFrontal">Frontal</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recAngulo" value="Angulo" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recAngulo">Âng. de Mandíbula</label>
                           </div>
                           <div class="form-check form-check-inline col-md-2">
                              <input class="form-check-input" type="checkbox" id="recMento" value="Mento" onclick="handleReconstrucao(this)">
                              <label class="form-check-label" for="recMento">Mento</label>
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">

                     <div id="recOrbitaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialOrbita">Material Orbita</label>
                              <select id="recMaterialOrbita" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoOrbita">Tamanho Orbita</label>
                              <select id="recTamanhoOrbita" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEQUENO (Somente assoalho)">PEQUENO (Somente assoalho)</option>
                                 <option value="MÉDIO (assoalho + parede orbitária)">MÉDIO (assoalho + parede orbitária)</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b33fa5475e8faff97c688356ab681f94.png" alt="Ícone Orbita">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recMaxilaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialMaxila">Material Maxila</label>
                              <select id="recMaterialMaxila" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoMaxila">Tamanho Maxila</label>
                              <select id="recTamanhoMaxila" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEQUENA (Até 6 dentes)">PEQUENA (Até 6 dentes)</option>
                                 <option value="MÉDIA (Acima 6 dentes)">MÉDIA (Acima 6 dentes)</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_48d7deeedfd7aa037d6cecda324f3396.png" alt="Ícone Maxila">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recMandibulaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialMandibula">Material Mandibula</label>
                              <select id="recMaterialMandibula" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoMandibula">Tamanho Mandibula</label>
                              <select id="recTamanhoMandibula" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEQUENA (Até 6 dentes)">PEQUENA (Até 6 dentes)</option>
                                 <option value="MÉDIA (Acima 6 dentes)">MÉDIA (Acima 6 dentes)</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b25e5c258da4318a4f45be86ccd2c042.png" alt="Ícone Mandibula">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recZigomaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialZigoma">Material Zigoma</label>
                              <select id="recMaterialZigoma" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoZigoma">Tamanho Zigoma</label>
                              <select id="recTamanhoZigoma" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P - Isolado">P - Isolado</option>
                                 <option value="M - Com Maxila">M - Com Maxila</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3513edbaac99a8c5441d55234868b418.png" alt="Ícone Zigoma">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recInfraorbitarioField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialInfraorbitario">Material Infraorbitário</label>
                              <select id="recMaterialInfraorbitario" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoInfraorbitario">Tamanho Infraorbitário</label>
                              <select id="recTamanhoInfraorbitario" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P - Isolado">P - Isolado</option>
                                 <option value="M - Com Maxila">M - Com Maxila</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3626ee59ca7bb4dc2f01fc56962674eb.png" alt="Ícone Infraorbitario">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recGlabelaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialGlabela">Material Glabela</label>
                              <select id="recMaterialGlabela" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoGlabela">Tamanho Glabela</label>
                              <select id="recTamanhoGlabela" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P - Isolado">P - Isolado</option>
                                 <option value="M - Com Supraorbital">M - Com Supraorbital</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_587b98495043917493de7660029d0c7d.png" alt="Ícone Glabela">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recFrontalField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialFrontal">Material Frontal</label>
                              <select id="recMaterialFrontal" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoFrontal">Tamanho Frontal</label>
                              <select id="recTamanhoFrontal" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P - Sem extensão">P - Sem extensão</option>
                                 <option value="M - Com extensão para Orbita ou Crânio">M - Com extensão para Orbita ou Crânio</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_35ab0063c68ae0cec13e40e95f359ae7.png" alt="Ícone Frontal">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recAnguloField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialAngulo">Material Ângulo de Mandibula</label>
                              <select id="recMaterialAngulo" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recLadoAngulo">Lado Ângulo de Mandibula</label>
                              <select id="recLadoAngulo" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="Direito">Direito</option>
                                 <option value="Esquerdo">Esquerdo</option>
                                 <option value="Bilateral">Bilateral</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_68feed2e8b08aa7a27a86100dcf2b9f7.png" alt="Ícone Ângulo de Mandibula">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="recMentoField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recMaterialMento">Material Mento</label>
                              <select id="recMaterialMento" class="form-control" aria-label="Default select" onchange="setMaterialRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PEEK">PEEK</option>
                                 <option value="TITÂNIO">TITÂNIO</option>
                              </select>
                           </div>
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="recTamanhoMento">Tamanho Mento</label>
                              <select id="recTamanhoMento" class="form-control" aria-label="Default select" onchange="setTamanhoRec(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P - Sem extensão">P - Sem extensão</option>
                                 <option value="M - Com extensão (>5mm)">M - Com extensão (>5mm)</option>
                                 <option value="Outra Região (Analisar)">Outra Região (Analisar)</option>
                              </select>
                           </div>
                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4659ef9ccb2cee4fb4653e2383ab63d4.png" alt="Ícone Mento">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                  </div>

                  <div id="smartmold" class="smartmold d-none">
                     <h4>SMARTMOLD</h4>
                     <div class="form-group">
                        <label class="form-label pt-2"><b>Região</b></label>
                        <div class="d-block">
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="smartmoldZigoma" value="zigoma" onclick="handleSmartmold(this)">
                              <label class="form-check-label" for="smartmoldZigoma">Zigoma</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="smartmoldParanasal" value="paranasal" onclick="handleSmartmold(this)">
                              <label class="form-check-label" for="smartmoldParanasal">Paranasal</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="smartmoldMento" value="mento" onclick="handleSmartmold(this)">
                              <label class="form-check-label" for="smartmoldMento">Mento</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="smartmoldAngulo" value="angulo" onclick="handleSmartmold(this)">
                              <label class="form-check-label" for="smartmoldAngulo">Ângulo de Mandíbula</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="smartmoldPremaxila" value="premaxila" onclick="handleSmartmold(this)">
                              <label class="form-check-label" for="smartmoldPremaxila">Pré-Maxila</label>
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">

                     <div id="zigomaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="ladoZigoma">Lado Zigoma</label>
                              <select id="ladoZigoma" class="form-control" aria-label="Default select" onchange="changeZigoma(this)">
                                 <option value="0">Selecione</option>
                                 <option value="Direito">Direito</option>
                                 <option value="Esquerdo">Esquerdo</option>
                                 <option value="Bilateral">Bilateral</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="materialZigoma">Material Zigoma</label>
                              <select id="materialZigoma" class="form-control" aria-label="Default select">
                                 <option value="0">Selecione</option>
                                 <option value="PMMA">PMMA</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_f6e41f38d0dc5cad42ce029cef257a7d.png" alt="Ícone Zigoma">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="paranasalField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="ladoParanasal">Lado Paranasal</label>
                              <select id="ladoParanasal" class="form-control" aria-label="Default select" onchange="changeParanasal(this)">
                                 <option value="0">Selecione</option>
                                 <option value="Bilateral">Bilateral</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="materialParanasal">Material Paranasal</label>
                              <select id="materialParanasal" class="form-control" aria-label="Default select">
                                 <option value="0">Selecione</option>
                                 <option value="PMMA">PMMA</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_40800f29644720b65edcc4724b7b247f.png" alt="Ícone Paranasal">
                              </div>
                           </div>
                        </div>

                        <div class="row p-3">
                           <input class="form-control" type="text" id="idParanasal" name="idParanasal" hidden />
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="mentoField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="tipoMento">Tipo Mento</label>
                              <select id="tipoMento" class="form-control" aria-label="Default select" onchange="changeMento(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PecaUnica">Peça Única</option>
                                 <option value="Bipartido">Bipartido</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="materialMento">Material Mento</label>
                              <select id="materialMento" class="form-control" aria-label="Default select">
                                 <option value="0">Selecione</option>
                                 <option value="PMMA">PMMA</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_91c1690357c075a3e2bc5293dc86fd5c.png" alt="Ícone Mento">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="anguloField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="tipoAngulo">Tipo Âng de Mand</label>
                              <select id="tipoAngulo" class="form-control" aria-label="Default select" onchange="changeAnguloTipo(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PecaUnica">Peça Única</option>
                                 <option value="Bipartido">Bipartido</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="ladoAngulo">Lado Âng de Mand</label>
                              <select id="ladoAngulo" class="form-control" aria-label="Default select" onchange="changeAngulo(this)">
                                 <option value="0">Selecione</option>
                                 <option value="Direito">Direito</option>
                                 <option value="Esquerdo">Esquerdo</option>
                                 <option value="Bilateral">Bilateral</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="materialAngulo">Material Âng de Mand</label>
                              <select id="materialAngulo" class="form-control" aria-label="Default select">
                                 <option value="0">Selecione</option>
                                 <option value="PMMA">PMMA</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_15b941481b95c7a83cbed902557294b4.png" alt="Ícone Ângulo de Mandíbula">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="premaxilaField" class="d-none">
                        <div class="d-flex">

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="materialPremaxila">Material Pré-Maxila</label>
                              <select id="materialPremaxila" class="form-control premaxilaSelect" aria-label="Default select" onchange="changePremaxila(this)">
                                 <option value="0">Selecione</option>
                                 <option value="PMMA">PMMA</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_58c76c919599dcd927d0a0ee186a758a.png" alt="Ícone Pré-Maxila">
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>

                  <div id="mesh" class="mesh d-none">
                     <h4>MESH 4U</h4>
                     <div class="form-group">
                        <label class="form-label pt-2"><b>Região</b></label>
                        <div class="d-block">
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="meshMaxila" value="maxila" onclick="handleMesh(this)">
                              <label class="form-check-label" for="meshMaxila">Maxila</label>
                           </div>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="meshMandibula" value="mandibula" onclick="handleMesh(this)">
                              <label class="form-check-label" for="meshMandibula">Mandíbula</label>
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">

                     <div id="meshMaxilaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="meshTamanhoMaxila">Tamanho Maxila</label>
                              <select id="meshTamanhoMaxila" class="form-control" aria-label="Default select" onchange="changeMesh(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P (até 6 dentes)">P (até 6 dentes)</option>
                                 <option value="M (+ de 6 dentes)">M (+ de 6 dentes)</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3 ">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_93a1683e935d225811637788c40f120a.png" alt="Ícone Mesh Maxila">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="meshMandibulaField" class="d-none">
                        <div class="d-flex">
                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="meshTamanhoMandibula">Tamanho Mandíbula</label>
                              <select id="meshTamanhoMandibula" class="form-control" aria-label="Default select" onchange="changeMesh(this)">
                                 <option value="0">Selecione</option>
                                 <option value="P (até 6 dentes)">P (até 6 dentes)</option>
                                 <option value="M (+ de 6 dentes)">M (+ de 6 dentes)</option>
                              </select>
                           </div>

                           <div class="flex-fill px-3">
                              <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                                 <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_8792258160ba5ff714b2db8c6b52e78c.png" alt="Ícone Mesh Mandibula">
                              </div>
                           </div>
                        </div>

                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                  </div>

                  <div id="customlife" class="customlife d-none">
                     <h4>CUSTOMLIFE</h4>
                     <div class="d-flex">
                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Região</b></label>
                           <div class="d-block">
                              <select class="form-control" name="customRegiao" id="customRegiao" onchange="selectCustomlife()">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="Maxila">Maxila</option>
                                 <option value="Mandíbula">Mandíbula</option>
                                 <option value="Maxila e Mandíbula">Maxila e Mandíbula</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Tamanho</b></label>
                           <div class="d-block">
                              <select class="form-control" name="customTamanho" id="customTamanho" onchange="setTamanhoCustom(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="Parcial">Parcial</option>
                                 <option value="Total">Total</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="customImg">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="guiabuco" class="guiabuco d-none">
                     <h4>GUIA DE BUCO</h4>
                     <div class='form-group d-inline-block flex-fill m-2 mb-4 p-2 border-left'>
                        <label style='color:red;'>*</label>

                        <div class='d-block'>
                           <div class='d-inline-block m-2'>
                              <input type='radio' id='planejarImpressao' name='op-Impressao' value='1'>
                              <label for='planejarImpressao' class='m-2'>Planejamento + Impressão</label>
                           </div>
                        </div>

                        <div class='d-block'>
                           <div class='d-inline-block m-2'>
                              <input type='radio' id='somenteImpressao' name='op-Impressao' value='2'>
                              <label for='somenteImpressao' class='m-2'>Somente Impressão</label>
                           </div>
                        </div>
                     </div>
                     <div class='form-group d-inline-block flex-fill m-2 mb-4 p-2 border-left'>
                        <label style='color:red;'>*</label>

                        <div class='d-block'>
                           <div class='d-inline-block m-2'>
                              <input type='radio' id='naoEsteril' name='op-Esteril' value='1'>
                              <label for='naoEsteril' class='m-2'>Não Estéril (7 dias úteis)</label>
                           </div>
                        </div>

                        <div class='d-block'>
                           <div class='d-inline-block m-2'>
                              <input type='radio' id='esteril' name='op-Esteril' value='2'>
                              <label for='esteril' class='m-2'>Estéril (9 dias úteis)</label>
                           </div>
                        </div>
                     </div>
                     <div class='form-group d-block flex-fill m-2 mb-4 p-2 border-left'>
                        <p>
                           *Em casos de emergência, sendo nescessária a antecipação de prazo, será cobrado uma taxa de 30% (hora extra), máximo de antecipaçao é de 2 dias.
                        </p>
                     </div>
                     <div class='form-group d-block flex-fill m-2 mb-4 p-2 border-left'>

                        <div class='form-check form-check-inline'>
                           <input class='form-check-input' type='checkbox' id='surgicalGuideIntermediario' value='1' />
                           <label class='form-check-label' for='surgicalGuideIntermediario'>Surgicalguide Intermediário</label>
                        </div>

                        <div class='form-check form-check-inline'>
                           <input class='form-check-input' type='checkbox' id='surgicalGuideFinal' value='2' />
                           <label class='form-check-label' for='surgicalGuideFinal'>Surgicalguide Final (oclusão)</label>
                        </div>

                        <div class='form-check form-check-inline'>
                           <input class='form-check-input' type='checkbox' id='dispositivoMentoplastia' value='3' />
                           <label class='form-check-label' for='dispositivoMentoplastia'>Dispositivo Mentoplastia</label>
                        </div>

                        <div class='form-check form-check-inline'>
                           <input class='form-check-input' type='checkbox' id='palatal' value='4' />
                           <label class='form-check-label' for='palatal'>Palatal</label>
                        </div>
                     </div>

                  </div>

                  <div id="cranioPeek" class="cranioPeek d-none">
                     <h4>CRÂNIO PEEK</h4>
                     <p class="lh-base" style="text-align:justify; text-justify:initial; text-indent: 50px;">
                        No momento atual estamos com restrições da matéria prima específica da especificação necessária para este produto (Lâminas),
                        por motivos de devolução recente de toda a importação do setor de Qualidade, motivos do fornecedor não estar conforme nas certificações
                        exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico esta estimado em 3 a 4m para normalidade.
                        Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros
                        e útil não conseguimos realizar este projeto. Mesmo assim deseja a sua proposta?
                     </p>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Tamanho</b></label>
                           <div class="d-block">
                              <select class="form-control" name="tamanhoCranioPeek" id="tamanhoCranioPeek" onchange="changePeek(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="P">1/4 - Tam P - até 30 cm³</option>
                                 <option value="M">1/2 - Tam M - 31 A 60 cm³</option>
                                 <option value="G">>1/2 - Tam G - acima até 61 cm³</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="cranioPeekImg" src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_904c0cfc313d2b35dbe47794d3788430.png">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="cranioTitanio" class="cranioTitanio d-none">
                     <h4>CRÂNIO TITÂNIO</h4>
                     <h6>Com tecnologia Trabeculada (impressão 3D titânio)</h6>
                     <p class="lh-base mt-2" style="text-align:justify; text-justify:initial; text-indent: 50px;">
                        No momento atual estamos com restrições da matéria prima específica da especificação necessária para este produto (Lâminas),
                        por motivos de devolução recente de toda a importação do setor de Qualidade, motivos do fornecedor não estar conforme nas
                        certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico esta estimado em 3 a 4m para normalidade.
                        Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e útil não
                        conseguimos realizar este projeto. Mesmo assim deseja a sua proposta?
                     </p>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Tamanho</b></label>
                           <div class="d-block">
                              <select class="form-control" name="tamanhoCranioTitanio" id="tamanhoCranioTitanio" onchange="changeTitanio(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="P">1/4 - Tam P - até 30 cm³</option>
                                 <option value="M">1/2 - Tam M - 31 A 60 cm³</option>
                                 <option value="G">>1/2 - Tam G - acima até 61 cm³</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="cranioTitanioImg" src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_904c0cfc313d2b35dbe47794d3788430.png">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="fastmold" class="fastmold d-none">
                     <h4>FASTMOLD CRÂNIO</h4>

                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Tamanho</b></label>
                           <div class="d-block">
                              <select class="form-control" name="tamanhoFastmold" id="tamanhoFastmold" onchange="changeFastmold(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="P">Tam P - < 30 cm³</option>
                                 <option value="M">Tam M - 31 a 60 cm³</option>
                                 <option value="G">Tam G - > 61 cm³</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="fastmoldImg" src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_904c0cfc313d2b35dbe47794d3788430.png">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="fastcmf" class="fastcmf d-none">
                     <h4>FASTCMF CRÂNIO</h4>

                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Tamanho</b></label>
                           <div class="d-block">
                              <select class="form-control" name="tamanhoFastcmf" id="tamanhoFastcmf" onchange="changeFastcmf(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="M">Tam M - até 50 cm³</option>
                                 <option value="G">Tam G - acima 51 cm³</option>
                              </select>
                           </div>
                        </div>
                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img id="fastcmfImg" src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_904c0cfc313d2b35dbe47794d3788430.png">
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="ataProd" class="ataProd d-none">
                     <h4 id="ataTitle"></h4>

                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2"><b>Observações</b></label>
                           <div class="d-block">
                              <input class="form-control" name="tamanhoAta" id="tamanhoAta" onblur="changeAta(this)" />
                           </div>
                        </div>

                     </div>
                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="biomodCranioField" class="d-none">
                     <h4>BIOMODELO CRÂNIO</h4>
                     <div class="d-flex">
                        <div class="form-group flex-fill px-3">
                           <label class="form-label" for="tamanhoBiomodCranio">Tamanho Crânio</label>
                           <select id="tamanhoBiomodCranio" class="form-control" aria-label="Default select" onchange="">
                              <option value="0">Selecione</option>
                              <option value="Parcial">Parcial</option>
                              <option value="Total">Total</option>
                           </select>
                        </div>

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2">Quantidade</label>
                           <div class="d-block">
                              <input type="number" class="form-control" name="qtdBiomodCranio" id="qtdBiomodCranio" onblur="changeBiomodCranio(this)" />
                           </div>
                        </div>

                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4768b41512dcd2a7bdc36334b5782539.png" alt="Ícone Biomodelo Crânio">
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="biomodMandField" class="d-none">
                     <h4>BIOMODELO MANDÍBULA</h4>
                     <div class="d-flex">
                        <div class="form-group flex-fill px-3">
                           <label class="form-label" for="tamanhoBiomodMand">Tamanho Mandíbula</label>
                           <select id="tamanhoBiomodMand" class="form-control" aria-label="Default select" onchange="">
                              <option value="0">Selecione</option>
                              <option value="Ampliado">Ampliado</option>
                              <option value="Padrão">Padrão</option>
                           </select>
                        </div>

                        <div class="form-group flex-fill px-3">
                           <label class="form-label" for="tipoBiomodMand">Tipo Mandíbula</label>
                           <select id="tipoBiomodMand" class="form-control" aria-label="Default select">
                              <option value="0">Selecione</option>
                              <option value="Opaco">Opaco</option>
                              <option value="OpacoA">Opaco - Ancoragem</option>
                           </select>
                        </div>

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2">Quantidade</label>
                           <div class="d-block">
                              <input type="number" class="form-control" name="qtdBiomodMand" id="qtdBiomodMand" onblur="changeBiomodMandibula(this)" />
                           </div>
                        </div>

                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_27da8d7b12ad1a9756f2edb0afabc611.png" alt="Ícone Biomodelo Mandíbula">
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="biomodMaxField" class="d-none">
                     <h4>BIOMODELO MAXILA</h4>
                     <div class="d-flex">
                        <div class="form-group flex-fill px-3">
                           <label class="form-label" for="tamanhoBiomodMax">Tamanho Maxila</label>
                           <select id="tamanhoBiomodMax" class="form-control" aria-label="Default select" onchange="">
                              <option value="0">Selecione</option>
                              <option value="Ampliado">Ampliado</option>
                              <option value="Padrão">Padrão</option>
                           </select>
                        </div>

                        <div class="form-group flex-fill px-3">
                           <label class="form-label" for="tipoBiomodMax">Tipo Maxila</label>
                           <select id="tipoBiomodMax" class="form-control" aria-label="Default select">
                              <option value="0">Selecione</option>
                              <option value="Opaco">Opaco</option>
                              <option value="OpacoA">Opaco - Ancoragem</option>
                           </select>
                        </div>

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2">Quantidade</label>
                           <div class="d-block">
                              <input type="number" class="form-control" name="qtdBiomodMax" id="qtdBiomodMax" onblur="changeBiomodMaxila(this)" />
                           </div>
                        </div>

                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_fb21a7581429548955e6f39dc7579499.png" alt="Ícone Biomodelo Maxila">
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="biomodVertebraField" class="d-none">
                     <h4>BIOMODELO VERTEBRA</h4>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2">Quantidade</label>
                           <div class="d-block">
                              <input type="number" class="form-control" name="qtdBiomodVertebra" id="qtdBiomodVertebra" onblur="changeBiomodVertebra(this)" />
                           </div>
                        </div>

                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_199d55b0defd697d8be75f916d7789a0.png" alt="Ícone Biomodelo Vertebra">
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="biomodOmbroField" class="d-none">
                     <h4>BIOMODELO OMBRO</h4>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2">Quantidade</label>
                           <div class="d-block">
                              <input type="number" class="form-control" name="qtdBiomodOmbro" id="qtdBiomodOmbro" onblur="changeBiomodOmbro(this)" />
                           </div>
                        </div>

                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_28e8f41fdaeb64432d79449815dc8a61.png" alt="Ícone Biomodelo Ombro">
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">
                  </div>

                  <div id="biomodOrtognaticaField" class="d-none">
                     <h4>BIOMODELO ORTOGNÁTICA</h4>
                     <div class="d-flex">

                        <div class="form-group flex-fill px-3">
                           <label class="form-label pt-2">Quantidade</label>
                           <div class="d-block">
                              <input type="number" class="form-control" name="qtdBiomodOrtognatica" id="qtdBiomodOrtognatica" onblur="changeBiomodOrtognatica(this)" />
                           </div>
                        </div>

                        <div class="flex-fill px-3 ">
                           <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                              <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_77c4a2b97ef8e35d732f7cb2394108b7.png" alt="Ícone Biomodelo Ortognatica">
                           </div>
                        </div>
                     </div>

                     <hr style="border: 1px #ee7624 solid;">
                  </div>


                  <div class="d-flex justify-content-end py-2">
                     <span name="addProduto" class="btn btn-primary" onclick="createProductList()">Adicionar</span>
                  </div>

               </div>
            </div>
         </div>
      </div>

      <hr style="border: 2px dashed #ccc;">
      <h4 class="text-conecta">Envio da TC</h4>
      <b style="color: #ee7624;">ATENÇÃO! Certifique-se de que o upload de arquivos foi concluido antes de enviar.</b>
      <p>Fazer o up-load de arquivos da área. Arquivos permitidos: rtf, zip, stl, dcm, obj, rar, dicom, 7zip, 7z.</p>


      <div class="p-2 mb-2 bg-light text-dark rounded">
         <div class="p-2 border border-5 rounded" style="border-style: dashed !important; border-width: 2px !important;">
            <!--<iframe src="https://www.sendgb.com/" frameborder="0" width="100%" height="400px"></iframe>-->
            <!-- <div class="d-flex justify-content-center align-itens-center">
                <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_a157a8a9e0b877cb265ac5c80b7dbb23.png" width="100px" alt="Arraste e Solte"> 
               <div class="icon"><i class="fas fa-cloud-upload-alt fa-5x text-muted"></i></div>
            </div> -->

            <!-- <div class="d-flex justify-content-center p-2">
               <p class="muted">Clique no ícone abaixo para selecionar seu arquivo</p>
            </div> -->

            <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
            <br />

            <div id="container">
               <a class="text-black" id="pickfiles" href="javascript:;">[Select files]</a>
               <a class="text-black" id="uploadfiles" href="javascript:;">[Upload files]</a>
            </div>
            <!-- //AQUI -->
            <!-- <div id="container d-flex justify-content-center align-itens-center">
               <a class="text-center" id="pickfiles" href="javascript:;" style="color: black;">[Browse...]</a>
               <input type="file" class="custom-file-input" id="file" name="file" accept=".rtf, .zip, .stl, .dcm, .obj, .rar, .dicom, .7zip, .7z" hidden>
               <label for="file" class="text-center d-flex justify-content-center " style="color: black;">
                  <div class="icon"><i class="fas fa-cloud-upload-alt fa-5x text-muted"></i></div>
               </label>
            </div>
            <div class="d-flex justify-content-center p-2">
               <p class="muted">Clique no ícone acima para selecionar seu arquivo e fazer o upload.</p>
            </div>
            <br>
            <ul id="filelist" style="color: black;"></ul> -->
            <!-- //ATE AQUI -->
            <!-- <div class="d-flex justify-content-center align-itens-center">
               <span class="text-muted">jogue aqui seus arquivos ou <label for="file" style="text-decoration: underline; color: blue;">procure</label></span>
            </div>
            <div id="container">
               <input type="file" class="custom-file-input" id="file" name="file" accept=".rtf, .zip, .stl, .dcm, .obj, .rar, .dicom, .7zip, .7z">
               <div id="filelist"></div>

            </div> -->
            <!--<iframe src="https://forms.gle/yPJApnzXrXQURKt36" frameborder="0" width="100%" height="400px"></iframe>

            <div class="custom-file">
               <input type="file" id="file" name="file" accept=".rtf, .zip, .stl, .dcm, .obj, .rar, .dicom, .7zip, .7z" onchange="verifyInputFile(this)">
                <a href="https://fileinbox.com/conecta" class="fileinbox">Upload Files through fileinbox.com</a> <script type="text/javascript" src="https://fileinbox.com/embed.js"></script> 



               <input type="file" class="custom-file-input" id="file" name="file" accept=".rtf, .zip, .stl, .dcm, .obj, .rar, .dicom, .7zip, .7z"> 
               <label class="custom-file-label" for="file">Escolha um arquivo</label>
            </div>-->
         </div>
      </div>


      <div class="py-4 col d-flex justify-content-center">
         <button class="btn btn-conecta" type="submit" name="submit" id="submit">Enviar</button>
      </div>
   </form>
   <script>
      function maskCel() {
         var cel = document.getElementById("teldr");

         if (cel.value.length == 1) {
            cel.value = '(' + cel.value;
         }

         if (cel.value.length == 3) {
            cel.value += ') ';
         } else if (cel.value.length == 10) {
            cel.value += '-';
         }

      }
   </script>

   <!-- (B) LOAD PLUPLOAD FROM CDN 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.full.min.js"></script>

   <script type="text/javascript">
      // Custom example logic

      var uploader = new plupload.Uploader({
         runtimes: 'html5,flash,silverlight,html4',

         browse_button: 'pickfiles', // you can pass in id...
         container: document.getElementById('container'), // ... or DOM Element itself

         url: "upload.php",

         // Flash settings
         flash_swf_url: '/plupload/js/Moxie.swf',

         // Silverlight settings
         silverlight_xap_url: '/plupload/js/Moxie.xap',


         init: {
            PostInit: function() {
               document.getElementById('filelist').innerHTML = '';

               document.getElementById('uploadfiles').onclick = function() {
                  uploader.start();
                  return false;
               };
            },

            FilesAdded: function(up, files) {
               plupload.each(files, function(file) {
                  document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
               });
            },

            UploadProgress: function(up, file) {
               document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },

            Error: function(up, err) {
               document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
         }
      });

      uploader.init();
   </script>-->

<?php
}

?>