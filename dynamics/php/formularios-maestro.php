<?php
include 'conexion.php';
session_start();

if ($_SESSION['rol'] != "profesor")
{
    header("Location: inicio-sesion.php");
    exit();
}

$id_profesor_usuario = $_SESSION['id_profesor'];

if ($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $fin = 0;
    
    // Verificar si el título ya existe (sin usar break)
    $sql = "SELECT titulo FROM formulario";
    $query = mysqli_query($conexion, $sql);
    while ($fin == 0 && ($nombre_duplicado = mysqli_fetch_assoc($query)))
    {
        if ($nombre_duplicado['titulo'] == $_POST['subir-nombre']) {
            $fin = 1;
        }
    }

    if ($fin == 0)
    {
        $id_grupo = null;
        if (!empty($_POST['subir-grupo']))
        {
            $nombre_grupo = mysqli_real_escape_string($conexion, $_POST['subir-grupo']);
            $sql_grupo = "SELECT id_grupo FROM grupo WHERE nombre_grupo = '$nombre_grupo'";
            $res_grupo = mysqli_query($conexion, $sql_grupo);

            if ($res_grupo && mysqli_num_rows($res_grupo) > 0)
            {
                $row_grupo = mysqli_fetch_assoc($res_grupo);
                $id_grupo = $row_grupo['id_grupo'];
            }
        }

        // Sanitización de entradas del formulario
        $titulo = mysqli_real_escape_string($conexion, $_POST['subir-nombre']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['subir-descripcion']);
        $fecha = date('dd/mm/aaaa');
        $hora = date('hh:mm');
        $modulo = (int)$_POST['subir-modulo'];
        $rendimiento = (int)$_POST['subir-rendimiento'];

        
        if ($id_grupo !== null)
        {
            $sql_form = "INSERT INTO formulario (id_grupo, titulo, descripcion, fecha, hora, modulo, rendimiento_esperado) VALUES ($id_grupo, '$titulo', '$descripcion', '$fecha', '$hora', $modulo, $rendimiento)";
        }
        else
        {
            $sql_form = "INSERT INTO formulario (titulo, descripcion, fecha, hora, modulo, rendimiento_esperado) VALUES ('$titulo', '$descripcion', '$fecha', '$hora', $modulo, $rendimiento)";
        }

        if (mysqli_query($conexion, $sql_form))
        {
            $id_formulario = mysqli_insert_id($conexion);

            if ($id_grupo !== null)
            {
                $sql_alumnos = "SELECT id_alumno FROM alumno WHERE id_grupo = $id_grupo";
                $res_alumnos = mysqli_query($conexion, $sql_alumnos);

                if ($res_alumnos)
                {
                    while ($alumno = mysqli_fetch_assoc($res_alumnos))
                    {
                        $id_alumno = $alumno['id_alumno'];
                        $sql_asignar = "INSERT INTO formulario_por_alumno (id_formulario, id_alumno, entregado) VALUES ($id_formulario, $id_alumno, 0)";
                        mysqli_query($conexion, $sql_asignar);
                    }
                }
            }

            if (isset($_POST['subir-preguntas']))
            {
                $preguntas = json_decode(trim($_POST['subir-preguntas']), true);

                if (is_array($preguntas))
                {
                    foreach ($preguntas as $pregunta) 
                    {
                        $tipo = 3; // Por defecto abierta
                        if ($pregunta['tipo'] == "opcion-multiple") $tipo = 1;
                        if ($pregunta['tipo'] == "opcion-multiple-multiseleccion") $tipo = 2;

                        $texto_pregunta = mysqli_real_escape_string($conexion, $pregunta['pregunta']);
                        $rend_pregunta = (int)$pregunta['rendimiento_pregunta'];

                        $sql_preg = "INSERT INTO pregunta (id_formulario, id_tipo_pregunta, pregunta, puntaje_rendimiento) VALUES ($id_formulario, $tipo, '$texto_pregunta', $rend_pregunta)";
                        mysqli_query($conexion, $sql_preg);
                        $id_pregunta = mysqli_insert_id($conexion);

                        for ($i = 1; $i <= 4; $i++)
                        {
                            if (!empty($pregunta["respuesta_$i"]))
                            {
                                $opcion = mysqli_real_escape_string($conexion, $pregunta["respuesta_$i"]);
                                $correcta = ($pregunta["respuesta_correcta_$i"] == "correcta") ? 1 : 0;
                                $rend_resp = empty($pregunta["rendimiento_$i"]) ? 0 : (int)$pregunta["rendimiento_$i"];

                                $sql_opc = "INSERT INTO opcion_pregunta (id_pregunta, opcion, correcta, puntaje_opcion) VALUES ($id_pregunta, '$opcion', $correcta, $rend_resp)";
                                mysqli_query($conexion, $sql_opc);
                            }
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página para la consulta de formularios">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Formularios</title>
</head>

<body>
<?php include 'header.php'?>
<main>
    <h1>Formularios</h1>
    <div id="gran-contenedor">
        <div class="modulo"> 
            <details>
                <summary onclick="window.location.href='./crear-formulario.php';" style="background-color: #2A3958; color: whitesmoke; cursor: pointer;">
                    + Agregar formulario
                </summary>
            </details>
        </div>
        <div class="modulo">
                <details>
                    <summary>Módulo 1</summary>
                    <?php
                        $sql = "SELECT * FROM formulario WHERE modulo = 1";
                        $formularios = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            while ($formulario = mysqli_fetch_assoc($formularios))
                            {
                                $sql_grupo = "SELECT nombre_grupo FROM grupo WHERE id_grupo = ".$formulario['id_grupo'];
                                $res_grupo = mysqli_query($conexion, $sql_grupo);
                                $datos = mysqli_fetch_assoc($res_grupo);
                                echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='grupo'> Grupo: ".$datos['nombre_grupo']."</p>";
                                echo "</div>";
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
                                                    echo "<button class='ver-mas' type='submit'>Ver formulario</button>";
                                                echo "</form>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                            }
                        ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 2</summary>
                    <?php
                        $sql = "SELECT * FROM formulario WHERE modulo = 2";
                        $formularios = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            while ($formulario = mysqli_fetch_assoc($formularios))
                            {
                                $sql_grupo = "SELECT nombre_grupo FROM grupo WHERE id_grupo = ".$formulario['id_grupo'];
                                $res_grupo = mysqli_query($conexion, $sql_grupo);
                                $datos = mysqli_fetch_assoc($res_grupo);
                                echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='grupo'> Grupo: ".$datos['nombre_grupo']."</p>";
                                echo "</div>";
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
                                                    echo "<button class='ver-mas' type='submit'>Ver formulario</button>";
                                                echo "</form>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                            }
                        ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 3</summary>
                    <?php
                        $$sql = "SELECT * FROM formulario WHERE modulo = 3";
                        $formularios = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            while ($formulario = mysqli_fetch_assoc($formularios))
                            {
                                $sql_grupo = "SELECT nombre_grupo FROM grupo WHERE id_grupo = ".$formulario['id_grupo'];
                                $res_grupo = mysqli_query($conexion, $sql_grupo);
                                $datos = mysqli_fetch_assoc($res_grupo);
                                echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='grupo'> Grupo: ".$datos['nombre_grupo']."</p>";
                                echo "</div>";
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
                                                    echo "<button class='ver-mas' type='submit'>Ver formulario</button>";
                                                echo "</form>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                            }
                        ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 4</summary>
                    <?php
                        $sql = "SELECT * FROM formulario WHERE modulo = 4";
                        $formularios = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            while ($formulario = mysqli_fetch_assoc($formularios))
                            {
                                $sql_grupo = "SELECT nombre_grupo FROM grupo WHERE id_grupo = ".$formulario['id_grupo'];
                                $res_grupo = mysqli_query($conexion, $sql_grupo);
                                $datos = mysqli_fetch_assoc($res_grupo);
                                echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='grupo'> Grupo: ".$datos['nombre_grupo']."</p>";
                                echo "</div>";
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
                                                    echo "<button class='ver-mas' type='submit'>Ver formulario</button>";
                                                echo "</form>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                            }
                        ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 5</summary>
                    <?php
                        $sql = "SELECT * FROM formulario WHERE modulo = 5";
                        $formularios = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($formularios) == 0) 
                        {
                            echo "<div class='formulario'>";
                                echo "<p class='titulo-formulario'> No hay formularios de este módulo </p>";
                            echo "</div>";
                        }
                        else
                        {
                            while ($formulario = mysqli_fetch_assoc($formularios))
                            {
                                $sql_grupo = "SELECT nombre_grupo FROM grupo WHERE id_grupo = ".$formulario['id_grupo'];
                                $res_grupo = mysqli_query($conexion, $sql_grupo);
                                $datos = mysqli_fetch_assoc($res_grupo);
                                echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='grupo'> Grupo: ".$datos['nombre_grupo']."</p>";
                                echo "</div>";
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
                                                    echo "<button class='ver-mas' type='submit'>Ver formulario</button>";
                                                echo "</form>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                            }
                        ?>
                </details>
            </div>

        </div>
    </div>
</main>
</body>
<footer>
    <?php include 'footer.php'?>
</footer>
</html>