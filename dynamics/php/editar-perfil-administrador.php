<?php
    session_start();
    $_SESSION["numero_cuenta_administrador"] = "20123456789";
    const DBHOST = "127.0.0.1";
    const DBUSER = "root";
    const PASSWORD = "";
    const DB = "sec_ete_db";

    function connect()
    {
        $conexion = mysqli_connect(DBHOST, DBUSER, PASSWORD, DB); 
        //var_dump($conexion);
        return $conexion;
    }
    $con = connect();

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

    if(!isset($_SESSION["numero_cuenta_administrador"]))
        $_SESSION["numero_cuenta_administrador"] = "20123456789";

    $buscar_cuenta_administrador = $_SESSION["numero_cuenta_administrador"];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contrasenia_actual"]) && isset($_POST["nueva_contrasenia"]) && isset($_POST["validacion_nueva_contrasenia"]))
    {
        $contra_actual = $_POST["contrasenia_actual"];
        $nueva_contra = $_POST["nueva_contrasenia"];
        $val_nueva_contra = $_POST["validacion_nueva_contrasenia"];
        if ($con)
        {
            $query_contra = "SELECT contra_administrador FROM administrador WHERE id_administrador = '$buscar_cuenta_administrador'";
            $res_contra = mysqli_query($con, $query_contra);
            $contra_admin= mysqli_fetch_assoc($res_contra);
            //var_dump ($contra_alumno);
            if($contra_admin)
            {
                $password_hasheada_bd = $contra_admin["contra_administrador"];
                
                if(password_verify($contra_actual, $password_hasheada_bd))
                {
                    if($nueva_contra == $val_nueva_contra)
                    {
                        if(es_password_es_segura($nueva_contra))
                        {
                            $nueva_contra_encriptada = hashea_password($nueva_contra);
                            $query_update = "UPDATE administrador SET contra_administrador = '$nueva_contra_encriptada' WHERE id_administrador = '$buscar_cuenta_administrador'";
                            if(!mysqli_query($con, $query_update))
                            {
                                $mensaje_alerta = "Error";
                            }
                            else
                            {
                                echo "CONTRASEÑA CAMBIADA";
                            }
                        }
                    }   
                }
            }
        }
    }

    $nombre_administrador = "No encontrado";
    $primer_apellido_administrador = "No encontrado";
    $segundo_apellido_administrador = "No encontrado";
    $correo_administrador = "No encontrado";
    $numero_cuenta_administrador = "$buscar_cuenta_administrador";

    $ruta_destino_administrador = "../../uploads/fotos-perfil/foto-default.png";

    if(isset($_FILES["foto-perfil"]))
    {
        $archivo = $_FILES["foto-perfil"];
        $ruta_temporal_administrador = $archivo["tmp_name"];
        $ruta_destino_administrador = "../../uploads/fotos-perfil/foto-perfil.png" . $buscar_cuenta_administrador . ".jpg";

        if(move_uploaded_file($ruta_temporal_administrador, $ruta_destino_administrador))
        {
            $querry_foto = "UPDATE administrador SET imagen_administrador = '$ruta_destino_administrador' WHERE id_administrador = '$buscar_cuenta_administrador'";
            mysqli_query($con, $querry_foto);
        }
    }

        if($con)
    {
        $query = "SELECT id_administrador, nombre_administrador, primer_apellido_administrador, segundo_apellido_administrador, correo_administrador, imagen_administrador FROM administrador WHERE id_administrador = '$buscar_cuenta_administrador'";
        $resultado_administrador  = mysqli_query($con, $query);
        $datos_administrador= mysqli_fetch_assoc($resultado_administrador);
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
        <title>Edición de perfil</title>
        <meta name = "author" content ="Git Pushers">
        <meta name = "description" content = "Edición de correo y foto de perfil">
        <link rel="stylesheet" href="../../statics/css/perfil.css">
    </head>
    <body>

            <nav class = "menu">
            <button class = "boton_menu"> MIEMBROS </button>
            <br>
            <button class = "boton_menu"> MATERIALES </button>
            <br>
            <button class = "boton_menu"> ESTADÍSTICAS GRUPALES </button>
            <br>
            <button class = "boton_menu"> ALUMNOS INSCRITOS </button>
        </nav>

        <h1 class = "encabezado"> Sec ETE </h1>
        <main class = "contenido_principal">
        <!-- Agrupa los textos para que se queden hacia abajo y la imagen a la derecha -->
        <div class = "bloqueo_datos">
            <h1>Edición de perfil</h1>
            <p> TIPO DE USUARIO: Administrador </p>
            <p> NOMBRE: <?php echo $nombre_administrador ?></p>
            <p> PRIMER APELLIDO: <?php echo $primer_apellido_administrador ?></p>
            <p> SEGUNDO APELLIDO: <?php echo $segundo_apellido_administrador ?></p>
            <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta_administrador ?></p>
            <p> CORREO: <?php echo $correo_administrador ?></p>


            <details class="boton_edicion_datos">
            <summary>Cambiar contraseña</summary>
                <section class="desplegable">
                <form action="editar-perfil-administrador.php" method="POST">
                <input type="hidden" name="accion" value="contrasenia">
                    <ul>
                        <li><label for="contrasenia_actual"> Ingresa tu contraseña actual:</label></li>
                        <input type="password" name="contrasenia_actual" id="contrasenia_actual" placeholder="contraseña actual"required>
                        <br>
                        <li><label for="nueva_contrasenia"> Ingresa tu nueva contraseña:</label></li>
                        <input type="password" name="nueva_contrasenia" id="nueva_contrasenia" placeholder="nueva contraseña"required>
                        <br>
                        <li><label for="validacion_nueva_contrasenia">Repite tu nueva contraseña:</label></li>
                        <input type="password" name="validacion_nueva_contrasenia" id="validacion_nueva_contrasenia" placeholder="nueva contraseña" required>
                    </ul>
                    <button type="submit" class="boton">Cambiar contraseña</button>
                </form>
                </section>
            </details>

            <br>
            <details class="boton_edicion_datos">
            <summary>Cambiar foto de perfil</summary>
                <section class="desplegable">
                <form action="editar-perfil-administrador.php" method="POST" enctype = "multipart/form-data">
                    <input type="file" name="foto-perfil" id="foto-perfil" accept="image/png, image/jpeg">
                    <button type="submit" class="boton">Cambiar foto de perfil</button>
                </form>
                </section>
            </details>
        </div>
        <br>
        <img src = "<?php echo $ruta_destino_administrador; ?>" class = "foto_perfil">
        </main>
    </body>
</html>
    