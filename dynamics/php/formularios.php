<?php
    include 'conexion.php';

        session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
        exit();
    }
    
    $sql = "";
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina para la consulta de formularios">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">
    <title>Formularios</title>
</head>
<?php include 'header.php' ?>
<body>
<main>
    <h1>Formularios</h1>
    <div id="cont-circul">
        <aside>
            <form action="perfil-alumno.php" method="POST">
                <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../uploads/fotos-perfil/foto-default.png" alt="Log Out"></button> 
            </form>
        </aside>
        <aside >
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
                    <!--aqui va un for each para los formularios -->
                    <?php
                        $sql = "SELECT * FROM formulario WHERE modulo ='1' AND id_grupo = " . $_SESSION['id_grupo'];
                        $formularios = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            foreach($formularios as $formulario)
                            {
                                $sql_entreado = "SELECT * FROM formulario_por_alumno WHERE entregado = 1 AND id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " . $formulario['id_formulario'];
                                $resultado = mysqli_query($conexion, $sql_entreado);
                                
                                
                                if(mysqli_num_rows($resultado) > 0)
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        
                                        echo "<p class = 'titulo-formulario'>".$formulario['titulo']."</p>"; // título
                                        echo "<br>";
                                        echo "<p class = 'descripcion-formulario'>".$formulario['descripcion']."</p>";   // descripción
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Resuelto</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                                else
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        // NO ENTREGADO: Título en rojo
                                        echo "<p class='titulo-formulario' style='color: red;'>". $formulario['titulo'] ."</p>";
                                        echo "<br>";
                                        echo "<p class='descripcion-formulario'>". $formulario['descripcion'] ."</p>";
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit' style='color: red;'>Por resolver</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    ?>
                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Módulo 2</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='2' AND id_grupo = " . $_SESSION['id_grupo'];
                        $formularios = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            foreach($formularios as $formulario)
                            {
                                $sql_entreado = "SELECT * FROM formulario_por_alumno WHERE entregado = 1 AND id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " . $formulario['id_formulario'];
                                $resultado = mysqli_query($conexion, $sql_entreado);
                                
                                
                                if(mysqli_num_rows($resultado) > 0)
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        
                                        echo "<p class = 'titulo-formulario'>".$formulario['titulo']."</p>"; // título
                                        echo "<br>";
                                        echo "<p class = 'descripcion-formulario'>".$formulario['descripcion']."</p>";   // descripción
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Resuelto</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                                else
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        // NO ENTREGADO: Título en rojo
                                        echo "<p class='titulo-formulario' style='color: red;'>". $formulario['titulo'] ."</p>";
                                        echo "<br>";
                                        echo "<p class='descripcion-formulario'>". $formulario['descripcion'] ."</p>";
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Por resolver</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    ?>
                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Módulo 3</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='3' AND id_grupo = " . $_SESSION['id_grupo'];
                        $formularios = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            foreach($formularios as $formulario)
                            {
                                $sql_entreado = "SELECT * FROM formulario_por_alumno WHERE entregado = 1 AND id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " . $formulario['id_formulario'];
                                $resultado = mysqli_query($conexion, $sql_entreado);
                                
                                
                                if(mysqli_num_rows($resultado) > 0)
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        
                                        echo "<p class = 'titulo-formulario'>".$formulario['titulo']."</p>"; // título
                                        echo "<br>";
                                        echo "<p class = 'descripcion-formulario'>".$formulario['descripcion']."</p>";   // descripción
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Resuelto</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                                else
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        // NO ENTREGADO: Título en rojo
                                        echo "<p class='titulo-formulario' style='color: red;'>". $formulario['titulo'] ."</p>";
                                        echo "<br>";
                                        echo "<p class='descripcion-formulario'>". $formulario['descripcion'] ."</p>";
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Por resolver</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    ?>
                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Módulo 4</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='4' AND id_grupo = " . $_SESSION['id_grupo'];
                        $formularios = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            foreach($formularios as $formulario)
                            {
                                $sql_entreado = "SELECT * FROM formulario_por_alumno WHERE entregado = 1 AND id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " . $formulario['id_formulario'];
                                $resultado = mysqli_query($conexion, $sql_entreado);
                                
                                
                                if(mysqli_num_rows($resultado) > 0)
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        
                                        echo "<p class = 'titulo-formulario'>".$formulario['titulo']."</p>"; // título
                                        echo "<br>";
                                        echo "<p class = 'descripcion-formulario'>".$formulario['descripcion']."</p>";   // descripción
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Resultado</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                                else
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        // NO ENTREGADO: Título en rojo
                                        echo "<p class='titulo-formulario' style='color: red;'>". $formulario['titulo'] ."</p>";
                                        echo "<br>";
                                        echo "<p class='descripcion-formulario'>". $formulario['descripcion'] ."</p>";
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Por resolver</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    ?>

                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Módulo 5</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='5' AND id_grupo = " . $_SESSION['id_grupo'];
                        $formularios = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<p class='formulario'> No hay formularios en este módulo</p>";
                        }
                        else
                        {
                            foreach($formularios as $formulario)
                            {
                                $sql_entreado = "SELECT * FROM formulario_por_alumno WHERE entregado = 1 AND id_alumno = " . $_SESSION['id_alumno'] . " AND id_formulario = " . $formulario['id_formulario'];
                                $resultado = mysqli_query($conexion, $sql_entreado);
                                
                                
                                if(mysqli_num_rows($resultado) > 0)
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        
                                        echo "<p class = 'titulo-formulario'>".$formulario['titulo']."</p>"; // título
                                        echo "<br>";
                                        echo "<p class = 'descripcion-formulario'>".$formulario['descripcion']."</p>";   // descripción
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit'>Resuelto</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                                else
                                {
                                    echo "<div class='formulario'>";
                                        echo "<div class='arriba'>";
                                            echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                                        echo "</div>";
                                        echo "<div class='arriba'>"; 
                                            echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                                        echo "</div>";
                                        // NO ENTREGADO: Título en rojo
                                        echo "<p class='titulo-formulario' style='color: red;'>". $formulario['titulo'] ."</p>";
                                        echo "<br>";
                                        echo "<p class='descripcion-formulario'>". $formulario['descripcion'] ."</p>";
                                        //Pasar por post el id del cuestionario
                                        echo "<div class='abajo'>";
                                            echo "<form action='./resolver-formulario.php' method='get'>";
                                                echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                                echo "<button class='ver-mas' type='submit' style='color: red;'>Por resolver</button>";
                                            echo "</form>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    ?>

                </details>

            </div>
            <div class="modulo">
        <details>
    <summary>Formularios no entregados</summary>
    <?php
        $sql_entregados = "SELECT id_formulario FROM formulario_por_alumno WHERE entregado = 1 AND id_alumno = " . $_SESSION['id_alumno'];
        $resultado_entregados = mysqli_query($conexion, $sql_entregados);

        $ids_entregados = array();
        while ($row = mysqli_fetch_assoc($resultado_entregados))
        {
            $ids_entregados[] = $row['id_formulario'];
        }
        $sql_formularios = "SELECT * FROM formulario WHERE id_grupo = " . $_SESSION['id_grupo'];
        $resultado_formularios = mysqli_query($conexion, $sql_formularios);

        $contador_pendientes = 0;
        
        while ($formulario = mysqli_fetch_assoc($resultado_formularios))
        {
            if (!in_array($formulario['id_formulario'], $ids_entregados))
            {
                $contador_pendientes++;

                echo "<div class='formulario'>";
                    echo "<div class='arriba'>";
                        echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] . "</p>"; 
                    echo "</div>";
                    echo "<div class='arriba'>"; 
                        echo "<p class='fecha-publicacion'>Hora de publicación: ". $formulario['hora'] ." </p>";
                    echo "</div>";
                    
                    echo "<p class='titulo-formulario' style='color: red;'>". $formulario['titulo'] ."</p>";
                    echo "<br>";
                    echo "<p class='descripcion-formulario'>Módulo: ". $formulario['modulo'] ."</p>";
                    echo "<p class='descripcion-formulario'>". $formulario['descripcion'] ."</p>";
                    echo "<div class='abajo'>";
                        echo "<form action='./resolver-formulario.php' method='get'>";
                            echo "<input type='hidden' name='id_formulario' value='".$formulario['id_formulario']."'>";
                            echo "<button class='ver-mas' type='submit' style='color: red;'>Por resolver</button>";
                        echo "</form>";
                    echo "</div>";
                echo "</div>";
            }
        }

        if ($contador_pendientes == 0)
        {
            echo "<div class='formulario'>";
                echo "<p class='titulo-formulario'> Todos los formularios han sido entregados</p>";
            echo "</div>";
        }
    ?>
</details>
</div>
        </div>
    </div>
</main>
</body>
<footer>
    <?php include 'footer.php' ?>
</footer>
</html>