<?php
    session_start();
    include 'conexion.php'; 

    function validate($data) //Limpiar datos
        {
            $data = trim($data); //Elimina espacios en extremos
            $data = stripslashes($data); // Eliminar barras invertidas
            $data = htmlspecialchars($data); //Convierte carácteres especiales en entidades seguras de html
            $data =str_replace('--','',$data);
            $data =str_replace('/*','',$data);
            $data =str_replace('*/','',$data);
            return $data;
        }
        function password_segura($pass)
        {
            if(strlen($pass) < 6)
            {
                return false;
            }
            $tiene_mayus = false;
            $tiene_num = false;
            for($i = 0; $i < strlen($pass); $i++)
                {
                    if (ctype_upper($pass[$i]))
                        $tiene_mayus = true;
                    if (ctype_digit($pass[$i]))
                        $tiene_num = true;
                }
            return ($tiene_mayus && $tiene_num);
        }
        function password_hasheada($pass)
        {
            $contrasenia = password_hash($pass, PASSWORD_DEFAULT);
            return $contrasenia;
        }

    if (isset($_POST["usuario"]) && isset($_POST["contrasenia"]) && isset($_POST["nombre"]) && isset($_POST["primer-apellido"])) //Verificar formulario
    {
        //Guardar
        $usuario = validate($_POST["usuario"]);
        $contrasenia_plana = validate($_POST["contrasenia"]);
        $correo = validate($_POST["correo"]);
        $nombre = validate($_POST["nombre"]);
        $primer_apellido = validate($_POST["primer-apellido"]);
        $segundo_apellido = validate($_POST["segundo-apellido"]);

        //$nombre_grupo = $_POST["grupo"];
        //$query_grupo = "SELECT id_grupo FROM grupo WHERE nombre_grupo = '$nombre_grupo'";
        //$res_grupo = mysqli_query($conexion, $query_grupo);
        //$grupo_row = mysqli_fetch_assoc($res_grupo);
        //$grupo = $grupo_row['id_grupo'];

        //Si los datos obligatorios estan vacios, se redirecciona a la misma página y marca error

        if(!password_segura($contrasenia_plana))
        {
            header("Location: anadir-profesor.php?error=La contraseña debe tener mayúsculas y números");
            exit();
        }
        if(empty($usuario))
        {
            header("Location: anadir-profesor.php?error=Usuario requerido");
            exit();
        }
        
        if(empty($nombre))
        {
            header("Location: anadir-profesor.php?error=Nombre requerido");
            exit();
        }
        if(empty($primer_apellido))
        {
            header("Location: anadir-profesor.php?error=Primer apellido requerido");
            exit();
        }

        //Validar
        if(!filter_var($usuario, FILTER_VALIDATE_INT))
        {
            header("Location: anadir-profesor.php?error=El usuario debe ser numérico");
            exit();
        }
        if(!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            header("Location: anadir-profesor.php?error=EL correo debe ser válido");
            exit();
        }

        $contrasenia = password_hasheada($contrasenia_plana);
        $query_insertar_profesor = "INSERT INTO profesor (id_profesor, nombre_profesor, primer_apellido_profesor, segundo_apellido_profesor, correo_profesor, contra_profesor ) 
        VALUES ('$usuario', '$nombre', '$primer_apellido', '$segundo_apellido', '$correo', '$contrasenia')";
        if(mysqli_query($conexion, $query_insertar_profesor))
            {
                header("Location: anadir-profesor.php?exito=1");
                exit();
            }
            else
            {
                header("Location: anadir-profesor.php?exito=0");
                exit();
            }
        



    }


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/anadir.css"> 
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Añadir Profesor<br></h2>
        <section id="tarjeta-anadir">
            <h3>Insertar datos de nuevo profesor</h3>
            <form action="anadir-profesor.php" method="POST"> <!--Formulario -->
                <label for="nombre"><br>Nombre del profesor:</label>
                <input id="nombre" name="nombre" type="text" placeholder="Ingresar el nombre del profesor">

                <label for="primer-apellido"><br>Primer apellido del profesor:</label>
                <input id="primer-apellido" name="primer-apellido" type="text" placeholder="Ingresa primer apellido">

                <label for="segundo-apellido"><br>Segundo apellido del profesor:</label>
                <input id="segundo-apellido" name="segundo-apellido" type="text" placeholder="Ingresa segundo apellido">

                <label for="correo"><br>Correo del profesor:</label>
                <input id="correo" name="correo" type="text" placeholder="Correo del profesor">

                <label for="usuario"><br>Usuario del profesor:</label>
                <input id="usuario" name="usuario" type="text" placeholder="Ingresar el número de trabajador del profesor">

                <label for="contraseña"><br>Contraseña<br></label>
                <input id="contrasenia" name="contrasenia" type="password" placeholder="Ingresa la contraseña del profesor">

                <!--<label for="grupo"><br>Grupo:</label>
                <select id="grupo" name="grupo">
                    <?php
                    //$query_buscar_grupos = "SELECT nombre_grupo FROM grupo";
                    //$res_grupos = mysqli_query($conexion, $query_buscar_grupos);

                    //while ($grupo = mysqli_fetch_assoc($res_grupos))
                    //{
                      //  echo '<option value="' . $grupo["nombre_grupo"] . '">' . $grupo["nombre_grupo"] . '</option>';
                    //}
                    ?>
                </select>-->

                <br>
                <input id="boton-anadir" type="submit" value="Añadir">
            </form>
            <?php 
                if(isset($_GET['error']))
                {
                echo $_GET['error'];
                }

                if(isset($_GET['exito']) && $_GET['exito']==1)
                {
                    echo "Añadido con éxito";
                }
                else
                {
                    echo "<br> Error al añadir";
                }
                
            ?>
        </section>

    </main>
    <footer>
        <?php include'footer.php';?>
    </footer>

</body>
</html>