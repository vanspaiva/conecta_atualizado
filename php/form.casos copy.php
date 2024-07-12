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

   if ($row['usersCnpj'] != null) {
      $cnpjcpf = $row['usersCnpj'];
   } else {
      $cnpjcpf = $row['usersCpf'];
   }

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
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.dev.min.js"></script> -->
   <!-- <script>
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
            <div class="form-group d-inline-block flex-fill m-2">
               <label class="control-label" style="color:black;">CNPJ/CPF</label>
               <input class="form-control" type="text" name="cnpjcpf" id="cnpjcpf" type="text" value="<?php echo $cnpjcpf; ?>" readonly>
            </div>
         </div>
         <hr>
      </div>

      <!--DATA - ID PROPOSTA - UF - NOME DR - NOME PAC -->

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
         echo "       <label class='control-label'>Convênio <b style='color: red;'>*</b></label>";
         echo "       <select class='form-control' name='convenio' id='convenio' required>";
         echo "          <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>";
         $retConvenio = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName ASC;");
         while ($rowConvenio = mysqli_fetch_array($retConvenio)) {
            echo "          <option value='" . $rowConvenio['convName'] . "'>" . $rowConvenio['convName'] . "</option>";
         }




         echo "       </select>";
         echo "    </div>";
         echo " </div>";
      }
      ?>

      <?php
      if (($_SESSION["userperm"] == 'Comercial') || ($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Representante')) {
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
         echo "       <label class='control-label'>Convênio <b style='color: red;'>*</b></label>";
         echo "       <select class='form-control' name='convenio' id='convenio' required>";
         echo "          <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>";
         $retConvenio = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName ASC;");
         while ($rowConvenio = mysqli_fetch_array($retConvenio)) {
            echo "          <option value='" . $rowConvenio['convName'] . "'>" . $rowConvenio['convName'] . "</option>";
         }
         echo "       </select>";
         echo "    </div>";
         echo " </div>";
      }
      ?>

      <?php
      if ($_SESSION["userperm"] == 'Distribuidor(a)') { ?>
         <div class='d-flex d-block justify-content-around'>
            <div hidden>
               <div class='form-group d-inline-block flex-fill m-2'>
                  <label class='control-label' style='color:black;'>Doutor Uid <b style='color: red;'>*</b> </label>
                  <input class='form-control' name='userdr' id='userdr' type='text' required>
               </div>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>Doutor <b style='color: red;'>*</b> <small><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addDr"><i class="fas fa-plus"></i> Add Dr(a)</button></small></label>
               <input class='form-control' name='nomedr' id='nomedr' type='text' style='text-transform: capitalize;' required>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>E-mail para envio da Proposta <b style='color: red;'>*</b></label>
               <input class='form-control' name='emailempresa' id='emailempresa' type='text' value="<?php echo $row['usersEmailEmpresa']; ?>" required>
            </div>
         </div>

         <div class='d-flex d-block justify-content-around'>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>E-mail Dr(a) <b style='color: red;'>*</b></label>
               <input class='form-control' name='emaildr' id='emaildr' type='text' required>
               <small>Para dúvidas e devolutivas</small>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>Telefone Dr(a) <b style='color: red;'>*</b></label>
               <input class='form-control' name='teldr' id='teldr' type='text' value=" <?php echo  $formtelDr; ?>" placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required>
               <small>Para notificação pelo whatsapp</small>
            </div>
         </div>

         <div class='d-flex d-block justify-content-around'>
            <div class='form-group d-inline-block flex-fill flex-wrap m-2'>
               <label class='control-label' style='color:black;'>Nome Paciente<b style='color: red;'>*</b></label>
               <input class='form-control' name='nomepaciente' id='nomepaciente' type='text' maxlength='5' style='text-transform: uppercase;' required>
               <small>Somente Iniciais</small>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label'>Convênio <b style='color: red;'>*</b></label>
               <select class='form-control' name='convenio' id='convenio' required>
                  <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>
                  <?php
                  $retConvenio = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName ASC;");
                  while ($rowConvenio = mysqli_fetch_array($retConvenio)) { ?>
                     <option value=" <?php echo $rowConvenio['convName']; ?>"><?php echo $rowConvenio['convName']; ?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
         </div>

         <!-- Modal Add UF-->
         <div class="modal fade" id="addDr" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title text-black">Novo Cadastro</h5>
                     <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="form-row">
                        <div class="form-group col-md ">

                           <?php
                           $azRange = range('A', 'Z');
                           foreach ($azRange as $letter) {
                           ?>
                              <button type="button" class="btn btn-secondary p-1 m-1" style="min-width: 30px;" onclick="searchByLetter(this)" value="<?php echo $letter; ?>"><?php echo $letter; ?></button>
                           <?php
                           }
                           ?>

                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                        <script>
                           function searchByLetter(letter) {

                              //Recuperar o valor do campo
                              var pesquisa = letter.value;

                              document.getElementById("druid").value = pesquisa;
                              var userCriador = document.getElementById("nomecriador").value;

                              //Verificar se há algo digitado
                              if (pesquisa != '') {
                                 var dados = {
                                    uid: pesquisa,
                                    userCriador: userCriador
                                 }
                                 $.post('proc_pesq_dr.php', dados, function(retorna) {
                                    //Mostra dentro da ul os resultado obtidos 
                                    if (retorna === "") {
                                       document.getElementById("userdr").value = '';
                                       document.getElementById("nomedr").value = '';
                                       document.getElementById("emaildr").value = '';
                                       document.getElementById("teldr").value = '';

                                       var tr = ``;

                                       document.querySelector("#result").innerHTML = '';
                                       document.querySelector("#result").insertAdjacentHTML("afterbegin", tr);
                                    } else {
                                       var array = retorna.split('/');
                                       var nome = array[0];
                                       var email = array[1];
                                       var fone = array[2];
                                       var druid = array[3];

                                       // document.getElementById("userdr").value = druid;
                                       // document.getElementById("nomedr").value = nome;
                                       // document.getElementById("emaildr").value = email;
                                       // document.getElementById("teldr").value = fone;

                                       var tr = `
                                          <tr id="trNew">
                                             <td><input type="text" class="form-control" id="drUser" name="drUser" value="${druid}" readonly></td>
                                             <td><input type="text" class="form-control" id="drNome" name="drNome" value="${nome}" readonly></td>
                                             <td><input type="text" class="form-control" id="drEmail" name="drEmail" value="${email}" readonly></td>
                                             <td><input type="text" class="form-control text-center" id="drTel" name="drTel" value="${fone}" readonly></td>
                                             <td><span class="btn" onclick="adicionarnalista(this)"><i class="far fa-plus-square" style="color: #000;"></i></span></td>
                                          </tr>
                                       `;

                                       document.querySelector("#result").innerHTML = '';
                                       document.querySelector("#result").insertAdjacentHTML("afterbegin", tr);
                                    }

                                 });
                              }
                           }

                           function adicionarnalista(elem) {
                              var parentElement1 = elem.parentElement;
                              parentElement1 = parentElement1.parentElement;
                              var user = parentElement1.children[0].firstChild.value;
                              var nome = parentElement1.children[1].firstChild.value;
                              var email = parentElement1.children[2].firstChild.value;
                              var tel = parentElement1.children[3].firstChild.value;

                              // console.log(user);
                              // console.log(nome);
                              // console.log(email);
                              // console.log(tel);

                              document.getElementById("userdr").value = user;
                              document.getElementById("nomedr").value = nome;
                              document.getElementById("emaildr").value = email;
                              document.getElementById("teldr").value = tel;

                              $('#closemodal').click();
                           }
                        </script>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md">
                           <label class="text-black" for="druid">Nome Usuário</label>
                           <input name="druid" class="form-control" id="druid" onkeyup="searchByLetter(this)" />
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md">
                           <div class="d-flex justify-content-center">
                              <table id="tableProp" class="table table-striped table-advance table-hover">
                                 <thead>
                                    <tr style="background-color: #ee7624; color: #fff;" class="text-center">
                                       <th>Usuário</th>
                                       <th>Nome</th>
                                       <th>E-mail</th>
                                       <th>Telefone</th>
                                       <th> </th>
                                    </tr>
                                 </thead>
                                 <tbody class="tbody" id="result">
                                 </tbody>
                              </table>
                           </div>

                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php
      }
      ?>

      <?php
      if ($_SESSION["userperm"] == 'Dist. Comercial') { ?>
         <div class=' d-flex d-block justify-content-around'>
            <div hidden>
               <div class='form-group d-inline-block flex-fill m-2'>
                  <label class='control-label' style='color:black;'>Doutor Uid <b style='color: red;'>*</b> </label>
                  <input class='form-control' name='userdr' id='userdr' type='text' required>
               </div>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>Doutor <b style='color: red;'>*</b> <small><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addDr"><i class="fas fa-plus"></i> Add Dr(a)</button></small></label>
               <input class='form-control' name='nomedr' id='nomedr' type='text' style='text-transform: capitalize;' required>
            </div>

            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>E-mail para envio da Proposta <b style='color: red;'>*</b></label>
               <input class='form-control' name='emailempresa' id='emailempresa' type='text' value="<?php echo $row['usersEmailEmpresa']; ?>" required readonly>
            </div>
         </div>

         <div class='d-flex d-block justify-content-around'>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>E-mail Dr(a) <b style='color: red;'>*</b></label>
               <input class='form-control' name='emaildr' id='emaildr' type='text' required>
               <small>Para dúvidas e devolutivas</small>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label' style='color:black;'>Telefone Dr(a) <b style='color: red;'>*</b></label>
               <input class='form-control' name='teldr' id='teldr' type='text' value=" <?php echo  $formtelDr; ?>" placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required>
               <small>Para notificação pelo whatsapp</small>
            </div>
         </div>

         <div class='d-flex d-block justify-content-around'>
            <div class='form-group d-inline-block flex-fill flex-wrap m-2'>
               <label class='control-label' style='color:black;'>Nome Paciente<b style='color: red;'>*</b></label>
               <input class='form-control' name='nomepaciente' id='nomepaciente' type='text' maxlength='5' style='text-transform: uppercase;' required>
               <small>Somente Iniciais</small>
            </div>
            <div class='form-group d-inline-block flex-fill m-2'>
               <label class='control-label'>Convênio <b style='color: red;'>*</b></label>
               <select class='form-control' name='convenio' id='convenio' required>
                  <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>
                  <?php
                  $retConvenio = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName ASC;");
                  while ($rowConvenio = mysqli_fetch_array($retConvenio)) { ?>
                     <option value=" <?php echo $rowConvenio['convName']; ?>"><?php echo $rowConvenio['convName']; ?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
         </div>
         <!-- Modal Add UF-->
         <div class="modal fade" id="addDr" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title text-black">Novo Cadastro</h5>
                     <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="form-row">
                        <div class="form-group col-md ">

                           <?php
                           $azRange = range('A', 'Z');
                           foreach ($azRange as $letter) {
                           ?>
                              <button type="button" class="btn btn-secondary p-1 m-1" style="min-width: 30px;" onclick="searchByLetter(this)" value="<?php echo $letter; ?>"><?php echo $letter; ?></button>
                           <?php
                           }
                           ?>

                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
                        <script>
                           function searchByLetter(letter) {

                              //Recuperar o valor do campo
                              var pesquisa = letter.value;

                              document.getElementById("druid").value = pesquisa;
                              var userCriador = document.getElementById("nomecriador").value;

                              //Verificar se há algo digitado
                              if (pesquisa != '') {
                                 var dados = {
                                    uid: pesquisa,
                                    userCriador: userCriador
                                 }
                                 $.post('proc_pesq_dr.php', dados, function(retorna) {
                                    //Mostra dentro da ul os resultado obtidos 
                                    if (retorna === "") {
                                       document.getElementById("userdr").value = '';
                                       document.getElementById("nomedr").value = '';
                                       document.getElementById("emaildr").value = '';
                                       document.getElementById("teldr").value = '';

                                       var tr = ``;

                                       document.querySelector("#result").innerHTML = '';
                                       document.querySelector("#result").insertAdjacentHTML("afterbegin", tr);
                                    } else {
                                       var array = retorna.split('/');
                                       var nome = array[0];
                                       var email = array[1];
                                       var fone = array[2];
                                       var druid = array[3];

                                       // document.getElementById("userdr").value = druid;
                                       // document.getElementById("nomedr").value = nome;
                                       // document.getElementById("emaildr").value = email;
                                       // document.getElementById("teldr").value = fone;

                                       var tr = `
                                          <tr id="trNew">
                                             <td><input type="text" class="form-control" id="drUser" name="drUser" value="${druid}" readonly></td>
                                             <td><input type="text" class="form-control" id="drNome" name="drNome" value="${nome}" readonly></td>
                                             <td><input type="text" class="form-control" id="drEmail" name="drEmail" value="${email}" readonly></td>
                                             <td><input type="text" class="form-control text-center" id="drTel" name="drTel" value="${fone}" readonly></td>
                                             <td><span class="btn" onclick="adicionarnalista(this)"><i class="far fa-plus-square" style="color: #000;"></i></span></td>
                                          </tr>
                                       `;

                                       document.querySelector("#result").innerHTML = '';
                                       document.querySelector("#result").insertAdjacentHTML("afterbegin", tr);
                                    }

                                 });
                              }
                           }

                           function adicionarnalista(elem) {
                              var parentElement1 = elem.parentElement;
                              parentElement1 = parentElement1.parentElement;
                              var user = parentElement1.children[0].firstChild.value;
                              var nome = parentElement1.children[1].firstChild.value;
                              var email = parentElement1.children[2].firstChild.value;
                              var tel = parentElement1.children[3].firstChild.value;

                              // console.log(user);
                              // console.log(nome);
                              // console.log(email);
                              // console.log(tel);

                              document.getElementById("userdr").value = user;
                              document.getElementById("nomedr").value = nome;
                              document.getElementById("emaildr").value = email;
                              document.getElementById("teldr").value = tel;

                              $('#closemodal').click();
                           }
                        </script>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md">
                           <label class="text-black" for="druid">Nome Usuário</label>
                           <input name="druid" class="form-control" id="druid" onkeyup="searchByLetter(this)" />
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md">
                           <div class="d-flex justify-content-center">
                              <table id="tableProp" class="table table-striped table-advance table-hover">
                                 <thead>
                                    <tr style="background-color: #ee7624; color: #fff;" class="text-center">
                                       <th>Usuário</th>
                                       <th>Nome</th>
                                       <th>E-mail</th>
                                       <th>Telefone</th>
                                       <th> </th>
                                    </tr>
                                 </thead>
                                 <tbody class="tbody" id="result">
                                 </tbody>
                              </table>
                           </div>

                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php
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
         echo "       <label class='control-label'>Convênio <b style='color: red;'>*</b></label>";
         echo "       <select class='form-control' name='convenio' id='convenio' required>";
         echo "          <option value='0' selected style='color: #F6F7FA;'>Escolha um convênio</option>";
         $retConvenio = mysqli_query($conn, "SELECT * FROM convenios ORDER BY convName ASC;");
         while ($rowConvenio = mysqli_fetch_array($retConvenio)) {
            echo "          <option value='" . $rowConvenio['convName'] . "'>" . $rowConvenio['convName'] . "</option>";
         }
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
               <th scope="col">Qtd</th>
               <th scope="col"></th>
            </tr>
         </thead>
         <tbody class="tableProd"></tbody>
      </table>



      <input type="text" id="tipoProd" name="tipoProd" hidden />
      <input type="text" id="listaItens" name="listaItens" hidden />
      <input type="text" id="listaQtdItens" name="listaQtdItens" hidden />
      <input type="text" id="longListaItens" name="longListaItens" hidden />
      <input type="text" id="espessuraSmartmold" name="espessuraSmartmold" hidden />

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Novo Produto</h5>
                  <button id="closeProdModal" type="button" class="close" data-dismiss="modal" aria-label="Fechar">
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
                  <div class="atm">


                     <div id="atmBig" class="atmBig d-none">
                        <h4>ATM</h4>
                        <!--<p class="lh-base" style="text-align:justify; text-justify:initial; text-indent: 50px;">
                        No momento atual estamos com restrições da matéria prima específica do polietileno com vitamina 'E'
                        para proteses de ATM, sendo ummaterial restrito a poucos fornecedores nomundo e por motivos de devolução
                        recente de toda a importação pelo setor de Qualidade, devido ao fornecedor não estar conforme nas certificações
                        exigidas pela CPMH, diante deste imprevisto por cortinas maiores esperamos que o tempo de estabilidade seja de 3 a 4meses.
                        Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de
                        implantes seguros e eficaz, não conseguimos realizar este projeto. Mesmo assim deseja solicitar a sua proposta?
                        </p>-->
                        <div class="form-group">
                           <label class="form-label pt-2"><b>Tipo</b></label>
                           <div class="d-block col">
                              <div class="form-check form-check-inline col-md-2">
                                 <input class="form-check-input" type="radio" name="radioTipoAtmBig" id="atmStandartBig" value="Standart" onclick="handleTipoAtm(this)">
                                 <label class="form-check-label" for="atmStandartBig">Standart</label>
                              </div>
                              <div class="form-check form-check-inline col-md-2">
                                 <input class="form-check-input" type="radio" name="radioTipoAtmBig" id="atmSobmedidaBig" value="Sobmedida" onclick="handleTipoAtm(this)">
                                 <label class="form-check-label" for="atmSobmedidaBig">Sobmedida</label>
                              </div>
                           </div>
                        </div>

                        <div class="d-none" id="atmSobmedidaFieldBig">
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
                        </div>

                        <div class="d-none" id="atmStandartFieldBig">

                           <div class="form-group flex-fill px-3 py-4">
                              <div class="d-flex justify-content-center">
                                 <div class="px-5">
                                    <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_2a17c080858351e532b02bdf9968bd4a.png" alt="ATM Direito">
                                 </div>
                                 <div class="px-2">
                                    <div class="px-2 d-flex justify-content-around">
                                       <table>
                                          <tbody>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="ppp" value="ppp" onclick="setTamanhoStandartDireito(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="mmp" value="mmp" onclick="setTamanhoStandartDireito(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="ppm" value="ppm" onclick="setTamanhoStandartDireito(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="mmm" value="mmm" onclick="setTamanhoStandartDireito(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="ppg" value="ppg" onclick="setTamanhoStandartDireito(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="mmg" value="mmg" onclick="setTamanhoStandartDireito(this)">
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                             </tr>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                             </tr>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">G</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">G</td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <hr>
                           <div class="form-group flex-fill px-3">
                              <div class="d-flex justify-content-center">
                                 <div class="px-5">
                                    <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0b431f518e9c871e80f523722e66d51b.png" alt="ATM Esquerdo">
                                 </div>
                                 <div class="px-2">
                                    <div class="px-2 d-flex justify-content-around">
                                       <table>
                                          <tbody>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhaesquerdo" id="ppp" value="ppp" onclick="setTamanhoStandartEsquerdo(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhaesquerdo" id="mmp" value="mmp" onclick="setTamanhoStandartEsquerdo(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhaesquerdo" id="ppm" value="ppm" onclick="setTamanhoStandartEsquerdo(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhaesquerdo" id="mmm" value="mmm" onclick="setTamanhoStandartEsquerdo(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhaesquerdo" id="ppg" value="ppg" onclick="setTamanhoStandartEsquerdo(this)">
                                                   </div>
                                                </td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                                   <div class="form-check form-check-inline col-md-2">
                                                      <input class="p-1 form-check-input" type="radio" name="escolhaesquerdo" id="mmg" value="mmg" onclick="setTamanhoStandartEsquerdo(this)">
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                             </tr>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                             </tr>
                                             <tr class="d-flex justify-content-center align-items-center p-2">
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">P</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">M</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">G</td>
                                                <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">G</td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>

                           </div>

                        </div>
                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="atmSmall" class="atmSmall d-none">
                        <h4>ATM</h4>

                        <div class="form-group">
                           <label class="form-label pt-2"><b>Tipo</b></label>
                           <div class="d-block col">
                              <div class="form-check form-check-inline col-md-2">
                                 <input class="form-check-input" type="radio" name="radioTipoAtmSmall" id="atmStandartSmall" value="Standart" onclick="handleTipoAtm(this)">
                                 <label class="form-check-label" for="atmStandartSmall">Standart</label>
                              </div>
                              <div class="form-check form-check-inline col-md-2">
                                 <input class="form-check-input" type="radio" name="radioTipoAtmSmall" id="atmSobmedidaSmall" value="Sobmedida" onclick="handleTipoAtm(this)">
                                 <label class="form-check-label" for="atmSobmedidaSmall">Sobmedida</label>
                              </div>
                           </div>
                        </div>

                        <div class="d-none" id="atmSobmedidaFieldSmall">
                           <div class="d-flex">

                              <div class="form-group flex-fill px-3">
                                 <label class="form-label pt-2"><b>Região</b></label>
                                 <div class="d-block">
                                    <select class="form-control" name="atmRegiaoSmall" id="atmRegiaoSmall" onchange="selectAtm()">
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
                                    <select class="form-control" name="atmTamanhoSmall" id="atmTamanhoSmall" onchange="setTamanho(this)">
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
                        </div>

                        <div class="d-none" id="atmStandartFieldSmall">
                           <div class="form-group flex-fill px-3 py-4">
                              <div class="d-flex justify-content-center">

                                 <div class="px-2">
                                    <div class="px-2 d-flex justify-content-center">
                                       <div class="form-group flex-fill px-3">
                                          <label class="form-label pt-2"><b>Tamanho Direita</b></label>
                                          <div class="d-block">
                                             <select class="form-control" name="escolhadireitoSmall" id="escolhadireitoSmall" onchange="setTamanhoStandartDireito(this)">
                                                <option value="0">Selecione uma opção</option>
                                                <option value="ppp">Fossa P - Cabeça P - Placa P</option>
                                                <option value="mmp">Fossa M - Cabeça M - Placa P</option>
                                                <option value="ppm">Fossa P - Cabeça P - Placa M</option>
                                                <option value="mmm">Fossa M - Cabeça M - Placa M</option>
                                                <option value="ppg">Fossa P - Cabeça P - Placa G</option>
                                                <option value="mmg">Fossa M - Cabeça M - Placa G</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group flex-fill px-3">
                                          <label class="form-label pt-2"><b>Tamanho Esquerda</b></label>
                                          <div class="d-block">
                                             <select class="form-control" name="escolhaesquerdoSmall" id="escolhaesquerdoSmall" onchange="setTamanhoStandartEsquerdo(this)">
                                                <option value="0">Selecione uma opção</option>
                                                <option value="ppp">Fossa P - Cabeça P - Placa P</option>
                                                <option value="mmp">Fossa M - Cabeça M - Placa P</option>
                                                <option value="ppm">Fossa P - Cabeça P - Placa M</option>
                                                <option value="mmm">Fossa M - Cabeça M - Placa M</option>
                                                <option value="ppg">Fossa P - Cabeça P - Placa G</option>
                                                <option value="mmg">Fossa M - Cabeça M - Placa G</option>
                                             </select>
                                          </div>
                                       </div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <hr style="border: 1px #ee7624 solid;">
                     </div>

                     <div id="aluguelCx" class="aluguelCx d-none">
                        <p>Produto Acompanha dispositivos e parafusos. OBS: quantidades são estabelecidas por padrão, caso deseja alterar entre em contato com o comercial.</p>
                        <div class="form-group">
                           <label class="form-label pt-2"><b>Deseja selecionar alguel da Caixa?</b></label>
                           <div class="d-block">
                              <select class="form-control" name="selectAluguelCx" id="selectAluguelCx" onchange="selectCaixa(this)">
                                 <option value="0">Selecione uma opção</option>
                                 <option value="super">Super Caixa Instrumental - R$3.500,00</option>
                                 <option value="basica">Caixa Básica Parafusos - R$750,00</option>
                              </select>
                           </div>
                        </div>
                     </div>
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
                                 <option value="PMMA" selected>PMMA</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="espessuraZigoma">Espessura Zigoma (mm)</label>
                              <input class="form-control" type="text" id="espessuraZigoma" name="espessuraZigoma" onchange="populateEspessura(this)" />
                              <small>Ex: 4 mm</small>
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
                                 <option value="PMMA" selected>PMMA</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="espessuraParanasal">Espessura Paranasal (mm)</label>
                              <input class="form-control" type="text" id="espessuraParanasal" name="espessuraParanasal" onchange="populateEspessura(this)" />
                              <small>Ex: 4 mm</small>
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
                                 <option value="PMMA" selected>PMMA</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="espessuraMento">Espessura Mento (mm)</label>
                              <input class="form-control" type="text" id="espessuraMento" name="espessuraMento" onchange="populateEspessura(this)" />
                              <small>Ex: 4 mm</small>
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
                                 <option value="PMMA" selected>PMMA</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="espessuraAngulo">Espessura Âng de Mand (mm)</label>
                              <input class="form-control" type="text" id="espessuraAngulo" name="espessuraAngulo" onchange="populateEspessura(this)" />
                              <small>Ex: 4 mm</small>
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
                                 <option value="PMMA" selected>PMMA</option>
                              </select>
                           </div>

                           <div class="form-group flex-fill px-3">
                              <label class="form-label" for="espessuraPremaxila">Espessura Pré-Maxila (mm)</label>
                              <input class="form-control" type="text" id="espessuraPremaxila" name="espessuraPremaxila" onchange="populateEspessura(this)" />
                              <small>Ex: 4 mm</small>
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
      <!-- <input type="text" id="keyInputNumber" name="keyInputNumber" hidden />
      <input type="text" id="weblinkInput" name="weblinkInput" hidden /> -->
      <input type="text" id="textExtraProd" name="textExtraProd" hidden />
      <input type="text" id="radioTaxa" name="radioTaxa" hidden />

      <!--submit-->


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

      <!--Taxa Extra-->
      <hr style="border: 2px dashed #ccc;">
      <h4 class="text-conecta">Taxa Extra</h4>

      <div class="p-2">
         <span>Deseja solicitar taxa extra de 20% do valor final para antecipação? <b style="color: red;">*</b></label></span>
         <div class="form-group d-inline-block flex-fill mx-1 py-3 w-100">
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="radioTaxaExtra" id="radioTaxaSim" value="sim">
               <label class="form-check-label" for="radioTaxaSim">Sim</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="radioTaxaExtra" id="radioTaxaNao" value="não">
               <label class="form-check-label" for="radioTaxaNão">Não</label>
            </div>
         </div>
      </div>

      <!-- Button trigger modal -->
      <button id="btnTaxa" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taxaModal" hidden>
         Taxa
      </button>

      <script>
         $('#radioTaxaSim').click(function() {
            $('#radioTaxa').val(document.getElementById('radioTaxaSim').value);
            $('#btnTaxa').click();
         });

         $('#radioTaxaNao').click(function() {
            $('#radioTaxa').val(document.getElementById('radioTaxaNao').value);
            $('#btnTaxa').click();
         });
      </script>

      <!-- Modal -->
      <div class="modal fade" id="taxaModal" tabindex="-1" aria-labelledby="taxaModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="taxaModalLabel">Taxa extra de antecipação</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                  <p><b>Atenção!</b> Solicitação de antecipação do pedido está sujeita a análise. </p>
                  <img class="img-fluid" src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_6f888d2544d5c65842895c374aadd90e.png" alt="Taxa de Antecipação">
               </div>
            </div>
         </div>
      </div>



      <!--LGPD-->
      <hr style="border: 2px dashed #ccc;">
      <h4 class="text-conecta">LGPD</h4>
      <div class="form-group p-3">
         <div class="d-flex justify-content-start">
            <div class="form-check form-check-inline p-2">
               <input class="form-check-input" type="checkbox" name="termo" id="termo" value="termo" required>
               <label class="form-check-label" for="termo">Declaro que li e concordo com o termo referente a LGPD. <b style="color: red;">*</b></label>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               <p style="line-height: 1.2rem;">Estou ciente da lei de proteção de dados (LGPD), e a paciente esta ciente do compartilhamento do seu exame com 3º. Conforme a LGPD (lei geral de proteção de dados) os exames do paciente precisam ter o consentimento dele para serem compartilhado com terceiros, podendo ocasionar multas para quem infligir a lei, trata-se de dados sensíveis. </p>

            </div>
         </div>
      </div>

      <!--TERMO DE CIÊNCIA-->
      <hr style="border: 2px dashed #ccc;">
      <h4 class="text-conecta">TERMO DE CIÊNCIA</h4>
      <div class="form-group p-3">
         <div class="d-flex justify-content-start">
            <div class="form-check form-check-inline p-2">
               <input class="form-check-input" type="checkbox" name="termo2" id="termo2" value="termo2" required>
               <label class="form-check-label" for="termo2">Declaro que li e concordo com o termo de ciência do prazo de validade da TC. <b style="color: red;">*</b></label>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               <p style="line-height: 1.2rem;">Prazo de validade da Tomografia para projetos é no máximo de 6 meses para garantir precisão e eficácia do implante Sob Medida, caso a data do laudo esteja superior a 6 meses será necessário uma nova TC do paciente no momento de realizarmos o projeto.</p>

            </div>
         </div>
      </div>

      <!--ENVIO TC-->
      <hr style="border: 2px dashed #ccc;">
      <h4 class="text-conecta">Envio da TC</h4>
      <!-- <span style="color: #6c757d;">Prezado cliente, estamos passando por algumas mudanças para melhor lhe atender. Por esse motivo, estaremos recebendo as TC's temporariamente por meio do We Transfer.</span>
      <p>Por favor, faça o upload pelo <a href="https://wetransfer.com/" target="_blank" style="color: #ee7624; text-decoration: underline;">wetransfer</a> crie um link compartilhável e insira a seguir o link do arquivo. Para mais informações entrar em contato pelo e-mail negocios@cpmh.com.br ou pelo telefone (61) 3028-8861.</p>
      </b> -->
      <b style="color: #ee7624;">ATENÇÃO! Certifique-se de que a tomografia foi realizada dentro de um prazo de 6 meses.</b>
      <p>Fazer o up-load de arquivos da área. </p>
      <!-- <p>Fazer o up-load de arquivos da área. Arquivos permitidos: rtf, zip, stl, dcm, obj, rar, dicom, 7zip, 7z.</p> -->


      <div class="p-2 mb-2 bg-light text-dark rounded">
         <div class="row p-2 border border-5 rounded" style="border-style: dashed !important; border-width: 2px !important;">


            <!-- <form id="sendForm" class="col-sm">  -->

            <div class="col-md form-group ">
               <label class='control-label text-black'>Anexe aqui a tomografia <b style="color: red;">*</b></label>
               <div class="d-flex justify-content-center p-2 border rounded bg-light">
                  <div>
                     <label class="d-block" for="tcfile" style="text-align: center;"><i class="fas fa-upload fa-3x hovericon"></i></label>
                     <small class="d-block" id="tcfileName" style="text-align: center; color: #ee7624;"></small>
                  </div>
               </div>
               <input class="form-control" type="file" id="tcfile" name="tcfile" onchange="javascript:updateListTC()" accept=".rtf, .zip, .stl, .dcm, .obj, .rar, .dicom, .7zip, .7z" hidden>
               <small class="text-muted">Arquivos permitidos: rtf, zip, stl, dcm, obj, rar, dicom, 7zip, 7z</small>
               <script>
                  updateListTC = function() {
                     var input = document.getElementById('tcfile');
                     var output = document.getElementById('tcfileName');

                     output.innerHTML = '';
                     for (var i = 0; i < input.files.length; ++i) {
                        output.innerHTML += input.files.item(i).name;
                     }
                  }
               </script>
               <style>
                  .hovericon {
                     transition: ease all 0.2s;
                  }

                  .hovericon:hover {
                     transform: scale(0.9);
                     cursor: pointer;
                  }
               </style>
            </div>

            <div class="col-md form-group">
               <label class='control-label text-black'>Anexe aqui o laudo da tomografia (TC) <b style="color: red;">*</b></label>
               <div class="d-flex justify-content-center p-2 border rounded bg-light">
                  <div>
                     <label class="d-block" for="laudofile" style="text-align: center;"><i class="fas fa-upload fa-3x hovericon"></i></label>
                     <small class="d-block" id="laudofileName" style="text-align: center; color: #ee7624;"></small>
                  </div>
               </div>
               <input class="form-control" type="file" id="laudofile" name="laudofile" onchange="javascript:updateListLaudo()" accept=".pdf" hidden>
               <small class="text-muted">Arquivos permitidos: pdf</small>
               <script>
                  updateListLaudo = function() {
                     var input = document.getElementById('laudofile');
                     var output = document.getElementById('laudofileName');

                     output.innerHTML = '';
                     for (var i = 0; i < input.files.length; ++i) {
                        output.innerHTML += input.files.item(i).name;
                     }
                  }
               </script>
               <style>
                  .hovericon {
                     transition: ease all 0.2s;
                  }

                  .hovericon:hover {
                     transform: scale(0.9);
                     cursor: pointer;
                  }
               </style>
            </div>
            <!-- </form> -->



            <!-- (B) LOAD PLUPLOAD FROM CDN 
             <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.full.min.js" defer></script> 
            <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
            <br />

            <div id="container">
               <a class="text-black" id="pickfiles" href="javascript:;">[Select files]</a>
               <a class="text-black" id="uploadfiles" href="javascript:;">[Upload files]</a>
            </div>

            <br />
            <pre id="console"></pre>

            <script src="php/plupload/js/plupload.full.min.js"></script>
            <script type="text/javascript">
               // Custom example logic

               var uploader = new plupload.Uploader({
                  runtimes: 'html5,flash,silverlight,html4',

                  browse_button: 'pickfiles', // you can pass in id...
                  container: document.getElementById('container'), // ... or DOM Element itself

                  url: "upload.php",

                  filters: {
                     max_file_size: '2gb',
                     mime_types: [{
                           title: "Image files",
                           extensions: "jpg,gif,png"
                        },
                        {
                           title: "Zip files",
                           extensions: "zip"
                        }
                     ]
                  },

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
         </div>

      </div>
      </div>

      <div class="py-4 col d-flex justify-content-center">
         <button class="btn btn-conecta" type="submit" name="submit" id="submit">Enviar</button>
      </div>
      <div class="py-4 col d-flex justify-content-center">
         <button class="btn btn-conecta" name="finalForm" id="finalForm" hidden>Enviar</button>
      </div>
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
   <script>
      $('#submit').click(function() {
         if (($('#radioTaxaNao').is(':checked')) || ($('#radioTaxaSim').is(':checked'))) {

            if ($("#termo").is(":checked") == false) {
               alert("Certifique-se de concordar com o termo da LGPD.");
            } else if ($("#termo2").is(":checked") == false) {
               alert("Certifique-se de concordar com o termo de ciência.");
            } else {
               $('#submit').trigger('click');
            }
         } else {
            alert("Escolha uma das opções da taxa extra.");
         }

      });
   </script>


<?php
}

?>