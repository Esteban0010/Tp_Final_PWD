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

        // Verificar que existan los parámetros necesarios (sin necesidad de idcompra en inserción)
        if ( array_key_exists('cofecha', $param) ) {
            $obj = new Compra();
            $objUsuario = new Usuario();
            $objUsuario->setId($param["usuario_id"]);
            $objUsuario->cargar();
            $costoTotal = 0;
            
            foreach ($param["productos"] as $producto) { // Uso correcto de foreach
                $costoTotal += $producto["precio"] * $producto["cantidad"]; // Faltaba el punto y coma al final
                }
            // Si el idcompra está presente (modificación), asignarlo, si no (inserción), dejar null
            if (isset($param['usuario_id'])) {
                $obj->setear( null,$param['cofecha'], $costoTotal,$objUsuario, );
            } else {
                // Si no tiene ID, asignar como null (para insertar)
                $obj->setear(null,  $param['cofecha'], $costoTotal,$objUsuario);
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

        // Solo se necesita el idcompra para obtener un objeto con clave primaria
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
        // Verificamos que solo idcompra sea necesario para modificar o eliminar
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
        // El idcompra se asigna automáticamente en la base de datos
        

        $obj = $this->cargarObjeto($param);

        if ($obj != null && $obj->insertar()) {
            $idCompra = $obj->getIdcompra();
            foreach ($param["productos"] as $producto) { // Uso correcto de foreach
                $compraItem = new AbmCompraItem;
                $nuevaCompraItem = [
                    'idcompra' => $idCompra, 
                    'idproducto' => $producto["id"], 
                    'cicantidad' => $producto["cantidad"] 
                ];
                $compraItem->alta($nuevaCompraItem);
                }
              $compraEstado = new AbmCompraEstado;
              $nuevaCompraEstado = [
                'idcompra' => $idCompra, 
                'idcompraestadotipo' => 1, 
                'cefechaini' => date('Y-m-d H:i:s'), 
                'cefechafin' => null
            ];
            $compraEstado->alta($nuevaCompraEstado);
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

        // Verificamos que idcompra esté presente antes de eliminar
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

        // Verificamos que idcompra esté presente antes de modificar
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
            // Verificamos solo los campos que pueden ser utilizados en la búsqueda
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

        // Retornamos las compras que coinciden con los filtros
        $arreglo = Compra::listar($where);
        return $arreglo;
    }
}
?>