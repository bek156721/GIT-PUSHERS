<?php
    session_start();

    /*if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
        exit();
    }*/
    include 'conexion.php';

    function validar ($data) //Limpiar datos 
    {
        $data = trim($data); //Elimina espacios en extremos
        $data = htmlspecialchars($data); //Convierte carácteres especiales en entidades seguras de html
        $data = str_replace('--','',$data);
        $data = str_replace('/*','',$data);
        $data = str_replace('*/','',$data);
        return $data;
    }

    /*if(empty($usuario))
    {
        header("Location: inicio-sesion.php?error=Usuario requerido");
        exit();
    
    }
    elseif(empty($contrasenia))
    {
        header("Location: inicio-sesion.php?error=Contraseña requerida");
        exit();
    }*/
    if(isset($_POST['id_formulario']))
    {
        $id_formulario = $_POST['id_formulario'];
    }


    // LEER RESPUESTAS DEL FORMULARIO // 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //COMPRUEBA QUE SOLO SE ENVIÉEUNA VEZ
        $query_verificacion_envio = "SELECT entregado FROM formulario_por_alumno WHERE id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " . $id_formulario . "";
        $res_envio_respuestas = mysqli_query($conexion, $query_verificacion_envio);
        $enviar_respuestas = mysqli_fetch_assoc($res_envio_respuestas);

        if($enviar_respuestas !== NULL && $enviar_respuestas['entregado'] == 1)
        {
            header("Location: resolver-formulario.php");
            exit();
        }

        $query_pregunta = "SELECT pregunta, id_pregunta, id_tipo_pregunta  FROM pregunta WHERE id_formulario = $id_formulario";
        $res = mysqli_query($conexion, $query_pregunta);

        $rendimiento_acumulado = 0;
        $calificacion_acumulada = 0;

        //echo "<div class = 'pregunta'>"; 
            while($preguntas= mysqli_fetch_assoc($res))
            {
                $id_tipo_preguntas = $preguntas['id_tipo_pregunta'];
                $id_preguntas = $preguntas['id_pregunta'];
                $respuestas = "respuesta_" . $id_preguntas;

                if(isset($_POST[$respuestas]))
                {
                    if($id_tipo_preguntas == 1)
                    {
                        $id_opcion_seleccionada = validar($_POST[$respuestas]);

                        $query_puntaje_opcion = "SELECT puntaje_opcion, correcta FROM opcion_pregunta WHERE id_opcion_pregunta = $id_opcion_seleccionada";
                        $res_puntos = mysqli_query($conexion, $query_puntaje_opcion);
                        $datos_opcion = mysqli_fetch_assoc($res_puntos);

                        $puntaje = $datos_opcion['puntaje_opcion'];
                        $respuesta_correcta = $datos_opcion['correcta'];

                        $query_insertar_respuestas = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (" . $_SESSION['id_alumno'] . ", " . $id_preguntas . ", " . $id_opcion_seleccionada .", ". $puntaje . ")";
                        mysqli_query($conexion, $query_insertar_respuestas);

                        if($respuesta_correcta == 1)
                            $calificacion_acumulada = $calificacion_acumulada + $puntaje;
                    }

                    elseif($id_tipo_preguntas == 2)
                    {
                        foreach($_POST[$respuestas] as $multi_opcion)
                        {
                            $id_opcion_seleccionada = validar($multi_opcion);

                            $query_puntaje_opcion = "SELECT puntaje_opcion, correcta FROM opcion_pregunta WHERE id_opcion_pregunta = $id_opcion_seleccionada";
                            $res_puntos = mysqli_query($conexion, $query_puntaje_opcion);
                            $datos_opcion = mysqli_fetch_assoc($res_puntos);

                            $puntaje = $datos_opcion['puntaje_opcion'];
                            $respuesta_correcta = $datos_opcion['correcta'];

                            $query_insertar_respuestas = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (" . $_SESSION['id_alumno'] . ", " . $id_preguntas . ", " . $id_opcion_seleccionada .", ". $puntaje . ")";
                            mysqli_query($conexion, $query_insertar_respuestas);

                            if($respuesta_correcta == 1)
                                $calificacion_acumulada = $calificacion_acumulada + $puntaje;
                        }
                    }
                    else
                    {
                        $texto_respuesta = validar($_POST[$respuestas]);

                        $query_insertar_texto = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (". $_SESSION['id_alumno'] . " , " . $id_preguntas . " , NULL, 0)";
                        mysqli_query($conexion, $query_insertar_texto);


                        $calificacion_acumulada = $calificacion_acumulada + 0;
                    }
                }

                // SI DEJA EN BLANCO RESPUESTA TIPO CHECKBOX //
                elseif($id_tipo_preguntas == 2)
                {
                    $query_respuesta_vacia = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (" . $_SESSION['id_alumno'] . " , " . $id_tipo_preguntas . ", NULL, 0)";
                    mysqli_query($conexion, $query_respuesta_vacia);

                    $calificacion_acumulada = $calificacion_acumulada + 0;
                }
                            
                //RENDIMIENTO 
                $query_rendimiento_pregunta = "SELECT puntaje_rendimiento FROM pregunta WHERE id_pregunta = $id_preguntas";
                $res_rendimiento = mysqli_query($conexion, $query_rendimiento_pregunta);
                $datos_rendimiento = mysqli_fetch_assoc($res_rendimiento);

                $rendimiento_acumulado = $rendimiento_acumulado + $datos_rendimiento['puntaje_rendimiento'];
            }
        echo "</div>";
                
        if($id_formulario == 1)
        {
            $query_formulario_alumno = "INSERT INTO formulario_por_alumno (entregado, rendimiento_alumno, calificacion, id_formulario, id_alumno) VALUES (1, " . $rendimiento_acumulado. ", ". $calificacion_acumulada . " , 1, " . $_SESSION['id_alumno'] .")";
            mysqli_query($conexion, $query_formulario_alumno);
        }
        else 
        {
            $query_formulario_alumno = "INSERT INTO formulario_por_alumno (entregado, rendimiento_alumno, calificacion, id_formulario, id_alumno) VALUES (1, " . $rendimiento_acumulado. ", ". $calificacion_acumulada . " , 1, " . $_SESSION['id_alumno'] .")";
            mysqli_query($conexion, $query_formulario_alumno);
        }
        header("Location: resolver-formulario.php?exito=1");
        exit();
    }

    $query_titulo = "SELECT titulo FROM formulario WHERE id_formulario = '".$id_formulario."'";
    $res_titulo = mysqli_query($conexion, $query_titulo);
    $titulos_formulario = mysqli_fetch_assoc($res_titulo);
    $titulo = $titulos_formulario['titulo'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Git Pushers">
    <link rel="stylesheet" href="../../statics/css/resolver-formulario.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
</head>
<body>
    <?php include 'header.php';?>
<main>
    <h1> FORMULARIO: <?php echo $titulo; ?> </h1>
    <?php
        echo "<p>holalalalallala</p>";
        var_dump($id_formulario);
        if(isset($_GET['exito']))
        {
            echo " <p class = 'envio_formulario'> ¡Formulario enviado con éxito! </p>";
        }
        else 
        {
                $query_verificacion_envio = "SELECT entregado FROM formulario_por_alumno WHERE id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " .$id_formulario . "";
                $res_envio_respuestas = mysqli_query($conexion, $query_verificacion_envio);
                $enviar_respuestas = mysqli_fetch_assoc($res_envio_respuestas);

            if($enviar_respuestas !== NULL && $enviar_respuestas['entregado'] == 1)
            {
                echo "<p class = 'ya_se_envio'> Ya enviaste este formulario con éxito </p>";
            }

            if(isset($_GET['exito']))
            {
                echo " <p class = 'envio_formulario'> ¡Formulario enviado con éxito! </p>";
            }

            else
            {
                echo "<form action = 'resolver-formulario.php' method = 'POST'>";

                echo "<div class = 'pregunta'>";

                    $query_pregunta = "SELECT pregunta, id_pregunta, id_tipo_pregunta  FROM pregunta WHERE id_formulario = $id_formulario";
                    $res = mysqli_query($conexion, $query_pregunta);

                    while($preguntas= mysqli_fetch_assoc($res))
                    {
                        $id_tipo_preguntas = $preguntas['id_tipo_pregunta'];
                        $id_preguntas = $preguntas['id_pregunta'];

                        echo $preguntas['pregunta'] . "<br>";

                        $query_opciones = "SELECT opcion, id_opcion_pregunta, puntaje_opcion FROM opcion_pregunta WHERE id_pregunta = $id_preguntas";
                        $res_opcion = mysqli_query($conexion, $query_opciones);

                        $query_contar_opciones = "SELECT COUNT(id_pregunta) FROM opcion_pregunta WHERE id_pregunta = $id_preguntas";
                        $res_numero_opciones = mysqli_query($conexion, $query_contar_opciones);
                        //$numero_opciones = mysqli_fetch_assoc($res_numero_opciones); 
                                
                        if($id_tipo_preguntas == 1)
                        {
                            while($opciones= mysqli_fetch_assoc($res_opcion))
                            {
                                echo "<div class = 'opciones_respuestas'>";
                                    echo "<input type='radio' name='respuesta_$id_preguntas' id='$opciones[opcion]' value='$opciones[id_opcion_pregunta]' required>";
                                    echo "<label > $opciones[opcion] </label>"; 
                                echo "</div>";
                            }
                        }

                        if($id_tipo_preguntas == 2)
                        {
                            while($opciones= mysqli_fetch_assoc($res_opcion))
                                {
                                    echo "<div class = 'opciones_respuestas'>";
                                        echo "<input type='checkbox' name='respuesta_".$id_preguntas."[]' id='$opciones[opcion]' value='$opciones[id_opcion_pregunta]'>";
                                        echo "<label> $opciones[opcion] </label>";            
                                    echo "</div>";
                                }
                        }

                        if($id_tipo_preguntas == 3)
                        {
                            echo "<div class = 'opciones_respuestas'>";
                                echo "<label> 'Escibre tu respuesta' </label>";     
                                echo "<textarea name ='respuesta_$id_preguntas' required></textarea>";       
                            echo "</div>";
                        }
                    }
                echo "</div>";
                echo "<button type='submit' class='boton'>ENVIAR</button>";
                echo "</form>";
            }
        }
    ?>
    </main>
    <footer>
        <?php include'footer.php';?>
    </footer>    
</body>
</html>