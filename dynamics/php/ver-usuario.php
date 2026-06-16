
<?php
    include 'conexion.php';
    if(isset($_GET['id_alumno']))
    {
        $id_alumno = $_GET['id_alumno'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pagina para ver a los alumnos">
    <meta name="author" content="git pushers (Equipo 7)">
    <link rel="stylesheet" href="../../statics/css/estilo-ver-usuario.css">
    <link rel="stylesheet" href="../../statics/css/header.css"> <!-- css de Encabezado -->
    <link rel="stylesheet" href="../../statics/css/footer.css"> <!-- css de Pie de página -->
    <title>Pagina de inicio</title>

</head>

    
<body>
    <?php include 'header.php'; ?>
    <p id = "titulo-pagina" >Consultar perfil</p>
    <p class="mini-titulo">Datos</p>
    <?php 
        $sql = "SELECT id_grupo, nombre_alumno, primer_apellido_alumno, segundo_apellido_alumno FROM alumno WHERE id_alumno = '".$id_alumno."'";
        $query = mysqli_query($conexion, $sql);
        $datos_alumno = mysqli_fetch_assoc($query);
        if($datos_alumno['id_grupo'] == 1)
            $grupo_alumno = "61B";
        else
            $grupo_alumno = "61D";
    ?>
    <p class="datos-alumno">No. Cuenta : <?php echo $id_alumno?></p>
    <p class="datos-alumno">Grupo : <?php echo $grupo_alumno?></p>
    <p class="datos-alumno">Nombre : <?php echo $datos_alumno['nombre_alumno']?></p>
    <p class="datos-alumno">Primer apellido : <?php echo $datos_alumno['primer_apellido_alumno']?></p>
    <p class="datos-alumno">Segundo apellido : <?php echo $datos_alumno['segundo_apellido_alumno']?></p>

    <p class="mini-titulo">Perfil</p>
    <?php
        $sql_2 = "SELECT pregunta, id_pregunta, puntaje_rendimiento, id_tipo_pregunta FROM pregunta WHERE id_formulario = '1'";
        $query_2 = mysqli_query($conexion, $sql_2);
        while($pregunta_formulario = mysqli_fetch_assoc($query_2))
        {
            echo "<p class='pregunta-formulario'>".htmlspecialchars($pregunta_formulario['pregunta'])." Rendimiento : ".$pregunta_formulario['puntaje_rendimiento']."</p>";
            $sql_3 = "SELECT id_opcion_pregunta, texto_respuesta FROM respuesta_alumno WHERE id_formulario = '1' and id_pregunta = '".$pregunta_formulario['id_pregunta']."' ";
            $query_3 = mysqli_query($conexion, $sql_3);
            while($id_respuesta_pregunta = mysqli_fetch_assoc($query_3))
            {
                if($pregunta_formulario['id_tipo_pregunta'] == 3)
                {
                    echo "<p class='respuesta-formulario'>".htmlspecialchars($id_respuesta_pregunta['texto_respuesta'])."</p>";
                }
                else
                {
                    $sql_4 = "SELECT opcion, puntaje_opcion FROM opcion_pregunta WHERE id_opcion_pregunta = '".$id_respuesta_pregunta['id_opcion_pregunta']."'";
                    $query_4 = mysqli_query($conexion, $sql_4);
                    while($respuesta = mysqli_fetch_assoc($query_4))
                    {
                        echo "<p class='respuesta-formulario'>".htmlspecialchars($respuesta['opcion'])." Puntaje : ".$respuesta['puntaje_opcion']."</p>";
                    }
                }
            }
        }
    ?>



<footer>
    <?php include'footer.php';?>
</footer>



</body>

</html>