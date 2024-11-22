<?php
 include_once('../../../configuracion.php');
 
 header('Content-Type: application/json');

 
 $datos = data_submitted();
 //verEstructura($datos);

 if (!empty($datos['idCompraEstado']) && !empty($datos['estado'])) {
   $idCompraEstado = $datos['idCompraEstado'];
   $nuevoEstado = $datos['estado'];

   $abmCompraEstado = new AbmCompraEstado();
   $abmCompra = new AbmCompra();
   $abmUsuario = new AbmUsuario();


   $compraEstado = $abmCompraEstado->buscar(['idcompraestado' => $idCompraEstado])[0];

   //verEstructura($compraEstado);

   if ($compraEstado) {
     
     $estadoActual = $compraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();

   
     if (($estadoActual == 1 && in_array($nuevoEstado, [2, 4])) || 
       ($estadoActual == 2 && $nuevoEstado == 3) ||             
       ($nuevoEstado == 4)
     ) {                                

      $fechaActual = date('Y-m-d H:i:s');
       $compraEstado->getObjCompraEstadoTipo()->setIdCompraEstadoTipo($nuevoEstado);
       $compraEstado->setCeFechaFin($fechaActual);
       
       if($compraEstado->modificar()){
        
        $respuesta = [
            "mensaje" => "Cambio Exitoso",
            "fechaFin" => $fechaActual // Devuelve la nueva fecha fin
        ];
        echo json_encode($respuesta);
        exit;
    }
      //  $idCompra = $compraEstado->getIdCompra(); 
      //  $compra = $abmCompra->buscar(['idcompra' => $idCompra])[0]; 

      //  if ($compra) {
      //    $idUsuario = $compra->getId(); 
      //    $usuario = $abmUsuario->buscar(['idusuario' => $idUsuario])[0];

       
      //  } else {
      //    echo "Compra no encontrada.";
      //  }
     } else {
       echo "Cambio de estado no permitido.";
     }
   } else {
     echo "Estado de la compra no encontrado.";
   }
 } else {
   echo "Datos inválidos.";
 }


 