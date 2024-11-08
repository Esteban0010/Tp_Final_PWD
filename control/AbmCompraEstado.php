<?php
class AbmCompraEstado{

     /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjeto($param){
        //print_r($param);
        $obj = null;
        if( array_key_exists('idcompraestado',$param) and array_key_exists('idcompra',$param)     
          and array_key_exists('idcompraestadotipo',$param) and array_key_exists('cefechaini',$param) and array_key_exists('cefechafin',$param)){
        
            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
            $objCompra->cargar();
            $objTipoEstado = new CompraEstadoTipo();
            $objTipoEstado->setIdCompraEstadoTipo($param['idcompraestadotipo']);
            $objTipoEstado->cargar();

            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], $objCompra,$objTipoEstado,$param['cefechaini'],$param['cefechafin']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     *  que son claves
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if(isset($param['idcompraestado']) ){
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'],null,null,null,null);
        }
        return $obj;
    }


     /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idcompraestado']))
            $resp = true;
        return $resp;
    }


    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $unObjCompraEstado = $this->cargarObjeto($param);
        if ($unObjCompraEstado!=null && $unObjCompraEstado->insertar()){
            $resp = true;
        }
        return $resp;
        
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $unObjCompraEstado = $this->cargarObjetoConClave($param);
            if ($unObjCompraEstado!=null && $unObjCompraEstado->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificar($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $unObjCompraEstado = $this->cargarObjeto($param);
            if($unObjCompraEstado!=null && $unObjCompraEstado->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
   /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>null){
            if  (isset($param['idcompraestado']))
                $where.=" and idcompraestado ='".$param['idcompraestado']."'";
            if  (isset($param['idcompra']))
                $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['idcompraestadotipo']))
                $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";
            if  (isset($param['cefechaini']))
                $where.=" and cefechaini ='".$param['cefechaini']."'";
            if  (isset($param['cefechafin']))
                $where.=" and cefechafin ='".$param['cefechafin']."'";
        }
        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }


    

    /**
     * Recibe el id(un numero no array) del usuario y coloca la compra en el estado Iniciada
     */
    public function pagarCompra($idusuario){
        $resp = false;
        $objCompra = new AbmCompra();
        $arayCompra = $objCompra->buscarCarrito($idusuario);//array
        //verEstructura($arayCompra);
        $compra = $arayCompra[0];//objCompra
        //verEstructura($compra);
        $fecha['idcompra'] = $compra->getIdCompra();
        $fecha['cofecha'] = date('Y-m-d H:i:s');
        $fecha['idusuario'] = $compra->getObjUsuario()->getIdUsuario();
        verEstructura($fecha);
        $compraExitosa = $objCompra->modificar($fecha);
       /*  $ItemComprados = new AbmCompraItem();
        $idCompra['idcompra'] = $fecha['idcompra'];
        $listaItems = $ItemComprados->buscar($idCompra);
        verEstructura($listaItems);
         //se modifica el stock en a base de datos, mover para deposito
        $objProducto = new AbmProducto();
       
        for ($i = 0; $i < count($listaItems); $i++){
            $idUnItem['idproducto'] = $listaItems[$i]->getObjProducto()->getIdProducto();//id del item a comprar
            //echo $idUnItem."<br>";
            $productoGondola = $objProducto->buscar($idUnItem);
            verEstructura($productoGondola);
            $cantLlevar = $listaItems[$i]->getCiCantidad();
            $stockGondola = $productoGondola[0]->getProCantstock();
            $nuevoStock = $stockGondola - $cantLlevar;
            $datosProductos['idproducto'] = $productoGondola[0]->getIdProducto();
            $datosProductos['pronombre'] = $productoGondola[0]->getProNombre();
            $datosProductos['prodetalle'] = $productoGondola[0]->getProDetalle();
            $datosProductos['procantstock'] = $nuevoStock;
            $datosProductos['tipo'] = $productoGondola[0]->getTipo();
            $datosProductos['imagenproducto'] = $productoGondola[0]->getImagenProducto();
            $objProducto->modificar($datosProductos);
        } */

        if($compraExitosa){
            $objEstado = new AbmCompraEstado();
            $param['idcompraestado'] = 0;
            $param['idcompra'] = $compra->getIdCompra();
            $param['idcompraestadotipo'] = 1;
            $param['cefechaini'] = date('Y-m-d H:i:s');
            $param['cefechafin'] = null;
            $exito = $objEstado->alta($param);
            $resp = true;
            if($exito){
                $nuevaCompra = new AbmCompra();
                $aux['idcompra'] = 0;
                $aux['cofecha'] = null;
                $aux['idusuario'] = $idusuario;
                $nuevaCompra->alta($aux);
                
               
            }else{
                echo "Algo fallo 2";
            }
        }else{
            echo "Algo fallo";
        }
        return $resp;

    }

    /**
     * Acepta una compra
     */
    public function aceptarCompra($datos){
        $resp = false;
        $objCompra = new AbmCompra();
        $arayCompra = $objCompra->buscar($datos);//array
        $compra = $arayCompra[0];//objCompra

        $objEstado = new AbmCompraEstado();
        $param['idcompra'] = $compra->getIdCompra();
        $param['idcompraestadotipo'] = 1;
        $param['cefechafin'] = null;
        $exito = $objEstado->buscar($param);

        if($exito){

            $ItemComprados = new AbmCompraItem();
            $idCompra['idcompra'] = $param['idcompra'];
            $listaItems = $ItemComprados->buscar($idCompra);
            //verEstructura($listaItems);
             //se modifica el stock en a base de datos, mover para deposito
            $objProducto = new AbmProducto();
           
            for ($i = 0; $i < count($listaItems); $i++){
                $idUnItem['idproducto'] = $listaItems[$i]->getObjProducto()->getIdProducto();//id del item a comprar
                //echo $idUnItem."<br>";
                $productoGondola = $objProducto->buscar($idUnItem);
                //verEstructura($productoGondola);
                $cantLlevar = $listaItems[$i]->getCiCantidad();
                $stockGondola = $productoGondola[0]->getProCantstock();
                $nuevoStock = $stockGondola - $cantLlevar;
                $datosProductos['idproducto'] = $productoGondola[0]->getIdProducto();
                $datosProductos['pronombre'] = $productoGondola[0]->getProNombre();
                $datosProductos['prodetalle'] = $productoGondola[0]->getProDetalle();
                $datosProductos['procantstock'] = $nuevoStock;
                $datosProductos['tipo'] = $productoGondola[0]->getTipo();
                $datosProductos['imagenproducto'] = $productoGondola[0]->getImagenProducto();
                $objProducto->modificar($datosProductos);
            }


            //modifico el estado inicial colocandole fecha fin
            $estado = $exito[0];
            $param['idcompraestado'] = $estado->getIdCompraEstado();
            $param['idcompra'] = $estado->getObjCompra()->getIdCompra();
            $param['idcompraestadotipo'] = $estado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
            $param['cefechaini'] = $estado->getCeFechaIni();
            $param['cefechafin'] = date('Y-m-d H:i:s');
            $objEstado->modificar($param);

            //creo el estado Aceptada con fecha de inicio
            $cancelado = new AbmCompraEstado();
            $param['idcompraestado'] = 0;
            $param['idcompra'] = $compra->getIdCompra();
            $param['idcompraestadotipo'] = 2;
            $param['cefechaini'] = date('Y-m-d H:i:s');
            $param['cefechafin'] = null;
            $exito = $cancelado->alta($param);
        
            //echo "Compra aceptada";
            $resp = true;
        }
        return $resp;
    }

    /**
     * Cambia el Estado A enviada
     */
    public function enviarCompra($datos){
        $resp = false;
        $objCompra = new AbmCompra();
        $arayCompra = $objCompra->buscar($datos);//array
        $compra = $arayCompra[0];//objCompra

            $objEstado = new AbmCompraEstado();
            //parametros de busqueda
            $param['idcompra'] = $compra->getIdCompra();
            $param['idcompraestadotipo'] = 2;
            $param['cefechafin'] = '0000-00-00 00:00:00';
            $exito = $objEstado->buscar($param);
            verEstructura($exito);

            if($exito){
                //modifico el estado inicial colocandole fecha fin
                $estado = $exito[0];
                $param['idcompraestado'] = $estado->getIdCompraEstado();
                $param['idcompra'] = $estado->getObjCompra()->getIdCompra();
                $param['idcompraestadotipo'] = $estado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
                $param['cefechaini'] = $estado->getCeFechaIni();
                $param['cefechafin'] = date('Y-m-d H:i:s');
                $objEstado->modificar($param);

                //creo el estado cancelada con fecha de inicio
                $cancelado = new AbmCompraEstado();
                $param['idcompraestado'] = 0;
                $param['idcompra'] = $compra->getIdCompra();
                $param['idcompraestadotipo'] = 3;
                $param['cefechaini'] = date('Y-m-d H:i:s');
                $param['cefechafin'] = null;
                $exito = $cancelado->alta($param);
                $resp = true;
            
                echo "Envio realizado";
            }else{
                echo "Algo fallo";
            }
            return $resp;
    }

    /**
     * Recibe un obj compraEstado, cancela una compra y devuelve el stock a su estado anterior
     */
    public function cancelarCompra($datos){
        $objEstado = new AbmCompraEstado();
        //Busco la compra que tenga fecha fin en '0000-00-00 00:00:00
        //el error era en como el buscar buscaba los datos(tenia cifechafin en ves de cefechafin)
        $busqueda['idcompra'] = $datos['idcompra'];
        $busqueda['cefechafin'] = '0000-00-00 00:00:00';
        $colEstado = $objEstado->buscar($busqueda);
        verEstructura($colEstado);
        
        //modifico el estado inicial colocandole fecha fin
        $estado = $colEstado[0];
        verEstructura($estado);
        $param['idcompraestado'] = $estado->getIdCompraEstado();
        $param['idcompra'] = $estado->getObjCompra()->getIdCompra();
        $param['idcompraestadotipo'] = $estado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $param['cefechaini'] = $estado->getCeFechaIni();
        $param['cefechafin'] = date('Y-m-d H:i:s');
        if($param['idcompraestadotipo'] != 1 ){
            echo "idcompraestadotipo es distinto de 1 <br>";
            $ItemComprados = new AbmCompraItem();
            $idCompra['idcompra'] = $estado->getObjCompra()->getIdCompra();;
            $listaItems = $ItemComprados->buscar($idCompra);
            //verEstructura($listaItems);
            $objProducto = new AbmProducto();
            //se modifica el stock en a base de datos
            for ($i = 0; $i < count($listaItems); $i++){
                $idUnItem['idproducto'] = $listaItems[$i]->getObjProducto()->getIdProducto();//id del item a comprar
                //echo $idUnItem."<br>";
                $productoGondola = $objProducto->buscar($idUnItem);
                //verEstructura($productoGondola);
                $cantLlevar = $listaItems[$i]->getCiCantidad();
                $stockGondola = $productoGondola[0]->getProCantstock();
                $nuevoStock = $stockGondola + $cantLlevar;
                $datosProductos['idproducto'] = $productoGondola[0]->getIdProducto();
                $datosProductos['pronombre'] = $productoGondola[0]->getProNombre();
                $datosProductos['prodetalle'] = $productoGondola[0]->getProDetalle();
                $datosProductos['procantstock'] = $nuevoStock;
                $datosProductos['tipo'] = $productoGondola[0]->getTipo();
                $datosProductos['imagenproducto'] = $productoGondola[0]->getImagenProducto();
                $objProducto->modificar($datosProductos);
            }
        }

        $exito = $objEstado->modificar($param);
       
        if($exito){
            echo "Se realizo la cancelacion <br>";
            $cancelado = new AbmCompraEstado();
            $param['idcompraestado'] = 0;
            $param['idcompra'] = $estado->getObjCompra()->getIdCompra();;
            $param['idcompraestadotipo'] = 4;
            $param['cefechaini'] = date('Y-m-d H:i:s');
            $param['cefechafin'] = null;
            $exito = $cancelado->alta($param);
            $resp = true;
            


            
        }
        //creo el estado cancelada con fecha de inicio
        return $resp;
    }
}

?>