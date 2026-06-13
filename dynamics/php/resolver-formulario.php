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

        $id_formulario = 1;

        echo "<form action = 'resolver_formulario.php' method = 'POST'>";
        $query_pregunta = "SELECT pregunta, id_pregunta, id_tipo_pregunta  FROM pregunta WHERE id_formulario = $id_formulario";
        $res = mysqli_query($conexion, $query_pregunta);

            while($preguntas= mysqli_fetch_assoc($res))
            {
                $id_tipo_preguntas = $preguntas['id_tipo_pregunta'];
                $id_preguntas = $preguntas['id_pregunta'];
                $query_opciones = "SELECT opcion, id_opcion_pregunta, puntaje_opcion FROM opcion_pregunta WHERE id_pregunta = $id_preguntas";
                $res_opcion = mysqli_query($conexion, $query_opciones);
                $id_opcion_preguntas = mysqli_fetch_assoc($res_opcion);

                echo $preguntas['pregunta'] . "<br>";

                /*$query_puntaje_opcion = "SELECT puntaje_opcion FROM opcion_pregunta WHERE id_formulario = $id_formulario";
                $res_puntaje = mysqli_query($conexion, $query_puntaje_opcion);
                $puntaje = myqli_fetch_assco($res_puntaje);*/

                $query_contar_opciones = "SELECT COUNT(id_pregunta) FROM opcion_pregunta WHERE id_pregunta = $id_preguntas";
                $res_numero_opciones = mysqli_query($conexion, $query_contar_opciones);
                //$numero_opciones = mysqli_fetch_assoc($res_numero_opciones); 
                
                        if($id_tipo_preguntas == 1)
                        {
                            echo "<br>";
            echo $id_preguntas;
            echo "<br>";
            echo $id_opcion_preguntas['id_opcion_pregunta'];
            echo "<br>";
            echo $id_opcion_preguntas['puntaje_opcion'];
                            while($opciones= mysqli_fetch_assoc($res_opcion))
                            {
                                    echo "<div class = 'opciones_respuestas'>";
                                        echo "<input type='radio' name='respuesta_$id_preguntas' id='$opciones[opcion]' value='$id_preguntas' required>";
                                        echo "<label > $opciones[opcion] </label>"; 
                                    echo "</div>";

                                    /*echo $id_preguntas;
                                    echo "<br>";
                                    echo $id_opcion_preguntas['id_opcion_pregunta'];
                                    echo "<br>";
                                    echo $id_opcion_preguntas['puntaje_opcion'];*/
                            }
                            
                        }
                        if($id_tipo_preguntas == 2)
                        {
                            while($opciones= mysqli_fetch_assoc($res_opcion))
                            {
                                echo "<div class = 'opciones_respuestas'>";
                                    echo "<input type='checkbox' name='respuesta_$id_preguntas' id='$opciones[opcion]' value='$id_preguntas'>";
                                    echo "<label> $opciones[opcion] </label>";            
                                echo "</div>";
                            }
                        }
                        if($id_tipo_preguntas == 3)
                        {
                            echo "<div class = 'opciones_respuestas'>";
                                //echo "<input type='textarea' name='$id_preguntas' id='$opciones[opcion]' value='Chica' required>";
                                echo "<label> 'Escibre tu respuesta' </label>";     
                                echo "<textarea name = respuesta_$id_preguntas' id = '$opciones[opcion]' value = '$id_preguntas'></textarea>";       
                            echo "</div>";
                        }
                        echo $_SESSION['id_alumno'];
            /*echo "<br>";
            echo $id_preguntas;
            echo "<br>";
            echo $id_opcion_preguntas['id_opcion_pregunta'];
            echo "<br>";
            echo $id_opcion_preguntas['puntaje_opcion'];*/
            }
            echo "<button class = 'boton' type='submit' class='boton'>ENVIAR</button>";
            echo "</form>";

            /*echo $_SESSION['id_alumno'];
            echo "<br>";
            echo $id_preguntas;
            echo "<br>";
            echo $id_opcion_preguntas['id_opcion_pregunta'];
            echo "<br>";
            echo $id_opcion_preguntas['puntaje_opcion'];*/

            /*FUNCTION guardar_respuesta ($respuestas)
            {
                if($id_tipo_preguntas == 1 || $id_tipo_preguntas== 2)
                    $query_respuestas = "INSERT INTO respuesta_alumno (id_alumno, id_pregunta, id_opcion_pregunta, calificacion_por_pregunta) 
                    VALUES ($_SESSION['id_alumno'], $id_preguntas, $id_opcion_preguntas['id_opcion_pregunta'],$id_opcion_preguntas['puntaje_opcion'])";
            }*/
?>