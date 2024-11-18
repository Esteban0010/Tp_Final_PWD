<?php
include_once("../../configuracion.php");
include_once("../Estructura/HeaderSeguro.php");

?>


<div class="container mt-4 mb-4">
    <?php
    $objAbmCompra = new AbmCompra();
    $objAbmEstado = new AbmCompraEstado();
    $listaCompra = $objAbmCompra->buscar(null);

    if (count($listaCompra) > 0) {
        echo '<table id="dg" class="easyui-datagrid" title="Listado de Compras" style="width:100%;height:auto;" 
              data-options="singleSelect:true,collapsible:true, url:\'#\',method:\'get\',pagination:true">';
        echo '<thead>
                <tr>
                    <th field="idcompra" width="10%" align="center">ID DE COMPRA</th>
                    <th field="fecha" width="15%" align="center">FECHA</th>
                    <th field="estado" width="15%" align="center">ESTADO DE COMPRA</th>
                    <th field="items" width="30%" align="center">ITEMS</th>
                    <th field="opciones" width="30%" align="center">OPCIONES DE COMPRA</th>
                </tr>
              </thead>';
        echo '<tbody>';
        foreach ($listaCompra as $objCompra) {
            $idCompra['idcompra'] = $objCompra->getIdCompra();
            $estadoCompra = $objAbmEstado->buscar($idCompra);

            if (count($estadoCompra) > 0) {
                $resp = false;
                $j = 0;
                $tipoEstado = '';
                while ($j < count($estadoCompra) && $resp == false) {
                    $fechafin = $estadoCompra[$j]->getCeFechaFin();
                    if ($fechafin == '0000-00-00 00:00:00') {
                        $tipoEstado = $estadoCompra[$j]->getObjCompraEstadoTipo()->getDescripcion();
                        $resp = true;
                    }
                    $j++;
                }

                // Construir filas para la tabla con EasyUI
                $estadoHtml = '';
                if ($tipoEstado == "iniciada") {
                    $estadoHtml = '<span class="easyui-linkbutton" data-options="iconCls:\'icon-add\'">Iniciada</span>';
                } else if ($tipoEstado == "aceptada") {
                    $estadoHtml = '<span class="easyui-linkbutton" data-options="iconCls:\'icon-ok\'">Aceptada</span>';
                } else if ($tipoEstado == "enviada") {
                    $estadoHtml = '<span class="easyui-linkbutton" data-options="iconCls:\'icon-send\'">Enviada</span>';
                } else {
                    $estadoHtml = '<span class="easyui-linkbutton" data-options="iconCls:\'icon-remove\'">Cancelada</span>';
                }

                // Mostrar productos
                $itemsHtml = '';
                $total = 0;
                $objCompraItem = new AbmCompraItem();
                $objProducto = new AbmProducto();
                $listaCompraItem = $objCompraItem->buscar($idCompra);
                
                if (count($listaCompraItem) > 0) {
                    foreach ($listaCompraItem as $objCompraItem) {
                        $idProducto['idproducto'] = $objCompraItem->getObjProducto()->getIdProducto();
                        $busquedaProducto = $objProducto->buscar($idProducto);
                        $producto = $busquedaProducto[0];
                        $total += $producto->getProDetalle() * $objCompraItem->getCiCantidad();

                        $itemsHtml .= '<tr>
                                        <td><img src="' . $producto->getImagenProducto() . '" width="60px"></td>
                                        <td>' . $producto->getProNombre() . '</td>
                                        <td>$' . $producto->getProDetalle() . '</td>
                                        <td>' . $objCompraItem->getCiCantidad() . '</td>';
                        if ($tipoEstado != "cancelada") {
                            $itemsHtml .= '<td><a href="action/eliminarArticuloCompra.php?idcompraitem=' . $objCompraItem->getIdCompraItem() . '" class="easyui-linkbutton" data-options="iconCls:\'icon-remove\'">Quitar Producto</a></td>';
                        } else {
                            $itemsHtml .= '<td>Sin Acción</td>';
                        }
                        $itemsHtml .= '</tr>';
                    }
                    $itemsHtml .= '<tr><td colspan="5" class="robotoBold">Total: $' . $total . '</td></tr>';
                }

                echo '<tr>
                        <td>' . $objCompra->getIdCompra() . '</td>
                        <td>' . $objCompra->getCoFecha() . '</td>
                        <td>' . $estadoHtml . '</td>
                        <td><table class="table">' . $itemsHtml . '</table></td>
                        <td>';

                if ($tipoEstado == 'iniciada') {
                    echo '<div><a href="action/aceptarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="easyui-linkbutton" data-options="iconCls:\'icon-ok\'">Aceptar Compra</a>
                          <a href="action/cancelarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="easyui-linkbutton" data-options="iconCls:\'icon-remove\'">Cancelar Compra</a></div>';
                } elseif ($tipoEstado == 'aceptada') {
                    echo '<div><a href="action/enviarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="easyui-linkbutton" data-options="iconCls:\'icon-send\'">Enviar Compra</a>
                          <a href="action/cancelarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="easyui-linkbutton" data-options="iconCls:\'icon-remove\'">Cancelar Compra</a></div>';
                } elseif ($tipoEstado == 'enviada') {
                    echo '<div><a href="action/cancelarCompra.php?idcompra=' . $objCompra->getIdCompra() . '" class="easyui-linkbutton" data-options="iconCls:\'icon-remove\'">Cancelar Compra</a></div>';
                } elseif ($tipoEstado == 'cancelada') {
                    echo 'CANCELADA';
                }

                echo '</td>
                      </tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<div class="container mt-5 mb-5">';
        echo '<div class="row justify-content-center">';
        echo '<div class="col-md-6">';
        echo '<div class="card p-5">';
        echo '<div class="alert alert-info" role="alert">No se encontraron compras.</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>


<?php
include_once("../Estructura/Footer.php");
?>
