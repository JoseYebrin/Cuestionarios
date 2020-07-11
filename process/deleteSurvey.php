<?php
    $id = $_POST["id"];

    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');

    $delete = "DELETE FROM cuestionarios WHERE id_cues='$id'";
    $query = mysqli_query($conexion, $delete);

    if (!$query) {
        echo mysqli_error($conexion);
    };

    mysqli_close($conexion);
?>