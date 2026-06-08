<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vridiana Castro">
    <link rel="stylesheet" href="/GIT-PUSHERS/statics/css/header.css">
    <link rel="stylesheet" href="/GIT-PUSHERS/statics/css/inicio-sesion.css">
    <link rel="stylesheet" href="/GIT-PUSHERS/statics/css/footer.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class id="contenedor-principal">
        <h2>Bienvenid@<br></h2>
        <section id="tarjeta-loging">
            <h3>Iniciar Sesión</h3>
            <img id="icono-perfil" src="/GIT-PUSHERS/statics/media/img/perfil.png" alt="imagen perfil">
            <form id="login">
                <label for="usuario">Nombre de Usuario:</label>
                <input id="usuario" name="usuario" type="text">
                <label for="contraseña"><br><br>Contraseña<br></label>
                <input id="contraseña" name="contraseña" type="pasword">
                <p>¿Tienes problemas para iniciar sesión?<br></p>
                <a href="Equipo_7.php" id= "ayuda"> Ayuda<br></a>
                <input type="submit" value="Iniciar Sesión">

            </form>
        </section>

    </main>
    <footer>
        <?php include'footer.php';?>
    </footer>

</body>
</html>