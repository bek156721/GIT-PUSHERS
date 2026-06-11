<?php
    session_start();
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

    if(!isset($_SESSION["numero_cuenta_profesor"]))
        $_SESSION["numero_cuenta_profesor"] = "30123456789";

    $buscar_cuenta_profesor = $_SESSION["numero_cuenta_profesor"];

    $nombre_profesor = "No encontrado";
    $primer_apellido_profesor = "No encontrado";
    $segundo_apellido_profesor = "No encontrado";
    $correo_profesor = "No encontrado";
    $numero_cuenta_profesor = "$buscar_cuenta_profesor";

    $ruta_imagen_profesor = "../../uploads/fotos-perfil/foto-default.png";
    if(isset($_FILES["foto-perfil"]))
        {
            $archivo = $_FILES["foto-perfil"];
            $ruta_temporal_profesor = $archivo["tmp_name"];

            $ruta_destino_profesor = "../../uploads/fotos-perfil/foto-perfil" . $buscar_cuenta_profesor . ".jpg";

            if(move_uploaded_file($ruta_temporal_profesor, $ruta_destino_profesor))
            {
                $querry_foto = "UPDATE profesor SET imagen_profesor = '$ruta_destino_profesor' WHERE id_profesor = '$buscar_cuenta_profesor'";
            }
        }
    
    if($con)
    {
        $query = "SELECT id_profesor, nombre_profesor, primer_apellido_profesor, segundo_apellido_profesor, correo_profesor, imagen_profesor FROM profesor WHERE id_profesor = '$buscar_cuenta_profesor'";
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
        <title>Perfil</title>
        <meta name = "author" content ="Git Pushers">
        <meta name = "description" content = "Información acerca de tu perfil">
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

        <main class = "contenido_principal">
            <!-- Agrupa los textos para que se queden hacia abajo y la imagen a la derecha -->
            <div class = "bloqueo_datos">
                <h1>Perfil</h1>
                <p> TIPO DE USUARIO: Profesor </p>
                <p> NOMBRE: <?php echo $nombre_profesor ?></p>
                <p> PRIMER APELLIDO: <?php echo $primer_apellido_profesor ?></p>
                <p> SEGUNDO APELLIDO: <?php echo $segundo_apellido_profesor ?></p>
                <p> NÚMERO DE CUENTA: <?php echo $numero_cuenta_profesor ?></p>
                <p> CORREO: <?php echo $correo_profesor ?></p>
                <form action = "editar-perfil-profesor.php" method = "POST">
                    <button class = "boton" type="submit" class="boton">Editar perfil</button>
                </form>
            </div>
                <img src = "<?php echo $ruta_destino_profesor; ?>" class = "foto_perfil">
        </main>
    </body>
</html>
