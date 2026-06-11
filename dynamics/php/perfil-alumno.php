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

    $buscar_cuenta_alumno = $_SESSION["id_alumno"];

    $ruta_imagen_alumno = "../../uploads/fotos-perfil/foto-default.png";
    if(isset($_FILES["foto-perfil"]))
        {
            $archivo = $_FILES["foto-perfil"];
            $ruta_temporal_alumno = $archivo["tmp_name"];

            $ruta_destino_alumno = "../../uploads/fotos-perfil/foto-perfil" . $buscar_cuenta_alumno . ".jpg";

            if(move_uploaded_file($ruta_temporal_alumno, $ruta_destino_alumno))
            {
                $querry_foto = "UPDATE alumno SET imagen_alumno = '$ruta_destino_alumno' WHERE id_alumno = $buscar_cuenta_alumno";
            }
        }
    
    if($conexion)
    {
        $query = "SELECT id_alumno, nombre_alumno, primer_apellido_alumno, segundo_apellido_alumno, correo_alumno, imagen_alumno, id_grupo FROM alumno WHERE id_alumno = $buscar_cuenta_alumno";
        $resultado_alumno  = mysqli_query($conexion, $query);
        $datos_alumno = mysqli_fetch_assoc($resultado_alumno);
        if($datos_alumno)
        {
            $numero_cuenta_alumno = $datos_alumno["id_alumno"];
            $nombre_alumno = $datos_alumno["nombre_alumno"];
            $primer_apellido_alumno = $datos_alumno["primer_apellido_alumno"];
            $segundo_apellido_alumno = $datos_alumno["segundo_apellido_alumno"];
            $correo_alumno = $datos_alumno["correo_alumno"];
            $grupo_alumno = $datos_alumno["id_grupo"];
            if($datos_alumno["imagen_alumno"] && file_exists($datos_alumno["imagen_alumno"]))
            {
                $ruta_destino_alumno = $datos_alumno["imagen_alumno"];
            }
            else 
            {
                $ruta_destino_alumno = "../../uploads/fotos-perfil/foto-default.png";
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
                <p> TIPO DE USUARIO: Alumno </p>
                <p> NOMBRE: <?php echo $nombre_alumno ?></p>
                <p> PRIMER APELLIDO: <?php echo $primer_apellido_alumno ?></p>
                <p> SEGUNDO APELLIDO: <?php echo $segundo_apellido_alumno ?></p>
                <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta_alumno ?></p>
                <p> GRUPO: <?php echo $grupo_alumno ?> </p>
                <p> CORREO: <?php echo $correo_alumno ?></p>
                <form action = "editar-perfil-alumno.php" method = "POST">
                    <button class = "boton" type="submit" class="boton">Editar perfil</button>
                </form>
            </div>
                <img src = "<?php echo $ruta_destino_alumno; ?>" class = "foto_perfil">
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>