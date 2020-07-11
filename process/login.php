<?php
    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');
    $usuario = $_POST["uname"];
    $clave = sha1($_POST["psw"]);

    $verificar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user_user = '$usuario' AND pass_user = '$clave'");
    if (mysqli_num_rows($verificar) == 1) {
    
        $query = mysqli_query($conexion, "SELECT mat_user FROM usuarios WHERE user_user = '$usuario'");
        $row = mysqli_fetch_assoc($query);
        $matricula = $row['mat_user'];

        session_start();
        $_SESSION['matricula'] = $matricula;
        echo '<script>
            window.history.go(-1);
          </script>';

    } else {
        echo '<script>
            alert("Usuario o contraseña inválida");
            window.history.go(-1);
          </script>';
        die();
    }
    mysqli_close($conexion);
?>