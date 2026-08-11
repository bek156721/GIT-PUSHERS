<?php
include 'conexion.php';
session_start();

if ($_SESSION['rol'] != "profesor")
{
    header("Location: inicio-sesion.php");
    exit();
}

$id_profesor_usuario = $_SESSION['id_profesor'];

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['eliminar'])) 
    {
        $id_material = $_POST['id_material'];
        $sql_delete = "DELETE FROM material WHERE id_material = '$id_material'";
        mysqli_query($conexion, $sql_delete);
    } 
    else 
    {
        $id_grupo   = $_POST['id_grupo'];
        $titulo     = $_POST['titulo'];
        $descripcion= $_POST['descripcion'];
        $fecha      = $_POST['fecha'];
        $hora       = $_POST['hora'];
        $modulo     = $_POST['modulo'];
        $url        = $_POST['url'];

        // Validamos el módulo con un if normal
        if ($modulo >= 1 && $modulo <= 5) 
        {
            $sql_insert = "INSERT INTO material (id_grupo, titulo, descripcion, fecha, hora, modulo, url) 
                        VALUES ('$id_grupo', '$titulo', '$descripcion', '$fecha', '$hora', '$modulo', '$url')";
            mysqli_query($conexion, $sql_insert);
        }
    }
}

$sql_profesor = "SELECT id_grupo, id_profesor, nombre_grupo FROM grupo WHERE id_profesor = $id_profesor_usuario";
$profesor = mysqli_query($conexion, $sql_profesor);
$datos;
$incremento2 = 0;
while ($fila_prof = mysqli_fetch_assoc($profesor)) 
{
    $datos[$incremento2][0] = $fila_prof['id_grupo'];
    $datos[$incremento2][1] = $fila_prof['nombre_grupo'];
    $incremento2 ++;
}

$ids = array();
for ($i=0; $i<$incremento2; $i++) 
{
    $ids[] = $datos[$i][0];
}

if ($incremento2 > 0) 
{
    $grupos_profesor = implode(',', $ids);
} 
else 
{
    $grupos_profesor = "0";
}

$sql = "SELECT id_material, titulo, descripcion, fecha, modulo, id_grupo, url, hora FROM material WHERE id_grupo IN ($grupos_profesor)";
$resultado = mysqli_query($conexion, $sql);
$materiales;
$incremento = 0;
while ($fila = mysqli_fetch_assoc($resultado)) 
{
    $materiales[$incremento][0] = $fila['modulo'];
    $materiales[$incremento][1] = $fila['titulo'];
    $materiales[$incremento][2] = $fila['descripcion'];
    $materiales[$incremento][3] = $fila['fecha'];
    $materiales[$incremento][4] = $fila['url'];
    $materiales[$incremento][5] = $fila['id_grupo'];
    $materiales[$incremento][6] = $fila['id_material'];
    $materiales[$incremento][7] = $fila['hora'];
    $incremento++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Materiales</title>
</head>
<body>
    <main>
        <?php include 'header.php'; ?>

        <div id="cont-circul">
            <aside>
                <form action="perfil-alumno.php" method="POST">
                    <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../uploads/fotos-perfil/foto-default.png" alt="Perfil"></button> 
                </form>
            </aside>
            <aside>
                <form action="cerrar-sesion.php" method="POST">
                    <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../statics/media/img/logout.png" alt="Log Out"></button> 
                </form>
            </aside>
        </div>

        <h1> Materiales </h1>
        <div id="gran-contenedor">
            <!-- MÓDULO 1 -->
            <div class="modulo">
                <details>
                <summary style="background-color: #2A3958; color: whitesmoke;">+ Agregar material</summary>
                <form action="vista-materiales-profesor.php" method="POST">
                    <label for="id_grupo">Grupo:</label>
                    <select name="id_grupo" id="id_grupo" required>
                        <?php
                        for ($i=0; $i<$incremento2; $i++) 
                        {
                            echo "<option value='".$datos[$i][0]."'>".$datos[$i][1]."</option>";
                        }
                        ?>
                    </select><br><br>

                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" required><br><br>

                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" required></textarea><br><br>

                    <label for="fecha">Fecha (dd/mm/aaaa):</label>
                    <input type="text" name="fecha" id="fecha" required><br><br>

                    <label for="hora">Hora (hh:mm):</label>
                    <input type="text" name="hora" id="hora"><br><br>

                    <label for="modulo">Módulo (1-5):</label>
                    <input type="number" name="modulo" id="modulo" min="1" max="5" required><br><br>

                    <label for="url">URL del recurso:</label>
                    <input type="text" name="url" id="url"><br><br>

                    <button type="submit" class = 'ver-mas'>Guardar material</button>
                </form>
            </div>
            <div class="modulo">
                <details>
                    <summary>Módulo 1</summary>
                    <?php
                        $contador_mod1 = 0;
                        for ($i=0; $i<$incremento; $i++) 
                        {
                            if($materiales[$i][0] == 1)
                            {
                                $contador_mod1++;
                                echo "<div class='formulario'>";
                                for ($i2=0; $i2<$incremento2; $i2++) 
                                    {
                                        if($materiales[$i][5] == $datos[$i2][0]) 
                                        {
                                            echo "<div class='arriba'>";
                                                echo "<p class='grupo'> Grupo: ".$datos[$i2][1]."</p>";
                                            echo "</div>";
                                        }
                                    }
                                    echo "<div class='arriba'>";
                                        echo "<p class='fecha-publicacion'>Fecha de publicación: ". $materiales[$i][3] . "</p>"; 
                                    echo "</div>";
                                    echo "<div class='arriba'>"; 
                                        echo "<p class='fecha-publicacion'>Hora de publicación: ". $materiales[$i][7] ." </p>";
                                    echo "</div>";
                                    
                                    echo "<p class='titulo-formulario'>".$materiales[$i][1]."</p>"; // título
                                    echo "<br>";
                                    echo "<p class='descripcion-formulario'>".$materiales[$i][2]."</p>";   // descripción
                                    
                                    echo "<div class='abajo'>";
                                        echo "<a class='ver-mas' href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                    echo '</div>';
                                echo "</div>";
                            }
                        }

                        if ($contador_mod1 == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        }
                ?>
                </details>
            </div>
            <div class="modulo">
                <details>
                        <summary> Módulo 2</summary>
                        <?php
                        $contador_mod2 = 0;
                        for ($i=0; $i<$incremento; $i++) 
                        {
                            if($materiales[$i][0] == 2)
                            {
                                $contador_mod2++;
                                echo "<div class='formulario'>";
                                    for ($i2=0; $i2<$incremento2; $i2++) 
                                    {
                                        if($materiales[$i][5] == $datos[$i2][0]) 
                                        {
                                            echo "<div class='arriba'>";
                                                echo "<p class='grupo'> Grupo: ".$datos[$i2][1]."</p>";
                                            echo "</div>";
                                        }
                                    }
                                    echo "<div class='arriba'>";
                                        echo "<p class='fecha-publicacion'>Fecha de publicación: ". $materiales[$i][3] . "</p>"; 
                                    echo "</div>";
                                    echo "<div class='arriba'>"; 
                                        echo "<p class='fecha-publicacion'>Hora de publicación: ". $materiales[$i][7] ." </p>";
                                    echo "</div>";
                                    echo "<p class='titulo-formulario'>".$materiales[$i][1]."</p>"; // título
                                    echo "<br>";
                                    echo "<p class='descripcion-formulario'>".$materiales[$i][2]."</p>";   // descripción
                                    
                                    echo "<div class='abajo'>";
                                        echo "<a class='ver-mas' href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                    echo '</div>';
                                echo "</div>";
                            }
                        }

                        if ($contador_mod2 == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        }
                ?>
                </details>
            </div>
            <div class="modulo">
                <details>
                        <summary> Módulo 3</summary>
                        <?php
                        $contador_mod3 = 0;
                        for ($i=0; $i<$incremento; $i++) 
                        {
                            if($materiales[$i][0] == 3)
                            {
                                $contador_mod3++;
                                echo "<div class='formulario'>";
                                    for ($i2=0; $i2<$incremento2; $i2++) 
                                    {
                                        if($materiales[$i][5] == $datos[$i2][0]) 
                                        {
                                            echo "<div class='arriba'>";
                                                echo "<p class='grupo'> Grupo: ".$datos[$i2][1]."</p>";
                                            echo "</div>";
                                        }
                                    }
                                    echo "<div class='arriba'>";
                                        echo "<p class='fecha-publicacion'>Fecha de publicación: ". $materiales[$i][3] . "</p>"; 
                                    echo "</div>";
                                    echo "<div class='arriba'>"; 
                                        echo "<p class='fecha-publicacion'>Hora de publicación: ". $materiales[$i][7] ." </p>";
                                    echo "</div>";
                                    echo "<p class='titulo-formulario'>".$materiales[$i][1]."</p>"; // título
                                    echo "<br>";
                                    echo "<p class='descripcion-formulario'>".$materiales[$i][2]."</p>";   // descripción
                                    
                                    echo "<div class='abajo'>";
                                        echo "<a class='ver-mas' href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                    echo '</div>';
                                echo "</div>";
                            }
                        }

                        if ($contador_mod3 == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        }
                ?>
                </details>
            </div>
            <div class="modulo">
                <details>
                        <summary> Módulo 4</summary>
                        <?php
                        $contador_mod4 = 0;
                        for ($i=0; $i<$incremento; $i++) 
                        {
                            if($materiales[$i][0] == 4)
                            {
                                $contador_mod4++;
                                echo "<div class='formulario'>";
                                    for ($i2=0; $i2<$incremento2; $i2++) 
                                    {
                                        if($materiales[$i][5] == $datos[$i2][0]) 
                                        {
                                            echo "<div class='arriba'>";
                                                echo "<p class='grupo'> Grupo: ".$datos[$i2][1]."</p>";
                                            echo "</div>";
                                        }
                                    }
                                    echo "<div class='arriba'>";
                                        echo "<p class='fecha-publicacion'>Fecha de publicación: ". $materiales[$i][3] . "</p>"; 
                                    echo "</div>";
                                    echo "<div class='arriba'>"; 
                                        echo "<p class='fecha-publicacion'>Hora de publicación: ". $materiales[$i][7] ." </p>";
                                    echo "</div>";
                                    echo "<p class='titulo-formulario'>".$materiales[$i][1]."</p>"; // título
                                    echo "<br>";
                                    echo "<p class='descripcion-formulario'>".$materiales[$i][2]."</p>";   // descripción
                                    
                                    echo "<div class='abajo'>";
                                        echo "<a class='ver-mas' href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                    echo '</div>';
                                echo "</div>";
                            }
                        }

                        if ($contador_mod4 == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        }
                ?>
                </details>
            </div>
            <div class="modulo">
                <details>
                        <summary> Módulo 5</summary>
                        <?php
                        $contador_mod5 = 0;
                        for ($i=0; $i<$incremento; $i++) 
                        {
                            if($materiales[$i][0] == 5)
                            {
                                $contador_mod5++;
                                for ($i2=0; $i2<$incremento2; $i2++) 
                                    {
                                        if($materiales[$i][5] == $datos[$i2][0]) 
                                        {
                                            echo "<div class='arriba'>";
                                                echo "<p class='grupo'> Grupo: ".$datos[$i2][1]."</p>";
                                            echo "</div>";
                                        }
                                    }
                                    echo "<div class='arriba'>";
                                        echo "<p class='fecha-publicacion'>Fecha de publicación: ". $materiales[$i][3] . "</p>"; 
                                    echo "</div>";
                                    echo "<div class='arriba'>"; 
                                        echo "<p class='fecha-publicacion'>Hora de publicación: ". $materiales[$i][7] ." </p>";
                                    echo "</div>";
                                    echo "<p class='titulo-formulario'>".$materiales[$i][1]."</p>"; // título
                                    echo "<br>";
                                    echo "<p class='descripcion-formulario'>".$materiales[$i][2]."</p>";   // descripción
                                    
                                    echo "<div class='abajo'>";
                                        echo "<a class='ver-mas' href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                    echo '</div>';
                                echo "</div>";
                            }
                        }

                        if ($contador_mod5 == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        }
                ?>
                </details>
            </div>
            
</div>
</details>
    </div>
    </main> 
<footer> 
    <?php include 'footer.php'; ?> 
</footer>    
</body>
</html>