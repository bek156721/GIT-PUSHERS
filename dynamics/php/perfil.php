<?php
    if(isset($_FILES["foto-perfil"]))
    {
        $archivo = $_FILES["foto-perfil"];
        $ruta_temporal = $archivo["tmp_name"];

        move_uploaded_file($ruta_temporal, "../../statics/media/img/foto-perfil.jpg");
    }
    $ruta_imagen = "../../statics/media/img/foto-default.png";
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

        <nav class = "menu">
            <button class = "boton-menu"> MIEMBROS </button>
            <br>
            <button class = "boton-menu"> MATERIALES </button>
            <br>
            <button class = "boton-menu"> ESTADÍSTICAS GRUPALES </button>
            <br>
            <button class = "boton-menu"> ALUMNOS INSCRITOS </button>
        </nav>

        <main class = "contenido-principal">
            <h1>Perfil</h1>
            <p> NOMBRE: <?php echo $nombre ?></p>
            <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta ?></p>
            <p> CORREO: <?php echo $correo ?></p>
            <div>
                <img src = "<?php echo $ruta_imagen; ?>" class = "foto-perfil">
            </div>
            <form action = "editar-perfil.php" method = "POST">
                <button class = "boton" type="submit" class="boton">Editar perfil</button>
            </form>
    </main>
    </body>
</html>
