<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
$datos = data_submitted();
$objControl = new AbmProducto();
$List_Producto = $objControl->buscar(null);
//verEstructura($List_Producto);
//verEstructura($datos);
?>
    <h1>Productos</h1>

    <?php
    //echo "<div>" . count($List_Producto) ."</div>";

    if (count($List_Producto) > 0) {
        echo "<div id=\"cc\" class=\"easyui-layout\" style=\"width:100%; min-height:300px; overflow:auto;\">"; // Cambié el height a min-height

        // Contenedor con clases Bootstrap
        echo "<div class=\"container-fluid p-2\" style=\"background:#fff;\">";

        echo "<div class=\"row justify-content-center g-3\">"; // Fila con espaciado entre tarjetas

        foreach ($List_Producto as $objProducto) {
            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">'; // Cada tarjeta ocupa 1/4 en pantallas grandes
            echo '<div id="card" name="card" class="card text-center border-dark h-100">';
            echo '<div class="card-body">';
            echo '<span class="card-title" value="' . $objProducto->getIdProducto() . '">' . $objProducto->getIdProducto() . '</span><br>';
            echo '<span class="card-subtitle mb-2 text-muted">' . $objProducto->getProNombre() . '</span><br>';
            echo '<span class="card-text">' . $objProducto->getProDetalle() . '</span><br>';
            echo '<span class="card-text">' . $objProducto->getProCantStock() . '</span><br>';
            echo '<span class="card-text">' . $objProducto->getValor() . '</span><br>';
            echo '<button class="btn btn-primary mt-2">Comprar Producto</button>';
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        echo "</div>"; // Cierra la fila
        echo "</div>"; // Cierra el contenedor
        echo "</div>"; // Cierra la capa de EasyUI


    } else {
        echo "<div> No Hay Productos Cargados</div>"; // no hay productos cargados
    }
    ?>

    <script type="text/javascript"></script>

<?php
include_once "../Estructura/Footer.php";
?>
<!-- 
El carácter \' en PHP se utiliza para escapar comillas simples dentro de una cadena delimitada por comillas simples. Esto le dice al intérprete de PHP que esa comilla simple no marca el final de la cadena, sino que es parte del contenido de la misma.

echo 'It\'s a beautiful day!';
// Salida: It's a beautiful day!

¿Por qué es necesario?
Cuando defines una cadena en PHP usando comillas simples ('), cualquier otra comilla simple dentro de esa cadena se interpretará como el final de la misma. Si no la escapas, obtendrás un error de sintaxis.

Sin escapar:
php:
echo 'It's a beautiful day!';
// Error: syntax error, unexpected 's' (T_STRING)

Con escapar:
php:
echo 'It\'s a beautiful day!';
// Salida: It's a beautiful day!

Escapando en HTML:
En tu caso, el atributo data-options contiene una estructura como esta:
html:
data-options='region:'center''

Aquí, el segundo par de comillas simples ('center') entra en conflicto con las comillas simples externas de data-options. Para solucionarlo, escapamos las comillas internas:

php:
echo "<div data-options='region:\'center\''></div>";
Esto produce un HTML válido para que EasyUI pueda interpretarlo correctamente:

html:
<div data-options='region:'center''></div>

Resumen:
\' es usado para incluir comillas simples dentro de cadenas delimitadas por comillas simples.
Ayuda a evitar conflictos de sintaxis y errores en el código.
-->

</html>