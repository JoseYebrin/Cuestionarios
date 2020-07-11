<?php
session_start();
if (isset($_SESSION["matricula"])) {    //Chequea si está iniciada alguna sesión
    $logged = true;
} else {
    $logged = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuestionario</title>
    <link rel="stylesheet" href="assets/main.css">
    <script src="assets/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/82c7bbe089.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if ($logged === false) {            //Si no está loggeado, mostrar
            //Inicio de sesión
            echo '<div id="login" class="modal">
                    <form class="modal-content animate" action="process/login.php" method="post">              
                      <div class="modal-container">
                        <span class="close" onclick="window.history.go(-1);" title="Regresar">&times;</span>
                        <p style="margin-bottom:30px;font-weight:700">Debes iniciar sesión para acceder a esta opción</p>
                        <label for="uname"><b>Usuario</b></label>
                        <input type="text" name="uname" autocomplete="off" autofocus required>
              
                        <label for="psw"><b>Contraseña</b></label>
                        <input type="password" name="psw" required>
                      
                        <button type="submit">Login</button>
                        <p onclick="register()">¿No estas registrado?</p>
                      </div>
                    </form>
                 </div>';
            //Registro
            echo '<div id="register" class="modal" style="display:none;">
                    <form class="modal-content animate" action="process/register.php" method="post">              
                        <div class="modal-container">
                            <span class="close" onclick="window.history.go(-1);" title="Regresar">&times;</span>
                            <label for="uname"><b>Usuario</b></label>
                            <input id="uname" type="text" name="uname" onkeyup="verify()" autocomplete="off" required>
      
                            <label for="psw1"><b>Contraseña</b></label>
                            <input id="psw1" type="password" name="psw1" onkeyup="verify()" required>

                            <label for="psw2"><b>Repetir contraseña</b></label>
                            <input id="psw2" type="password" name="psw2" onkeyup="verify()" required>

                            <label for="mail"><b>Email</b></label>
                            <input id="mail" type="text" name="mail" onkeyup="verify()" autocomplete="off" required>

                            <p id="error" style="color:red;"></p>
              
                            <button type="submit">Registrarse</button>
                            <p onclick="login()">¿Ya estás registrado?</p>
                        </div>
                    </form>
                </div>';
        }
    ?>
    <div class="main">
        <div class="nav">
            <img src=" " id="logo" width="90" height="55" title="Universidad José Antonio Páez" style="float:left; margin-left:-100px; margin-top:5px;">
            <a href="index.php">Inicio</a>
            <a class="active" href="create.php">Crear</a>
            <a href="explore.php">Explorar</a>
            <a href="personal.php">Mi Cuenta</a>
            <div class="search-container">
                <form action="explore.php">
                    <input type="text" placeholder="Busca un cuestionario..." name="q" autocomplete="off"/>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="header" style="display: none;">
                <h2>CREA UN CUESTIONARIO</h2>
                <hr>
            </div>
            <input type="text" id="nombre" name="nombre" class="type" placeholder=
            "Ingrese aquí el nombre del cuestionario" maxlength="98" style="display: none;">
            <div class="effect" style="display: none;">
                <div class="question">
                    <h3>Pregunta <span id="number"></span>:</h3>
                    <input type="text" id="pregunta" name="pregunta" class="type jqclear" placeholder=
                    "Ingrese aquí una pregunta" maxlength="138">
                    <div class="answer">
                        <h3 style="display: inline; margin-right: 120px;">Respuestas: </h3>
                        <button class="add" id="add" title="Agregar respuesta"><i class="fas fa-plus"></i></button><!--
                        --><button class="add" id="delete" title="Eliminar respuesta" style="display: none;">
                            <i class="fas fa-minus"></i></button>
                        <label class="checkbox-container">Selección única
                            <input type="checkbox" checked="checked" id="unica">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Selección múltiple
                            <input type="checkbox" checked="checked" id="multiple">
                            <span class="checkmark"></span>
                        </label>
                        <ul style="margin: 20px 16px 0 16px;">
                            <p>1</p><li><input type="text" id="respuesta1" name="respuesta1" class=
                            "type jqclear respuesta" placeholder="Ingrese aquí una respuesta" maxlength="138" style=
                            "margin-bottom: 25px; margin-top: 6px;"></li>
                            <p>2</p><li><input type="text" id="respuesta2" name="respuesta2" class=
                            "type jqclear respuesta" placeholder="Ingrese aquí una respuesta" maxlength="138" style=
                            "margin-bottom: 25px; margin-top: 6px;"></li>
                        </ul>
                    </div>
                </div>
                <div class="submit">
                    <button class="btn red" title="Regresar" id="regresar"style="display:none;"><i class="fas fa-chevron-left"></i></button><!--
                    --><button class="btn blue" title="Agregar pregunta" id="agregar"><i class="fas fa-plus"></i></button><!--
                    --><button class="btn green" title="Terminar cuestionario" id="terminar"><i class="fas fa-check"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="tick__container">
        <svg class="tick" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="tick__circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="tick__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
    </div>
    <footer class="footer">
        <div class="left">
            <a href="#">Política de Privacidad</a><!--
            --><div class="divider"></div><!--
            --><a href="#">Condiciones de Uso</a>
        </div>

        <div class="right">
            <a href="#" title="Facebook"><i class="fab fa-facebook-square"></i></a><!--
            --><div class="divider"></div><!--
            --><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a><!--
            --><div class="divider"></div><!--
            --><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>
    <script src="process/access.js"></script>       <!--Script para la validación de login/registro-->
    <script>
        var dummy = Math.random();
        $("#logo").attr("src","assets/logo.gif?dummy=" + dummy);     //Previene la carga del GIF cacheado
        $(document).ready(function() {
            $(".header").fadeIn(function() {    //Animaciones
                $(".effect").fadeIn();
                $("#nombre").fadeIn();
            });
            var r = 3;
            var p = 1;
            var myObj = {}
            var add = $("#add"), del = $("#delete"), checkb = $('input[type=checkbox]'), list = $("ul"),
            tick = $(".tick__container"), inputClear = $(".jqclear");
            $("#number").text(p).css("color", "rgb(172, 172, 172)");

            $(function(){       //Desmarca los checkbox (selección única o múltiple)
                checkb.prop("checked", false);
            });
            add.click(function() {  //Agregar respuesta
                list.append('<p>' + r + '</p><li class="item"><input type="text" id="respuesta' + r +
                '" name="respuesta' + r + '" class="type jqclear respuesta" placeholder="Ingrese aquí una respuesta"' +
                ' maxlength="138" style="margin-bottom: 25px; margin-top: 6px;"></li>');
                r++;
                del.show();
                if($('ul li').length == 8){
                    add.css("visibility", "hidden");
                };
            });
            del.click(function() {  //Eliminar respuesta
                $("p").last().remove();
                $("li").last().remove();
                r--;
                add.css("visibility", "visible");
                if($('ul li').length == 2){
                    del.hide();
                };
            });

            function validate(obj) {    //No permite preguntas iguales en el mismo cuestionario
                                        //Ni respuestas iguales en la misma pregunta
                var values = [];
                var objString = " ";
                var strToTest = " ";
                var error = false;
                $(".respuesta").each(function(index){       //Chequea respuestas
                    strToTest = $.trim($(this).val());
                    strToTest = strToTest.toLowerCase();
                    strToTest = strToTest.replace(/\s\s+/g, ' ');
                    if ($.inArray(strToTest, values) === -1){
                        values.push(strToTest);
                    }else{
                        error = "No pueden existir respuestas duplicadas en la misma pregunta.";
                    }
                });

                for (var i = 1; i < p; i++) {           //Chequea preguntas
                    strToTest = $.trim($("#pregunta").val());
                    strToTest = strToTest.toLowerCase();
                    strToTest = strToTest.replace(/\s\s+/g, ' ');
                    objString = obj["pregunta" + i]["nombre"];
                    objString = objString.toLowerCase();
                    objString = objString.replace(/\s\s+/g, ' ');
                    if (objString == strToTest) {
                        error = "Ya ingresó esta pregunta en el cuestionario, utilice otra.";
                    };
                };

                return error;
            };

            function next() {               //Almacena los valores en un objeto y procede a la siguiente pregunta
                myObj["pregunta" + p] = {};
                for (i = 1; i < ($('ul li').length + 1); i++) {
                    myObj["pregunta" + p]["respuesta" + i] = [];
                    myObj["pregunta" + p]["respuesta" + i] = $.trim($("#respuesta" + i + "").val());
                };
                myObj["pregunta" + p]["nombre"] = $.trim($("#pregunta").val());     //Elimina los espacios en blanco antes y después
                if ($("#unica").is(":checked")) {
                    myObj["pregunta" + p]["seleccion"] = 1;
                } else {
                    myObj["pregunta" + p]["seleccion"] = 2;
                };
                
                p++;
                r = 3;
                if (p == 20) {                      //Máximo 20 preguntas
                    $("#agregar").css("visibility", "hidden");
                };
                checkb.prop("checked", false);      //Vacía los input y resetea el formato
                add.css("visibility", "visible");
                del.hide();
                inputClear.val("");
                $("#number").text(p);
                list.html('<p>1</p><li><input type="text" id="respuesta1" name="respuesta1"' +
                ' class="type jqclear respuesta" placeholder="Ingrese aquí una respuesta"' +
                ' maxlength="138" style="margin-bottom: 25px; margin-top: 6px;"></li><p>2</p><li><input type="text"' +
                ' id="respuesta2" name="respuesta2" class="type jqclear respuesta" placeholder="Ingrese aquí una respuesta"' +
                ' maxlength="138" style="margin-bottom: 25px; margin-top: 6px;"></li>');
            };

            $("#agregar").click(function() {       //Al hacer click en el botón agregar pregunta
                var error = validate(myObj);        //Valida los valores ingresados
                $("#agregar").prop("disabled", true);       //Desactiva botón para prevenir múltiples clicks seguidos
                if (!$(".jqclear").filter(function () {return $.trim($(this).val()).length == 0}).length ==
                0 || $('input[type=checkbox]:checked').length == 0) {
                    alert("Asegurese de marcar el tipo de selección y llenar todos los campos.");
                } else if (error != false) {
                    alert(error);       //Si existe error en los input, muestra el mensaje de error
                } else {
                    tick.show();
                    tick.delay(1300).fadeOut();
                    window.location.href = "#";
                    $(".effect").fadeOut(function() {
                        $("#regresar").show();
                        next();                         //Almacena los valores en el objeto
                        $(".effect").fadeIn();
                    });
                };
                $("#agregar").prop("disabled", false);      //Vuelve a activar el botón
            });

            $("#regresar").click(function() {
                $("#regresar").prop("disabled", true);
                window.location.href = "#";
                p--;                                //Decrementa el número de pregunta
                $(".effect").fadeOut(function() {
                    if (p == 1) {                   //Esconde el botón en caso de estar en la pregunta número 1
                        $("#regresar").hide();
                    };

                    delete myObj["pregunta" + p];   //Elimina la pregunta anterior y sus valores

                    r = 3;
                    checkb.prop("checked", false);      //Resetea el formato
                    add.css("visibility", "visible");
                    del.hide();
                    inputClear.val("");
                    $("#number").text(p);
                    list.html('<p>1</p><li><input type="text" id="respuesta1" name="respuesta1"' +
                    ' class="type jqclear respuesta" placeholder="Ingrese aquí una respuesta"' +
                    ' maxlength="138" style="margin-bottom: 25px; margin-top: 6px;"></li><p>2</p><li><input type="text"' +
                    ' id="respuesta2" name="respuesta2" class="type jqclear respuesta" placeholder="Ingrese aquí una respuesta"' +
                    ' maxlength="138" style="margin-bottom: 25px; margin-top: 6px;"></li>');
                    $(".effect").fadeIn();
                    $("#regresar").prop("disabled", false);
                });
            });

            function terminar() {                   //Función que se ejecuta al hacer click en Terminar
                var nombre = $.trim($("#nombre").val());
                nombre = nombre.replace(/\s\s+/g, ' ');     //Si existen dos o más espacios seguidos, cambiar por un sólo espacio
                $.ajax({
                    url: "process/verifySurvey.php",        //Verifica si ya está en uso el nombre del cuestionario
                    type: 'POST',
                    data: {cuestionario:nombre},            //Pasa el nombre del cuestionario al servidor
                    success: function(bool) {
                        if (bool == false) {
                            alert("El nombre del cuestionario introducido ya está en uso, por favor intente con otro.");
                        } else if (bool == true) {
                            myObj["pregunta" + p] = {};             //Si no está en uso, almacenar la última pregunta y sus valores
                            for (i = 1; i < ($('ul li').length + 1); i++) {
                                myObj["pregunta" + p]["respuesta" + i] = [];
                                myObj["pregunta" + p]["respuesta" + i] = $.trim($("#respuesta" + i + "").val());
                            };
                            myObj["pregunta" + p]["nombre"] = $.trim($("#pregunta").val());
                            if ($("#unica").is(":checked")) {
                                myObj["pregunta" + p]["seleccion"] = 1;
                            } else {
                                myObj["pregunta" + p]["seleccion"] = 2;
                            };
                            myObj.nombre = $.trim($("#nombre").val());

                            myObj = JSON.stringify(myObj);      //Convierte el objeto en string para pasarlo al servidor

                            myObj = myObj.replace(/\s\s+/g, ' ');
                
                            tick.show();
                            $.ajax({
                                url: "process/createSurvey.php",    //Pasa todos los valores a la base de datos
                                type: 'POST',
                                data: {obj:myObj, preguntas:p},
                                success: function() {
                                    setTimeout(function() {
                                        window.location.replace("explore.php");
                                    }, 700);
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    if (xhr.status == 200) {
                                        alert(ajaxOptions);
                                    } else {
                                        alert(xhr.status);
                                        alert(thrownError);
                                    }
                                }
                            });
                        };
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        if (xhr.status == 200) {
                            alert(ajaxOptions);
                        } else {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    }
                });
            };

            $("#terminar").click(function() {
                var error = validate(myObj);
                $("#terminar").prop("disabled", true);
                if (!$(".jqclear").filter(function () {return $.trim($(this).val()).length == 0}).length == 
                0 || !$("#nombre").filter(function () {return $.trim($(this).val()).length == 0}).length == 
                0 || $('input[type=checkbox]:checked').length == 0) {
                    alert("Asegurese de marcar el tipo de selección y llenar todos los campos.");
                } else if (error != false) {
                    alert(error);
                } else {
                    terminar();
                };
                $("#terminar").prop("disabled", false);
            });
            checkb.on('change', function() {        //Sólo un checkbox marcado a la vez
                checkb.not(this).prop('checked', false);
            });
        });
    </script>
</body>
</html>