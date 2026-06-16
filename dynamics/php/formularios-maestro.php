<?php
    include 'conexion.php';

    $sql = "";
    if($_SERVER["REQUEST_METHOD"] == 'POST')
    {
        $fin = 0;
        $sql = "SELECT titulo FROM formulario";
        $query = mysqli_query($conexion, $sql);
        while($nombre_duplicado = mysqli_fetch_assoc($query))
        {
            if($nombre_duplicado['titulo'] == $_POST['subir-nombre'] )
                $fin = 1;
        }
        if($fin == 0)
        {
            //TABLA formulario
            if(isset($_POST['subir-grupo']))
            {   
                if($_POST['subir-grupo'] == "61B")
                {
                    $sql = "INSERT INTO formulario (id_grupo, titulo, descripcion, fecha, hora, modulo, rendimiento_esperado) 
                    VALUES (1,'" .$_POST['subir-nombre']. "','".$_POST['subir-descripcion']."',' ".date('Y-m-d')."',' ".date('H:i:s')."', ".$_POST['subir-modulo'].", ".$_POST['subir-rendimiento'].")";
                    mysqli_query($conexion, $sql);
                }
                
                if($_POST['subir-grupo'] == "61D")
                {
                    $sql = "INSERT INTO formulario (id_grupo, titulo, descripcion, fecha, hora, modulo, rendimiento_esperado) 
                    VALUES (2,'" .$_POST['subir-nombre']. "','".$_POST['subir-descripcion']."', '".date('Y-m-d')."', '".date('H:i:s')."', ".$_POST['subir-modulo'].", ".$_POST['subir-rendimiento'].")";
                    mysqli_query($conexion, $sql);
                }

                if(empty($_POST['subir-grupo']))
                {
                    $sql = "INSERT INTO formulario (titulo, descripcion, fecha, hora, modulo, rendimiento_esperado) 
                    VALUES ('".$_POST['subir-nombre']. "','".$_POST['subir-descripcion']."', '".date('Y-m-d')."', '".date('H:i:s')."', ".$_POST['subir-modulo'].", ".$_POST['subir-rendimiento'].")";
                    mysqli_query($conexion, $sql);
                }
            }
            if(isset($_POST['subir-nombre']))
            {
                $nombre = $_POST['subir-nombre'];
                //obtenemos el id del formulario que acabamos de hacer
                $id_formulario = mysqli_insert_id($conexion);
            }
            //decodificamos las preguntas
            if(isset($_POST['subir-preguntas']))
            {
                $json_sin_decodificar = trim($_POST['subir-preguntas']);
                $preguntas_decodificadas = json_decode($json_sin_decodificar, true);
                $preguntas = $preguntas_decodificadas;
            }
            //preguntas
            if(isset($preguntas))
            {
                foreach ($preguntas as $pregunta) 
                {
                    //tabla pregunta
                    if($pregunta['tipo'] == "opcion-multiple")
                        $tipo = 1;
                    if($pregunta['tipo'] == "opcion-multiple-multiseleccion")
                        $tipo = 2;
                    if($pregunta['tipo'] == "abierta")
                        $tipo = 3;
                    $sql = "INSERT INTO pregunta (id_formulario, id_tipo_pregunta, pregunta, puntaje_rendimiento) 
                    VALUES (".$id_formulario.", ".$tipo.", '".$pregunta['pregunta']."', ".$pregunta['rendimiento_pregunta'].")";
                    mysqli_query($conexion, $sql);
                    $id_pregunta = mysqli_insert_id($conexion);
                    //obtenemos el id de la pregunta que acabamos de hacer
                    //tablaa de opcion pregunta
                    if(!empty($pregunta['respuesta_1']))
                    {
                        if ($pregunta['respuesta_correcta_1'] == "correcta")
                            $correcta = 1;
                        else
                            $correcta = 0;
                        if(empty($pregunta['rendimiento_1']))
                            $rendimiento_respuesta = 0;
                        else
                            $rendimiento_respuesta = $pregunta['rendimiento_1'];

                        $sql = "INSERT INTO opcion_pregunta (id_pregunta, opcion, correcta, puntaje_opcion) 
                        VALUES (".$id_pregunta.", '".$pregunta['respuesta_1']."', ".$correcta.", ".$rendimiento_respuesta.")";
                        mysqli_query($conexion, $sql);
                    }
                    if(!empty($pregunta['respuesta_2']))
                    {
                        if ($pregunta['respuesta_correcta_2'] == "correcta")
                            $correcta = 1;
                        else
                            $correcta = 0;
                        if(empty($pregunta['rendimiento_2']))
                            $rendimiento_respuesta = 0;
                        else
                            $rendimiento_respuesta = $pregunta['rendimiento_2'];
                        $sql = "INSERT INTO opcion_pregunta (id_pregunta, opcion, correcta, puntaje_opcion) 
                        VALUES (".$id_pregunta.", '".$pregunta['respuesta_2']."', ".$correcta.", ".$rendimiento_respuesta.")";
                        mysqli_query($conexion, $sql);
                    }
                    if(!empty($pregunta['respuesta_3']))
                    {
                        if ($pregunta['respuesta_correcta_3'] == "correcta")
                            $correcta = 1;
                        else
                            $correcta = 0;
                        if(empty($pregunta['rendimiento_3']))
                            $rendimiento_respuesta = 0;
                        else
                            $rendimiento_respuesta = $pregunta['rendimiento_3'];
                        $sql = "INSERT INTO opcion_pregunta (id_pregunta, opcion, correcta, puntaje_opcion) 
                        VALUES (".$id_pregunta.", '".$pregunta['respuesta_3']."', ".$correcta.", ".$rendimiento_respuesta.")";
                        mysqli_query($conexion, $sql);
                    }
                    if(!empty($pregunta['respuesta_4']))
                    {
                        if ($pregunta['respuesta_correcta_4'] == "correcta")
                            $correcta = 1;
                        else
                            $correcta = 0;
                        if(empty($pregunta['rendimiento_4']))
                            $rendimiento_respuesta = 0;
                        else
                            $rendimiento_respuesta = $pregunta['rendimiento_4'];
                        $sql = "INSERT INTO opcion_pregunta (id_pregunta, opcion, correcta, puntaje_opcion) 
                        VALUES (".$id_pregunta.", '".$pregunta['respuesta_4']."',". $correcta.", ".$rendimiento_respuesta.")";
                        mysqli_query($conexion, $sql);
                    }
                }
            }
        }
    }
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
                        
                        $sql = "SELECT * FROM formulario WHERE modulo = 1";
                        $query = mysqli_query($conexion, $sql);
                        //foreach($formularios as $formulario)
                        while($formulario = mysqli_fetch_assoc($query))
                        {
                            echo "<div class='formulario'>";
                                echo "<div class='arriba'>";
                                    echo "<p class='fecha-publicacion'>Fecha de publicación: ". $formulario['fecha'] ."</p>";
                                echo "</div>";
                                echo "<p class='titulo-formulario'>". $formulario['titulo'] ."</p>";
                                //Pasar por post el id del cuestionario
                                echo "<div class='abajo'>";
                                    echo "<form action='./resolver-formulario.php' method='post'>";
                                        echo "<input type='hidden' id='id-formulario' name='id_formulario' value=".$formulario['id_formulario'].">";
                                        var_dump($formulario['id_formulario']);
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
                                    echo "<form action='./resolver-formulario.php' method='get'>";
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
                                    echo "<form action='./resolver-formulario.php' method='get'>";
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
                                    echo "<form action='./resolver-formulario.php' method='get'>";
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
                                    echo "<form action='./resolver-formulario.php' method='get'>";
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