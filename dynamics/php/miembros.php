<?php
    session_start();

    if ($_SESSION['rol'] != "profesor")
    {
        header("Location: inicio-sesion.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina para la consulta de formularios">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/miembros.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Miembros</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Añadir un nuevo miembro<h2>
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

        <p id= "instruccion" >Para añadir a un nuevo miembro, seleccione el tipo de usuario que desea añadir:<p><br>
            <div id = "seleccionar">
                <form action="./anadir-alumno.php" method="POST">
                    <button id="boton-alumno" type="submit">Alumno</button> 
                        <p class="anadir">Añadir nuevo alumno<p><br>
                </form>
                <form action="./anadir-profesor.php" method="POST">
                    <button id="boton-profesor" type="submit">Profesor</button> 
                        <p class="anadir">Añadir nuevo profesor<p><br>
                </form>
            </div>
    </main> 
    <footer>   
        <?php include 'footer.php'; ?>
    <footer>
</body>
</html>