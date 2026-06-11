<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Página para consultar estadisticas generales de los estudiantes">
        <title>Estadisticas</title>
        <link rel="stylesheet" href="./../../statics/css/graficas.css">

    </head>
    <body>
        <header> 
            <?php ?>
        </header>
        
        <nav>
            <?php ?>
        </nav>
        
        <main class="contenido-principal">
            <div class="barra-busqueda">
                <h1>Estadisticas</h1>
                <br>
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
                <form action="GET" id="form-grupo" >
                    <span>Grupo: </span>
                    <select name="consulta" id="grupos">
                        <!--Se agregaran la lista de grupos según la base de datos-->
                        <option value="no-seleccionado">Seleccione un grupo</option>
                    </select>
                </form>
            </div>
            <br>
            <br>
            <br>
            <figure>
                <!--Gráfica de ejemplo, se agregaran según la base de datos-->
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXSAJWC0ds2FLkOksXks8QSNdi8NLjsMq7Ew&s" alt="Gráfica de actividades" class="graficas">
                <ul class="descripcion-graficas">
                    <li>Descripción 1</li>
                    <li>Descripción 2</li>
                    <li>Descripción 3</li>
                </ul>
            </figure>
            <br>
            <br>
            <br>
            <br>
            <div class="cambio-página"> 
                <a href="formularios.php"  id="cambio-formulario">Formularios</a>
                <a href="actividades.php"  id="cambio-actividades">Actividades</a>
            </div>
        </main>

        <footer>
            <?php ?>
        </footer>
    </body>
</html>