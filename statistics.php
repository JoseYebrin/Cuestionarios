<?php 
$name = $_GET["name"]; 
$cant = $_GET["cant"];              //Retira el nombre y cantidad de preguntas del cuestionario solicitado

if (!isset($name) || !isset($cant)) {       //Si no contiene alguno de estos, redireccionar a index
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name ?> - Estadísticas</title>
    <link rel="stylesheet" href="assets/main.css">
    <script src="assets/jquery-3.4.1.min.js"></script>
    <script src="assets/Chart.min.js"></script>
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
                <button class="chart-btn" title="Llenar cuestionario">
                    <i class="fas fa-poll-h chart"></i>
                </button>
                <h2><?php echo $name ?></h2>
                <hr>
            </div>
            <div class="effect" style="opacity:0;">
                <h3 style="margin: 0 0 30px 60px;">Pregunta <span id="number"></span>:</h3>
                <div class="graph-container">
                    <button id="regresar" class="graph-controls" disabled><i class="fas fa-chevron-left"></i></button>
                    <div class="graph">
                        <canvas id="myChart"></canvas>              <!--Lienzo para el gráfico de barras-->
                    </div>
                    <button id="siguiente" class="graph-controls"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
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
            var p = 0;
            var nombre = "<?php echo $name; ?>";
            var cant = "<?php echo $cant; ?>";
            
            Chart.defaults.global.defaultFontFamily = "'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif";
            Chart.defaults.global.defaultFontColor = "#aaa";
            Chart.defaults.global.defaultFontSize = 10;                 //Estilos básicos para el gráfico
            Chart.defaults.global.legend.display = false;

            function ellipsis(s, l) {               //Si la cadena s contiene más de l caracteres
                if (s.length > l) {                 //reducir la cadena a l - 1 e imprimir ... después de esta
                    s = s.substring(0, (l - 1)) + "..."; 
                    return s; 
                } else {                            //Retorna el nuevo valor
                    return s;
                };
            };

            function showGraph(p, pregunta, respuesta, cont) {              //Función para mostrar el gráfico
                $("#number").text(p+1).css("color", "rgb(172, 172, 172)");     //Muestra el número de la pregunta actual en el HTML
                var ctx = $("#myChart");
                var myChart = new Chart(ctx, {                      //Inicializa el gráfico
                    type: 'bar',                                    //Gráfico de barras
                    data: {
                        labels: respuesta[p],                   //Imprime las respuestas en el eje X
                        datasets: [{
                            label: "Número de votos",
                            data: cont[p],                      //Valor de cada respuesta
                            backgroundColor: [                  //Colores para cada barra (se imprimen sólo las necesarias)
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(180, 30, 123, 0.2)',
                            'rgba(255, 255, 255, 0.2)'
                            ],
                            borderColor: [                      //Bordes para cada barra
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(180, 30, 123, 1)',
                            'rgba(255, 255, 255, 1)'
                            ],
                            borderWidth: 1,
                            hoverBorderWidth: 2,            //Doble borde en la barra apuntada por el ratón
                            barPercentage: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,              //Empezar a contar en 0
                                    callback: function (value) { if (Number.isInteger(value)) { return value; } }   //Imprime sólo valores enteros en el eje Y
                                },
                                gridLines: {
                                    color: "rgba(0,0,0,0.3)"        //Grilla apenas visible
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    callback: function (string) {       //Llama a la función ellipsis() para cortar la cadena en caso que sea muy larga
                                        if (respuesta[p].length == 2 ){
                                            string = ellipsis(string, 55);
                                            return string;
                                        } else if (respuesta[p].length < 5) {
                                            string = ellipsis(string, 31);
                                            return string;
                                        } else if (respuesta[p].length < 7) {
                                            string = ellipsis(string, 22);
                                            return string;
                                        } else {
                                            string = ellipsis(string, 14);
                                            return string;
                                        };
                                    }
                                },
                                scaleLabel: {               //Leyenda debajo del eje X
                                    display: true,
                                    labelString: 'Respuestas',
                                    fontSize: 18
                                },
                                gridLines: {                //Esconde las línas verticales de la grilla
                                    display: false
                                }
                            }]    
                        },
                        responsive: true,
                        maintainAspectRatio: false,         //Mantiene el gráfico dentro del contenedor
                        hover: {
                            animationDuration: 0            //Elimina las animaciones al apuntar una barra
                        },
                        responsiveAnimationDuration: 0,
                        title: {                            //Muestra el título con la pregunta
                            display: true,
                            fontSize: 12,
                            fontColor: '#eee',
                            fontStyle: 'normal',            //Estilos para el título
                            padding: 50,
                            text: pregunta[p]               //Imprime la pregunta
                        }
                    }
                });
                $(".effect").animate({opacity:"1"}, 500);       //Animaciones
            };

            $(".header").fadeIn();                              //Animaciones
            $(".chart-btn").click(function() {                  //Al hacer click, redirigir a llenar el cuestionario
                location.href = "survey.php?name=" + $("h2").text().split(' ').join('+') + "&cant=<?php echo $cant; ?>";
            });
            
            $.ajax({                                            //Solicita los datos del cuestionario
                url: "process/graphSurvey.php",
                type: 'POST',
                data: {survey:nombre},                          //Pasa el nombre del cuestionario a solicitar
                success: function(cuestionario){
                    if ((p+1) == cant) {                        //Si contiene 1 pregunta deshabilita el botón siguiente
                        $("#siguiente").prop("disabled", true);
                    };
                    $(".effect").animate({opacity:"1"}, 500);
                    cuestionario = JSON.parse(cuestionario);        //Convierte la cadena retornada en un JSON
                    showGraph(p, cuestionario.pregunta, cuestionario.respuesta, cuestionario.cont);     //Pasa los datos al gráfico y lo imprime

                    $("#siguiente").click(function() {                  //Al hacer click en Siguiente
                        $("#siguiente").prop("disabled", true);         //Deshabilita el botón temporalmente para evitar múltiples clicks
                        $("#regresar").prop("disabled", false);         //Habilita el botón Regresar
                        p++;                                            //Pasa la siguiente pregunta
                        $(".effect").animate({opacity:"0"}, 500, function() {           //Animaciones
                            if ((p+1) < cant) {                          //Si no es la última pregunta, habilita el botón Siguiente
                                $("#siguiente").prop("disabled", false);
                            };
                            $(".graph").html("<canvas id='myChart'></canvas>");         //Reemplaza el lienzo por uno nuevo vacío
                            showGraph(p, cuestionario.pregunta, cuestionario.respuesta, cuestionario.cont);     //Imprime el gráfico de la siguiente pregunta
                        });
                    });

                    $("#regresar").click(function() {
                        $("#regresar").prop("disabled", true);          //Deshabilita el botón para prevenir múltiples clicks
                        $("#siguiente").prop("disabled", false);        //Habilita el botón siguiente en caso que esté deshabilitado
                        p--;                                    //Pasa a la pregunta anterior
                        $(".effect").animate({opacity:"0"}, 500, function() {
                            if ((p+1) > 1) {                            //Si no está en la última pregunta vuelve a habilitar el botón Regresar
                                $("#regresar").prop("disabled", false);
                            };
                            $(".graph").html("<canvas id='myChart'></canvas>");     //Lienzo vacío
                            showGraph(p, cuestionario.pregunta, cuestionario.respuesta, cuestionario.cont);     //Nuevo gráfico
                        });
                    });
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
        });
    </script>
</body>
</html>