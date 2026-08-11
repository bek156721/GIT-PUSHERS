<?php
    include 'conexion.php';

    session_start();

    if ($_SESSION['rol'] != "alumno")
    {
        header("Location: inicio-sesion.php");
        exit();
    }
    $id_grupo_usuario = $_SESSION['id_grupo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">
    <link rel="stylesheet" href="../../statics/css/header.css">
    <link rel="stylesheet" href="../../statics/css/footer.css">
    <title>Materiales</title>
</head>
<body>
<main>
    <?php include 'header.php'; ?>
    <section id="cont-principal">
        <div id="cont-circul">
            <aside>
                <form action="perfil-alumno.php" method="POST">
                    <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../uploads/fotos-perfil/foto-default.png" alt="Perfil"></button> 
                </form>
            </aside>
            <aside>
                <form action="cerrar-sesion.php" method="POST">
                    <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../statics/media/img/logout.png" alt="Log Out"></button> 
                </form>
            </aside>
            <aside>
                <form action="pagina-inicio-alumno.php" method="POST">
                    <button id="cerrar-sesion" type="submit"><img id="img_logout" src="../../statics/media/img/home.png" alt="Log Out"></button> 
                </form>
            </aside>
        </div>  
        
        <h1>Materiales</h1>

        <div id="gran-contenedor">
            <div class="modulo">
                <details>
                    <summary>Módulo 1</summary>
                    <?php
                        $sql = "SELECT * FROM material WHERE modulo ='1' AND id_grupo = $id_grupo_usuario";
                        $materiales = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($materiales) == 0) {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        } 
                        else 
                        {
                            while ($material = mysqli_fetch_assoc($materiales)) 
                            {
                                echo "<div class='formulario'>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Fecha de publicación: ". $material['fecha'] ."</p></div>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Hora de publicación: ". $material['hora'] ."</p></div>";
                                    echo "<p class='titulo-formulario'>". $material['titulo'] ."</p>";
                                    echo "<p class='descripcion-formulario'>". $material['descripcion'] ."</p>";
                                    echo "<div class='abajo'><a class='ver-mas' href='". $material['url'] ."' target='_blank'>Ver recurso</a></div>";
                                echo "</div>";
                            }
                        }
                    ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 2</summary>
                    <?php
                        $sql = "SELECT * FROM material WHERE modulo ='2' AND id_grupo = $id_grupo_usuario";
                        $materiales = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($materiales) == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        } 
                        else 
                        {
                            while ($material = mysqli_fetch_assoc($materiales)) 
                            {
                                echo "<div class='formulario'>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Fecha de publicación: ". $material['fecha'] ."</p></div>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Hora de publicación: ". $material['hora'] ."</p></div>";
                                    echo "<p class='titulo-formulario'>". $material['titulo'] ."</p>";
                                    echo "<p class='descripcion-formulario'>". $material['descripcion'] ."</p>";
                                    echo "<div class='abajo'><a class='ver-mas' href='". $material['url'] ."' target='_blank'>Ver recurso</a></div>";
                                echo "</div>";
                            }
                        }
                    ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 3</summary>
                    <?php
                        $sql = "SELECT * FROM material WHERE modulo ='3' AND id_grupo = $id_grupo_usuario";
                        $materiales = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($materiales) == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        } 
                        else 
                        {
                            while ($material = mysqli_fetch_assoc($materiales)) 
                            {
                                echo "<div class='formulario'>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Fecha de publicación: ". $material['fecha'] ."</p></div>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Hora de publicación: ". $material['hora'] ."</p></div>";
                                    echo "<p class='titulo-formulario'>". $material['titulo'] ."</p>";
                                    echo "<p class='descripcion-formulario'>". $material['descripcion'] ."</p>";
                                    echo "<div class='abajo'><a class='ver-mas' href='". $material['url'] ."' target='_blank'>Ver recurso</a></div>";
                                echo "</div>";
                            }
                        }
                    ?>
                </details>
            </div>

            <div class="modulo">
                <details>
                    <summary>Módulo 4</summary>
                    <?php
                        $sql = "SELECT * FROM material WHERE modulo ='4' AND id_grupo = $id_grupo_usuario";
                        $materiales = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($materiales) == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        } 
                        else 
                        {
                            while ($material = mysqli_fetch_assoc($materiales)) 
                            {
                                echo "<div class='formulario'>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Fecha de publicación: ". $material['fecha'] ."</p></div>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Hora de publicación: ". $material['hora'] ."</p></div>";
                                    echo "<p class='titulo-formulario'>". $material['titulo'] ."</p>";
                                    echo "<p class='descripcion-formulario'>". $material['descripcion'] ."</p>";
                                    echo "<div class='abajo'><a class='ver-mas' href='". $material['url'] ."' target='_blank'>Ver recurso</a></div>";
                                echo "</div>";
                            }
                        }
                    ?>
                </details>
            </div>

            <!-- MÓDULO 5 -->
            <div class="modulo">
                <details>
                    <summary>Módulo 5</summary>
                    <?php
                        $sql = "SELECT * FROM material WHERE modulo ='5' AND id_grupo = $id_grupo_usuario";
                        $materiales = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($materiales) == 0) 
                        {
                            echo "<div class='formulario'><p class='titulo-formulario'>No hay materiales de este módulo</p></div>";
                        } 
                        else 
                        {
                            while ($material = mysqli_fetch_assoc($materiales)) 
                            {
                                echo "<div class='formulario'>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Fecha de publicación: ". $material['fecha'] ."</p></div>";
                                    echo "<div class='arriba'><p class='fecha-publicacion'>Hora de publicación: ". $material['hora'] ."</p></div>";
                                    echo "<p class='titulo-formulario'>". $material['titulo'] ."</p>";
                                    echo "<p class='descripcion-formulario'>". $material['descripcion'] ."</p>";
                                    echo "<div class='abajo'><a class='ver-mas' href='". $material['url'] ."' target='_blank'>Ver recurso</a></div>";
                                echo "</div>";
                            }
                        }
                    ?>
                </details>
            </div>
        </div>
    </section>
</main>
<footer> 
    <?php include 'footer.php'; ?> 
</footer>
</body>
</html>