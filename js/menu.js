function passwordPopup(){
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

function passwordPopup_close(){
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

  function backHistory(){
    window.history.go(1);
  }

  $('#backBtn').on('click', function (event) {

    // prevenir comportamento normal do link
    window.history.go(1);

    // código a executar aqui
});
