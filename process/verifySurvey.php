<?php
    $nombre = $_POST["cuestionario"];

    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');

    $verificar_nombre = mysqli_query($conexion, "SELECT * FROM cuestionarios WHERE nom_cues = '$nombre'");
    if (mysqli_num_rows($verificar_nombre) > 0) {
        echo false;
    } else {
        echo true;
    }

    mysqli_close($conexion);
?>