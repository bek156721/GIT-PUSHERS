<?php
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil</title>
        <meta name = "author" content ="Git Pushers">
        <meta name = "description" content = "Información acerca de tu perfil">
        <link rel="stylesheet" href="../../statics/css/perfil.css">
    </head>
    <body>
        <h1>Perfil</h1>
        <p> NOMBRE: $nombre </p>
        <p> NÚMERO DE CUENTA: $numero_cuenta </p>
        <p> CORREO: $correo </p>

        <form action = "editar-perfil.php" method = "POST">
            <button class = "boton" type="submit" class="boton-submit">Editar perfil</button>
        </form>
    </body>
</html>
