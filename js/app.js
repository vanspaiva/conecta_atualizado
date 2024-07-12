
// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.1.1/firebase-app.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAsVHTPuT_T88bPf8KuO6DkifI4OeySj7w",
    authDomain: "conecta-tc.firebaseapp.com",
    projectId: "conecta-tc",
    storageBucket: "conecta-tc.appspot.com",
    messagingSenderId: "758288058331",
    appId: "1:758288058331:web:ab98cce32dcf37203489fe"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Get a reference to the storage service, which is used to create references in your storage bucket
var storage = firebase.storage();

let imagemSelecionada;

var submit = document.getElementById("submit");

$(submit).on("click", function () {
    var nomeArquivo;

    var dtcriacao = document.getElementById("dtcriacao").value;
    var nomepaciente = document.getElementById("nomepaciente").value;
    var tipoProd = document.getElementById("tipoProd").value;
    var nomedr = document.getElementById("nomedr").value;

    nomeArquivo = dtcriacao + " - " + tipoProd + " - " + nomedr + " - " + nomepaciente;

    salvarImagemFirebase(nomeArquivo);

    var fileToUpload = document.getElementById("file");

});

//------------Tratamento de Imagem
$("#file").on("change", function (event) {
    console.log(event);

    const imagem = document.getElementById("imagemAdicionar");

    const imagemAdicionar = event.target.file[0];

    imagem.file = imagemArquivo;

    imagemSelecionada = imagemArquivo;

    if(imagemSelecionada != null){
        const reader = new FileReader();

        reader.onload = (function (img){
            return function (e){
                img.src = e.target.result;
            }
        })(imagem)

        reader.readAsDataURL(imagemArquivo);
    }
})




//-------------Salvar Imagem Firebase

function salvarImagemFirebase(nomeArquivo){

    const upload = storage.ref().child("tomografias").put(nomeArquivo);

    upload.on("state_changed", function(){
        console.log("Sucesso ao Salvar Imagem");
    }, function(error){
        console.log("Erro ao Salvar Imagem");
    })
}
