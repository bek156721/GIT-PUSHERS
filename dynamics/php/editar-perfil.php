<?php
    session_start();
    $_SESSION["numero_cuenta"] = "123456789";
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
    $mensaje_alerta = "";

    function validar_password($pass_login)
    {
        $password_hasheada_bd = "";
        if(password_verify($pass_login, $password_hasheada_bd))
            echo "Bienvenido $nombre";
        else 
            echo "Contraseña incorrecta";
    }

    if(!isset($_SESSION["numero_cuenta"]))
        $_SESSION["numero_cuenta"] = "123456789";

    $buscar_cuenta = $_SESSION["numero_cuenta"];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contrasenia_actual"]) && isset($_POST["nueva_contrasenia"]) && isset($_POST["validacion_nueva_contrasenia"]))
    {
        $contra_actual = $_POST["contrasenia_actual"];
        $nueva_contra = $_POST["nueva_contrasenia"];
        $val_nueva_contra = $_POST["validacion_nueva_contrasenia"];
        if ($con)
        {
            $query_contra = "SELECT contra_alumno FROM alumno WHERE id_alumno = $buscar_cuenta";
            $res_contra = mysqli_query($con, $query_contra);
            $contra_alumno = mysqli_fetch_assoc($res_contra);
            //var_dump ($contra_alumno);
            if($contra_alumno)
            {
                $password_hasheada_bd = $contra_alumno["contra_alumno"];
                if(password_verify($contra_actual, $password_hasheada_bd))
                {
                    if($nueva_contra == $val_nueva_contra)
                    {
                        if(es_password_es_segura($nueva_contra))
                        {
                            $nueva_contra_encriptada = hashea_password($nueva_contra);
                            $query_update = "UPDATE alumno SET contra_alumno = '$nueva_contra_encriptada' WHERE id_alumno = $buscar_cuenta";
                            if(!mysqli_query($con, $query_update))
                            {
                                $mensaje_alerta = "Error";
                            }
                        }
                    }   
                }
            }
        }
    }

    $nombre = "No encontrado";
    $primer_apellido = "No encontrado";
    $segundo_apellido = "No encontrado";
    $correo = "No encontrado";
    $numero_cuenta = "$buscar_cuenta";

    $ruta_destino = "../../uploads/fotos-perfil/foto-default.png";

    if(isset($_FILES["foto-perfil"]))
    {
        $archivo = $_FILES["foto-perfil"];
        $ruta_temporal = $archivo["tmp_name"];
        $ruta_destino = "../../uploads/fotos-perfil/foto-perfil.png" . $buscar_cuenta . ".jpg";

        if(move_uploaded_file($ruta_temporal, $ruta_destino))
        {
            $querry_foto = "UPDATE alumno SET imagen = '$ruta_destino' WHERE id_alumno = $buscar_cuenta";
            mysqli_query($con, $querry_foto);
        }
    }

        if($con)
    {
        $query = "SELECT id_alumno, nombre_alumno, primer_apellido_alumno, segundo_apellido_alumno, correo_alumno, imagen FROM alumno WHERE id_alumno = $buscar_cuenta";
        $resultado  = mysqli_query($con, $query);
        $datos_alumno = mysqli_fetch_assoc($resultado);
        if($datos_alumno)
        {
            $numero_cuenta = $datos_alumno["id_alumno"];
            $nombre = $datos_alumno["nombre_alumno"];
            $primer_apellido = $datos_alumno["primer_apellido_alumno"];
            $segundo_apellido = $datos_alumno["segundo_apellido_alumno"];
            $correo = $datos_alumno["correo_alumno"];
            if($datos_alumno["imagen"] && file_exists($datos_alumno["imagen"]))
            {
                $ruta_destino = $datos_alumno["imagen"];
            }
            else 
            {
                $ruta_destino = "../../uploads/fotos-perfil/foto-default.png";
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
            <p> NOMBRE: <?php echo $nombre ?></p>
            <p> PRIMER APELLIDO: <?php echo $primer_apellido ?></p>
            <p> SEGUNDO APELLIDO: <?php echo $segundo_apellido ?></p>
            <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta ?></p>
            <p> CORREO: <?php echo $correo ?></p>


            <details class="boton_edicion_datos">
            <summary>Cambiar contraseña</summary>
                <section class="desplegable">
                <form action="editar-perfil.php" method="POST" enctype = "multipart/form-data">
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
                <form action="editar-perfil.php" method="POST" enctype = "multipart/form-data">
                    <input type="file" name="foto-perfil" id="foto-perfil" accept="image/png, image/jpeg">
                    <button type="submit" class="boton">Cambiar foto de perfil</button>
                </form>
                </section>
            </details>
        </div>
        <br>
        <img src = "<?php echo $ruta_destino; ?>" class = "foto_perfil">
        </main>
    </body>
</html>
    