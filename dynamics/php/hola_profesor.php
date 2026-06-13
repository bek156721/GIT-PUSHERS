<?php
    session_start();

    if ($_SESSION['rol'] != "profesor")
    {
        header("Location: inicio-sesion.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOLA</title>
</head>
<body>
    <h1>Hola Profesor<?php echo $_SESSION['nombre_profesor'] ?><h1>
    <form action="cerrar-sesion.php" method="POST">
        <button type="submit">Cerrar sesión</button>
    </form>
    <form action = "perfil-profesor.php" method = "POST">
        <button class = "boton" type="submit" class="boton">Perfil</button>
    </form>
</body>

</html>