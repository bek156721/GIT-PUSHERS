<?php
    include 'conexion.php';
    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
        exit();
    }
    //Obtiene el id_alumno y el id_grupo para que no esten en un arreglo
    $id_alumno = $_SESSION['id_alumno'];
    $id_grupo = $_SESSION['id_grupo'];

    //Selecciona todas las actividades del alumno para despues obtener informacion de ellas
    $sql_alumno ="SELECT entregado, id_actividad FROM actividad_por_alumno WHERE id_alumno = $id_alumno";
    $resultado_alumno = mysqli_query($conexion, $sql_alumno);
    
    $actividades= [];
    $num_actividades= [0,0,0,0,0,0];//Guarda la cantidad de actividades por cada modulo y si estan entregadas
    $incremento = 0; 
    while ($act_alumno = mysqli_fetch_assoc($resultado_alumno)) //recorre todos los registros para verifivar cada actividad
    {  
        $sql_actividad = "SELECT titulo, descripcion, modulo, fecha, hora FROM actividad WHERE id_actividad =".$act_alumno["id_actividad"];
        $resultado_actividad = mysqli_query($conexion, $sql_actividad);
        
        if($fila = mysqli_fetch_assoc($resultado_actividad))//Solo lo ejecuta si existe
        {
            $actividades[$incremento][0] = $fila['modulo'];
            $actividades[$incremento][1] = $act_alumno['id_actividad'];
            $actividades[$incremento][2] = $act_alumno['entregado'];
            $actividades[$incremento][3] = $fila['titulo'];
            $actividades[$incremento][4] = $fila['descripcion'];
            $actividades[$incremento][5] = $fila['fecha'];
            $actividades[$incremento][6] = $fila['hora'];

            if($actividades[$incremento][2]==0)
                $num_actividades[5]++; 
            $num_actividades[$actividades[$incremento][0] - 1]++;

            $incremento++;            
        }
    }
?>  
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Actividades</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Pagina para la consulta de actividades">
        <meta name="author" content="git pushers (Equipo 7)">
        <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
        <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">
        <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <h1>Actividades</h1>
            <div id="cont-circul">
                <aside>
                    <form action="perfil-alumno.php" method="POST">
                        <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../uploads/fotos-perfil/foto-default.png" alt="Log Out"></button> 
                    </form>
                </aside>
                <aside>
                    <form action="cerrar-sesion.php" method="POST">
                        <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../statics/media/img/logout.png" alt="Log Out"></button> 
                    </form>
                </aside>
                <aside>
                    <form action="pagina-inicio-alumno.php" method="POST">
                        <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../statics/media/img/home.png" alt="Log Out"></button> 
                    </form>
                </aside>
            </div>       
            <div id="gran-contenedor">
                    <div class="modulo">
                        <details>
                            <summary>Módulo 1</summary>
                                <?php
                                    for ($i=0;$i<$incremento;$i++) 
                                    {
                                        if($actividades[$i][0] == 1)
                                        {
                                            echo "<div class='formulario'>";
                                                echo "<div class='arriba'>";
                                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $actividades[$i][5] . "</p>"; 
                                                echo "</div>";
                                                echo "<div class='arriba'>"; 
                                                    echo "<p class='fecha-publicacion'>Hora de publicación: ". $actividades[$i][6] ." </p>";
                                                echo "</div>";
                                                if($actividades[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                                {
                                                    echo "<p class='titulo-formulario' style='color: red;'>".$actividades[$i][3]."</p>"; // título
                                                    //echo "<br>";
                                                }
                                                else
                                                    echo "<p class='titulo-formulario'>".$actividades[$i][3]."</p>";
                                                echo "<p class='descripcion-formulario'>".$actividades[$i][4]."</p>";   // descripción
                                            echo "</div>";
                                        }
                                    }
                                    if ($num_actividades[0] == 0)
                                    {
                                        echo "<div class='formulario'>";
                                            echo "<p class='titulo-formulario'> No hay actividades de este módulo </p>";
                                        echo "</div>";
                                    }
                                ?>
                        </details>
                    </div>
                    <div class="modulo">
                        <details>
                            <summary>Módulo 2</summary>
                                <?php
                                    for ($i=0;$i<$incremento;$i++) 
                                    {
                                        if($actividades[$i][0] == 2)
                                        {
                                            echo "<div class='formulario'>";
                                                echo "<div class='arriba'>";
                                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $actividades[$i][5] . "</p>"; 
                                                echo "</div>";
                                                echo "<div class='arriba'>"; 
                                                    echo "<p class='fecha-publicacion'>Hora de publicación: ". $actividades[$i][6] ." </p>";
                                                echo "</div>";;
                                                if($actividades[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                                    echo "<p class='titulo-formulario' style='color: red;'>".$actividades[$i][3]."</p>"; // título
                                                else
                                                    echo "<p class='titulo-formulario'>".$actividades[$i][3]."</p>";
                                                echo "<p class='descripcion-formulario'>".$actividades[$i][4]."</p>";   // descripción
                                            echo "</div>";
                                        }
                                    }

                                    if ($num_actividades[1] == 0)
                                    {
                                        echo "<div class='formulario'>";
                                            echo "<p class='titulo-formulario'> No hay actividades de este módulo </p>";
                                        echo "</div>";
                                    }
                                ?>
                        </details>
                    </div>
                    <div class="modulo">
                        <details>
                            <summary>Módulo 3</summary>
                                <?php
                                    for ($i=0;$i<$incremento;$i++) 
                                    {
                                        if($actividades[$i][0] == 3)
                                        {
                                            echo "<div class='formulario'>";
                                                echo "<div class='arriba'>";
                                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $actividades[$i][5] . "</p>"; 
                                                echo "</div>";
                                                echo "<div class='arriba'>"; 
                                                    echo "<p class='fecha-publicacion'>Hora de publicación: ". $actividades[$i][6] ." </p>";
                                                echo "</div>";                                                if($actividades[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                                    echo "<p class='titulo-formulario' style='color: red;'>".$actividades[$i][3]."</p>"; // título
                                                else
                                                    echo "<p class='titulo-formulario'>".$actividades[$i][3]."</p>";
                                                echo "<p class='descripcion-formulario'>".$actividades[$i][4]."</p>";   // descripción
                                            echo "</div>";
                                        }
                                    }

                                    if ($num_actividades[2] == 0)
                                    {
                                        echo "<div class='formulario'>";
                                            echo "<p class='titulo-formulario'> No hay actividades de este módulo </p>";
                                        echo "</div>";
                                    }
                                ?>
                        </details>
                    </div>
                    <div class="modulo">
                        <details>
                            <summary>Módulo 4</summary>
                                <?php
                                    for ($i=0;$i<$incremento;$i++) 
                                    {
                                        if($actividades[$i][0] == 4)
                                        {
                                            echo "<div class='formulario'>";
                                                echo "<div class='arriba'>";
                                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $actividades[$i][5] ."</p>";
                                                echo "</div>";
                                                if($actividades[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                                    echo "<p class='titulo-formulario' style='color: red;'>".$actividades[$i][3]."</p>"; // título
                                                else
                                                    echo "<p class='titulo-formulario'>".$actividades[$i][3]."</p>";
                                                echo "<p class='descripcion-formulario'>".$actividades[$i][4]."</p>";   // descripción
                                            echo "</div>";
                                        }
                                    }

                                    if ($num_actividades[3] == 0)
                                    {
                                        echo "<div class='formulario'>";
                                            echo "<p class='titulo-formulario'> No hay actividades de este módulo </p>";
                                        echo "</div>";
                                    }
                                ?>
                        </details>
                    </div>
                    <div class="modulo">
                        <details>
                            <summary>Módulo 5</summary>
                                <?php
                                    for ($i=0;$i<$incremento;$i++) 
                                    {
                                        if($actividades[$i][0] == 5)
                                        {
                                            echo "<div class='formulario'>";
                                                echo "<div class='arriba'>";
                                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $actividades[$i][5] ."</p>";
                                                echo "</div>";
                                                if($actividades[$i][2]==0) //Si no esta entregado se pone en rojo el título
                                                    echo "<p class='titulo-formulario' style='color: red;'>".$actividades[$i][3]."</p>"; // título
                                                else
                                                    echo "<p class='titulo-formulario'>".$actividades[$i][3]."</p>";
                                                echo "<p class='descripcion-formulario'>".$actividades[$i][4]."</p>";   // descripción
                                            echo "</div>";
                                        }
                                    }

                                    if ($num_actividades[4] == 0)
                                    {
                                        echo "<div class='formulario'>";
                                            echo "<p class='titulo-formulario'> No hay actividades de este módulo </p>";
                                        echo "</div>";
                                    }
                                ?>
                        </details>
                    </div>
                    <div class="modulo">
                        <details>
                            <summary>Actividades no entregadas</summary>
                                <?php
                                    for ($i=0;$i<$incremento;$i++) 
                                    {
                                        if($actividades[$i][2] == 0)
                                        {
                                            echo "<div class='formulario'>";
                                                echo "<div class='arriba'>";
                                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $actividades[$i][5] . "</p>"; 
                                                echo "</div>";
                                                echo "<div class='arriba'>"; 
                                                    echo "<p class='fecha-publicacion'>Hora de publicación: ". $actividades[$i][6] ." </p>";
                                                echo "</div>";
                                                
                                                echo "<p class='titulo-formulario' style='color: red;'>".$actividades[$i][3]."</p>"; // título
                                                echo "<br>";
                                                echo "<p class='descripcion-formulario'>Módulo: ".$actividades[$i][0]."</p>";
                                                echo "<p class='descripcion-formulario'>".$actividades[$i][4]."</p>";   // descripción
                                            echo "</div>";
                                        }
                                    }

                                    if ($num_actividades[5] == 0)
                                    {
                                        echo "<div class='formulario'>";
                                            echo "<p class='titulo-formulario'> Todas las actividades han sido entregadas </p>";
                                        echo "</div>";
                                    }
                                ?>
                        </details>
                    </div>
            </div>
        </main>
    </body>
    <?php include 'footer.php'; ?>
</html>
