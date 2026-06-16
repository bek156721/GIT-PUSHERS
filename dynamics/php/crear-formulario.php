<?php

    include 'conexion.php';

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
        /* SI PASAR HAY PREGUNTAS YA HECHAS, LAS GUARDA, ESTAS ESTAN ODIFICADAS EN json POR LO QUE SE DECODIFICAN */
        if (isset($_POST['pasar-preguntas']))
        {
            $json_sin_decodificar = trim($_POST['pasar-preguntas']);
            $preguntas_decodificadas = json_decode($json_sin_decodificar, true);
            $preguntas = $preguntas_decodificadas;
        }
        if (isset($_POST['pregunta'])&&isset($_POST['tipo-pregunta']))
        {
            /*RECIBES */
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
                    /*INTRODUCIMOS LOS RENDIMIENTOS DE LAS RESPUESTAS PARA MAS ADELANTE OBTENER EL MAXIMO*/
                    $rendimientos = [$_POST['rendimiento-1'], $_POST['rendimiento-2'], $_POST['rendimiento-3'], $_POST['rendimiento-4']];
                    /*SI NO ES ABIERTA */
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
                    /* SI HAY RESPUESTA 1, 2 Y 4 xd SE COLOCARA LA RESPUESTA 4 SE LE ASOCIARA CON LA 3 */
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
    <link rel="stylesheet" href="../../statics/css/estilo-crear-formularios.css">
    <title>Pagina de inicio</title>

</head>
<header>
    <p>sec ETE xd</p>
</header>
<body>
    <h1>Crear un formulario</h1>
    <?php
        //SI TE MANDARON UN APREGUNTA NO ABIERTA CON MENOS DE DOS RESPUESTAS
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            if($_POST['tipo-pregunta'] == "opcion-multiple" || $_POST['tipo-pregunta'] == "opcion-multiple-multiseleccion")
            {
                if( empty($_POST['respuesta-1']) || empty($_POST['respuesta-2']))
                    {
                        echo '<p id="mensaje-error">     **Error, no se pudo añadir la pregunta. En una pregunta de opcion multiple los campos de respuesta 1 y 2 son obligatorios.</p>';
                    }
            }
        }
    ?>
    <div id="creacion">
        <h2>Caracteristicas</h2>

        <form id="datos-form" action="./crear-formulario.php" method="post">
            <p>Titulo del formulario <input class="in-texto" type="text" name="nombre-formulario" size="50" value="<?php echo $titulo; ?>" required></p>

            <p>Descripcion del formulario <input class="in-texto" type="text" name="descripcion-formulario" size="50" value="<?php echo $descripcion; ?>" required></p>
            <div id="in-modulos">
                <p>
                    Modulo del formulario
                    <input class="r-modulo" type="radio" name="modulo" id="m1" value="1" <?php if($modulo == "1") echo "checked=checked"; ?> required>
                    <label class="l-modulo" for="m1">Modulo-1</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m2" value="2" <?php if($modulo == "2") echo "checked=checked"; ?>>
                    <label class="l-modulo" for="m2">Modulo-2</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m3" value="3" <?php if($modulo == "3") echo "checked=checked"; ?>>
                    <label class="l-modulo" for="m3">Modulo-3</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m4" value="4" <?php if($modulo == "4") echo "checked=checked"; ?>>
                    <label class="l-modulo" for="m4">Modulo-4</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m5" value="5" <?php if($modulo == "5") echo "checked=checked"; ?>>
                    <label class="l-modulo" for="m5">Modulo-5</label>
                </p>
            </div>
            <div id="in-grupos">
                <p>
                    Grupo
                    <input class="r-grupo" type="radio" name="grupo" id="g1" value="61B" <?php if($grupo == "61B") echo "checked=checked"; ?>>
                    <label class="l-grupo" for="g1">61B</label>
                    <input class="r-grupo" type="radio" name="grupo" id="g2" value="61D" <?php if($grupo == "61D") echo "checked=checked"; ?>>
                    <label class="l-grupo" for="g2">61D</label>
                    <input class="r-grupo" type="radio" name="grupo" id="g2" value="" <?php if($grupo == "") echo "checked=checked"; ?>>
                    <label class="l-grupo" for="g2">No especifico</label>
                </p>
            </div>
        <!-----APARTADO DE LAS PREGUNTAS----->
        <h3>Preguntas</h3>
            <!----INPUT PARA LA PREGUNTA----->
            <p>Pregunta <input class="in-texto" type="text" name="pregunta" size="50" required></p>
            <div id="tipo-respuesta">
                <p>Tipo de respuesta </p>
                <!-----                 INPUT DE PARA LA RESPUESTA ABIERTA (SIN RESPUESTAS)                   ----->
                <input class="r-tipo-r" type="radio" name="tipo-pregunta" value="abierta" required>
                <label class="l-tipo-r" for="abierta">Abierta</label>
                <!-----         INPUT PARA LAS RESPUESTAS DE OPCION MULTIPLE (RADIOS)        ----->
                <input class="r-tipo-r" id="mostrar-2" type="radio" name="tipo-pregunta" value="opcion-multiple" required>
                <label class="l-tipo-r" for="opcionmultiple">Opcion multiple</label>
                <!-----          INPUT PARA LAS PREGUNTAS DE OPCION DE VARIAS RESPUESTAS (CHECKBOXES)         ------>
                <input class="r-tipo-r" id="mostrar-2" type="radio" name="tipo-pregunta" value="opcion-multiple-multiseleccion"required>
                <label class="l-tipo-r" for="opcionmultiple-2">Opcion multiple (multiseleccion)</label>

                <div id="respuestas">
                    <!----       RESPUESTAS (SI ES ABIERTA ES NULL), DOS SON OBLIGATORIAS, PUEDEN HABER MAS DE UNA RESPUESTA CORRECTA, O NINGUNA xd       ----->
                    <div class="respuesta">
                        <!-----       INPUT PARA LA RESPUESTA UNO (OBLIGATORIA)       ----->
                        <p>Respuesta 1 <input class="in-respuesta" type="text" name="respuesta-1" size="50" placeholder="Campo obligatorio"></p>
                        <!----CHECKBOX DE RESPUESTA CORRECTA Y UN INPUT NUMERICO QUE EMPIEZA EN 0 ---->
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-1" id="respeusta-1" value="correcta">Rendimiento <input type="number" name="rendimiento-1" min="0" max="10" step="0"><p>
                    </div>
                    <div class="respuesta" id="r-2">
                        <!-----     INPUT DE LA RESPUESTA DOS (OBLIGATORIA)     ------>
                        <p>Respuesta 2 <input class="in-respuesta" type="text" name="respuesta-2" size="50" placeholder="Campo obligatorio"></p>
                        <!--- CHECK BOX Y UN INPUT NUMERICO ---->
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-2" id="respeusta-2" value="correcta">Rendimiento <input type="number" name="rendimiento-2" min="0" max="10" step="0"><p>
                    </div>
                    <div class="respuesta" id="r-3">
                        <p>Respuesta 3 <input class="in-respuesta" type="text" name="respuesta-3" size="50" placeholder="Campo opcional"></p>
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-3" id="respeusta-3" value="correcta">Rendimiento <input type="number" name="rendimiento-3" min="0" max="10" step="0"><p>
                    </div>
                    <div class="respuesta" id="r-4">
                        <p>Respuesta 4 <input class="in-respuesta" type="text" name="respuesta-4" size="50" placeholder="Campo opcional"></p>
                        <p class="respuesta-correcta">Respuesta correcta <input type="checkbox" name="respuesta-correcta-4" id="respeusta-4" value="correcta">Rendimiento <input type="number" name="rendimiento-4" min="0" max="10" step="0"><p>
                    </div>
                </div>
            </div> 
            <!--
                EN UN INPUT OCULTO PASAMOS EL ARREGLO QUE CONTIENE LAS PREGUNTAS PARA QUE PUEDAN SER MOSTRADAS EN LA VISTA PREVIA 
                htmlspecialchars PERMITE HACER QUE LOS CARACTERES DE UNA CADENA QUE SIGNIFICAN ALGO O TIENEN UN VALOR EN HTML, SEAN REMPLAZADOS Y NO HAGAN QUE PASE ALGO RARO
                json_encode PERMITE PASAR EL ARREGLO CON LAS PREGUNTAS TRANSFORMANDOLO EN UN FORMATO ENVIABLE AL SERVIDOR, DE LO CONTRARIO NO SE ENVIARIA COPLETO EL ARREGLO Y SOLO SE ENVIARIA LA ULTIMA PREGUNTA
            -->
            <input type="hidden" name="pasar-preguntas" value=" <?php echo htmlspecialchars(json_encode($preguntas)) ;?> ">
        </form>
        <div id="añadir-pregunta">
            <!-----          PASAMOS TODOS LOS DATOS A ESA MISMA PAGINA PARA QUE SE CARGUE LA VISTA PREVIA       ----->
            <button id="btn-añadir" type="submit" form="datos-form" name="actualizar-datos">Añadir pregunta</button>
        </div>

        <h4>Vista previa</h3>
        <div id="alineacion-vista">           
            <div id="vista-previa">
                <?php
                    if(!empty($preguntas))
                    {
                        $cont = 1;
                        $rendimiento_total = 0;
                        echo "<p> Titulo del formulario : ". $titulo ."</p>";
                        echo "<p> Descripción del formulario : ". $descripcion ."</p>";
                        foreach($preguntas as $pregunta) 
                        {
                            echo "<br><p>".$cont.".-" .$pregunta["pregunta"]." (".$pregunta["tipo"].")</p>";
                            if($pregunta["tipo"] != "abierta")
                            {
                                echo "<p>a)".$pregunta["respuesta_1"]." (".$pregunta["respuesta_correcta_1"].")  rendimiento (". $pregunta["rendimiento_1"] .")</p>";
                                echo "<p>b)".$pregunta["respuesta_2"]." (".$pregunta["respuesta_correcta_2"].")  rendimiento (". $pregunta["rendimiento_2"] .")</p>";
                                if(!empty($pregunta["respuesta_3"]))
                                {
                                    echo "<p>c)".$pregunta["respuesta_3"]." (".$pregunta["respuesta_correcta_3"].")  rendimiento (". $pregunta["rendimiento_3"] .")</p>";
                                }
                                if(!empty($pregunta["respuesta_4"]))
                                {
                                    echo "<p>d)".$pregunta["respuesta_4"]." (".$pregunta["respuesta_correcta_4"].")  rendimiento (". $pregunta["rendimiento_4"] .")</p>";
                                }
                                echo "<p>Rendimiento esperado : ". $pregunta["rendimiento_pregunta"] ."</p>";
                                $rendimiento_total = $rendimiento_total + $pregunta["rendimiento_pregunta"];
                            }
                            $cont = $cont + 1;
                        }
                        echo "<p>Total de preguntas : ". $cont - 1 ." <br>Rendimiento esperado : ". $rendimiento_total ."</p>";
                    }
                ?>
            </div>
        </div>
        <form id="subir-form" action="./formularios-maestro.php" method="post">
            <!---se pasan todos los datos por post en un input hidden, los type text se ponen con specialchars para que no pase algo raro--->
            <input type="hidden" name="subir-nombre" value="<?php echo htmlspecialchars($titulo); ?>">
            <input type="hidden" name="subir-descripcion" value="<?php echo htmlspecialchars($descripcion); ?>">
            <input type="hidden" name="subir-modulo" value="<?php echo $modulo; ?>">
            <input type="hidden" name="subir-grupo" value="<?php echo $grupo; ?>">
            <input type="hidden" name="subir-rendimiento" value="<?php echo $rendimiento_total; ?>">
            <input type="hidden" name="subir-preguntas" value=" <?php echo htmlspecialchars(json_encode($preguntas)) ;?> ">
        </form>
        <div id="subir-form">
            <button id="btn-subir" type="submit" form="subir-form" name="subir-bd">Subir</button>
        </div>

    </div>

</body>

<footer>

    <p>Pie de página</p>

</footer>


</html>