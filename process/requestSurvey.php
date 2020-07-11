<?php
    header('Content-Type: application/json');
    $nombre = $_POST["cuestionario"];
    $p = $_POST["pregunta"];
    $p--;

    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');

    $select = "SELECT id_cues FROM cuestionarios WHERE nom_cues='$nombre'";
    $query = mysqli_query($conexion, $select);
    $row = mysqli_fetch_assoc($query);
    $idCuestionario = $row["id_cues"];

    $select = "SELECT * FROM preguntas WHERE id_cues1='$idCuestionario' LIMIT $p, 1";
    $query = mysqli_query($conexion, $select);
    $row = mysqli_fetch_assoc($query);
    $idPregunta = $row["id_pre"];
    $obj["seleccion"] = $row["id_sel1"];
    $obj["pregunta"] = $row["pre_pre"];

    $a = 0;
    $select = "SELECT * FROM respuestas WHERE id_pre1='$idPregunta'";
    $query = mysqli_query($conexion, $select);
    while($row = mysqli_fetch_assoc($query)) {
        $obj["respuesta"][$a] = $row["res_res"];
        $a++;
    };

    mysqli_close($conexion);

    $obj = json_encode($obj);
    echo $obj;
?>