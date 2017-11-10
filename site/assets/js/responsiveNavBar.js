function dropDown(){
  var v = document.getElementById("navBar");
  if (v.className === "navBar"){
      v.className += " dropped";
  } else {
      v.className = "navBar"
  }
}
