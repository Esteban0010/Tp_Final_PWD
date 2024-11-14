<?php
class AbmUsuario
{
    /**
     * Carga un objeto AbmUsuario con los parámetros provistos
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('usnombre', $param) && array_key_exists('uspass', $param) && array_key_exists('usmail', $param) && array_key_exists('usdeshabilitado', $param)) {
            $obj = new Usuario();
            if(isset($param['idusuario'])){
                // Si tiene un Id, que se lo ponga (modificar)
                $obj->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
            } else {
                // Si no tiene ID no es necesario poner el param, ya que es autoincremental (insertar)
                $obj->setear(null, $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
            }            
        }
        return $obj;
    }

    /**
     * Carga un objeto AbmUsuario con la clave primaria
     * @param array $param
     * @return Usuario
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            $obj = new Usuario();
            $obj->setId($param['idusuario']);
            $obj->cargar();  // Carga el resto de los datos desde la DB
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return BOOLEAN
     */
    private function seteadosCamposClaves($param)
    {   
        return isset($param['idusuario']);
    }

    /**
     * Alta (A): Es el proceso de crear o agregar un nuevo objeto o registro a un sistema.
     * @param array $param
     */
    public function alta($param)
    { //agrega
        $resp = false;
        $param['idusuario'] = null;
        $objAbmUsuario = $this->cargarObjeto($param);
        if ($objAbmUsuario != null && $objAbmUsuario->insertar()) {
            $resp = $objAbmUsuario;
        }
        return $resp;
    }

    /**
     * Baja (B): Se refiere a eliminar un objeto o registro existente.
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    { //elimina
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objAbmUsuario = $this->cargarObjetoConClave($param);
            if ($objAbmUsuario != null && $objAbmUsuario->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modificación (M): Es la actualización de la información de un objeto o registro existente.
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //verEstructura($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objAbmUsuario = $this->cargarObjeto($param);
            //verEstructura($objAbmUsuario);
            if ($objAbmUsuario != null && $objAbmUsuario->modificar()) {
                // se rompe en modifciar()
                //verEstructura($param);
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return ARRAY
     */
    public function buscar($param)
    {   
        $where = "true";
        if ($param <> NULL) {

            if (isset($param['idusuario'])) {
                $where .= " and idusuario = " . $param['idusuario'] . "";
            }
            
            if (isset($param['usnombre'])) {
                $where .= " and usnombre = '" . $param['usnombre'] . "'";
            }

            if (isset($param['uspass'])) {
                $where .= " and uspass = '" . $param['uspass'] . "'";
            }

            if (isset($param['usmail'])) {
                $where .= " and usmail = '" . $param['usmail'] . "'";
            }

            if (isset($param['usdeshabilitado'])) {
                $where .= " and usdeshabilitado = '" . $param['usdeshabilitado'] . "'";
            }
        }
        $arreglo = Usuario::listar($where);
        return $arreglo;
    }

    /**
     * permite dar un array de los datos del objeto
     * @param array $param
     * @return ARRAY
     */
    public function darArray($param = "")
    {

        $arregloObjAbmUsuario = $this->buscar($param);
        $listadoArray = [];

        if (count($arregloObjAbmUsuario) > 0) {

            foreach ($arregloObjAbmUsuario as $objAbmUsuario) {
                $arrayAbmUsuario = [
                    'idusuario' => $objAbmUsuario->getId(),
                    'usnombre' => $objAbmUsuario->getNombre(),
                    'uspass' => $objAbmUsuario->getPassword(),
                    'usmail' => $objAbmUsuario->getMail(),
                    'usdeshabilitado' => $objAbmUsuario->getDeshabilitado()
                ];

                array_push($listadoArray, $arrayAbmUsuario);
            }
        }
        return  $listadoArray;
    }

}
?>