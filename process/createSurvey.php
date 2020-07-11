<?php
    $obj = json_decode($_POST["obj"], true);
    $p = $_POST["preguntas"];
    
    $conexion = mysqli_connect("localhost", "root", "", "cuestionarios");
    mysqli_set_charset($conexion,'utf8');
    session_start();
    
    $matricula = $_SESSION["matricula"];

    $nombre = $obj["nombre"];
    $insertar = "INSERT INTO cuestionarios(mat_user1, nom_cues) VALUES ('$matricula', '$nombre')";
    $query = mysqli_query($conexion, $insertar);
    if (!$query) {
        echo '<script>
            alert("Error al ingresar en la tabla cuestionarios");
            window.history.go(-1);
        </script>';
        die();
    };

    $query = mysqli_query($conexion, "SELECT id_cues FROM cuestionarios WHERE nom_cues = '$nombre'");
    while ($row = mysqli_fetch_assoc($query)) {
        $idCuestionario = $row['id_cues'];
    };

    for ($i = 1; $i <= $p; $i++){
        $seleccion = $obj["pregunta".$i]["seleccion"];
        $pregunta = $obj["pregunta".$i]["nombre"];
        $insertar = "INSERT INTO preguntas(id_cues1, id_sel1, pre_pre) VALUES ('$idCuestionario', '$seleccion', '$pregunta')";
        $query = mysqli_query($conexion, $insertar);
        if (!$query) {
            echo '<script>
                alert("Error al ingresar en la tabla preguntas");
                window.history.go(-1);
            </script>';
            die();
        };

        $query = mysqli_query($conexion, "SELECT id_pre FROM preguntas WHERE pre_pre = '$pregunta'");
        while ($row = mysqli_fetch_assoc($query)) {
            $idPregunta = $row['id_pre'];
        };

        $array = $obj["pregunta".$i];
        $removeLastTwo = array();
        array_splice($array,-2,2,$removeLastTwo);

        foreach($array as $respuestas => $value) {
            $insertar = "INSERT INTO respuestas(id_pre1, res_res, cont_res) VALUES ('$idPregunta', '$value', '0')";
            $query = mysqli_query($conexion, $insertar);
            if (!$query) {
                echo '<script>
                    alert("Error al ingresar en la tabla respuestas");
                    window.history.go(-1);
                </script>';
                die();
            };
        };
    };
    mysqli_close($conexion);
?>