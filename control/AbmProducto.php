<?php
class AbmProducto


// CREATE TABLE `producto` (
//     `idproducto` bigint(20) NOT NULL AUTO_INCREMENT,
//     `pronombre` int(11) NOT NULL,
//     `prodetalle` varchar(512) NOT NULL,
//     `procantstock` int(11) NOT NULL,
//     PRIMARY KEY (`idproducto`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;



{
    /**
     * Carga un objeto Producto a partir de un arreglo asociativo.
     * @param array $param
     * @return Producto|null
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idproducto', $param) && array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('procantstock', $param)) {
            $obj = new Producto();
            $obj->setear(
                null,
                $param['pronombre'],
                $param['prodetalle'],
                $param['procantstock']
            );
        }
        return $obj;
    }

    /**
     * Carga un objeto Producto a partir de su clave primaria.
     * @param array $param
     * @return Producto|null
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null);
        }
        return $obj;
    }

    /**
     * Verifica si los campos claves están seteados.
     * @param array $param
     * @return bool
     */
    private function seteadosCamposClaves($param)
    {
        return isset($param['idproducto']);
    }

    /**
     * Alta: Agrega un nuevo producto.
     * @param array $param
     * @return bool
     */
    public function alta($param)
    {
        $resp = false;
        $elObjProducto = $this->cargarObjeto($param);

        if ($elObjProducto !== null && $elObjProducto->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Baja: Elimina un producto por su clave primaria.
     * @param array $param
     * @return bool
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjProducto = $this->cargarObjetoConClave($param);
            if ($elObjProducto !== null && $elObjProducto->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modificación: Actualiza los datos de un producto existente.
     * @param array $param
     * @return bool
     */
    public function modificacion($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $elObjProducto = $this->cargarObjeto($param);

            if ($elObjProducto !== null && $elObjProducto->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Busca productos en la base de datos según los parámetros dados.
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = "";

        if ($param <> NULL) {
            if (isset($param['idproducto'])) {
                $where .= " idproducto = " . $param['idproducto'];
            }

            if (isset($param['pronombre'])) {
                $where .= " and pronombre ='" . $param['pronombre'] . "'";
            }

            if (isset($param['prodetalle'])) {
                $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            }

            if (isset($param['procantstock'])) {
                $where .= " and procantstock ='" . $param['procantstock'] . "'";
            }
        }

        return Producto::listar($where);
    }

    /**
     * Verifica si un producto ya existe en la base de datos.
     * @param array $param
     * @return bool
     */
    public function existeProducto($param)
    {
        $existe = false;
        $productos = $this->buscar($param);
        if (count($productos) > 0) {
            $existe = true;
        }
        return $existe;
    }
}
