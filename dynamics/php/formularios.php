<?php
    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina para la consulta de formularios">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-formularios.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Pagina de inicio</title>

</head>

<body>
    <?php include 'header.php'; ?>
    <h1>Formularios</h1>
    <div id="cont-circul">
        <aside>
            <form action="perfil-alumno.php" method="POST">
                <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../uploads/fotos-perfil/foto-default.png" alt="Log Out"></button> 
            </form>
        </aside>
        <aside >
            <form action="cerrar-sesion.php" method="POST">
                <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../statics/media/img/logout.png" alt="Log Out"></button> 
            </form>
        </aside>
    </div>       
    <div id="gran-contenedor">

        <div id="modulos">

            <div class="modulo">
                <details>

                    <summary>Modulo 1</summary>
                    <!--aqui va u while para los formularios -->
                    <div class="formulario">
                        <div class="arriba">
                            <p class="fecha-publicacion">Fecha de publicación: 2026-05-24</p>
                        </div>
                        <p class="titulo-formulario">Cuestionario de arreglos</p>
                        <!-- Pasar por post el id del cuestionario -->
                        <div class="abajo">
                            <a class="ver-mas" href="./formulario.php">Ver más</a>
                        </div>
                    </div>

                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 2</summary>
                    <!--aqui va u while para los formularios -->
                    <div class="formulario">
                        <div class="arriba">
                            <p class="fecha-publicacion">Fecha de publicación: 2026-05-24</p>
                        </div>
                        <p class="titulo-formulario">Cuestionario de arreglos</p>
                        <!-- Pasar por post el id del cuestionario -->
                        <div class="abajo">
                            <a class="ver-mas" href="./formulario.php">Ver más</a>
                        </div>
                    </div>

                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 3</summary>
                    <!--aqui va u while para los formularios -->
                    <div class="formulario">
                        <div class="arriba">
                            <p class="fecha-publicacion">Fecha de publicación: 2026-05-24</p>
                        </div>
                        <p class="titulo-formulario">Cuestionario de arreglos</p>
                        <!-- Pasar por post el id del cuestionario -->
                        <div class="abajo">
                            <a class="ver-mas" href="./formulario.php">Ver más</a>
                        </div>
                    </div>

                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 4</summary>
                    <!--aqui va u while para los formularios -->
                    <div class="formulario">
                        <div class="arriba">
                            <p class="fecha-publicacion">Fecha de publicación: 2026-05-24</p>
                        </div>
                        <p class="titulo-formulario">Cuestionario de arreglos</p>
                        <!-- Pasar por post el id del cuestionario -->
                        <div class="abajo">
                            <a class="ver-mas" href="./formulario.php">Ver más</a>
                        </div>
                    </div>

                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 5</summary>
                    <!--aqui va u while para los formularios -->
                    <div class="formulario">
                        <div class="arriba">
                            <p class="fecha-publicacion">Fecha de publicación: 2026-05-24</p>
                        </div>
                        <p class="titulo-formulario">Cuestionario de arreglos</p>
                        <!-- Pasar por post el id del cuestionario -->
                        <div class="abajo">
                            <a class="ver-mas" href="./formulario.php">Ver más</a>
                        </div>
                    </div>

                </details>

            </div>
        </div>
    </div>
<form action = "resolver_formulario.php" method = "POST">
        <button class = "boton" type="submit" class="boton">Perfil</button>
    </form>
</body>
<?php include 'footer.php'; ?>



</html>