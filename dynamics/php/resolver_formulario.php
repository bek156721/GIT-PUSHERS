<?php
    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
    }
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
    $query_titulo = "SELECT titulo FROM formulario WHERE id_formulario = 4";
    $res_titulo = mysqli_query($conexion, $query_titulo);
    $titulos_formulario = mysqli_fetch_assoc($res_titulo);
    $titulo = $titulos_formulario['titulo'];
?>

<!DOCTYPE html>
<html lang="es">
<body>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vridiana Castro">
        <link rel="stylesheet" href="../../statics/css/resolver-formulario.css">
        <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
        <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    </head>
    <main>
        <?php include 'header.php';?>
        <h1> FORMULARIO: <?php echo $titulo; ?> 
        <?php
            $id_formulario = 4;

            // LEER RESPUESTAS DEL FORMULARIO // 
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                echo "<form action = 'resolver_formulario.php' method = 'POST'>";
                $query_pregunta = "SELECT pregunta, id_pregunta, id_tipo_pregunta  FROM pregunta WHERE id_formulario = $id_formulario";
                $res = mysqli_query($conexion, $query_pregunta);

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

                            $query_puntaje_opcion = "SELECT puntaje_opcion FROM opcion_pregunta WHERE id_opcion_pregunta = $id_opcion_seleccionada";
                            $res_puntos = mysqli_query($conexion, $query_puntaje_opcion);
                            $datos_opcion = mysqli_fetch_assoc($res_puntos);
                            $puntaje = $datos_opcion['puntaje_opcion'];

                            $query_insertar_respuestas = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (" . $_SESSION['id_alumno'] . ", " . $id_preguntas . ", " . $id_opcion_seleccionada .", ". $puntaje . ")";
                            mysqli_query($conexion, $query_insertar_respuestas);

                        }

                        elseif($id_tipo_preguntas == 2)
                        {
                            foreach($_POST[$respuestas] as $multi_opcion)
                            {
                                $id_opcion_seleccionada = validar($multi_opcion);

                                $query_puntaje_opcion = "SELECT puntaje_opcion FROM opcion_pregunta WHERE id_opcion_pregunta = $id_opcion_seleccionada";
                                $res_puntos = mysqli_query($conexion, $query_puntaje_opcion);
                                $datos_opcion = mysqli_fetch_assoc($res_puntos);
                                $puntaje = $datos_opcion['puntaje_opcion'];

                                $query_insertar_respuestas = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (" . $_SESSION['id_alumno'] . ", " . $id_preguntas . ", " . $id_opcion_seleccionada .", ". $puntaje . ")";
                                mysqli_query($conexion, $query_insertar_respuestas);
                            }
                        }
                        
                        else
                        {
                            $texto_respuesta = validar($_POST[$respuestas]);

                            $query_insertar_texto = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) VALUES (". $_SESSION['id_alumno'] . " , " . $id_preguntas . " , NULL, 0)";
                            mysqli_query($conexion, $query_insertar_texto);
                        }
                    }
                }
                header("Location: resolver_formulario.php?exito = 1");
                exit(); 
            }


            //FORMULARIO//

            if(isset($_GET['exito']))
            {
                echo " <p class = 'envio_formulario'> ¡Formulario enviado con éxito! </p>";

            }

            echo "<form action = 'resolver_formulario.php' method = 'POST'>";

            $query_pregunta = "SELECT pregunta, id_pregunta, id_tipo_pregunta  FROM pregunta WHERE id_formulario = $id_formulario";
            $res = mysqli_query($conexion, $query_pregunta);
            echo "<div class = 'pregunta'>"; 
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
                        echo "<textarea name ='respuesta_$id_preguntas' id = '$opciones[opcion]'></textarea>";       
                    echo "</div>";
                }

            }
            echo "</div>"; 
                            
                echo "<button class = 'boton' type='submit' class='boton'>ENVIAR</button>";
                echo "</form>";
        ?>
    </main>
    <footer>
        <?php include'footer.php';?>
    </footer>    
</body>
    

