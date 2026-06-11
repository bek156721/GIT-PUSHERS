<?php
$conexion = mysqli_connect("localhost", "root", "", "sec_ete_db");
$id_grupo_usuario = 1;

$sql = "SELECT titulo, descripcion, fecha, modulo, url FROM material WHERE id_grupo = $id_grupo_usuario";

$resultado = mysqli_query($conexion, $sql);
$materiales ;
$incremento = 0;
while ($fila = mysqli_fetch_assoc($resultado)) 
{
    $materiales[$incremento][0] = $fila['modulo'];
    $materiales[$incremento][1] = $fila['titulo'];
    $materiales[$incremento][2] = $fila['descripcion'];
    $materiales[$incremento][3] = $fila['fecha'];
    $materiales[$incremento][4] = $fila['url'];
    $incremento++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../statics/css/vista-materiales.css">
    <title>Materiales</title>
</head>
<body>
    <div id="cont-ventana">
        <input type="checkbox" id="menu-toggle" class="menu-checkbox">
        <header>
            <div class="navbar">
                <label for="menu-toggle" class="btn-hamburguesa">☰</label>
            </div>
            <h1>Prepa 6</h1>
        </header>
        <aside class="menu-lateral">
            <ul>
                <li><a href="#">ACTIVIDADES →</a></li>
                <li><a href="#">FORMULARIO DE EVALUACIÓN →</a></li>
                <li><a href="#">RECURSOS DE APOYO →</a></li>
                <li><a href="#">LOL →</a></li>
                <li><a href="#">PROYECTOS ANTERIORES →</a></li>
            </ul>
        </aside>
        <section id="cont-principal">
            <div id="cont-circul">
                <aside id="perfil">

                </aside>
                <aside id="cerrar-sesion">

                </aside>
            </div>
            <h2> MATERIALES </h2>
            <br>
            <aside id="cont-materiales">
                <?php
                    if ($resultado) 
                    {
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 1</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 1)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 2</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 2)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 3</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 3)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 4</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 4)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                        echo '<details id="cont-modul">';
                        echo '<summary> MODULO 5</summary>';
                        for ($i=0;$i<$incremento;$i++) 
                        {
                            if($materiales[$i][0] == 5)
                            {
                                echo '<div id="cont-link">';
                                echo "<h3>".$materiales[$i][1]."</h3>"; // título
                                echo "<p>".$materiales[$i][2]."</p>";   // descripción
                                echo "<p><strong>Fecha:</strong> ".$materiales[$i][3]."</p>"; // fecha
                                echo "<a href='".$materiales[$i][4]."' target='_blank'>Ver recurso</a>"; // enlace
                                echo '</div>';
                            }
                        }
                        echo "</details>";
                    } 
                ?>
            </aside>
        </section>
        <footer>
            <p>ns que va aquí jsjs</p>
        </footer>
    </div>
    </footer>
</body>
</html>