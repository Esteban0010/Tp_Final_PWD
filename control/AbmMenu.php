<?php
class AbmMenu
{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Tabla
     */
    private function cargarObjeto($param)
    {

        //echo "<script>console.log(" . json_encode('cargarObjeto(param) en el abm - aca esta el error') . ");</script>";
        //verEstructuraJson($param);
        $obj = null;

        if (array_key_exists('menombre', $param)) {
            $obj = new Menu();
            $objmenu = null;

            //verEstructuraJson($param);

            if (isset($param['idpadre'])) {
                $objmenu = new Menu();
                $objmenu->setIdmenu($param['idpadre']);
                $objmenu->cargar();
            }

            if (!isset($param['medeshabilitado'])) {
                $param['medeshabilitado'] = '0000:00:00';
            } else {               
                // date("Y-m-d H:i:s")
            }

            if(isset($param['idmenu'])){
                // Si tiene un Id, que se lo ponga (modificar)
                $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objmenu, $param['medeshabilitado']);
            } else {
                // Si no tiene ID no es necesario poner el param, ya que es autoincremental (insertar)
                // aca esta!!!! jajaja
                $obj->setear(null, $param['menombre'], $param['medescripcion'], $objmenu, $param['medeshabilitado']);
            }            

            //verEstructuraJson($obj);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idmenu'])) {
            $obj = new Menu();
            $obj->setIdmenu($param['idmenu']);
        }
        return $obj;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {        

        //echo "<script>console.log(" . json_encode('seteadosCamposClaves(param) en el abm') . ");</script>";
        //verEstructuraJson($param);
        return isset($param['idmenu']);
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idmenu'] = null;
        $param['medeshabilitado'] = null;

        //verEstructuraJson($param);

        $elObjtTabla = $this->cargarObjeto($param);

        //verEstructuraJson($elObjtTabla);

        //echo "<script>console.log(" . json_encode($param) . ");</script>";

        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
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
    public function modificacion($param)
    {        
        //echo "<script>console.log(" . json_encode($param) . ");</script>";
        $resp = false;
        //echo "<script>console.log(" . json_encode('verEstructuraJson(param) en el abm') . ");</script>";
        //verEstructuraJson($param);

        if ($this->seteadosCamposClaves($param)) {

            //echo "<script>console.log(" . json_encode('objeto en el abm') . ");</script>";
            //verEstructuraJson($param);
            $elObjtMenu = $this->cargarObjeto($param);
            //verEstructuraJson($elObjtMenu);
            if ($elObjtMenu != null && $elObjtMenu->modificar()) {
                $resp = true;
                //verEstructuraJson($elObjtMenu);
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {
        /* no comprobe si funciona buscar($param) */

        $where = " true ";
        if ($param <> NULL){

            if  (isset($param['idmenu'])){
                $where.=" and idmenu =".$param['idmenu'];
            }

            if  (isset($param['menombre'])){
                $where.=" and menombre =".$param['menombre'];
            }
                
            if  (isset($param['medescripcion'])){
                $where.=" and medescripcion ='".$param['medescripcion']."'";
            } 

            if  (isset($param['idpadre'])){
                $where.=" and idpadre ='".$param['idpadre']."'";
            } 

            if  (isset($param['medeshabilitado'])){
                $where.=" and medeshabilitado ='".$param['medeshabilitado']."'";
            }
            /* no comprobe si funciona buscar($param) */    
        }
        $arreglo = Menu::listar($where);
        return $arreglo;
    }
}
