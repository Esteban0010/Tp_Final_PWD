<?php
class AbmUsuarioRol
{
    /**
     * Carga un objeto AbmUsuario con los parámetros provistos
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjeto($param)
    {   
        $obj = null;
        if (array_key_exists('idusuario', $param) && array_key_exists('idrol', $param)) {   
            $obj = new UsuarioRol();
            $obj->setear($param['idusuario'], $param['idrol']);
        } 
        return $obj;
    }

    /**
     * Carga un objeto AbmUsuario con la clave primaria
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            if (isset($param['idrol'])) {
                $obj = new UsuarioRol();
                $obj->setear($param['idusuario'], $param['idrol']);
            }
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
        return (isset($param['idusuario']) && isset($param['idrol']));
    }

    /**
     * Alta (A): Es el proceso de crear o agregar un nuevo objeto o registro a un sistema.
     * @param array $param
     */
    public function alta($param)
    { //agrega
        $resp = false;
        $objAbmUsuarioRol = $this->cargarObjeto($param);
        if ($objAbmUsuarioRol != null && $objAbmUsuarioRol->insertar()) {            
            $resp = true;
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
            $objAbmUsuarioRol = $this->cargarObjetoConClave($param);
            if ($objAbmUsuarioRol != null && $objAbmUsuarioRol->eliminar()) {
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
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objAbmUsuarioRol = $this->cargarObjeto($param);
            if ($objAbmUsuarioRol != null && $objAbmUsuarioRol->modificar()) {
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
        //verEstructura($param);
        $where = "true";
        if ($param <> NULL) {

            if (isset($param['idusuario'])) {
                //echo "<div>idsuario:</div>";
                $where .= " and idusuario = " . $param['idusuario'] . "";
            }

            if (isset($param['idrol'])) {
                $where .= " and idrol = " . $param['idrol'] . "";
            }
        }
        $arreglo = UsuarioRol::listar($where);
        return $arreglo;
    }

    /**
     * permite dar un array de los datos del objeto
     * @param array $param
     * @return ARRAY
     */
    public function darArray($param)
    {          
        $arregloObjAbmUsuarioRol = $this->buscar($param);
        $listadoArray = [];

        if (count($arregloObjAbmUsuarioRol) > 0) {

            foreach ($arregloObjAbmUsuarioRol as $objAbmUsuarioRol) {
                $arrayAbmUsuarioRol = [
                    'idusuario' => $objAbmUsuarioRol->getObjIdUsuario()->getId(),
                    'idrol' => $objAbmUsuarioRol->getObjIdRol()->getId()
                ];
            
                array_push($listadoArray, $arrayAbmUsuarioRol);
            }
            

        } 
        return  $listadoArray;
    }

    /**
     * permite dar un array de los datos del objeto
     * @param array $param
     * @return ARRAY
     */
    public function darArrayCompleto($param)
    {          
        $arregloObjAbmUsuarioRol = $this->buscar($param);
        $listadoArray = [];

        if (count($arregloObjAbmUsuarioRol) > 0) {

            foreach ($arregloObjAbmUsuarioRol as $objAbmUsuarioRol) {
                $arrayAbmUsuarioRol = [
                    'idusuario' => $objAbmUsuarioRol->getObjIdUsuario()->getId(),
                    'usnombre' => $objAbmUsuarioRol->getObjIdUsuario()->getNombre(),
                    'uspassword' => $objAbmUsuarioRol->getObjIdUsuario()->getPassword(),
                    'usmail' => $objAbmUsuarioRol->getObjIdUsuario()->getMail(),
                    'usdeshabilitado' => $objAbmUsuarioRol->getObjIdUsuario()->getDeshabilitado(),
                    'idrol' => $objAbmUsuarioRol->getObjIdRol()->getId(),
                    'rodescripcion' => $objAbmUsuarioRol->getObjIdRol()->getDescripcion()
                ];
            
                array_push($listadoArray, $arrayAbmUsuarioRol);
            }
            

        } 
        return  $listadoArray;
    }
}
