//---Para mostrar y ocultar  la contraseña en los campos 
var passwordField = document.getElementById("exampleInputPassword1");
var showPasswordButton = document.getElementById("showPassword");

showPasswordButton.addEventListener("mousedown", function () {
  passwordField.type = "text";
});

showPasswordButton.addEventListener("mouseup", function () {
  passwordField.type = "password";
});