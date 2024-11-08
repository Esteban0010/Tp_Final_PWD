<?php
class AbmRol{

     /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Rol
     */
    private function cargarObjeto($param){
        //print_r($param);
        $obj = null;
        if( array_key_exists('idrol',$param) and array_key_exists('rodescripcion',$param)){
            $obj = new Rol();
            $obj->setear($param['idrol'], $param['rodescripcion']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     *  que son claves
     * @param array $param
     * @return Rol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if(isset($param['idrol']) ){
            $obj = new Rol();
            $obj->setear($param['idrol'],null);
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
        if (isset($param['idrol']))
            $resp = true;
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        //$param['NroDni'] =null;
        $unObjRol = $this->cargarObjeto($param);
        if ($unObjRol!=null && $unObjRol->insertar()){
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
            $unObjRol = $this->cargarObjetoConClave($param);
            if ($unObjRol!=null && $unObjRol->eliminar()){
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
            $unObjRol = $this->cargarObjeto($param);
            if($unObjRol!=null && $unObjRol->modificar()){
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
            if  (isset($param['idrol']))
                $where.=" and idrol = ".$param['idrol'];
            if  (isset($param['rodescripcion']))
                $where.=" and rodescripcion ='".$param['rodescripcion']."'";
        }

        $obj = new Rol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Retorna todos los obj menu a los que el usuario puede acceder
     * Devuelve un array MenuRol
     * @param array $param
     * @return array|null
     */
    public function buscarPermisos($param){

        $arreglo = null;

        $where = " true ";
        if($param != null){
            if(array_key_exists("id",$param)){
                $where.= "and idrol = '". $param["id"]  ."'";
            }
        }

        $obj = new MenuRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}

?>