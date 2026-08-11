<?php
    include 'conexion.php';
    session_start();

    if ($_SESSION['rol'] != "profesor")
    {
        header("Location: inicio-sesion.php");
        exit();
    }

    $id_profesor_usuario = $_SESSION['id_profesor'];

    $titulo = "";
    $descripcion = "";
    $modulo = "";
    $grupo = "";
    $preguntas = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_POST['nombre-formulario']))
        {
            $titulo = $_POST['nombre-formulario'];
        }
        if (isset($_POST['descripcion-formulario']))
        {
            $descripcion = $_POST['descripcion-formulario'];
        }
        if (isset($_POST['modulo']))
        {
            $modulo = $_POST['modulo'];
        }
        if (isset($_POST['grupo']))
        {
            $grupo = $_POST['grupo'];
        }
        /* SI HAY PREGUNTAS YA HECHAS, LAS GUARDA (DECODIFICA EL JSON) */
        if (isset($_POST['pasar-preguntas']))
        {
            $json_sin_decodificar = trim($_POST['pasar-preguntas']);
            $preguntas_decodificadas = json_decode($json_sin_decodificar, true);
            $preguntas = $preguntas_decodificadas;
        }
        if (isset($_POST['pregunta']) && isset($_POST['tipo-pregunta']))
        {
            /* RECIBE */
            if($_POST['tipo-pregunta'] == "abierta")
            {
                $preguntas[]=
                [
                    "pregunta" => $_POST['pregunta'],
                    "tipo" => $_POST['tipo-pregunta'],
                    "respuesta_1" => NULL,
                    "respuesta_correcta_1" => NULL,
                    "rendimiento_1" => '0',
                    "respuesta_2" => NULL,
                    "respuesta_correcta_2" => NULL,
                    "rendimiento_2" => '0',
                    "respuesta_3" => NULL,
                    "respuesta_correcta_3" => NULL,
                    "rendimiento_3" => '0',
                    "respuesta_4" => NULL,
                    "respuesta_correcta_4" => NULL,
                    "rendimiento_4" => '0',
                    "rendimiento_pregunta" => '0'
                ];
            }
            else
            {
                if(!empty($_POST['respuesta-1']) && !empty($_POST['respuesta-2']))
                {
                    /* INTRODUCIMOS LOS RENDIMIENTOS DE LAS RESPUESTAS PARA MAS ADELANTE OBTENER EL MAXIMO */
                    $rendimientos = [$_POST['rendimiento-1'], $_POST['rendimiento-2'], $_POST['rendimiento-3'], $_POST['rendimiento-4']];
                    /* SI NO ES ABIERTA */
                    /* SI SOLO HAY RESPUESTA 1 Y 2 (DOS RESPUESTAS-OBLIGATORIO) */
                    if(empty($_POST['respuesta-3']) && empty($_POST['respuesta-4']))
                    {
                        $preguntas[]=
                        [
                            "pregunta" => $_POST['pregunta'],
                            "tipo" => $_POST['tipo-pregunta'],
                            "respuesta_1" => $_POST['respuesta-1'] ?? '',
                            "respuesta_correcta_1" => $_POST['respuesta-correcta-1'] ?? 'incorrecta',
                            "rendimiento_1" => $_POST['rendimiento-1'] ?? '0',
                            "respuesta_2" => $_POST['respuesta-2'] ?? '',
                            "respuesta_correcta_2" => $_POST['respuesta-correcta-2'] ?? 'incorrecta',
                            "rendimiento_2" => $_POST['rendimiento-2'] ?? '0',
                            "respuesta_3" => NULL,
                            "respuesta_correcta_3" => NULL,
                            "rendimiento_3" => '0',
                            "respuesta_4" => NULL,
                            "respuesta_correcta_4" => NULL,
                            "rendimiento_4" => '0',
                            "rendimiento_pregunta" => max($rendimientos)
                        ];
                    }
                    /* SI HAY RESPUESTA 1, 2 Y 3 */
                    if(!empty($_POST['respuesta-3']) && empty($_POST['respuesta-4']))
                    {
                        $preguntas[]=
                        [
                            "pregunta" => $_POST['pregunta'],
                            "tipo" => $_POST['tipo-pregunta'],
                            "respuesta_1" => $_POST['respuesta-1'] ?? '',
                            "respuesta_correcta_1" => $_POST['respuesta-correcta-1'] ?? 'incorrecta',
                            "rendimiento_1" => $_POST['rendimiento-1'] ?? '0',
                            "respuesta_2" => $_POST['respuesta-2'] ?? '',
                            "respuesta_correcta_2" => $_POST['respuesta-correcta-2'] ?? 'incorrecta',
                            "rendimiento_2" => $_POST['rendimiento-2'] ?? '0',
                            "respuesta_3" => $_POST['respuesta-3'] ?? '',
                            "respuesta_correcta_3" => $_POST['respuesta-correcta-3'] ?? 'incorrecta',
                            "rendimiento_3" => $_POST['rendimiento-3'] ?? '0',
                            "respuesta_4" => NULL,
                            "respuesta_correcta_4" => NULL,
                            "rendimiento_4" => '0',
                            "rendimiento_pregunta" => max($rendimientos)
                        ];
                    }
                    /* SI HAY RESPUESTA 1, 2 Y 4 SE COLOCARA LA RESPUESTA 4 ASOCIADA CON LA 3 */
                    if(empty($_POST['respuesta-3']) && !empty($_POST['respuesta-4']))
                    {
                        $preguntas[]=
                        [
                            "pregunta" => $_POST['pregunta'],
                            "tipo" => $_POST['tipo-pregunta'],
                            "respuesta_1" => $_POST['respuesta-1'] ?? '',
                            "respuesta_correcta_1" => $_POST['respuesta-correcta-1'] ?? 'incorrecta',
                            "rendimiento_1" => $_POST['rendimiento-1'] ?? '0',
                            "respuesta_2" => $_POST['respuesta-2'] ?? '',
                            "respuesta_correcta_2" => $_POST['respuesta-correcta-2'] ?? 'incorrecta',
                            "rendimiento_2" => $_POST['rendimiento-2'] ?? '0',
                            "respuesta_3" => $_POST['respuesta-4'] ?? '',
                            "respuesta_correcta_3" => $_POST['respuesta-correcta-4'] ?? 'incorrecta',
                            "rendimiento_3" => $_POST['rendimiento-4'] ?? '0',
                            "respuesta_4" => NULL,
                            "respuesta_correcta_4" => NULL,
                            "rendimiento_4" => '0',
                            "rendimiento_pregunta" => max($rendimientos)
                        ];
                    }
                    /* SI HAY RESPUESTA 1, 2, 3 Y 4 */
                    if(!empty($_POST['respuesta-3']) && !empty($_POST['respuesta-4']))
                    {
                        $preguntas[]=
                        [
                            "pregunta" => $_POST['pregunta'],
                            "tipo" => $_POST['tipo-pregunta'],
                            "respuesta_1" => $_POST['respuesta-1'] ?? '',
                            "respuesta_correcta_1" => $_POST['respuesta-correcta-1'] ?? 'incorrecta',
                            "rendimiento_1" => $_POST['rendimiento-1'] ?? '0',
                            "respuesta_2" => $_POST['respuesta-2'] ?? '',
                            "respuesta_correcta_2" => $_POST['respuesta-correcta-2'] ?? 'incorrecta',
                            "rendimiento_2" => $_POST['rendimiento-2'] ?? '0',
                            "respuesta_3" => $_POST['respuesta-3'] ?? '',
                            "respuesta_correcta_3" => $_POST['respuesta-correcta-3'] ?? 'incorrecta',
                            "rendimiento_3" => $_POST['rendimiento-3'] ?? '0',
                            "respuesta_4" => $_POST['respuesta-4'] ?? '',
                            "respuesta_correcta_4" => $_POST['respuesta-correcta-4'] ?? 'incorrecta',
                            "rendimiento_4" => $_POST['rendimiento-4'] ?? '0',
                            "rendimiento_pregunta" => max($rendimientos)
                        ];
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
    <!--<link rel="stylesheet" href="../../statics/css/estilo-crear-formularios.css">-->
    <link rel="stylesheet" href="../../statics/css/estilo-formularios-maestro.css">

    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Nuevo formulario</title>

</head>

<body>
    <?php include 'header.php'?>
<main>
    <?php
        // SI SE MANDÓ UNA PREGUNTA NO ABIERTA CON MENOS DE DOS RESPUESTAS
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            if(isset($_POST['tipo-pregunta']) && ($_POST['tipo-pregunta'] == "opcion-multiple" || $_POST['tipo-pregunta'] == "opcion-multiple-multiseleccion"))
            {
                if( empty($_POST['respuesta-1']) || empty($_POST['respuesta-2']))
                {
                    echo '<p id="mensaje-error">     **Error, no se pudo añadir la pregunta. En una pregunta de opcion multiple los campos de respuesta 1 y 2 son obligatorios.</p>';
                }
            }
        }
    ?>

    <h1>Nuevo formulario</h1>
        
    <div id="gran-contenedor">
        <form id="datos-form" action="./crear-formulario.php" method="post">
            <p class ="formulario">Título del formulario: <input  type="text" name="nombre-formulario" value="<?php echo htmlspecialchars($titulo); ?>" required></p>
            <br>
            <p class ="formulario">Descripción del formulario: <input class="in-texto" type="text" name="descripcion-formulario" value="<?php echo htmlspecialchars($descripcion); ?>" required></p>
            <br>
                <p class ="formulario">
                    Módulo del formulario:
                    <ul class="lista-sin-vineta">
                        <li>
                        <input  type="radio" name="modulo" id="m1" value="1" <?php if($modulo == "1") echo "checked=checked"; ?> required>
                        <label class="descripcion-formulario" for="m1">Módulo 1</label>
                        
                        <input type="radio" name="modulo" id="m2" value="2" <?php if($modulo == "2") echo "checked=checked"; ?>>
                        <label class="descripcion-formulario" for="m2">Módulo 2</label>
                        
                        <input  type="radio" name="modulo" id="m3" value="3" <?php if($modulo == "3") echo "checked=checked"; ?>>
                        <label class="descripcion-formulario" for="m3">Módulo 3</label>
                        
                        <input  type="radio" name="modulo" id="m4" value="4" <?php if($modulo == "4") echo "checked=checked"; ?>>
                        <label class="descripcion-formulario" for="m4">Módulo 4</label>
                        
                        <input type="radio" name="modulo" id="m5" value="5" <?php if($modulo == "5") echo "checked=checked"; ?>>
                        <label class="descripcion-formulario" for="m5">Módulo 5</label>
                        </li>
                    </ul>
                </p>
            
            
            
                <p class ="formulario">
                    Grupo:
                    <?php
                        $query_grupos = "SELECT * FROM grupo WHERE id_profesor = '$id_profesor_usuario'";
                        $resultado_grupos = mysqli_query($conexion, $query_grupos);
                        echo '<ul class="lista-sin-vineta">'; 
                            echo '<li>';
                        if ($resultado_grupos && mysqli_num_rows($resultado_grupos) > 0) 
                        {
                            while ($g = mysqli_fetch_assoc($resultado_grupos)) 
                            {
                                $nombre_g = htmlspecialchars($g['nombre_grupo']); 
                                $checked = ($grupo == $nombre_g) ? 'checked="checked"' : '';
                                
                                    echo '<input class="r-grupo" type="radio" name="grupo" id="g_' . $nombre_g . '" value="' . $nombre_g . '" ' . $checked . ' required>';
                                    echo '<label class="descripcion-formulario" for="g_' . $nombre_g . '">' . $nombre_g . '</label> ';
                                
                            }
                        } 
                        else 
                        {
                            
                            echo '<p class="descripcion-formulario"> No hay grupos asignados <p> ';
                            
                        }
                        
                    ?>
                    <input class="r-grupo" type="radio" name="grupo" id="g_ninguno" value="" 
                    <?php if($grupo == "") echo 'checked="checked"'; ?>>

                    
                        <label class="descripcion-formulario" for="g_ninguno">No específico</label>
                        <li>    
                    </ul>
                </p>
            

        <!-----APARTADO DE LAS PREGUNTAS----->
        <p class="formulario">Preguntas:</p>
            <!----INPUT PARA LA PREGUNTA----->
            <p class="descripcion-formulario">Pregunta: <input  type="text" name="pregunta" size="50" required></p>
            <div id="tipo-respuesta">
                <p class="formulario">Tipo de respuesta: </p>
                <!----- INPUT PARA LA RESPUESTA ABIERTA (SIN RESPUESTAS) ----->
                <ul class="lista-sin-vineta">
                    <li>
                        <input class="r-tipo-r" type="radio" name="tipo-pregunta" value="abierta" required>
                        <label class="descripcion-formulario" for="abierta">Abierta</label>
                        <!----- INPUT PARA LAS RESPUESTAS DE OPCIÓN MÚLTIPLE (RADIOS) ----->
                        <input class="r-tipo-r" id="mostrar-2" type="radio" name="tipo-pregunta" value="opcion-multiple" required>
                        <label class="descripcion-formulario" for="opcionmultiple">Opción múltiple</label>
                        <!----- INPUT PARA LAS PREGUNTAS DE OPCIÓN DE VARIAS RESPUESTAS (CHECKBOXES) ------>
                        <input class="r-tipo-r" id="mostrar-2" type="radio" name="tipo-pregunta" value="opcion-multiple-multiseleccion" required>
                        <label class="descripcion-formulario" for="opcionmultiple-2">Opción múltiple (multiselección)</label>
                    <li>    
                </ul>

                <p class="formulario">Respuestas:</p>
                <div id="respuestas">
                    <!---- RESPUESTAS (SI ES ABIERTA ES NULL), DOS SON OBLIGATORIAS ----->
                    <div class="respuesta">
                        <!----- INPUT PARA LA RESPUESTA UNO (OBLIGATORIA) ----->
                        <p class="descripcion-formulario">Respuesta 1 <input  type="text" name="respuesta-1" size="50" placeholder="Campo obligatorio"></p>
                        <!----CHECKBOX DE RESPUESTA CORRECTA Y UN INPUT NUMERICO QUE EMPIEZA EN 0 ---->
                        <p class="descripcion-formulario">Respuesta correcta <input type="checkbox" name="respuesta-correcta-1" id="respeusta-1" value="correcta">Rendimiento <input type="number" name="rendimiento-1" min="0" max="5" step="0"></p>
                    </div>
                    <div class="respuesta" id="r-2">
                        <!----- INPUT DE LA RESPUESTA DOS (OBLIGATORIA) ------>
                        <p class="descripcion-formulario">Respuesta 2 <input  type="text" name="respuesta-2" size="50" placeholder="Campo obligatorio"></p>
                        <!--- CHECKBOX Y UN INPUT NUMÉRICO ---->
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-2" id="respeusta-2" value="correcta">Rendimiento <input type="number" name="rendimiento-2" min="0" max="5" step="0"></p>
                    </div>
                    <div class="respuesta" id="r-3">
                        <p class="descripcion-formulario">Respuesta 3 <input  type="text" name="respuesta-3" size="50" placeholder="Campo opcional"></p>
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-3" id="respeusta-3" value="correcta">Rendimiento <input type="number" name="rendimiento-3" min="0" max="5" step="0"></p>
                    </div>
                    <div class="respuesta" id="r-4">
                        <p class="descripcion-formulario">Respuesta 4 <input  type="text" name="respuesta-4" size="50" placeholder="Campo opcional"></p>
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-4" id="respeusta-4" value="correcta">Rendimiento <input type="number" name="rendimiento-4" min="0" max="5" step="0"></p>
                    </div>
                </div>
            </div> 

            <input type="hidden" name="pasar-preguntas" value="<?php echo htmlspecialchars(json_encode($preguntas)); ?>">
        </form>
        <div id="añadir-pregunta">
            <button class="ver-mas" type="submit" form="datos-form" name="actualizar-datos">Añadir pregunta</button>
        </div>
</div>
        <h1>Vista previa</h1>
        <div class = "body_formulario">
            <div class = "main_formulario">
                
                <?php
                    $rendimiento_total = 0;
                    if(!empty($preguntas))
                    {
                        $cont = 1;
                        echo "<p class='titulo-formulario'> Título del formulario : ". htmlspecialchars($titulo) ."</p>";
                        echo "<p class='descripcion-formulario'> Descripción del formulario : ". htmlspecialchars($descripcion) ."</p>";
                        foreach($preguntas as $pregunta) 
                        {
                            echo "<br><p class='pregunta'>".$cont.".-" .$pregunta["pregunta"]." (".$pregunta["tipo"].")</p>";
                            if($pregunta["tipo"] != "abierta")
                            {
                                echo "<p class='opciones_respuestas'>a)".$pregunta["respuesta_1"]." (".$pregunta["respuesta_correcta_1"].")  rendimiento (". $pregunta["rendimiento_1"] .")</p>";
                                echo "<p class='opciones_respuestas'>b)".$pregunta["respuesta_2"]." (".$pregunta["respuesta_correcta_2"].")  rendimiento (". $pregunta["rendimiento_2"] .")</p>";
                                if(!empty($pregunta["respuesta_3"]))
                                {
                                    echo "<p class='opciones_respuestas'>c)".$pregunta["respuesta_3"]." (".$pregunta["respuesta_correcta_3"].")  rendimiento (". $pregunta["rendimiento_3"] .")</p>";
                                }
                                if(!empty($pregunta["respuesta_4"]))
                                {
                                    echo "<p class='opciones_respuestas'>d)".$pregunta["respuesta_4"]." (".$pregunta["respuesta_correcta_4"].")  rendimiento (". $pregunta["rendimiento_4"] .")</p>";
                                }
                                echo "<p>Rendimiento esperado : ". $pregunta["rendimiento_pregunta"] ."</p>";
                                $rendimiento_total = $rendimiento_total + $pregunta["rendimiento_pregunta"];
                            }
                            $cont = $cont + 1;
                        }
                        echo "<p>Total de preguntas : ". ($cont - 1) ." <br>Rendimiento esperado : ". $rendimiento_total ."</p>";
                    }
                ?>
            </div>
        </div>
        <form id="subir-form" action="./formularios-maestro.php" method="post">
            <input type="hidden" name="subir-nombre" value="<?php echo htmlspecialchars($titulo); ?>">
            <input type="hidden" name="subir-descripcion" value="<?php echo htmlspecialchars($descripcion); ?>">
            <input type="hidden" name="subir-modulo" value="<?php echo htmlspecialchars($modulo); ?>">
            <input type="hidden" name="subir-grupo" value="<?php echo htmlspecialchars($grupo); ?>">
            <input type="hidden" name="subir-rendimiento" value="<?php echo $rendimiento_total; ?>">
            <input type="hidden" name="subir-preguntas" value="<?php echo htmlspecialchars(json_encode($preguntas)); ?>">
        </form>
        <div id="subir-form">
            <button id="btn-subir" type="submit" form="subir-form" name="subir-bd">Subir</button>
        </div>
    </div>
</main>

<footer>
<?php include 'footer.php'?> 
</footer>

</body>
</html>