<?php
    session_start();
    include 'conexion.php'; 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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

    if (isset($_POST["usuario"]) && isset($_POST["contrasenia"])) //Verificar formulario
    {
        //Guardar
        $usuario = validate($_POST["usuario"]); //Enviar usuario = usuario limpio
        $contrasenia = validate($_POST["contrasenia"]);
    
        //Si usuario y contraseña estan vacios, se redirecciona a la misma página y marca error
        if(empty($usuario))
        {
            header("Location: inicio-sesion.php?error=Usuario requerido");
            exit();
        }elseif(empty($contrasenia))
        {
            header("Location: inicio-sesion.php?error=Contraseña requerida");
            exit();
        }

        //Validar usuario que sea un número:
        if(!filter_var($usuario, FILTER_VALIDATE_INT))
        {
            header("Location: inicio-sesion.php?error=El usuario debe ser numérico");
            exit();
        }

        //Ver si es un alumno

        $sql = "SELECT * FROM alumno WHERE id_alumno = '$usuario' AND contra_alumno = '$contrasenia'";
        $result = mysqli_query($conexion, $sql);
        
        if (mysqli_num_rows($result)=== 1)//verifica que solo exista 1 resultado
        {
            $row = mysqli_fetch_assoc($result);
                $_SESSION['id_alumno'] = $row['id_alumno']; //Guardar datos en servidor
                $_SESSION['nombre_alumno'] = $row['nombre_alumno'];
                $_SESSION['id_grupo'] = $row['id_grupo'];
                $_SESSION['rol']='alumno';
                header("Location: ./pagina-inicio-alumno.php");
                exit();
        }

        // Ver si es Porfesor
        
        $sql = "SELECT * FROM profesor WHERE id_profesor= '$usuario' AND contra_profesor = '$contrasenia'";
        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result)=== 1)//verifica que solo exista 1 resultado
        {
            $row = mysqli_fetch_assoc($result);
                $_SESSION['id_profesor'] = $row['id_profesor']; //Guardar datos en servidor
                $_SESSION['nombre_profesor'] = $row['nombre_profesor'];
                $_SESSION['rol']='profesor';
                header("Location: hola_profesor.php");
                exit();
        }
        // Ver si es Administrador
        
        $sql = "SELECT * FROM administrador WHERE id_administrador = '$usuario' AND contra_administrador = '$contrasenia'";
        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result)=== 1)//verifica que solo exista 1 resultado
        {
            $row = mysqli_fetch_assoc($result);
                $_SESSION['id_administrador'] = $row['id_administrador']; //Guardar datos en servidor
                $_SESSION['nombre_administrador'] = $row['nombre_administrador'];
                $_SESSION['rol']='administrador';
                header("Location: hola_administrador.php");
                exit();
        }else
        {
            header("Location: inicio-sesion.php?error=Usuario o contraseña incorrectos");
            exit();
        }

    }else
    {
        header("Location: inicio-sesion.php");
        exit();
    }
    
?>