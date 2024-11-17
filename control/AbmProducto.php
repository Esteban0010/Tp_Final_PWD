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
        //echo "<script>console.log(" . json_encode('cargarObjeto(param) en el abm - aca esta el error') . ");</script>";
        //echo "<script>console.log(" . json_encode($param) . ");</script>";
        //verEstructuraJson($param);
        
        $obj = null;
        if (array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('procantstock', $param) && array_key_exists('valor', $param)) {
            
            $obj = new Producto();
            if(isset($param['idproducto'])){
                // Si tiene un Id, que se lo ponga (modificar)
                $obj->setear($param['idproducto'], $param['pronombre'], $param['prodetalle'], $param['procantstock'], $param['valor']);                
            } else {
                //echo "<script>console.log(" . json_encode('incremento') . ");</script>";
                // Si no tiene ID no es necesario poner el param, ya que es autoincremental (insertar)
                $obj->setear(null, $param['pronombre'], $param['prodetalle'], $param['procantstock'], $param['valor']);
                //verEstructuraJson($param);
            }
            
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
            $obj->setIdProducto($param['idproducto']);
            $obj->cargar();
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
        $param['idproducto'] = null;
        $elObjProducto = $this->cargarObjeto($param);

        
        //verEstructuraJson($elObjProducto);

        //echo "<script>console.log(" . json_encode($param) . ");</script>";

        //verEstructuraJson($elObjProducto);

        if ($elObjProducto !== null && $elObjProducto->insertar()) {
            
            //verEstructuraJson($elObjProducto);

            //echo "<script>console.log(" . json_encode($param) . ");</script>";

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
        //echo "<script>console.log(" . json_encode($param) . ");</script>";
        if ($this->seteadosCamposClaves($param)) {
            $elObjProducto = $this->cargarObjetoConClave($param);
            //verEstructuraJson($elObjProducto);
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

        //echo "<script>console.log(" . json_encode($param) . ");</script>";

        

        if ($this->seteadosCamposClaves($param)) {
            $elObjProducto = $this->cargarObjeto($param);

            //echo "<script>console.log(" . json_encode('objeto en el abm') . ");</script>";
            //echo "<script>console.log(" . json_encode('objeto en el abm') . ");</script>";
            
            //verEstructuraJson($elObjProducto);

            if ($elObjProducto !== null && $elObjProducto->modificar()) {

                //echo "<script>console.log(" . json_encode('Entro a la modificacion') . ");</script>";
                $resp = true;
            } 
            //echo "<script>console.log(" . json_encode('NO Entro a la Modificacion!!!!') . ");</script>";
            
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
        $where = " true ";

        if ($param <> NULL) {
            if (isset($param['idproducto'])) {
                $where .= " and idproducto = " . $param['idproducto'];
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

            if (isset($param['valor'])) {
                $where .= " and valor ='" . $param['valor'] . "'";
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
