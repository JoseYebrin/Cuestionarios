<?php
    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');
    $usuario = $_POST["uname"];
    $clave = sha1($_POST["psw1"]);
    $mail = filter_var($_POST["mail"], FILTER_SANITIZE_EMAIL);

    if (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
        echo '<script>
        alert("Error en el correo introducido. Verifíquelo e intentelo de nuevo.");
        window.history.go(-1);
        </script>';
        die();
    };

    $matricula = rand(100000000, 999999999);
    $verificar_matricula = mysqli_query($conexion, "SELECT * FROM usuarios WHERE mat_user='$matricula'");
    while(mysqli_num_rows($verificar_matricula) > 0) {
        $matricula = rand(100000000, 999999999);
        $verificar_matricula = mysqli_query($conexion, "SELECT * FROM usuarios WHERE mat_user='$matricula'");
    };

    $verificar_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE user_user = '$usuario'");
    if (mysqli_num_rows($verificar_user) > 0) {
        echo '<script>
            alert("El usuario ya esta registrado. Intente de nuevo con otro usuario.");
            window.history.go(-1);
          </script>';
        die();
    };

    $verificar_mail = mysqli_query($conexion, "SELECT * FROM usuarios WHERE mail_user = '$mail'");
    if (mysqli_num_rows($verificar_mail) > 0) {
        echo '<script>
            alert("El correo ya esta registrado. Intente de nuevo con otro correo.");
            window.history.go(-1);
          </script>';
        die();
    };

    $insertar = "INSERT INTO usuarios(mat_user, user_user, pass_user,  mail_user) VALUES ('$matricula', '$usuario', '$clave', '$mail')";

    $query = mysqli_query($conexion, $insertar);
    if (!$query) {
        echo '<script>
        alert("Error al registrarse en el servidor. Intentelo de nuevo.");
        window.history.go(-1);
      </script>';
      die();
    } else {
        echo '<script>
            alert("Registrado exitosamente.");
            window.history.go(-1);
          </script>';
          die();
    };
    mysqli_close($conexion);
?>