<?php
    $nombre = $_POST["survey"];

    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');

    $select = "SELECT id_cues FROM cuestionarios WHERE nom_cues='$nombre'";
    $query = mysqli_query($conexion, $select);
    $row = mysqli_fetch_assoc($query);
    $idCuestionario = $row["id_cues"];

    $p = 0;
    $select = "SELECT * FROM preguntas WHERE id_cues1='$idCuestionario'";
    $query = mysqli_query($conexion, $select);
    while($row = mysqli_fetch_assoc($query)) {
        $idPregunta = $row["id_pre"];
        $obj["pregunta"][$p] = $row["pre_pre"];

        $r = 0;
        $select2 = "SELECT * FROM respuestas WHERE id_pre1='$idPregunta'";
        $query2 = mysqli_query($conexion, $select2);
        while($row2 = mysqli_fetch_assoc($query2)) {
            $obj["respuesta"][$p][$r] = $row2["res_res"];
            $obj["cont"][$p][$r] = $row2["cont_res"];
            $r++;
        };

        $p++;
    };
    
    mysqli_close($conexion);

    $obj = json_encode($obj);
    echo $obj;
?>