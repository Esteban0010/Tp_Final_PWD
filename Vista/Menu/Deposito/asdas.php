<?php
//include_once ('../../../configuracion.php');
include_once ('../../Estructura/HeaderSeguro.php');
?>

<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Compras</title>

     //css bootstrap 5 
    <link href="../../Asets/librerias/bootstrap-5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    //js bootstrap 5 
    <script src="../../Asets/librerias/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    //jquery-easyui 
    <link rel="stylesheet" type="text/css" href="../../Asets/librerias/jquery-easyui-1.11.0/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../../Asets/librerias/jquery-easyui-1.11.0/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../../Asets/librerias/jquery-easyui-1.11.0/themes/color.css">
    <script type="text/javascript" src="../../Asets/librerias/jquery-easyui-1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="../../Asets/librerias/jquery-easyui-1.11.0/jquery.easyui.min.js"></script>
</head> -->

<?php



$abmCompraEstado = new ABMCompraEstado();

//obtener todas las comrpas
$compras = $abmCompraEstado->buscar(null);

//verificar q haya compras
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';

                foreach ($compras as $compra) {
                $idCompraEstado = $compra->getIdCompraEstado();
                $estadoActual = $compra->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
                $fechaInicio = $compra->getCeFechaIni();
                $fechaFin = $compra->getCeFechaFin(); 

                //pasar el estado numero a texto
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

                //determinar si hay q deshabilitar los botnes
                $disabledAceptar = $estadoActual >= 2 ? 'disabled' : '';
                $disabledEnviar = $estadoActual >= 3 ? 'disabled' : '';
                $disabledCancelar = $estadoActual == 4 ? 'disabled' : '';

                echo "<tr>
                    <td>{$idCompraEstado}</td>
                    <td>{$estadoTexto}</td>
                    <td>{$fechaInicio}</td>
                    <td>{$fechaFin}</td>
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
include_once('../../estructura/footer.php');
?>