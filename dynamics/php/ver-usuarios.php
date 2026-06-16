
<?php
    include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina para ver a los alumnos">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-ver-usuarios.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Pagina de inicio</title>

</head>

    
<body>
    <?php include 'header.php'; ?>
    <p id = "titulo-pagina" >Ver alumnos</p>
    <table>
        <tr>
            <th>No. Cuenta</th>
            <th>Grupo</th>
            <th>Nombre</th>
            <th>Primer apellido</th>
            <th>Segundo apellido</th>
            <th>Ver datos del alumno</th>
        </tr>
        <?php
            $sql = "SELECT id_alumno, id_grupo, nombre_alumno, primer_apellido_alumno, segundo_apellido_alumno FROM alumno";
            $query = mysqli_query($conexion, $sql);
            while($alumno = mysqli_fetch_assoc($query))
            {
                if($alumno['id_grupo'] == 1)
                    $grupo_alumno = "61B";
                else
                    $grupo_alumno = "61D";
                echo "<tr>";
                    echo "<td>".htmlspecialchars($alumno['id_alumno'])."</td>";
                    echo "<td>".$grupo_alumno."</td>";
                    echo "<td>".htmlspecialchars($alumno['nombre_alumno'])."</td>";
                    echo "<td>".htmlspecialchars($alumno['primer_apellido_alumno'])."</td>";
                    echo "<td>".htmlspecialchars($alumno['segundo_apellido_alumno'])."</td>";
                    echo "<td>";
                        echo "<form action='./ver-usuario.php' id='ver-usuario' method='get'>";
                            echo "<input type='hidden' id='id-alumno' name='id_alumno' value='".$alumno['id_alumno']."'>";
                            echo "<button type='submit'>Ver datos</button>";
                        echo "</form>";
                    echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>



<footer>
    <?php include'footer.php';?>
</footer>


</body>

</html>