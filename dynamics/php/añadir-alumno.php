<?php
    session_start();
    include 'conexion.php'; 


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vridiana Castro">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/añadir.css"> 
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Añadir Alumno<br></h2>
        <section id="tarjeta-añadir">
            <h3>Insertar datos de nuevo alumno</h3>
            <form action="añadir-alumno.php" method="POST"> <!--Formulario -->
                <label for="nombre"><br>Nombre del alumno:</label>
                <input id="nombre" name="nombre" type="text" placeholder="Ingresar el nombre del alumno">

                <label for="primer-apellido"><br>Primer apellido del alumno:</label>
                <input id="primer-apellido" name="primer-apellido" type="text" placeholder="Ingresa primer apellido">

                <label for="segundo-apellido"><br>Segundo apellido del alumno:</label>
                <input id="segundo-apellido" name="segundo-apellido" type="text" placeholder="Ingresa segundo apellido">

                <label for="correo"><br>Correo del alumno:</label>
                <input id="correo" name="correo" type="text" placeholder="Correo del alumno">

                <label for="usuario"><br>Usuario del alumno:</label>
                <input id="usuario" name="usuario" type="text" placeholder="Ingresar el número de cuenta del alumno">

                <label for="contraseña"><br>Contraseña<br></label>
                <input id="contrasenia" name="contrasenia" type="password" placeholder="Ingresa la contraseña del alumno">

                <label for="grupo"><br>Grupo:</label>
                <select id="grupo" name="grupo">
                    <?php
                    $query_buscar_grupos = "SELECT nombre_grupo FROM grupo";
                    $res_grupos = mysqli_query($conexion, $query_buscar_grupos);

                    while ($grupo = mysqli_fetch_assoc($res_grupos))
                    {
                        echo '<option value="' . $grupo["nombre_grupo"] . '">' . $grupo["nombre_grupo"] . '</option>';
                    }
                    ?>
                </select>

                <br>
                <input id="boton-añadir" type="submit" value="Añadir">
            </form>
            <?php 
                if(isset($_GET['error']))
                echo $_GET['error']
            ?>
        </section>

    </main>
    <footer>
        <?php include'footer.php';?>
    </footer>

</body>
</html>