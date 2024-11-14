<?php
class AbmRol
{
    /**
     * Carga un objeto AbmUsuario con los parámetros provistos
     * @param array $param
     * @return Rol
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('rodescripcion', $param)) { //usnombre
            $obj = new Rol();
            // El ID no es necesario al crear un nuevo Rol, ya que es autoincremental
            $obj->setear(null, $param['rodescripcion']);
        }
        return $obj;
    }


    /**
     * Carga un objeto AbmUsuario con la clave primaria
     * @param array $param
     * @return Rol
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idrol'])) {
            $obj = new Rol();
            $obj->setId($param['idrol']);
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
        return isset($param['idrol']);
    }

    /**
     * Alta (A): Es el proceso de crear o agregar un nuevo objeto o registro a un sistema.
     * @param array $param
     */
    public function alta($param)
    { //agrega
        $resp = false;
        $param['idrol'] = null;
        $objAbmRol = $this->cargarObjeto($param);
        if ($objAbmRol != null && $objAbmRol->insertar()) {
            $resp = $objAbmRol;
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
            $objAbmRol = $this->cargarObjetoConClave($param);
            if ($objAbmRol != null && $objAbmRol->eliminar()) {
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
            $objAbmRol = $this->cargarObjeto($param);
            if ($objAbmRol != null && $objAbmRol->modificar()) {
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

            if (isset($param['idrol'])) {
                $where .= " and idrol = " . $param['idrol'] . "";
            }

            if (isset($param['rodescripcion'])) {
                $where .= " and rodescripcion ='" . $param['rodescripcion'] . "'";
            }

        }
        $arreglo = Rol::listar($where);
        return $arreglo;
    }

    /**
     * permite dar un array de los datos del objeto
     * @param array $param
     * @return ARRAY
     */
    public function darArray($param = "")
    {

        $arregloObjAbmRol = $this->buscar($param);
        $listadoArray = [];

        if (count($arregloObjAbmRol) > 0) {

            foreach ($arregloObjAbmRol as $objAbmRol) {
                $arrayAbmRol = [
                    'idrol' => $objAbmRol->getId(),
                    'rodescripcion' => $objAbmRol->getDescripcion()
                ];

                array_push($listadoArray, $arrayAbmRol);
            }
        }
        return  $listadoArray;
    }
}
