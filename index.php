<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creador de cuestionarios</title>
    <link rel="stylesheet" href="assets/main.css">
    <script src="assets/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/82c7bbe089.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main">
        <div class="inicio" style="display: none;">
            <h1>CREA TU PROPIO CUESTIONARIO O <br> COMPLETA UNO</h1>
            <button class="btn blue" onclick="location.href='create.php'">CREAR</button><!--
            --><div class="divider"></div><!--
            --><button class="btn green" onclick="location.href='explore.php'">EXPLORAR</button>
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
        $(document).ready(function() {
            $(".inicio").fadeIn(1000);      //Animaciones
        });
    </script>
</body>
</html>