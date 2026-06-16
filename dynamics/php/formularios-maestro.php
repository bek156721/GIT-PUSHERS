<?php
    include 'conexion.php';

    $sql = "";
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina para la consulta de formularios">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Pagina de inicio</title>

</head>

<body>
<?php include 'header.php'?>
<main>
    <h1>Formularios</h1>
    <div id="gran-contenedor">
        <div id="parte-arriba">    
            <p id="desc-btn-forms">Crear un nuevo formulario</p>
            <a href="./crear-formulario.php">
                <div id="btn-crear">
                    <img id="simbolo-subir-form" src="../../statics/media/img/btn-crear-form.png" alt="Simbolo de subir">
                </div>
            </a> 
        </div>
        <div id="modulos">

            <div class="modulo">
                <details>

                    <summary>Modulo 1</summary>
                    <!--aqui va un for each para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='1'";
                        $formularios = mysqli_query($conexion, $sql);
                        foreach($formularios as $formulario)
                        {
                            echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] ."</p>";
                                echo "</div>";
                                echo "<p class='titulo-formulario'>". $formulario['titulo'] ."</p>";
                                //Pasar por post el id del cuestionario
                                echo "<div class='abajo'>";
                                    echo "<form action='./formulario.php' method='get'>";
                                        echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                        echo "<button class='ver-mas type='submit'>Ver mas</button>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 2</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='2'";
                        $formularios = mysqli_query($conexion, $sql);
                        foreach($formularios as $formulario)
                        {
                            echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] ."</p>";
                                echo "</div>";
                                echo "<p class='titulo-formulario'>". $formulario['titulo'] ."</p>";
                                //Pasar por post el id del cuestionario
                                echo "<div class='abajo'>";
                                    echo "<form action='./formulario.php' method='get'>";
                                        echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                        echo "<button class='ver-mas type='submit'>Ver mas</button>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 3</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='3'";
                        $formularios = mysqli_query($conexion, $sql);
                        foreach($formularios as $formulario)
                        {
                            echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] ."</p>";
                                echo "</div>";
                                echo "<p class='titulo-formulario'>". $formulario['titulo'] ."</p>";
                                //Pasar por post el id del cuestionario
                                echo "<div class='abajo'>";
                                    echo "<form action='./formulario.php' method='get'>";
                                        echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                        echo "<button class='ver-mas type='submit'>Ver mas</button>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 4</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='4'";
                        $formularios = mysqli_query($conexion, $sql);
                        foreach($formularios as $formulario)
                        {
                            echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] ."</p>";
                                echo "</div>";
                                echo "<p class='titulo-formulario'>". $formulario['titulo'] ."</p>";
                                //Pasar por post el id del cuestionario
                                echo "<div class='abajo'>";
                                    echo "<form action='./formulario.php' method='get'>";
                                        echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                        echo "<button class='ver-mas type='submit'>Ver mas</button>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>

                </details>

            </div>
            <div class="modulo">
                <details>

                    <summary>Modulo 5</summary>
                    <!--aqui va u while para los formularios -->
                    <?php
                        
                        $sql = "SELECT * FROM formulario WHERE modulo ='5'";
                        $formularios = mysqli_query($conexion, $sql);
                        foreach($formularios as $formulario)
                        {
                            echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] ."</p>";
                                echo "</div>";
                                echo "<p class='titulo-formulario'>". $formulario['titulo'] ."</p>";
                                //Pasar por post el id del cuestionario
                                echo "<div class='abajo'>";
                                    echo "<form action='./formulario.php' method='get'>";
                                        echo "<input type='hidden' id='id-formulario' name='id_formulario' value='".$formulario['id_formulario']."'>";
                                        echo "<button class='ver-mas type='submit'>Ver mas</button>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>

                </details>

            </div>
        </div>
    </div>
</main>
</body>
<footer>
    <?php include 'footer.php'?>
</footer>
</html>