<?php
class AbmCompra
{
    /**
     * Carga un objeto Compra con los parámetros proporcionados
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('idusuario', $param) && array_key_exists('cofecha', $param)) {
            $obj = new Compra();

            // Crear instancia de Usuario
            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idusuario']);
            $objUsuario->cargar();

            if (isset($param['idcompra'])) {
                // Si tiene un ID, asignarlo (para modificar)
                $obj->setear($param['idcompra'], $objUsuario, $param['cofecha']);
            } else {
                // Si no tiene ID, asignar como null (para insertar)
                $obj->setear(null, $objUsuario, $param['cofecha']);
            }
        }
        return $obj;
    }

    /**
     * Carga un objeto Compra solo con clave primaria
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompra'])) {
            $obj = new Compra();
            $obj->setIdCompra($param['idcompra']);
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
        return isset($param['idcompra']);
    }

    /**
     * Agrega un nuevo Compra
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $param['idcompra'] = null;

        $obj = $this->cargarObjeto($param);

        if ($obj != null && $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Elimina un Compra por su clave primaria
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
     * Modifica un Compra existente
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
     * Busca y retorna un array de Compra según el parámetro especificado
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        
        if ($param != NULL) {
            if (isset($param['idcompra'])) {
                $where .= " and idcompra = " . $param['idcompra'];
            }
            if (isset($param['idusuario'])) {
                $where .= " and idusuario = " . $param['idusuario'];
            }
            if (isset($param['cofecha'])) {
                $where .= " and cofecha = '" . $param['cofecha'] . "'";
            }
        }

        $arreglo = Compra::listar($where);
        return $arreglo;
    }
}
?>