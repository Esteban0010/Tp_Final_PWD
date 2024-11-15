<?php
class AbmCompraEstadoTipo
{
    /**
     * Carga un objeto CompraEstadoTipo con los parámetros proporcionados
     * @param array $param
     * @return CompraEstadoTipo
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('cetdescripcion', $param) && array_key_exists('cetdetalle', $param)) {
            $obj = new CompraEstadoTipo();
            
            if (isset($param['idcompraestadotipo'])) {
                $obj->setear($param['idcompraestadotipo'], $param['cetdescripcion'], $param['cetdetalle']);
            } else {
                $obj->setear(null, $param['cetdescripcion'], $param['cetdetalle']);
            }
        }
        return $obj;
    }

    /**
     * Carga un objeto CompraEstadoTipo solo con clave primaria
     * @param array $param
     * @return CompraEstadoTipo|null
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompraestadotipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->setIdCompraEstadoTipo($param['idcompraestadotipo']);
        }
        return $obj;
    }

    /**
     * Verifica si están seteados los campos claves en el arreglo de parámetros
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        return isset($param['idcompraestadotipo']);
    }

    /**
     * Agrega un nuevo CompraEstadoTipo
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $param['idcompraestadotipo'] = null;

        $obj = $this->cargarObjeto($param);

        if ($obj != null && $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Elimina un CompraEstadoTipo por su clave primaria
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modifica un CompraEstadoTipo existente
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Busca y retorna un array de CompraEstadoTipo según el parámetro especificado
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        
        if ($param != NULL) {
            if (isset($param['idcompraestadotipo'])) {
                $where .= " and idcompraestadotipo = " . $param['idcompraestadotipo'];
            }
            if (isset($param['cetdescripcion'])) {
                $where .= " and cetdescripcion = '" . $param['cetdescripcion'] . "'";
            }
            if (isset($param['cetdetalle'])) {
                $where .= " and cetdetalle = '" . $param['cetdetalle'] . "'";
            }
        }

        $arreglo = CompraEstadoTipo::listar($where);
        return $arreglo;
    }
}
?>