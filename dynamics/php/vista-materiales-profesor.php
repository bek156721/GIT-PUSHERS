<?php
include 'conexion.php';
session_start();

$id_profesor_usuario = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['eliminar'])) 
    {
        $id_material = $_POST['id_material'];
        $sql_delete = "DELETE FROM material WHERE id_material = '$id_material'";
        mysqli_query($conexion, $sql_delete);
    } else 
    {
        $id_grupo   = $_POST['id_grupo'];
        $titulo     = $_POST['titulo'];
        $descripcion= $_POST['descripcion'];
        $fecha      = $_POST['fecha'];
        $hora       = $_POST['hora'];
        $modulo     = $_POST['modulo'];
        $url        = $_POST['url'];

        if ($modulo < 1 || $modulo > 5) {
            die("Error: el módulo debe estar entre 1 y 5");
        }

        $sql_insert = "INSERT INTO material (id_grupo, titulo, descripcion, fecha, hora, modulo, url) 
                    VALUES ('$id_grupo', '$titulo', '$descripcion', '$fecha', '$hora', '$modulo', '$url')";
        mysqli_query($conexion, $sql_insert);
    }
}

$sql_profesor = "SELECT id_grupo, id_profesor, nombre_grupo FROM grupo WHERE id_profesor = $id_profesor_usuario";
$profesor = mysqli_query($conexion, $sql_profesor);
$datos ;
$incremento2 = 0;
while ($fila_prof = mysqli_fetch_assoc($profesor)) 
{
    $datos[$incremento2][0] = $fila_prof['id_grupo'];
    $datos[$incremento2][1] = $fila_prof['nombre_grupo'];
    $incremento2 ++;
}

$ids = [];
for ($i=0;$i<$incremento2;$i++) 
{
    $ids[] = $datos[$i][0];
}
$grupos_profesor = implode(',', $ids);

$sql = "SELECT id_material, titulo, descripcion, fecha, modulo, id_grupo, url FROM material WHERE id_grupo IN ($grupos_profesor)";
$resultado = mysqli_query($conexion, $sql);
$materiales ;
$incremento = 0;
while ($fila = mysqli_fetch_assoc($resultado)) 
{
    $materiales[$incremento][0] = $fila['modulo'];
    $materiales[$incremento][1] = $fila['titulo'];
    $materiales[$incremento][2] = $fila['descripcion'];
    $materiales[$incremento][3] = $fila['fecha'];
    $materiales[$incremento][4] = $fila['url'];
    $materiales[$incremento][5] = $fila['id_grupo'];
    $materiales[$incremento][5] = $fila['id_material'];
    $incremento++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../statics/css/vista-materiales.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Materiales</title>
</head>
<body>
    <div id="cont-ventana">
        <input type="checkbox" id="menu-toggle" class="menu-checkbox">
        <?php include 'header.php'; ?>
        <aside class="menu-lateral">
            <ul>
                <li><a href="#">ACTIVIDADES →</a></li>
                <li><a href="#">FORMULARIO DE EVALUACIÓN →</a></li>
                <li><a href="#">RECURSOS DE APOYO →</a></li>
                <li><a href="#">LOL →</a></li>
                <li><a href="#">PROYECTOS ANTERIORES →</a></li>
            </ul>
        </aside>
        <section id="cont-principal">
            <div id="cont-circul">
                <aside id="perfil">

                </aside>
                <aside>
                    <form action="cerrar-sesion.php" method="POST">
                        <button id="cerrar-sesion" type="submit"></button>
                    </form>
                </aside>
            </div>
            <h2> MATERIALES </h2>
            <aside id="cont-materiales">
                <?php
                    if ($resultado) 
                    {
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 1</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 1)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                for ($i2=0;$i2<$incremento2;$i2++) 
                                {
                                    if($materiales[$i][5] == $datos[$i2][0] ) 
                                    {
                                        echo "<p> GRUPO:".$datos[$i2][1]."</p>";
                                    }
                                }
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo "<form action='vista-materiales-profesor.php' method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='id_material' value='".$materiales[$i]['5']."'>";
                                echo "<button type='submit' name='eliminar' id='but-eliminar'>Eliminar</button>";
                                echo "</form>";
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 2</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 2)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                for ($i2=0;$i2<$incremento2;$i2++) 
                                {
                                    if($materiales[$i][5] == $datos[$i2][0] ) 
                                    {
                                        echo "<p> GRUPO:".$datos[$i2][1]."</p>";
                                    }
                                }
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 3</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 3)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                for ($i2=0;$i2<$incremento2;$i2++) 
                                {
                                    if($materiales[$i][5] == $datos[$i2][0] ) 
                                    {
                                        echo "<p> GRUPO:".$datos[$i2][1]."</p>";
                                    }
                                }
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 4</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 4)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                for ($i2=0;$i2<$incremento2;$i2++) 
                                {
                                    if($materiales[$i][5] == $datos[$i2][0] ) 
                                    {
                                        echo "<p> GRUPO:".$datos[$i2][1]."</p>";
                                    }
                                }
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 5</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 5)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                for ($i2=0;$i2<$incremento2;$i2++) 
                                {
                                    if($materiales[$i][5] == $datos[$i2][0] ) 
                                    {
                                        echo "<p> GRUPO:".$datos[$i2][1]."</p>";
                                    }
                                }
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                    } 
                ?>
            </aside>
            <details id="cont-agregar">
                <summary>+</summary>          
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

                    <label for="fecha">Fecha (YYYYMMDD):</label>
                    <input type="text" name="fecha" id="fecha" required><br><br>

                    <label for="hora">Hora (HH:MM):</label>
                    <input type="text" name="hora" id="hora"><br><br>

                    <label for="modulo">Módulo (1-5):</label>
                    <input type="number" name="modulo" id="modulo" min="1" max="5" required><br><br>

                    <label for="url">URL del recurso:</label>
                    <input type="text" name="url" id="url"><br><br>

                    <button type="submit">Guardar material</button>
                </form>
            </details>
        </section>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>