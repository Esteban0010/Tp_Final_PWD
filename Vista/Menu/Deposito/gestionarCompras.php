<?php
include_once("../../../configuracion.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Compras</title>

    <!-- css bootstrap 5 -->
    <link href="../../Asets/librerias/bootstrap-5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- js bootstrap 5 -->
    <script src="../../Asets/librerias/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jquery-easyui -->
    <link rel="stylesheet" type="text/css" href="../../Asets/librerias/jquery-easyui-1.11.0/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../../Asets/librerias/jquery-easyui-1.11.0/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../../Asets/librerias/jquery-easyui-1.11.0/themes/color.css">
    <script type="text/javascript" src="../../Asets/librerias/jquery-easyui-1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="../../Asets/librerias/jquery-easyui-1.11.0/jquery.easyui.min.js"></script>
</head>

<body>
    <div class="container mt-4 mb-4">
        <h1 class="text-center mb-4">Listado de Compras</h1>

        <?php
    $objAbmCompra = new AbmCompra();
    $objAbmEstado = new AbmCompraEstado();
    $objCompraItem = new AbmCompraItem();
    $objProducto = new AbmProducto();
    $listaCompra = $objAbmCompra->buscar(null);

    if (count($listaCompra) > 0) {
        echo '<table id="dg" class="table table-bordered table-striped" style="width:100%;">';
        echo '<thead class="table-dark">
                <tr>
                    <th>ID Compra</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Productos</th>
                    <th>Acciones</th>
                </tr>
              </thead>';
        echo '<tbody>';

        foreach ($listaCompra as $objCompra) {
            $idCompra['idcompra'] = $objCompra->getIdCompra();
            $estadoCompra = $objAbmEstado->buscar($idCompra);
            $tipoEstado = 'Sin estado';

            // Buscar estado actual
            foreach ($estadoCompra as $estado) {
                if ($estado->getCeFechaFin() === '0000-00-00 00:00:00') {
                    $tipoEstado = $estado->getObjCompraEstadoTipo()->getCetDescripcion();
                    break;
                }
            }

            // Obtener productos de la compra
            $listaCompraItem = $objCompraItem->buscar($idCompra);
            $itemsHtml = '';
            $total = 0;

            if (count($listaCompraItem) > 0) {
                $itemsHtml = '<table class="table table-sm">';
                $itemsHtml .= '<thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Detalle</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>
                              </thead>';
                $itemsHtml .= '<tbody>';

                foreach ($listaCompraItem as $compraItem) {
                    $idProducto['idproducto'] = $compraItem->getObjProducto()->getIdProducto();
                    $producto = $objProducto->buscar($idProducto)[0];

                    $itemsHtml .= '<tr>
                                    <td><img src="' . $producto->getProArchivo() . '" alt="Imagen" style="width:50px;"></td>
                                    <td>' . $producto->getProNombre() . '</td>
                                    <td>' . $producto->getProDetalle() . '</td>
                                    <td>' . $compraItem->getCantidad() . '</td>
                                    <td>$' . number_format($producto->getValor(), 2) . '</td>
                                   </tr>';
                    $total += $producto->getValor() * $compraItem->getCantidad();
                }

                $itemsHtml .= '<tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong>$' . number_format($total, 2) . '</strong></td>
                              </tr>';
                $itemsHtml .= '</tbody></table>';
            } else {
                $itemsHtml = '<div class="text-muted">No hay productos asociados a esta compra.</div>';
            }

            // Acciones según estado
            $accionesHtml = '';
            if ($tipoEstado == 'iniciada') {
                $accionesHtml = '<a href="action/aceptarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="btn btn-success btn-sm">Aceptar</a>
                                 <a href="action/cancelarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="btn btn-danger btn-sm">Cancelar</a>';
            } elseif ($tipoEstado == 'aceptada') {
                $accionesHtml = '<a href="action/enviarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="btn btn-primary btn-sm">Enviar</a>
                                 <a href="action/cancelarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="btn btn-danger btn-sm">Cancelar</a>';
            } elseif ($tipoEstado == 'enviada') {
                $accionesHtml = '<span class="badge bg-info">Enviada</span>';
            } elseif ($tipoEstado == 'cancelada') {
                $accionesHtml = '<span class="badge bg-danger">Cancelada</span>';
            }

            echo '<tr>
                    <td>' . $objCompra->getIdCompra() . '</td>
                    <td>' . $objCompra->getCoFecha() . '</td>
                    <td>' . ucfirst($tipoEstado) . '</td>
                    <td>' . $itemsHtml . '</td>
                    <td>' . $accionesHtml . '</td>
                  </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info text-center">No se encontraron compras registradas.</div>';
    }
    ?>
    </div>
</body>