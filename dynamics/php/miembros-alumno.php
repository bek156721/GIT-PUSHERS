<?php
    session_start();

    include 'conexion.php';
    
    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
        exit();
    }
    

    $sql = "SELECT id_grupo FROM alumno WHERE id_alumno = " . $_SESSION['id_alumno'];
    $res = mysqli_query($conexion, $sql);
    $fila_grupo = mysqli_fetch_assoc($res);

    $id_grupo = $fila_grupo['id_grupo'];

    $query_grupo = "SELECT nombre_grupo FROM grupo WHERE id_grupo = $id_grupo";
    $res_nombre_grupo = mysqli_query($conexion, $query_grupo);
    $fila_nombre_grupo = mysqli_fetch_assoc($res_nombre_grupo);

    $nombre_grupo = $fila_nombre_grupo['nombre_grupo'];

    $query_nombres = "SELECT nombre_alumno, primer_apellido_alumno, segundo_apellido_alumno FROM alumno WHERE id_grupo = $id_grupo";
    $res_nombres = mysqli_query ($conexion,$query_nombres);
    
    /*while($nombres = mysqli_fetch_assoc($res_nombres))
    {
        echo $nombres['nombre_alumno'] . " " . $nombres['primer_apellido_alumno'] . " " . $nombres['segundo_apellido_alumno'] . "<br>";
    }*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/miembros-alumno.css"> 
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h2> Mis compañeros </h2>
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
    </div>  
        <?php 

            echo "<h3> Grupo:" . $nombre_grupo . "</h3>";
            while($nombres = mysqli_fetch_assoc($res_nombres))
            {
                echo "<p class='miembros'>" . $nombres['nombre_alumno'] . " " . $nombres['primer_apellido_alumno'] . " " . $nombres['segundo_apellido_alumno'] . "</p>";
            }
        ?>
    </main>
</body>
    <?php include'footer.php';?>    
</html>