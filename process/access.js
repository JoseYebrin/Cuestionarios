function register() {
    $("#login").hide();         //Esconde el modal login y muestra el modal registrar
    $("#register").show();
};
function login() {
    $("#register").hide();      //Esconde el modal registrar y muestra el modal login
    $("#login").show();
};
function verify() {             //Valida los datos a del usuario a registrar
    if ($("#uname").val().length < 8 || $("#uname").val().length > 20) {
        $("#error").text("El usuario debe tener entre 8 y 20 caracteres.");
        $("#register button").attr("disabled", true);
    } else if ($("#uname").val().indexOf(" ") >= 0) {
        $("#error").text("El usuario no puede contener espacios");
        $("#register button").attr("disabled", true);
    } else if ($("#psw1").val().length < 6 || $("#psw1").val().length > 20){
        $("#error").text("La contraseña debe tener entre 6 y 20 caracteres");
        $("#register button").attr("disabled", true);
    } else if ($("#psw1").val() != $("#psw2").val()) {
        $("#error").text("Las contraseñas no coinciden.");
        $("#register button").attr("disabled", true);
    } else if ($("#mail").val().length > 0) {
        if ($("#mail").val().indexOf("@") < 0 || $("#mail").val().indexOf(".") < 0) {
            $("#error").text("El correo ingresado es inválido.");
            $("#register button").attr("disabled", true);
        } else {
            $("#error").text("");
            $("#register button").attr("disabled", false);
        };
    } else {
        $("#error").text("");
        $("#register button").attr("disabled", false);
    };
};