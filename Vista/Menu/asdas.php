<?php
 include_once('../../configuracion.php');
 
 header('Content-Type: application/json');

 
 $datos = data_submitted();


 if (!empty($datos['idCompraEstado']) && !empty($datos['estado'])) {
   $idCompraEstado = $datos['idCompraEstado'];
   $nuevoEstado = $datos['estado'];

   $abmCompraEstado = new AbmCompraEstado();
   

   $compraEstado = $abmCompraEstado->buscar(['idcompraestado' => $idCompraEstado])[0];

   

   //verEstructura($compraEstado);

   if ($compraEstado) {
    $fechaInicial = $compraEstado->getCeFechaFin();
    $idCompraEstado = $compraEstado->getIdCompraEstado();
    
     $estadoActual = $compraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();

         // Si el estado actual es '1' y el nuevo estado es '2' o '4'
     if (($estadoActual == 1 && in_array($nuevoEstado, [2, 4])) ||
        // Si el estado actual es '2' y el nuevo estado es '3' 
       ($estadoActual == 2 && $nuevoEstado == 3) ||
       // Si el nuevo estado es '4', independientemente del estado actual             
       ($nuevoEstado == 4)
     ) {                                

       $fechaActual = date('Y-m-d H:i:s');
       $compraEstado->getObjCompraEstadoTipo()->setIdCompraEstadoTipo($nuevoEstado);
       
       $compraEstado->setCeFechaFin($fechaActual);
       $modificandoFechaFin = $compraEstado->modificar($idCompraEstado);

       if ($modificandoFechaFin){

        $insertar = $compraEstado->alta($idCompraEstado);

       
       }

       if ($insertar){
        $compraEstado->setCeFechaIni($fechaInicial);
        $compraEstado->setCeFechaFin(null);
        $modificar = $compraEstado->modificar($idCompraEstado);
       }
      
       
       if($modificar){
        
        $respuesta = [
            "mensaje" => "Cambio Exitoso",
            "fechaFin" => $fechaActual // Devuelve la nueva fecha fin
        ];
        echo json_encode($respuesta);
        exit;
    }
  
      
     } 
   } else {
     echo "Estado de la compra no encontrado.";
   }
 } else {
   echo "Datos no validos.";
 }


 