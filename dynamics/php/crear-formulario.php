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
    <div id="creacion">
        <h2>Caracteristicas</h2>

        <form>
            <p>Titulo del formulario <input class="in-texto" type="text" name="nombre-formulario" size="250"></p>

            <p>Descripcion del formulario <input class="in-texto" type="text" name="descripcion-formulario" size="250"></p>
            <div id="in-modulos">
                <p>
                    Modulo del formulario
                    <input class="r-modulo" type="radio" name="modulo" id="m1">
                    <label class="l-modulo" for="m1">Modulo-1</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m2">
                    <label class="l-modulo" for="m2">Modulo-2</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m3">
                    <label class="l-modulo" for="m3">Modulo-3</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m4">
                    <label class="l-modulo" for="m4">Modulo-4</label>
                    <input class="r-modulo" type="radio" name="modulo" id="m5">
                    <label class="l-modulo" for="m5">Modulo-5</label>
                </p>
            </div>
            <div id="in-grupos">
                <p>
                    Grupo
                    <input class="r-grupo" type="radio" name="grupo" id="g1">
                    <label id class="l-grupo" for="g1">61B</label>
                    <input class="r-grupo" type="radio" name="grupo" id="g2">
                    <label class="l-grupo" for="g2">61D</label>
                </p>
            </div>
        </form>

        <h3>Preguntas</h3>

        <p>Pregunta</p>

        <p>Tipo de pregunta</p>

        <!--
        <p>Respuesta</p>
            <p class="respuesta-correcta">Respuesta correcta<p>

        <p>Respuesta</p>
            <p class="respuesta-correcta">Respuesta correcta<p>
        
        <p>Respuesta</p>
            <p class="respuesta-correcta">Respuesta correcta<p>
        
        <p>Respuesta</p>
            <p class="respuesta-correcta">Respuesta correcta<p>
        -->

        
        <div id="agregar-pregunta">
            <a id="btn-agregar" href="./crear-formulario.php">Agregar pregunta</a>
        </div>

        <h4>Vista previa de las preguntas</h3>
        <div id="alineacion-vista">
            <div id="vista-previa">
                <br>
            </div>
        </div>
        <div id="subir-form">
            <a id="btn-subir" href="./subir-form.php">Subir</a>
        </div>

    </div>

</body>

<footer>

    <p>Pie de página</p>

</footer>


</html>