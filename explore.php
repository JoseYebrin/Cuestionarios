<?php
    if (!isset($_GET["q"])){        //Pasa la cadena ingresada en la barra de búsqueda
        $q = "";
    } else {
        $q = $_GET["q"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar cuestionarios</title>
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
            <a class="active" href="explore.php">Explorar</a>
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
                <h2>EXPLORAR CUESTIONARIOS</h2>
                <hr>
            </div>
        </div>
        <table class="cuestionarios" style="display: none;">
        <?php
            $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
            mysqli_set_charset($conexion,'utf8');

            $select = "SELECT * FROM cuestionarios WHERE nom_cues LIKE '%$q%'";     //Retira los cuestionarios que contengan lo ingresado en la barra de búsqueda
            $query = mysqli_query($conexion, $select);
            while($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td>
                <p><?php echo $row["nom_cues"]; $id = $row["id_cues"]; $a = 0;?></p>
                <p>Cantidad de preguntas: <span style="color: rgb(172, 172, 172);">
                    <?php $select2 = "SELECT * FROM preguntas WHERE id_cues1='$id'";    //Retira la cantidad de preguntas de cada cuestionario mostrado
                        $query2 = mysqli_query($conexion, $select2);
                        while($row2 = mysqli_fetch_assoc($query2)) {
                            $a++;
                        };
                        echo $a;
                    ?>
                </span></p>
            </td>
        </tr>
        <?php
          }
          mysqli_close($conexion);
        ?>
        </table>
    </div>
    <footer class="footer" style="margin-top: 36px;">
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
        $("#logo").attr("src","assets/logo.gif?dummy=" + dummy);    //Previene la carga del GIF cacheado
        $(document).ready(function() {
            $(".header").fadeIn(function(){             //Animaciones
                $(".cuestionarios").fadeIn();
            });
            $("td").click(function() {          //Redireccionar al cuestionario clickeado
                location.href = "survey.php?name=" + $(this).children(":first").text().split(' ').join('+') +"&cant=" + $(this).find("span").text().trim();
            });
        });
    </script>
</body>
</html>