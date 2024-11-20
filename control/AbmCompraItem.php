<?php
class AbmCompraItem
{
    // CREATE TABLE `compraitem` (
    //     `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    //     `idproducto` bigint(20) NOT NULL,
    //     `idcompra` bigint(20) NOT NULL,
    //     `cicantidad` int(11) NOT NULL,
    //     PRIMARY KEY (`idcompraitem`),
    //     FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
    //     FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE
    // ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
    /**
     * Carga un objeto CompraItem a partir de un arreglo asociativo.
     * @param array $param
     * @return CompraItem|null
     * 
     */
    private function cargarObjeto($param)
    {
        $objCompraItem = null;

        if (array_key_exists('idcompraitem', $param) && array_key_exists('idproducto', $param)  && array_key_exists('idcompra', $param) && array_key_exists('cicantidad', $param)) {
            $objProducto = new Producto();
            $objProducto->setIdProducto($param['idproducto']);
            $objProducto->cargar();

            $objCompra = new Compra();
            $objCompra->setIdcompra($param['idcompra']);
            $objCompra->cargar();

            $objCompraItem = new CompraItem();
            $objCompraItem->setear(
                $param['idcompraitem'],
                $objProducto,
                $objCompra,
                $param['cicantidad']
            );
        }
        return $objCompraItem;
    }

    /**
     * Carga un objeto CompraItem a partir de su clave primaria.
     * @param array $param
     * @return CompraItem|null
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraitem'])) {
            $obj = new CompraItem();
            $obj->setear($param['idcompraitem'], null, null, null);
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
        return isset($param['idcompraitem']);
    }

    /**
     * Alta: Agrega un nuevo registro de CompraItem.
     * @param array $param
     * @return bool
     */
    public function alta($param)
    {
        $resp = false;
        $param['idcompraitem'] = null;
        $elObjCompraItem = $this->cargarObjeto($param);

        if ($elObjCompraItem !== null && $elObjCompraItem->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Baja: Elimina un registro de CompraItem por su clave primaria.
     * @param array $param
     * @return bool
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjCompraItem = $this->cargarObjetoConClave($param);
            if ($elObjCompraItem !== null && $elObjCompraItem->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modificación: Actualiza los datos de un registro de CompraItem.
     * @param array $param
     * @return bool
     */
    public function modificacion($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $elObjCompraItem = $this->cargarObjeto($param);

            if ($elObjCompraItem !== null && $elObjCompraItem->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Busca registros de CompraItem en la base de datos según los parámetros dados.
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = "";

        if ($param !== null) {
            if (isset($param['idcompraitem'])) {
                $where .= " idcompraitem = " . $param['idcompraitem'];
            }

            if (isset($param['idproducto'])) {
                $where .= " and idproducto ='" . $param['idproducto'] . "'";
            }
            if (isset($param['idcompra'])) {
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            }
            if (isset($param['cicantidad'])) {
                $where .= " and cicantidad ='" . $param['cicantidad'] . "'";
            }
        }
        $objCompraItem = new CompraItem();
        $arregloCompraItem = $objCompraItem->listar($where);
        return $arregloCompraItem;
    }

    /**
     * Verifica si un registro de CompraItem ya existe en la base de datos.
     * @param array $param
     * @return bool
     */
    public function existeCompraItem($param)
    {
        $existe = false;
        $compraItems = $this->buscar($param);
        if (count($compraItems) > 0) {
            $existe = true;
        }
        return $existe;
    }
}