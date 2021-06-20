//Fonction affiche mot de passe
function myFunction() {
    
  const ShowPass = document.getElementById('myInput');

  if(ShowPass.type === 'password') {
    ShowPass.type = 'text';
  }else{
    ShowPass.type = 'password';
  }
}
//fin fonction affiche mot de passe


//Script alertBox

// On recup tout les elements avec class="closebtn"
var close = document.getElementsByClassName("closebtn");
var i;

// Boucle à travers tous les boutons de fermeture
for (i = 0; i < close.length; i++) {
  // Quand quelqu'un clique sur le close button
  close[i].onclick = function(){

    // On recup les parents de <span class="closebtn"> (<div class="alert">)
    var div = this.parentElement;

    // On met l'opacité de la div à 0 (transparent)
    div.style.opacity = "0";

    // On cache la div après 600ms (Le même nombre de milliseconde qu'il faut pour disparaitre)
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
//Fin script AlertBox
