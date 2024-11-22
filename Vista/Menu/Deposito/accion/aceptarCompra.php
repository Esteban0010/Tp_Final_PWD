<?php

include_once("../../../../configuracion.php");
$datos=data_submitted();

if (isset($datos['idcompra'])) {
    $idcompra = intval($datos['idcompra']);
    $objAbmEstado = new AbmCompraEstado();

    // Buscar el estado actual
    $idCompra['idcompra'] = $idcompra;
    $estadoActual = $objAbmEstado->buscar($idCompra);

    foreach ($estadoActual as $estado) {
        if ($estado->getCeFechaFin() === '0000-00-00 00:00:00') {
            // Finalizar el estado actual
            $estado->setCeFechaFin(date('Y-m-d H:i:s'));
            $objAbmEstado->modificar($estado);

            // Crear nuevo estado "aceptada"
            $nuevoEstado = [
                'idcompra' => $idcompra,
                'idcompraestadotipo' => 2, // ID del estado "aceptada" en la tabla `compra_estado_tipo`
                'cefechaini' => date('Y-m-d H:i:s'),
                'cefechafin' => '0000-00-00 00:00:00'
            ];
            $objAbmEstado->alta($nuevoEstado);

            header("Location: ../listadoCompras.php?msg=Compra aceptada con éxito");
            exit;
        }
    }
}
header("Location: ../listadoCompras.php?msg=Error al aceptar la compra");
exit;