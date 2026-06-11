<?php
    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina de inicio de sec ETE">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-inicio.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Pagina de inicio</title>

</head>

    
<body>
    <?php include 'header.php'; ?>
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
    <h1>Inicio</h1>
    <!-- Carrusel de imagenes -->
    <div id="imagen">
        <img src="../../statics/media/img/ete.jpg" alt="Imagen de ETE" width="400px">
    </div>
    <div class="contenedor-grande" id="menu">
        <h2>Menu</h2>
        <div id="botones">
            <a class="boton-menu" id="boton-miembros" href="./miembros.php">Miembros</a>
            <a class="boton-menu" id="boton-materiales" href="./vista-materiales.php">Materiales</a>
            <a class="boton-menu" id="boton-cuestionarios" href="./formularios.php">Formularios</a>
            <a class="boton-menu" id="boton-actividades" href="./actividades.php">Actividades</a>
            <a class="boton-menu" id="boton-estadisticas" href="./estadisticas.php">Estadisticas</a>
        </div>
    </div>
    <div class="contenedor-grande" id="novedades">
        <h3>Novedades</h3>
        <div class="anuncio">
            <!-- Hacer un while (fecha de publicación es menor a 15 dias) -->
            <div id="arriba">
                <p id="fecha-publicacion">Fecha de publicación: 2026-05-24</p>
            </div>
            <p id="titulo-novedad">Nuevo cuestionario</p><!-- titulo de la novedad -->
            <!-- Pasar por post el id de la actividad -->
            <div id="abajo">
                <a id="ver-mas" href="../../dynamics/php/actividades-actividad.php">Ver más</a>
            </div>
        </div>
    </div>
</body>
    <?php include'footer.php';?>

</html>