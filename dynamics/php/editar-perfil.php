<?php
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edición de perfil</title>
        <meta name = "author" content ="Git Pushers">
        <meta name = "description" content = "Edición de correo y foto de perfil">
        <link rel="stylesheet" href="../../statics/css/editar-perfil.css">
    </head>
    <body>
        <h1>Edición de perfil</h1>
        <p> NOMBRE: $nombre </p>
        <p> NÚMERO DE CUENTA: $numero_cuenta </p>
        <p> CORREO: $correo </p>

        <details class="boton-edicion-datos">
            <summary>Editar correo</summary>
            <section class="desplegable">
                <ul>
                    <li><label for="nuevo-correo"> Nuevo correo electrónico:</label></li>
                    <input type="email" name="nuevo-correo" id="nuevo-correo" placeholder="nuevo@correo.com" required>
                    <br>
                    <li><label for="validacion-nuevo-correo">Repite tu correo:</label></li>
                    <input type="email" name="validacion-nuevo-correo" id="validacion-nuevo-correo" placeholder="nuevo@correo.com" required>
                </ul>
            </section>
        </details>
        <br>
        <details class="boton-edicion-datos">
        <summary>Cambiar contraseña</summary>
            <section class="desplegable">
                <ul>
                    <li><label for="contrasenia-actual"> Ingresa tu contraseña actual:</label></li>
                    <input type="password" name="contrasenia-actual" id="contrasenia-actual" placeholder="contraseña actual" required>
                    <br>
                    <li><label for="nueva-contrasenia"> Ingresa tu nueva contraseña:</label></li>
                    <input type="password" name="nueva-contrasenia" id="nueva-contrasenia" placeholder="nueva contraseña" required>
                    <br>
                    <li><label for="validacion-nueva-contrasenia">Repite tu nueva contraseña:</label></li>
                    <input type="password" name="validacion-nueva-contrasenia" id="validacion-nueva-contrasenia" placeholder="nueva contraseña" required>
                </ul>
            </section>
        </details>
    </body>
</html>
    