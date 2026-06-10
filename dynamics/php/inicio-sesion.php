
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vridiana Castro">
    <link rel="stylesheet" href="/GIT-PUSHERS/statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="/GIT-PUSHERS/statics/css/inicio-sesion.css"> 
    <link rel="stylesheet" href="/GIT-PUSHERS/statics/css/footer.css"> <!-- css de Pie de página -->
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Bienvenid@<br></h2>
        <section id="tarjeta-loging">
            <h3>Iniciar Sesión</h3>
            <img id="icono-perfil" src="/GIT-PUSHERS/statics/media/img/perfil.png" alt="imagen perfil">
            <form action="login.php" method="post"> <!--Formulario -->
                <label for="usuario">Nombre de Usuario:</label>
                <input id="usuario" name="usuario" type="text" placeholder="Ingresa tu número de cuenta">
                <label for="contraseña"><br>Contraseña<br></label>
                <input id="contrasenia" name="contrasenia" type="password" placeholder="Ingresa tu contraseña">
                <p>¿Tienes problemas para iniciar sesión?<br></p>
                <a id="ayuda" href="Equipo_7.php"> Ayuda<br></a>
                <input id="boton_inicio_sesion" type="submit" value="Iniciar Sesión">
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