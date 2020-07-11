<?php
session_start();
if (isset($_SESSION["matricula"])) {            //Retira la matrícula del usuario loggeado
    $logged = true;
    $matricula = $_SESSION["matricula"];
} else {
    $logged = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi cuenta</title>
    <link rel="stylesheet" href="assets/main.css">
    <script src="assets/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/82c7bbe089.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if ($logged === false) {        //Si no está loggeado, mostrar
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
            //Registro de usuario
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
            <a href="create.php">Crear</a>
            <a href="explore.php">Explorar</a>
            <a class="active" href="personal.php">Mi Cuenta</a>
            <div class="search-container">
                <form action="explore.php">
                    <input type="text" placeholder="Busca un cuestionario..." name="q" autocomplete="off"/>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="header" style="display: none;">
                <button class="chart-btn" onclick="window.location = 'process/logout.php'" title="Cerrar sesión">
                    <i class="fas fa-power-off chart"></i>
                </button>
                <h2>MI CUENTA</h2>
                <hr>
            </div>
            <div class="effect" style="display: none;">
                <?php
                $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
                mysqli_set_charset($conexion,'utf8');

                if ($logged === true) {
                    $select = "SELECT * FROM usuarios WHERE mat_user='$matricula'";     //Retira los datos del usuario loggeado
                    $query = mysqli_query($conexion, $select);
                    $row = mysqli_fetch_assoc($query);
                ?>
                <div class="personal-info">
                    <p style="margin: -40px 0 20px 0;"><span>Usuario: </span><?php echo $row["user_user"]; ?></p>
                    <p><span>Email: </span><?php echo $row["mail_user"]; ?></p>
                    <p id="no-surveys" style="display:none; margin-top:100px;"><span>Aún no tienes cuestionarios para mostrar. <a href="create.php">¡CREA UNO AQUÍ!</a></span></p>
                </div>
                <table class="cuestionarios" style="transform: scale(0.8, 0.8); margin-bottom: 0px;">
                    <?php
                    $select = "SELECT * FROM cuestionarios WHERE mat_user1='$matricula'";   //Retira los cuestionarios creados por el usuario loggeado
                    $query = mysqli_query($conexion, $select);
                    while($row = mysqli_fetch_assoc($query)) {
                    ?>
                <tr>
                    <td style="position:relative;">
                      <div class="mark">
                        <p><?php echo $row["nom_cues"]; $id = $row["id_cues"]; $a = 0;?></p>
                        <p style="color: rgb(172, 172, 172);">Cantidad de preguntas: <span class="cant" style="color: rgb(172, 172, 172);">
                        <?php 
                        $select2 = "SELECT * FROM preguntas WHERE id_cues1='$id'";
                        $query2 = mysqli_query($conexion, $select2);
                        while($row2 = mysqli_fetch_assoc($query2)) {
                            $a++;
                        };
                        echo $a;
                        ?>
                        </span></p>
                      </div>
                      <span class="close delete-survey" data-idsurvey="<?php echo $id; ?>" title="Eliminar">&times;</span>
                    </td>
                </tr>
                <?php
                    };
                };
                mysqli_close($conexion);
                ?>
                </table>
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
        $("#logo").attr("src","assets/logo.gif?dummy=" + dummy);     //Previene que se cargue el GIF cacheado
        $(document).ready(function() {
            var tableRows = $("table tr").length;           //Cuenta la cantidad de cuestionarios
            $(".header").fadeIn(function() {        //Animaciones
                $(".effect").fadeIn();
            });
            $(".mark").click(function() {           //Redireccionar al cuestionario clickeado
                location.href = "survey.php?name=" + $(this).children(":first").text().split(' ').join('+') +"&cant=" + $(this).find(".cant").text().trim();
            });
            $(".delete-survey").click(function() {      //Al hacer click en la X de un cuestionario
                $(this).parent().fadeOut();             //Desaparece el cuestionario
                var idcuestionario = $(this).data("idsurvey");      //Retira en id del cuestionario clickeado impreso en su atributo data
                $.ajax({
                    url: "process/deleteSurvey.php",                //Elimina el cuestionario de la base de datos
                    type: 'POST',
                    data: {id:idcuestionario},                  //Pasa el id del cuestionario a eliminar
                    error: function(xhr, ajaxOptions, thrownError) {
                        if (xhr.status == 200) {
                            alert(ajaxOptions);
                        } else {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    }
                });
            });
            if(tableRows == 0) {            //Si la cantidad de cuestionarios es 0, mostrar el diálogo de id #no-surveys
                $("#no-surveys").show();
            };
        });
    </script>
    </body>
</html>