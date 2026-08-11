<?php
include 'conexion.php';
session_start();
if ($_SESSION['rol'] != "profesor")
    {
        header("Location: inicio-sesion.php");
    }

$id_profesor_usuario = $_SESSION['id_profesor'];

//var_dump($id_profesor_usuario);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear'])) 
{
    $id_grupo    = $_POST['id_grupo'];
    $titulo      = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $modulo      = $_POST['modulo'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];

    if ($modulo < 1 || $modulo > 5) 
    {
        die("Error: el módulo debe estar entre 1 y 5");
    }
    $sql_alumnos = "SELECT id_alumno FROM alumno WHERE id_grupo = '$id_grupo'";
    $res_alumnos = mysqli_query($conexion, $sql_alumnos);

    while ($fila = mysqli_fetch_assoc($res_alumnos)) 
    {
        $id_alumno = $fila['id_alumno'];
        $sql_insert = "INSERT INTO actividad (titulo, descripcion, modulo, fecha, hora, entregado)
                    VALUES ('$titulo', '$descripcion', '$modulo', '$fecha', '$hora', 0)";
        mysqli_query($conexion, $sql_insert);
    }

    var_dump ($sql_insert);
    var_dump ($hora);

}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar']))
{
    // Traer todos los id_actividad del grupo para actualizar
    $sql_all = "SELECT id_actividad FROM actividad";
    $res_all = mysqli_query($conexion, $sql_all);

    while ($fila = mysqli_fetch_assoc($res_all))
    {
        $id_actividad = $fila['id_actividad'];
        // Si el checkbox está marcado, vale 1; si no, 0
        $estado = (isset($_POST['estado'][$id_actividad])) ? 1 : 0;

        $sql_update = "UPDATE actividad SET entregado = '$estado' WHERE id_actividad = '$id_actividad'";
        mysqli_query($conexion, $sql_update);
    }

    echo "<p style='color:blue;'>Estados actualizados correctamente</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Página para consultar actividades generales de los estudiantes">
        <title>Estadisticas</title>
        <link rel="stylesheet" href="./../../statics/css/graficas.css">

    </head>
    <body>
        <header> 
            <?php ?>
        </header>
        
        <nav>
            <?php ?>
        </nav>      
        <main class="contenido-principal">
            
            <h1>Actividades</h1>
            <div id="sesion">
                <a href="index.php"><img src="https://static.vecteezy.com/system/resources/previews/022/457/896/original/door-icon-adobe-x1-free-vector.jpg" alt=""></a>
                <a href=""><img src="https://wallpapers.com/images/hd/blank-white-landscape-7sn5o1woonmklx1h.jpg" alt=""></a>
            </div>
            <br>
            <br>
            <br>
            <figure>
                <!--Gráfica de ejemplo, se agregaran según la base de datos-->
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXSAJWC0ds2FLkOksXks8QSNdi8NLjsMq7Ew&s" alt="Gráfica de actividades" class="graficas">
                <ul class="descripcion-graficas">
                    <li>Descripción 1</li>
                    <li>Descripción 2</li>
                    <li>Descripción 3</li>
                </ul>
            </figure>
            <br>
            <br>
            <br>
            <br>

            <details id="cont-agregar">
                <summary>+ Crear nueva actividad</summary>
                <form action="actividades-profesor.php" method="POST">
                    <label for="id_grupo">Grupo:</label>
                    <select name="id_grupo" id="id_grupo" required>
                        <?php
                        $sql_grupos = "SELECT id_grupo, nombre_grupo FROM grupo WHERE id_profesor = $id_profesor_usuario";
                        $res_grupos = mysqli_query($conexion, $sql_grupos);
                        while ($fila = mysqli_fetch_assoc($res_grupos)) 
                        {
                            echo "<option value='".$fila['id_grupo']."'>".$fila['nombre_grupo']."</option>";
                        }
                        ?>
                    </select><br><br>

                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" required><br><br>

                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" required></textarea><br><br>

                    <label for="modulo">Módulo (1-5):</label>
                    <input type="number" name="modulo" id="modulo" min="1" max="5" required><br><br>

                    <label for="fecha">Fecha (YYYYMMDD):</label>
                    <input type="text" name="fecha" id="fecha" required><br><br>

                    <label for="hora">Hora (HH:MM):</label>
                    <input type="text" name="hora" id="hora"><br><br>

                    <button type="submit" name="crear">Guardar actividad</button>
                </form>
            </details>
            <details id="cont-agregar">
                <summary>+ Revisar entregas</summary>
                <form method="POST" action="actividades-profesor.php">
                    <?php
                    $sql_grupos = "SELECT id_grupo, nombre_grupo FROM grupo WHERE id_profesor = $id_profesor_usuario";
                    $res_grupos = mysqli_query($conexion, $sql_grupos);

                    while ($grupo = mysqli_fetch_assoc($res_grupos))
                    {
                        echo "<h2>Grupo: ".$grupo['nombre_grupo']."</h2>";

                        // Traer actividades distintas del grupo
                        $sql_actividades = "SELECT DISTINCT titulo, descripcion 
                                            FROM actividad a
                                            JOIN alumno al ON a.id_alumno = al.id_alumno
                                            WHERE al.id_grupo = ".$grupo['id_grupo']."
                                            ORDER BY titulo";
                        $res_actividades = mysqli_query($conexion, $sql_actividades);

                        while ($actividad = mysqli_fetch_assoc($res_actividades))
                        {
                            echo "<h3>Actividad: ".$actividad['titulo']." (".$actividad['descripcion'].")</h3>";

                            // Traer alumnos de esa actividad
                            $sql_alumnos_act = "SELECT a.id_actividad, al.nombre_alumno, a.entregado
                                                FROM actividad a
                                                JOIN alumno al ON a.id_alumno = al.id_alumno
                                                WHERE al.id_grupo = ".$grupo['id_grupo']."
                                                AND a.titulo = '".$actividad['titulo']."'
                                                ORDER BY al.nombre_alumno";
                            $res_alumnos_act = mysqli_query($conexion, $sql_alumnos_act);

                            echo "<table class='tabla-entregas'>";
                            echo "<tr><th>Alumno</th><th>Entregado</th></tr>";

                            while ($fila = mysqli_fetch_assoc($res_alumnos_act))
                            {
                                echo "<tr>";
                                echo "<td>".$fila['nombre_alumno']."</td>";
                                echo "<td>
                                        <input type='checkbox' name='estado[".$fila['id_actividad']."]' value='1' ".($fila['entregado'] ? "checked" : "").">
                                    </td>";
                                echo "</tr>";
                            }
                            echo "</table><br>";
                        }
                    }
                    ?>
                    <button type="submit" name="actualizar">Actualizar entregas</button>
                </form>
            </details>
        </main>

        <footer>
        </footer>
    </body>
</html>