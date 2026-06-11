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

    $buscar_cuenta_profesor = $_SESSION["id_profesor"];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contrasenia_actual"]) && isset($_POST["nueva_contrasenia"]) && isset($_POST["validacion_nueva_contrasenia"]))
    {
        $contra_actual = $_POST["contrasenia_actual"];
        $nueva_contra = $_POST["nueva_contrasenia"];
        $val_nueva_contra = $_POST["validacion_nueva_contrasenia"];
        if ($conexion)
        {
            $query_contra = "SELECT contra_profesor FROM profesor WHERE id_profesor = $buscar_cuenta_profesor";
            $res_contra = mysqli_query($con, $query_contra);
            $contra_profesor = mysqli_fetch_assoc($res_contra);

            if($contra_profesor)
            {
                $password_hasheada_bd = $contra_profesor["contra_profesor"];
                if(password_verify($contra_actual, $password_hasheada_bd))
                {
                    if($nueva_contra == $val_nueva_contra)
                    {
                        if(es_password_es_segura($nueva_contra))
                        {
                            $nueva_contra_encriptada = hashea_password($nueva_contra);
                            $query_update = "UPDATE profesor SET contra_profesor = '$nueva_contra_encriptada' WHERE id_profesor = '$buscar_cuenta_profesor'";
                        }
                    }   
                }
            }
        }
    }

    $numero_cuenta_profesor = "$buscar_cuenta_profesor";

    $ruta_destino_profesor = "../../uploads/fotos-perfil/foto-default.png";

    if(isset($_FILES["foto-perfil"]))
    {
        $archivo = $_FILES["foto-perfil"];
        $ruta_temporal_profesor = $archivo["tmp_name"];
        $nombre_archivo =  "foto-perfil-" . $buscar_cuenta_alumno . ".jpg";
        $ruta_destino_profesor = "../../uploads/fotos-perfil/" . $nombre_archivo;

        if(move_uploaded_file($ruta_temporal_profesor, $ruta_destino_profesor))
        {
            $querry_foto = "UPDATE profesor SET imagen_profesor = '$ruta_destino_profesor' WHERE id_profesor = $buscar_cuenta_profesor";
            mysqli_query($conexion, $querry_foto);
        }
    }

        if($conexion)
    {
        $query = "SELECT id_profesor, nombre_profesor, primer_apellido_profesor, segundo_apellido_profesor, correo_profesor, imagen_profesor FROM profesor WHERE id_profesor = $buscar_cuenta_profesor";
        $resultado_profesor  = mysqli_query($con, $query);
        $datos_profesor = mysqli_fetch_assoc($resultado_profesor);
        if($datos_profesor)
        {
            $numero_cuenta_profesor = $datos_profesor["id_profesor"];
            $nombre_profesor = $datos_profesor["nombre_profesor"];
            $primer_apellido_profesor = $datos_profesor["primer_apellido_profesor"];
            $segundo_apellido_profesor = $datos_profesor["segundo_apellido_profesor"];
            $correo_profesor = $datos_profesor["correo_profesor"];
            if($datos_profesor["imagen_profesor"] && file_exists($datos_profesor["imagen_profesor"]))
            {
                $ruta_destino_profesor = $datos_profesor["imagen_profesor"];
            }
            else 
            {
                $ruta_destino_profesor = "../../uploads/fotos-perfil/foto-default.png";
            }
        }
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
        <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
        <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    </head>
    <body>
        <?php include 'header.php'; ?> 
        <main class = "contenido_principal">
        <!-- Agrupa los textos para que se queden hacia abajo y la imagen a la derecha -->
        <div class = "bloqueo_datos">
            <h1>Edición de perfil</h1>
            <p> TIPO DE USUARIO: Profesor </p>
            <p> NOMBRE: <?php echo $nombre_profesor ?></p>
            <p> PRIMER APELLIDO: <?php echo $primer_apellido_profesor ?></p>
            <p> SEGUNDO APELLIDO: <?php echo $segundo_apellido_profesor ?></p>
            <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta_profesor ?></p>
            <p> CORREO: <?php echo $correo_profesor ?></p>


            <details class="boton_edicion_datos">
            <summary>Cambiar contraseña</summary>
                <section class="desplegable">
                <form action="editar-perfil-profesor.php" method="POST" enctype = "multipart/form-data">
                <input type="hidden" name="accion" value="contrasenia">
                    <ul>
                        <li><label for="contrasenia_actual"> Ingresa tu contraseña actual:</label></li>
                        <input type="password" name="contrasenia_actual" id="contrasenia_actual" placeholder="contraseña actual"  method = "POST" required>
                        <br>
                        <li><label for="nueva_contrasenia"> Ingresa tu nueva contraseña:</label></li>
                        <input type="password" name="nueva_contrasenia" id="nueva_contrasenia" placeholder="nueva contraseña"  method = "POST" required>
                        <br>
                        <li><label for="validacion_nueva_contrasenia">Repite tu nueva contraseña:</label></li>
                        <input type="password" name="validacion_nueva_contrasenia" id="validacion_nueva_contrasenia" placeholder="nueva contraseña"  method = "POST" required>
                    </ul>
                    <button type="submit" class="boton">Cambiar contraseña</button>
                </form>
                </section>
            </details>

            <br>
            <details class="boton_edicion_datos">
            <summary>Cambiar foto de perfil</summary>
                <section class="desplegable">
                <form action="editar-perfil-profesor.php" method="POST" enctype = "multipart/form-data">
                    <input type="file" name="foto-perfil" id="foto-perfil" accept="image/png, image/jpeg">
                    <button type="submit" class="boton">Cambiar foto de perfil</button>
                </form>
                </section>
            </details>
        </div>
        <br>
        <img src = "<?php echo $ruta_destino_profesor; ?>" class = "foto_perfil">
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>
    