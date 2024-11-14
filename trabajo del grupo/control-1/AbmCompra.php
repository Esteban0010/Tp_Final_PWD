<?php

class AbmCompra{

    /*
    ATRIBUTOS:
    'idcompra'
    'cofecha'
    'idusuario' <-- corresponde un objeto Usuario
    */

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres 
     * de las variables instancias del objeto
     * @param array $param
     * @return Compra
     */
    private function cargarObjeto($param){
        $objCompra = null;
        
        /*OBSERVACIÓN: Se puede verificar la existencia de las claves que sean necesarias
        en vez de obligar a cargar todo, esto puede aplicar en caso de que se quiera
        cargar un objeto del cual no se tengan todos los datos.
        En este caso se carga todo*/
        
        if( 
        array_key_exists('idcompra', $param) &&
        array_key_exists('cofecha', $param) &&
        array_key_exists('idusuario', $param)
        ){
            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idusuario']);
            $objUsuario->cargar();

            $objCompra = new Compra();

            $objCompra->setear(
                $param['idcompra'],
                $param['cofecha'],
                $objUsuario
            );
        }
        return $objCompra;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * 
     * OBSERVACION: Se utiliza este método principalmente para borrar un registro, ya que para ello
     * solamente se necesitan las claves del mismo
     * 
     * @param array $param
     * @return Compra
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idcompra']) ){
            $obj = new Compra();
            $obj->setear($param['idcompra'], null, null);
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
        if (isset($param['idcompra']))
            $resp = true;
        return $resp;
    }
    
    /**
     * Esta función carga la información de un objeto a la base de datos
     * 
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;

        /*Si el id del objeto tuviera autoincrement en la base de datos entonces los campos claves 
        del mismo deberían setearse en nulos al momento de realizar la insersión*/
        $param['idcompra'] = null;

        $obj = $this->cargarObjeto($param);
        // verEstructura($obj);
        if ($obj != null && $obj->insertar()){
            $resp = true;
        }
        return $resp;
    }
    
    /**
     * Permite eliminar un objeto de la base de datos
     * @param array $param
     * @return boolean
     */
    public function baja($param){

        $resp = false;

        /*Primero verifica que el campo clave es enviado correctamente como parámetro */
        if ($this->seteadosCamposClaves($param)){

            /*Carga solamente la clave recibida por parámetro en el objeto actual ya que es lo único
            que se necesita para eliminar el resgistro de la base de datos */
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificar($param){
        //echo "Estoy en modificacion";
        $resp = false;

        /*Primero verifica que el campo clave es enviado correctamente como parámetro */
        if ($this->seteadosCamposClaves($param)){

            /*Para realizar una modificación se debe recibir un arreglo con todos los datos 
            del registro cargados, tanto los que se desea editar como los que se desea que 
            permanezcan igual y se lo sobreescribe con la función modificar */
            $obj = $this->cargarObjeto($param);
            if($obj != null and $obj->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * Permite buscar un objeto según distintos criterios.
     * Recibe un arreglo indexado que contiene los criterios de busqueda.
     * Retorna un arreglo compuesto por los objetos que cumplen el criterio indicado.
     * @param array $param
     * @return array
     */
    public function buscar($param){

        /*Se incia la consulta sql en true por que facilita el armado de la misma
        según el criterio de busqueda */
        $where = " true ";

        if ($param <> NULL){

            if  (isset($param['idcompra']))
                $where .= " and idcompra = ".$param['idcompra'];

            if  (isset($param['cofecha']))
                $where.= " and cofecha = '".$param['cofecha']."'";

            if  (isset($param['idusuario']))
                $where.= " and idusuario = ".$param['idusuario'];
        }

        $obj = new Compra();
        $arreglo = $obj->listar($where);

        return $arreglo;
    }

    
    /**
     * Crea un carrito con su estado
     * $param contiene:
     * $param['idusuario']
     */
    public function crearCarrito($param){
        $resp = false;
       /* $estadoCompra = new AbmCompraEstado();
         if($this->alta($param)){
            $compraUsuario = $this->buscar($param['idusuario']);
            $objCompra = $compraUsuario[count($compraUsuario)-1];//seecciona a ultima compra
            $array['idcompraestado'] = 0;
            $array['idcompra'] = $objCompra->getIdCompra();
            $array['idcompraestadotipo'] = 1;
            $array['cefechaini'] = NULL;// date('Y-m-d H:i:s');//guarda la fecha de inicio?
            $array['cefechafin'] = NULL;
            if($estadoCompra->alta($array)){
                $resp = true;
            }
        } */
        
        return $resp;
    }

    /**
     * Recibe un id de usuario y retorna una colección de objeto 
     * compra que no posea un estado de ese usuario.
     * @param int $idUsuario
     * @return array
     */
    public function buscarCarrito($idUsuario){
        $compra = new Compra();
        $sql = "idusuario = ".$idUsuario. " AND 
        NOT EXISTS (
        SELECT * FROM compraestado WHERE compraestado.idcompra = compra.idcompra);";
       // echo $sql."<br>";
        $carrito = $compra->listar($sql);//devuelve 1 carrito sin relacion a compraestado
        return $carrito;
    }

    /**
     * Recibe un arreglo indexado que contiene los criterios de busqueda
     * Devuelve un arreglo con la información de todos los objetos que cumplan la condición
     * recibida por parámetro
     * 
     * @param array $param
     * @return array
     */
    public function buscarColInfo($param){

        $colInfo = array();
        $arregloObj = $this->buscar($param);

        if (count($arregloObj) > 0){

            for ($i = 0; $i < count($arregloObj); $i++){
                $colInfo[$i] = $arregloObj[$i]->obtenerInfo();
            }
        }

        return $colInfo;
    }
}

?>