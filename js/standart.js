function passwordPopup() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}

function passwordPopup_close() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("hide");
}

/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "200px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function backHistory() {
  window.history.go(1);
}

$('#backBtn').on('click', function (event) {

  // prevenir comportamento normal do link
  window.history.go(1);

  // código a executar aqui
});


// // INÍCIO TIPO DE usuário
// function handleRegisterForm(tipoUsuario) {
//   tipoUsuario = tipoUsuario.value;
//   var registerForm = document.getElementById('register-form');
//   const permissao = document.querySelector('.usuario');
//   permissao.value = tipoUsuario;
//   createForm(tipoUsuario, registerForm);
// }
// FIM TIPO DE usuário

//CRIA O RESTANTE DO FORMULÁRIO
// function createForm(usuario, elemento) {
//   //variável que guarda o formulário completo
//   let formCompleto = " ";
//   console.log(formCompleto);

//   switch (usuario) { //menu de tipo de formulário
//     case "doutor": //chama os campos necessários e concatena em uma variável
//       formCompleto = callBase() + callDoutorComplemento() + callSenhas();
//       elemento.innerHTML = formCompleto;

//       break;

//     case "distribuidor":
//       formCompleto = callBase() + callDistribuidorComplemento() + callSenhas();
//       elemento.innerHTML = formCompleto;
//       break;

//     case "paciente":
//       formCompleto = callBase() + callPacienteComplemento() + callSenhas();
//       elemento.innerHTML = formCompleto;
//       break;

//     case "internacional":
//       formCompleto = callBaseInternacional() + callIternationalComplemento() + callSenhas();
//       elemento.innerHTML = formCompleto;
//       break;

//     case "0":
//       elemento.innerHtml = '';
//       break;
//     default:
//       console.log(`Erro interno. Opção "${valor}" não existe.`);
//   }
// }




// function callBase() { //monta o campo de DOUTOR
//   return (
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Nome Completo *</label>" +
//     "<input class='form-control py-4' name='name' type='text' style='text-transform: capitalize;' required />" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Usuário *</label>" +
//     "<input class='form-control py-4' name='username' type='text' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>" +

//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>E-mail *</label>" +
//     "<input class='form-control py-4' name='email' type='email' aria-describedby='emailHelp' required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Celular *</label>" +
//     "<input class='form-control py-4' name='celular' id='celular' type='text' placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>" +
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Telefone *</label>" +
//     "<input class='form-control py-4' name='tel' id='tel' type='text' placeholder='(xx) xxxx-xxxx' maxlength='14' onkeyup='maskTel()'  required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>UF *</label>" +
//     "<select class='form-select form-select-xl w-100 ' name='uf' required>" +
//     "<option selected>Selecione uma UF</option>" +
//     "<option value='AC'>Acre</option>" +
//     "<option value='AL'>Alagoas</option>" +
//     "<option value='AP'>Amapá</option>" +
//     "<option value='AM'>Amazonas</option>" +
//     "<option value='BA'>Bahia</option>" +
//     "<option value='CE'>Ceará</option>" +
//     "<option value='DF'>Distrito Federal</option>" +
//     "<option value='ES'>Espirito Santo</option>" +
//     "<option value='GO'>Goiás</option>" +
//     "<option value='MA'>Maranhão</option>" +
//     "<option value='MS'>Mato Grosso do Sul</option>" +
//     "<option value='MT'>Mato Grosso</option>" +
//     "<option value='MG'>Minas Gerais</option>" +
//     "<option value='PA'>Pará</option>" +
//     "<option value='PB'>Paraíba</option>" +
//     "<option value='PR'>Paraná</option>" +
//     "<option value='PE'>Pernambuco</option>" +
//     "<option value='PI'>Piauí</option>" +
//     "<option value='RJ'>Rio de Janeiro</option>" +
//     "<option value='RN'>Rio Grande do Norte</option>" +
//     "<option value='RS'>Rio Grande do Sul</option>" +
//     "<option value='RO'>Rondônia</option>" +
//     "<option value='RR'>Roraima</option>" +
//     "<option value='SC'>Santa Catarina</option>" +
//     "<option value='SP'>São Paulo</option>" +
//     "<option value='SE'>Sergipe</option>" +
//     "<option value='TO'>Tocantins</option>" +
//     "</select>" +
//     "</div>" +
//     "</div>" +
//     "</div>"
//   )
// }

// function callBaseInternacional() { //monta o campo de DOUTOR
//   return (
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Nome Completo *</label>" +
//     "<input class='form-control py-4' name='name' type='text' style='text-transform: capitalize;' required />" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Usuário *</label>" +
//     "<input class='form-control py-4' name='username' type='text' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>" +

//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>E-mail *</label>" +
//     "<input class='form-control py-4' name='email' type='email' aria-describedby='emailHelp' required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Celular *</label>" +
//     "<input class='form-control py-4' name='celular' id='celular' type='text' placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>" +
//     "<div class='form-row'>" +
//     "<div class='col'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Telefone *</label>" +
//     "<input class='form-control py-4' name='tel' id='tel' type='text' placeholder='(xx) xxxx-xxxx' maxlength='14' onkeyup='maskTel()' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>"
//   )
// }

// function callSenhas() { //monta o campo de SENHAS
//   return (
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Senha *</label>" +
//     "<input class='form-control py-4' name='password' type='password'  required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Confirmar Senha*</label>" +
//     "<input class='form-control py-4' name='confirmpassword' type='password' required />" +
//     "</div>" +
//     "</div>" +
//     "</div>" +
//     "<div class='form-row'>" +
//     "<div class='col-md'>" +
//     "<div class='form-check'>" +
//     "<input class='form-check-input check-required' type='checkbox' id='termsCheck' name='termsCheck'>" +
//     "<label class='form-check-label' for='flexCheckChecked' style='color:#fff;'>" +
//     "Ao informar meus dados, eu concordo com a <a href='https://www.cpmhdigital.com.br/politica-de-privacidade-app/' target='blank' style='text-decoration: underline;'>Política de Privacidade </a>e em receber ofertas e comunicação personalizadas de acordo com meus interesses" +
//     "</label>" +
//     "</div>" +
//     "</div>" +
//     "</div>" +
//     "<button class='form-group mt-4 mb-0 btn btn-primary btn-block' type='submit' name='submit' id='submit'>Criar Conta</button>"
//   )
// }

// function callDoutorComplemento() { //monta o campo de SENHAS
//   return (
//     `<div class='form-row'>
//     <div class='col-md'>
//         <div class='form-group'>
//             <label for="tipocr" class='ml-2 label-control text-white'>Conselho Profissional *</label>
//             <select id="tipocr" name="tipocr" class='form-select form-select-xl w-100 ' required>
//                 <option value="0">Escolha uma opção</option>
//                 <option value="CRM">de Medicina</option>
//                 <option value="CRO">de Odontologia</option>
//             </select>
//         </div>
//     </div>
//     <div class='col-md'>
//         <div class='form-group'>
//             <label for="ufcr" class='ml-2 label-control text-white'>UF Conselho *</label>
//             <select id="ufcr" name="ufcr" class='form-select form-select-xl w-100 ' required>
//                 <option selected>Selecione uma UF</option>
//                 <option value='AC'>AC</option>
//                 <option value='AL'>AL</option>
//                 <option value='AP'>AP</option>
//                 <option value='AM'>AM</option>
//                 <option value='BA'>BA</option>
//                 <option value='CE'>CE</option>
//                 <option value='DF'>DF</option>
//                 <option value='ES'>ES</option>
//                 <option value='GO'>GO</option>
//                 <option value='MA'>MA</option>
//                 <option value='MS'>MS</option>
//                 <option value='MT'>MT</option>
//                 <option value='MG'>MG</option>
//                 <option value='PA'>PA</option>
//                 <option value='PB'>PB</option>
//                 <option value='PR'>PR</option>
//                 <option value='PE'>PE</option>
//                 <option value='PI'>PI</option>
//                 <option value='RJ'>RJ</option>
//                 <option value='RN'>RN</option>
//                 <option value='RS'>RS</option>
//                 <option value='RO'>RO</option>
//                 <option value='RR'>RR</option>
//                 <option value='SC'>SC</option>
//                 <option value='SP'>SP</option>
//                 <option value='SE'>SE</option>
//                 <option value='TO'>TO</option>
//             </select>
//         </div>
//     </div>

//     <div class='col-md'>
//         <div class='form-group'>
//             <label class='ml-2 label-control text-white'>Nº do Conselho *</label>
//             <input class='form-control py-4' name='crm' id='crm' type='number' maxlength='6' required/>
//         </div>
//     </div>
// </div>

// <div class='form-row'>
//     <div class='col-md'>
//         <div class='form-group'>
//             <label class='ml-2 label-control text-white'>CPF *</label>
//             <input class='form-control py-4' name='cpf' id='cpf' type='text' placeholder='XXX.XXX.XXX-XX' maxlength='14' onkeyup='maskCPF()' required/>
//         </div>
//     </div>
//     <div class='col-md'>
//         <div class='form-group'>
//             <label class='ml-2 label-control text-white'>Especialidade *</label>
//             <select class='form-select form-select-xl w-100 ' name='especialidade' required>
//                 <option selected>Especialidade</option>
//                 '<?php
//                 $retEspec = mysqli_query($conn, "SELECT * FROM especialidades ORDER BY especNome ASC");
//                 while ($rowEspec = mysqli_fetch_array($retEspec)) {
//                 ?>'
//                 option value='<?php echo $rowEspec["especNome"]; ?>'><?php echo ""+$rowEspec['especNome']; ?></option>
//                 '<?php
//                 }
//             ?>'
//         </select>
//     </div>
// </div>  
// </div>`
//   )
// }

// function callDistribuidorComplemento() { //monta o campo de SENHAS
//   return (
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Empresa *</label>" +
//     "<input class='form-control py-4' name='empresa' type='text' style='text-transform: capitalize;' required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>CNPJ *</label>" +
//     "<input class='form-control py-4' name='cnpj' id='cnpj' type='text' maxlength='18' onkeyup='maskCNPJ()' required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>E-mail Empresa *</label>" +
//     "<input class='form-control py-4' name='emailempresa' type='text' placeholder='para envio da proposta' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>"
//   )
// }


// function callIternationalComplemento() { //monta o campo de SENHAS
//   return (
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Empresa *</label>" +
//     "<input class='form-control py-4' name='empresa' type='text' style='text-transform: capitalize;' required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>País/Cidade *</label>" +
//     "<input class='form-control py-4' name='paiscidade' type='text' style='text-transform: capitalize;' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>"
//   )
// }

// function callPacienteComplemento() {
//   return (
//     "<div class='form-row'>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>Nome Dr(a) Responsável *</label>" +
//     "<input class='form-control py-4' name='drResp' type='text' style='text-transform: capitalize;' required/>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col-md-6'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>UF Dr(a) *</label>" +
//     "<select class='form-select form-select-xl w-100 ' name='ufdr' required>" +
//     "<option selected>Selecione uma UF</option>" +
//     "<option value='AC'>Acre</option>" +
//     "<option value='AL'>Alagoas</option>" +
//     "<option value='AP'>Amapá</option>" +
//     "<option value='AM'>Amazonas</option>" +
//     "<option value='BA'>Bahia</option>" +
//     "<option value='CE'>Ceará</option>" +
//     "<option value='DF'>Distrito Federal</option>" +
//     "<option value='ES'>Espirito Santo</option>" +
//     "<option value='GO'>Goiás</option>" +
//     "<option value='MA'>Maranhão</option>" +
//     "<option value='MS'>Mato Grosso do Sul</option>" +
//     "<option value='MT'>Mato Grosso</option>" +
//     "<option value='MG'>Minas Gerais</option>" +
//     "<option value='PA'>Pará</option>" +
//     "<option value='PB'>Paraíba</option>" +
//     "<option value='PR'>Paraná</option>" +
//     "<option value='PE'>Pernambuco</option>" +
//     "<option value='PI'>Piauí</option>" +
//     "<option value='RJ'>Rio de Janeiro</option>" +
//     "<option value='RN'>Rio Grande do Norte</option>" +
//     "<option value='RS'>Rio Grande do Sul</option>" +
//     "<option value='RO'>Rondônia</option>" +
//     "<option value='RR'>Roraima</option>" +
//     "<option value='SC'>Santa Catarina</option>" +
//     "<option value='SP'>São Paulo</option>" +
//     "<option value='SE'>Sergipe</option>" +
//     "<option value='TO'>Tocantins</option>" +
//     "</select>" +
//     "</div>" +
//     "</div>" +
//     "<div class='col'>" +
//     "<div class='form-group'>" +
//     "<label class='ml-2 label-control text-white'>CPF *</label>" +
//     "<input class='form-control py-4' name='cpf' id='cpf' type='text' placeholder='XXX.XXX.XXX-XX' maxlength='14' onkeyup='maskCPF()' required/>" +
//     "</div>" +
//     "</div>" +
//     "</div>"
//   )
// }

$("form").on("submit", function (e) {
  if (!document.getElementById("termsCheck").checked) {
    alert("Você precisa aceitar os termos e politicas de privacidade!");
    e.preventDefault();
  }
});

function maskCPF() {
  var cpf = document.getElementById("cpf");

  //000.000.000-00
  //'.' nas posições -> 3,7
  //'-' nas posições -> 11

  if (cpf.value.length == 3 || cpf.value.length == 7) {
    cpf.value += '.';
  } else if (cpf.value.length == 11) {
    cpf.value += '-';
  }

}

function maskCNPJ() {
  var cnpj = document.getElementById("cnpj");

  //39.376.870/0001-03
  //'.' nas posições -> 2,6
  //'/' nas posições -> 10
  //'-' nas posições -> 15

  if (cnpj.value.length == 2 || cnpj.value.length == 6) {
    cnpj.value += '.';
  } else if (cnpj.value.length == 10) {
    cnpj.value += '/';
  } else if (cnpj.value.length == 15) {
    cnpj.value += '-';
  }

}

function maskCel() {
  var cel = document.getElementById("celular");

  //(61) 9xxxx-xxxx
  //'(' nas posições -> 0
  //')' nas posições -> 3
  //' ' nas posições -> 4
  //'-' nas posições -> 10

  if (cel.value.length == 1) {
    cel.value = '(' + cel.value;
  }

  if (cel.value.length == 3) {
    cel.value += ') ';
  } else if (cel.value.length == 10) {
    cel.value += '-';
  }

}

function maskTel() {
  var tel = document.getElementById("tel");

  //(61) xxxx-xxxx
  //'(' nas posições -> 0
  //')' nas posições -> 3
  //' ' nas posições -> 4
  //'-' nas posições -> 10

  if (tel.value.length == 1) {
    tel.value = '(' + tel.value;
  }

  if (tel.value.length == 3) {
    tel.value += ') ';
  } else if (tel.value.length == 9) {
    tel.value += '-';
  }

}

function maskCRM() {
  var crm = document.getElementById("crm");

  //CRX-UF-0000
  //'-' nas posições -> 3,6

  if (crm.value.length == 3 || crm.value.length == 6) {
    crm.value += '-';
  }

}

function maskUid() {
  var uid = document.getElementById("username").value;
  uid.value = uid.toLowerCase();
  

  if (uid.search(/\s/g) != -1) {
      alert("Não é permitido espaços em branco\n");
      uid = uid.replace(/\s/g, "");
      $("#username").val(uid.substring(0, uid.length - 1));
  }
  if (uid.search(/[^a-z0-9]/i) != -1) {
      alert("Não é permitido caracteres especiais");
      uid = uid.replace(/[^a-z0-9]/gi, "");
      $("#username").val(uid.substring(0, uid.length - 1));
  }
  // console.log(uid.toLowerCase());
}