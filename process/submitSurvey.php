<?php
    $nombre = $_POST["n"];
    $pregunta = json_decode($_POST["p"], true);
    $respuesta = json_decode($_POST["r"], true);

    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');

    $select = "SELECT id_cues FROM cuestionarios WHERE nom_cues = '$nombre'";
    $query = mysqli_query($conexion, $select);
    $row = mysqli_fetch_assoc($query);
    $idCuestionario = $row["id_cues"];
    for ($p = 1; $p < count($pregunta); $p++) {
        $select = "SELECT id_pre FROM preguntas WHERE id_cues1 = '$idCuestionario' AND pre_pre = '$pregunta[$p]'";
        $query = mysqli_query($conexion, $select);
        $row = mysqli_fetch_assoc($query);
        $idPregunta = $row["id_pre"];

        for ($r = 0; $r < count($respuesta[$p]); $r++) {
            $res = $respuesta[$p][$r];
            $update = "UPDATE respuestas SET cont_res = cont_res + 1 WHERE id_pre1 = '$idPregunta' AND res_res = '$res'";
            $query2 = mysqli_query($conexion, $update);
        };
    };
    mysqli_close($conexion);
?>