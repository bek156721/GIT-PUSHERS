<?php
    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
    }
    include 'conexion.php';

        $id_formulario = 1;

        echo "<form action = 'resolver_formulario.php' method = 'POST'>";
        $query_pregunta = "SELECT pregunta, id_pregunta, id_tipo_pregunta  FROM pregunta WHERE id_formulario = $id_formulario";
        $res = mysqli_query($conexion, $query_pregunta);

        while($preguntas= mysqli_fetch_assoc($res))
        {
            $id_tipo_preguntas = $preguntas['id_tipo_pregunta'];
            $id_preguntas = $preguntas['id_pregunta'];
            $query_opciones = "SELECT opcion FROM opcion_pregunta WHERE id_pregunta = $id_preguntas";
            $res_opcion = mysqli_query($conexion, $query_opciones);
            echo $preguntas['pregunta'] . "<br>";

            $query_contar_opciones = "SELECT COUNT(id_pregunta) FROM opcion_pregunta WHERE id_pregunta = $id_preguntas";
            $res_numero_opciones = mysqli_query($conexion, $query_contar_opciones);
            //$numero_opciones = mysqli_fetch_assoc($res_numero_opciones); 
                    if($id_tipo_preguntas == 1)
                    {
                        while($opciones= mysqli_fetch_assoc($res_opcion))
                        {
                                echo "<div class = 'opciones_respuestas'>";
                                    echo "<input type='radio' name='respuesta_$id_preguntas' id='$opciones[opcion]' value='$id_preguntas' required>";
                                    echo "<label > $opciones[opcion] </label>"; 
                                echo "</div>";
                        }
                        
                    }
                    if($preguntas['id_tipo_pregunta'] == 2)
                    {
                        while($opciones= mysqli_fetch_assoc($res_opcion))
                        {
                            echo "<div class = 'opciones_respuestas'>";
                                echo "<input type='checkbox' name='respuesta_$id_preguntas' id='$opciones[opcion]' value='$id_preguntas' required>";
                                echo "<label> $opciones[opcion] </label>";            
                            echo "</div>";
                        }
                    }
                    if($preguntas['id_tipo_pregunta'] == 3)
                    {
                        echo "<div class = 'opciones_respuestas'>";
                            //echo "<input type='textarea' name='$id_preguntas' id='$opciones[opcion]' value='Chica' required>";
                            echo "<label> 'Escibre tu respuesta' </label>";     
                            echo "<textarea name = respuesta_$id_preguntas' id = '$opciones[opcion]' value = '$id_preguntas'></textarea>";       
                        echo "</div>";
                    }
        }
        echo "<button class = 'boton' type='submit' class='boton'>ENVIAR</button>";
        echo "</form>";
?>