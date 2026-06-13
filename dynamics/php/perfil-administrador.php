<?php
    session_start();

    include 'conexion.php';
    
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

    function hashea_password($pass)
    {
        $password_hasheada = password_hash($pass, PASSWORD_DEFAULT);
        return $password_hasheada;
    }
    
    $buscar_cuenta_administrador = $_SESSION["id_administrador"];

    $ruta_imagen_administrador = "../../uploads/fotos-perfil/foto-default.png";
    if(isset($_FILES["foto-perfil"]))
        {
            $archivo = $_FILES["foto-perfil"];
            $ruta_temporal_administrador = $archivo["tmp_name"];

            $ruta_destino_administrador = "../../uploads/fotos-perfil/foto-perfil" . $buscar_cuenta_administrador . ".jpg";

            if(move_uploaded_file($ruta_temporal_administrador, $ruta_destino_administrador))
            {
                $querry_foto = "UPDATE administrador SET imagen_administrador = '$ruta_destino_administrador' WHERE id_administrador = $buscar_cuenta_administrador";
            }
        }
    
    if($conexion)
    {
        $query = "SELECT id_administrador, nombre_administrador, primer_apellido_administrador, segundo_apellido_administrador, correo_administrador, imagen_administrador FROM administrador WHERE id_administrador = $buscar_cuenta_administrador";
        $resultado_administrador  = mysqli_query($conexion, $query);
        $datos_administrador = mysqli_fetch_assoc($resultado_administrador);
        if($datos_administrador)
        {
            $numero_cuenta_administrador = $datos_administrador["id_administrador"];
            $nombre_administrador = $datos_administrador["nombre_administrador"];
            $primer_apellido_administrador = $datos_administrador["primer_apellido_administrador"];
            $segundo_apellido_administrador = $datos_administrador["segundo_apellido_administrador"];
            $correo_administrador = $datos_administrador["correo_administrador"];
            if($datos_administrador["imagen_administrador"] && file_exists($datos_administrador["imagen_administrador"]))
            {
                $ruta_destino_administrador = $datos_administrador["imagen_administrador"];
            }
            else 
            {
                $ruta_destino_administrador = "../../uploads/fotos-perfil/foto-default.png";
            }
        }
    }
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
        <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
        <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    </head>
    <body>

        <?php include 'header.php'; ?>  
        <main class = "contenido_principal">
            <!-- Agrupa los textos para que se queden hacia abajo y la imagen a la derecha -->
            <div class = "bloqueo_datos">
                <h1>Perfil</h1>
                <p> TIPO DE USUARIO: Administrador </p>
                <p> NOMBRE: <?php echo $nombre_administrador ?></p>
                <p> PRIMER APELLIDO: <?php echo $primer_apellido_administrador ?></p>
                <p> SEGUNDO APELLIDO: <?php echo $segundo_apellido_administrador ?></p>
                <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta_administrador ?></p>
                <p> CORREO: <?php echo $correo_administrador ?></p>
                <form action = "editar-perfil-administrador.php" method = "POST">
                    <button class = "boton" type="submit" class="boton">Editar perfil</button>
                </form>
            </div>
                <img src = "<?php echo $ruta_destino_administrador; ?>" class = "foto_perfil">
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>
