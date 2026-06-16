<?php
    session_start();

    if ($_SESSION['rol'] != "alumno")
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
    <h1>Hola <?php echo $_SESSION['nombre_alumno'] ?><h1>
    <form action="cerrar-sesion.php" method="POST">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>