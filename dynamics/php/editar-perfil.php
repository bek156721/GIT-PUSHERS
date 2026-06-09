<?php
    if(isset($_FILES["foto-perfil"]))
    {
        $archivo = $_FILES["foto-perfil"];
        $ruta_temporal = $archivo["tmp_name"];

        move_uploaded_file($ruta_temporal, "../../statics/media/img/foto-perfil.jpg");
    }
    $ruta_imagen = "./../statics/media/img/foto-default.png";
    if(file_exists("../../statics/media/img/foto-perfil.jpg"))
    {
        $ruta_imagen = "../../statics/media/img/foto-perfil.jpg";
    }
    else
    {
        $ruta_imagen = "../../statics/media/img/foto-default.png";
    }
    
    $nombre = "Usuario de prueba";
    $correo = "correo@actual.com";
    $numero_cuenta = "123456789";

    

    function es_password_es_segura($pass)
    {
        if(strlen($pass) < 6)
            return false;
        $tiene_mayus = false;
        $tiene_num = false;

        for($i = 0; $i < strlen($pass); $i++)
        {
            if(ctype_upper($pass[$i]))
                $tiene_mayus = true;
            if(ctype_digit($pass[$i]))
                $tiene_num = true;
        }
        return ($tiene_mayus && $tiene_num);
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edición de perfil</title>
        <meta name = "author" content ="Git Pushers">
        <meta name = "description" content = "Edición de correo y foto de perfil">
        <link rel="stylesheet" href="../../statics/css/perfil.css">
    </head>
    <body>

        <nav class = "menu">
            <button class = "boton-menu"> MIEMBROS </button>
            <br>
            <button class = "boton-menu"> MATERIALES </button>
            <br>
            <button class = "boton-menu"> ESTADÍSTICAS GRUPALES </button>
            <br>
            <button class = "boton-menu"> ALUMNOS INSCRITOS </button>
        </nav>

        <h1 class = "encabezado"> Sec ETE </h1>

        <main class = "contenido-principal">
            <h1>Edición de perfil</h1>
            <p> NOMBRE: <?php echo $nombre ?></p>
            <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta ?></p>
            <p> CORREO: <?php echo $correo ?></p>

            <details class="boton-edicion-datos">
            <summary>Cambiar contraseña</summary>
                <section class="desplegable">
                <form action="editar-perfil.php" method="POST" enctype = "multipart/form-data">
                <input type="hidden" name="accion" value="contrasenia">
                    <ul>
                        <li><label for="contrasenia-actual"> Ingresa tu contraseña actual:</label></li>
                        <input type="password" name="contrasenia-actual" id="contrasenia-actual" placeholder="contraseña actual"  method = "POST" required>
                        <br>
                        <li><label for="nueva-contrasenia"> Ingresa tu nueva contraseña:</label></li>
                        <input type="password" name="nueva-contrasenia" id="nueva-contrasenia" placeholder="nueva contraseña"  method = "POST" required>
                        <br>
                        <li><label for="validacion-nueva-contrasenia">Repite tu nueva contraseña:</label></li>
                        <input type="password" name="validacion-nueva-contrasenia" id="validacion-nueva-contrasenia" placeholder="nueva contraseña"  method = "POST" required>
                    </ul>
                </form>
                </section>
                <button type="submit" class="boton">Cambiar contraseña</button>
            </details>

            <br>
            <details class="boton-edicion-datos">
            <summary>Cambiar foto de perfil</summary>
                <section class="desplegable">
                <form action="editar-perfil.php" method="POST" enctype = "multipart/form-data">
                    <input type="file" name="foto-perfil" id="foto-perfil" accept="image/png, image/jpeg">
                    <button type="submit" class="boton">Cambiar foto de perfil</button>
                </form>
                </section>
            </details>
            <br>
            <img src = "<?php echo $ruta_imagen; ?>" class = "foto-perfil">
        </main>
    </body>
</html>
    