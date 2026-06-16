<?php
    include 'conexion.php';
    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
    }
    //Obtiene el id_alumno y el id_grupo para que no esten en un arreglo
    $id_alumno = $_SESSION['id_alumno'];
    $id_grupo = $_SESSION['id_grupo'];

    //Selecciona todas las actividades del alumno para despues obtener informacion de ellas
    $sql_alumno ="SELECT entregado, calificacion, id_formulario FROM formulario_por_alumno WHERE id_alumno = $id_alumno";
    $resultado_alumno = mysqli_query($conexion, $sql_alumno);
    
    $formularios ;
    $num_formularios= [0,0,0,0,0,0];//Guarda la cantidad de actividades por cada modulo y si estan entregadas
    $incremento = 0; 
    while ($act_alumno = mysqli_fetch_assoc($resultado_alumno)) //recorre todos los registros para verifivar cada actividad
    {  
        $sql_actividad = "SELECT titulo, descripcion, modulo, fecha, hora FROM formulario WHERE id_formulario =".$act_alumno["id_formulario"];
        $resultado_actividad = mysqli_query($conexion, $sql_actividad);
        
        if($fila = mysqli_fetch_assoc($resultado_actividad))//Solo lo ejecuta si existe
        {
            $formularios[$incremento][0] = $fila['modulo'];
            $formularios[$incremento][1] = $act_alumno['id_formulario'];
            $formularios[$incremento][2] = $act_alumno['entregado'];
            $formularios[$incremento][3] = $fila['titulo'];
            $formularios[$incremento][4] = $fila['descripcion'];
            $formularios[$incremento][5] = $fila['fecha'];
            $formularios[$incremento][6] = $fila['hora'];

            if($formularios[$incremento][2]==0)
               $num_formularios[5]++; 
            $num_formularios[$formularios[$incremento][0] - 1]++;

            $incremento++;            
        }
    }
?>  
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Formularios</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Pagina para la consulta de formularios">
        <meta name="author" content="git pushers (Equipo 7)">
        <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
        <link rel="stylesheet" href="../../statics/css/estilo-formularios.css">
        <link rel="stylesheet" href="../../statics/css/contenido.css"> <!-- css de contenido a mostrar -->
        <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    </head>
    <body>
        <?php include 'header.php'; ?>
        <h1 >Formularios</h1>

        <div id="gran-contenedor">

            <div id="modulos">
                <div class="modulo">
                    <details>

                        <summary>Modulo 1</summary>
                            <?php
                                for ($i=0;$i<$incremento;$i++) 
                                {
                                    if($formularios[$i][0] == 1)
                                    {
                                        echo "<div class='formulario' >";
                                        if($formularios[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                            echo "<p style='color: red;'>".$formularios[$i][3]."</p>"; // título
                                        else
                                            echo "<p>".$formularios[$i][3]."</p>";

                                        echo "<p>".$formularios[$i][4]."</p>";   // descripción
                                        echo "<p><strong>Fecha:</strong> ".$formularios[$i][5]."</p>"; // fecha
                                        echo "<a href='formulario.php?id_formulario=".$formularios[$i][1]."'>Ir a formulario</a>";
                                        echo "</div>";
                                        echo "<br>";
                                    }
                                }

                                if ($num_formularios[0] == 0)
                                    echo "<p> No hay formularios de este modulo <p>";
                            ?>
                    </details>

                </div>
                <div class="modulo">
                    <details>

                        <summary>Modulo 2</summary>
                            <?php
                                for ($i=0;$i<$incremento;$i++) 
                                {
                                    if($formularios[$i][0] == 2)
                                    {
                                        echo "<div class='formulario' >";
                                        if($formularios[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                            echo "<p style='color: red;'>".$formularios[$i][3]."</p>"; // título
                                        else
                                            echo "<p>".$formularios[$i][3]."</p>";

                                        echo "<p>".$formularios[$i][4]."</p>";   // descripción
                                        echo "<p><strong>Fecha:</strong> ".$formularios[$i][5]."</p>"; // fecha
                                        echo "<a href='formulario.php?id_formulario=".$formularios[$i][1]."'>Ir a formulario</a>";
                                        echo "</div>";
                                        echo "<br>";
                                    }
                                }

                                if ($num_formularios[1] == 0)
                                    echo "<p> No hay formularios de este modulo <p>";
                            ?>
                        </div>

                    </details>

                </div>
                <div class="modulo">
                    <details>

                        <summary>Modulo 3</summary>
                            <?php
                                for ($i=0;$i<$incremento;$i++) 
                                {
                                    if($formularios[$i][0] == 3)
                                    {
                                        echo "<div class='formulario' >";
                                        if($formularios[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                            echo "<p style='color: red;'>".$formularios[$i][3]."</p>"; // título
                                        else
                                            echo "<p>".$formularios[$i][3]."</p>";

                                        echo "<p>".$formularios[$i][4]."</p>";   // descripción
                                        echo "<p><strong>Fecha:</strong> ".$formularios[$i][5]."</p>"; // fecha
                                        echo "<a href='formulario.php?id_formulario=".$formularios[$i][1]."'>Ir a formulario</a>";
                                        echo "</div>";
                                        echo "<br>";
                                    }
                                }

                                if ($num_formularios[2] == 0)
                                    echo "<p> No hay formularios de este modulo <p>";
                            ?>

                    </details>

                </div>
                <div class="modulo">
                    <details>

                        <summary>Modulo 4</summary>
                            <?php
                                for ($i=0;$i<$incremento;$i++) 
                                {
                                    if($formularios[$i][0] == 4)
                                    {
                                        echo "<div class='formulario' >";
                                        if($formularios[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                            echo "<p style='color: red;'>".$formularios[$i][3]."</p>"; // título
                                        else
                                            echo "<p>".$formularios[$i][3]."</p>";

                                        echo "<p>".$formularios[$i][4]."</p>";   // descripción
                                        echo "<p><strong>Fecha:</strong> ".$formularios[$i][5]."</p>"; // fecha
                                        echo "<a href='formulario.php?id_formulario=".$formularios[$i][1]."'>Ir a formulario</a>";
                                        echo "</div>";
                                        echo "<br>";
                                    }
                                }

                                if ($num_formularios[3] == 0)
                                    echo "<p> No hay formularios de este modulo <p>";
                            ?>

                    </details>

                </div>
                <div class="modulo">
                    <details>

                        <summary>Modulo 5</summary>
                            <?php
                                for ($i=0;$i<$incremento;$i++) 
                                {
                                    if($formularios[$i][0] == 5)
                                    {
                                        echo "<div class='formulario' >";
                                        if($formularios[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                            echo "<p style='color: red;'>".$formularios[$i][3]."</p>"; // título
                                        else
                                            echo "<p>".$formularios[$i][3]."</p>";

                                        echo "<p>".$formularios[$i][4]."</p>";   // descripción
                                        echo "<p><strong>Fecha:</strong> ".$formularios[$i][5]."</p>"; // fecha
                                        echo "<a href='formulario.php?id_formulario=".$formularios[$i][1]."'>Ir a formulario</a>";
                                        echo "</div>";
                                        echo "<br>";
                                    }
                                }

                                if ($num_formularios[4] == 0)
                                    echo "<p> No hay formularios de este modulo <p>";
                            ?>

                    </details>

                </div>
                <div class="modulo">
                    <details>

                        <summary>Formularios no entregadas</summary>
                            <?php
                                for ($i=0;$i<$incremento;$i++) 
                                {
                                    if($formularios[$i][2] == 0)
                                    {
                                        echo "<div class='formulario' >";
                                        echo "<p style='color: red;'>".$formularios[$i][3]."</p>"; // título
                                        echo "<p>".$formularios[$i][4]."</p>";   // descripción
                                        echo "<p><strong>Fecha:</strong> ".$formularios[$i][5]."</p>"; // fecha
                                        echo "<p>Modulo: ".$formularios[$i][0]."</p>";
                                        echo "<a href='formulario.php?id_formulario=".$formularios[$i][1]."'>Ir a formulario</a>";
                                        echo "</div>";
                                        echo "<br>";
                                    }
                                }

                                if ($num_formularios[5] == 0)
                                    echo "<p>Todas los formularios estan entregadas <p>";
                            ?>

                    </details>

                </div>
            </div>
        </div>
    </body>
    <?php include 'footer.php'; ?>
</html>