<?php 
$name = $_GET["name"];
$cant = $_GET["cant"];                  //Retira el nombre y cantidad de preguntas del cuestionario solicitado

if (!isset($name) || !isset($cant)) {   //Si no contiene alguno de estos datos, redireccionar a index
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> - Completar</title>
    <link rel="stylesheet" href="assets/main.css">
    <script src="assets/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/82c7bbe089.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main">
        <div class="nav">
            <img src=" " id="logo" width="90" height="55" title="Universidad José Antonio Páez" style="float:left; margin-left:-100px; margin-top:5px;">
            <a href="index.php">Inicio</a>
            <a href="create.php">Crear</a>
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
            <div class="header" style="display:none;">
                <button class="chart-btn" title="Estadísticas">
                    <i class="fas fa-chart-pie chart"></i>
                </button>
                <h2><?php echo $name; ?></h2>
                <hr>
            </div>
            <div class="effect" style="display:none;">
                <h3>Pregunta <span id="number"></span>:</h3>
                <p id="question" style="margin: 0 20px 40px 20px; line-height: 20px;"></p>
                <h3>Respuestas:</h3>
                <table class="respuestas">

                </table>
                <div class="submit">
                    <button class="btn red" title="Pregunta anterior" id="regresar" style="display:none;"><i class="fas fa-chevron-left"></i></button><!--
                    --><button class="btn blue" title="Pregunta siguiente" id="siguiente"><i class="fas fa-chevron-right"></i></button><!--
                    --><button class="btn green" title="Terminar cuestionario" id="terminar" style="visibility:hidden;"><i class="fas fa-check"></i></button>
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
    <script>
        var dummy = Math.random();
        $("#logo").attr("src","assets/logo.gif?dummy=" + dummy);     //Previene la carga del GIF cacheado
        $(document).ready(function() {
            var p = 1;
            var nombre = "<?php echo $name; ?>";
            var cant = "<?php echo $cant; ?>";
            var respuestas = {};
            var preguntas = [];                     //Inicializa las variables, arrays y objetos a utilizar
            var selected = [];
            $(".header").fadeIn(function() {        //Animaciones
                $(".effect").fadeIn();
            });
            $(".chart-btn").click(function() {      //Redireccionar a las estadisticas del cuestionario, si se hace click en el ícono
                location.href = "statistics.php?name=" + $("h2").text().split(' ').join('+') + "&cant=" + cant;
            });
            function query() {          //Retira la pregunta solicitada y sus respuestas de la base de datos
                if (p == cant) {
                    $("#siguiente").css("visibility", "hidden");        //Si se encuentra en la pregunta final
                    $("#terminar").css("visibility", "visible");        //esconder Siguiente y mostrar Terminar
                };
                $("table").html("");                                    //Vacía la tabla
                $("#number").text(p).css("color", "rgb(172, 172, 172)");    //Imprime el número de la pregunta actual
                $.ajax({
                    url: "process/requestSurvey.php",           //Solicita la pregunta y sus respuestas
                    type: 'POST',
                    data: {cuestionario:nombre, pregunta:p},    //Pasa las variables nombre del cuestionario y número de la pregunta a solicitar
                    success: function(myObj){
                        preguntas[p] = myObj["pregunta"];           //Pasa el nombre de cada pregunta
                        $("#question").text(myObj["pregunta"]);     //Imprime la pregunta
                        for (var i = 0; i < myObj["respuesta"].length; i++){
                            $("table").append('<tr><td>'+ myObj["respuesta"][i] +'</td></tr>'); //Imprime las respuestas
                        };
                        if (myObj["seleccion"] == 1){           //Si es selección única permitir sólo una respuesta
                            $("td").click(function() {
                                $("td").removeClass("selected");
                                $(this).toggleClass("selected");
                            });
                        } else {                                //De lo contrario permitir múltiples respuestas
                            $("td").click(function() {
                                $(this).toggleClass("selected");
                            });
                        };
                        $(".effect").fadeIn();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        if (xhr.status == 200) {
                            alert(ajaxOptions);
                        } else {
                            alert(xhr.status);
                            alert(thrownError);
                        };
                    }
                });
            };
            function submit() {                 //Guarda las respuestas seleccionadas en un array
                respuestas[p] = [];
                for (var i = 0; i < selected.length; i++) {
                    respuestas[p][i] = selected[i].innerText;
                };
            };
            query();
            $("#siguiente").click(function() {          //Al hacer click en siguiente
                $("#siguiente").prop("disabled", true);     //Desactiva el botón temporalmente para prevenir múltiples clicks seguidos
                selected = document.getElementsByClassName("selected");     //Retira la cantidad de respuestas seleccionadas
                if (selected.length == 0) {                                 //Si no seleccionó ninguna
                    alert("Seleccione al menos una respuesta para continuar.");
                } else {
                    submit();
                    p++;                                    //Pasa a la siguiente pregunta
                    $(".tick__container").show();
                    $(".tick__container").delay(1300).fadeOut();
                    window.location.href = "#";
                    $(".effect").fadeOut(function() {
                        query();                            //Vuelve a hacer la consulta
                        $("#regresar").show();              //Muestra el botón para regresar a la pregunta anterior
                    });
                };
                $("#siguiente").prop("disabled", false);        //Vuelve a activar el botón
            });
            $("#regresar").click(function() {               //Al hacer click en el botón regresar
                $("#regresar").prop("disabled", true);
                window.location.href = "#";
                $(".effect").fadeOut(function() {
                    $("#regresar").prop("disabled", false);
                    p--;                                    //Pasa a la pregunta anterior
                    query();
                    delete respuestas[p];                   //Elimina las respuestas de la última pregunta almacenadas en el array
                    preguntas.pop();                        //Elimina el nombre de la última pregunta
                    if (p == 1) {                           //Esconde el botón regresar si se encuentra en la primera pregunta
                        $("#regresar").hide();
                    };
                    $("#terminar").css("visibility", "hidden");     //Esconde el botón Terminar
                    $("#siguiente").css("visibility", "visible");   //Muestra el botón Siguiente
                });
            });
            $("#terminar").click(function() {
                $("#terminar").prop("disabled", true);
                selected = document.getElementsByClassName("selected");
                if (selected.length == 0) {
                    alert("Seleccione al menos una respuesta para continuar.");
                } else {
                    $(".tick__container").show();
                    window.location.href = "#";
                    submit();
                    preguntas = JSON.stringify(preguntas);
                    respuestas = JSON.stringify(respuestas);
                    $.ajax({
                        url: "process/submitSurvey.php",        //Pasa las respuestas ingresadas a la base de datos
                        type: 'POST',
                        data: {n:nombre, p:preguntas, r:respuestas},
                        dataType: 'html',
                        success: function() {
                            setTimeout(function() {
                                window.location.replace("statistics.php?name=" + $("h2").text().split(' ').join('+') + "&cant=" + cant);
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
                $("#terminar").prop("disabled", false);
            });
        });
    </script>
</body>
</html>