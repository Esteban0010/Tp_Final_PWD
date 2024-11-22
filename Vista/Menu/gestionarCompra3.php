<?php
include_once ('../Estructura/HeaderSeguro.php');

?>


<?php

$abmCompraEstado = new ABMCompraEstado();

// Obtener todas las compras
$compras = $abmCompraEstado->buscar(null);

// Verificar que haya compras
if (count($compras) > 0) {
echo '<div class="container mt-5">
    <h3 class="text-primary text-center">Depósito</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Compra</th>
                    <th>Estado Actual</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Detalles de Productos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';

                foreach ($compras as $compra) {
                $idCompraEstado = $compra->getIdCompraEstado();
                $estadoActual = $compra->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
                $fechaInicio = $compra->getCeFechaIni();
                $fechaFin = $compra->getCeFechaFin();

                // Pasar el estado número a texto
                $estadoTexto = '';
                switch ($estadoActual) {
                case 1:
                $estadoTexto = 'Iniciada';
                break;
                case 2:
                $estadoTexto = 'Aceptada';
                break;
                case 3:
                $estadoTexto = 'Enviada';
                break;
                case 4:
                $estadoTexto = 'Cancelada';
                break;
                }

                // Determinar si hay que deshabilitar los botones
                $disabledAceptar = $estadoActual >= 2 ? 'disabled' : '';
                $disabledEnviar = $estadoActual >= 3 ? 'disabled' : '';
                $disabledCancelar = $estadoActual == 4 ? 'disabled' : '';

                echo "<tr>
                    <td>{$idCompraEstado}</td>
                    <td>{$estadoTexto}</td>
                    <td>{$fechaInicio}</td>
                    <td>{$fechaFin}</td>
                    <td>";

                        // Obtener los productos asociados a esta compra
                        $abmCompraItem = new AbmCompraItem();
                        $listaCompraItem = $abmCompraItem->buscar(['idcompra' => $idCompraEstado]);

                        if ($listaCompraItem) {
                        $itemsHtml = '<table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Detalle</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>';

                                $total = 0;
                                foreach ($listaCompraItem as $compraItem) {
                                $idProducto['idproducto'] = $compraItem->getObjProducto()->getIdProducto();
                                $producto = (new AbmProducto())->buscar($idProducto)[0];

                                $itemsHtml .= '<tr>
                                    <td><img src="' . $producto->getProArchivo() . '" alt="Imagen" style="width:50px;">
                                    </td>
                                    <td>' . $producto->getProNombre() . '</td>
                                    <td>' . $producto->getProDetalle() . '</td>
                                    <td>' . $compraItem->getCantidad() . '</td>
                                    <td>$' . number_format($producto->getValor(), 2) . '</td>
                                </tr>';
                                $total += $producto->getValor() * $compraItem->getCantidad();
                                }

                                $itemsHtml .= '<tr>
                                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                    <td>$' . number_format($total, 2) . '</td>
                                </tr>';
                                $itemsHtml .= '</tbody>
                        </table>';
                        } else {
                        $itemsHtml = '<p>No hay productos asociados a esta compra.</p>';
                        }

                        echo $itemsHtml . "</td>
                    <td>
                        <button class='btn btn-primary btn-sm change-state' data-id='{$idCompraEstado}' data-state='2'
                            {$disabledAceptar}>Aceptar</button>
                        <button class='btn btn-warning btn-sm change-state' data-id='{$idCompraEstado}' data-state='3'
                            {$disabledEnviar}>Enviar</button>
                        <button class='btn btn-danger btn-sm change-state' data-id='{$idCompraEstado}' data-state='4'
                            {$disabledCancelar}>Cancelar</button>
                    </td>
                </tr>";
                }

                echo '</tbody>
        </table>
    </div>
    <!-- Contenedor para mensajes dinámicos -->
    <div id="mensaje" class="my-3"></div>
</div>';
} else {
echo '<div class="container">
    <p>No hay compras registradas.</p>
</div>';
}
?>

<script src="Js/gestionarcompra.js"></script>

<?php
include_once('../Estructura/Footer.php');
?>