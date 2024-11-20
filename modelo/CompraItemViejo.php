<?php

class CompraItem
{
    private $idcompraitem;
    private $idproducto;
    private $idcompra;
    private $cicantidad;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompraitem = "";
        $this->idproducto = "";
        $this->idcompra = "";
        $this->cicantidad = 0;
        $this->mensajeoperacion = "";
    }

    public function setear($idcompraitem, $idproducto, $idcompra, $cicantidad)
    {
        $this->setIdCompraItem($idcompraitem);
        $this->setIdProducto($idproducto);
        $this->setIdCompra($idcompra);
        $this->setCiCantidad($cicantidad);
    }

    public function getIdCompraItem()
    {
        return $this->idcompraitem;
    }

    public function getIdProducto()
    {
        return $this->idproducto;
    }

    public function getIdCompra()
    {
        return $this->idcompra;
    }

    public function getCiCantidad()
    {
        return $this->cicantidad;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdCompraItem($valor)
    {
        $this->idcompraitem = $valor;
    }

    public function setIdProducto($valor)
    {
        $this->idproducto = $valor;
    }

    public function setIdCompra($valor)
    {
        $this->idcompra = $valor;
    }

    public function setCiCantidad($valor)
    {
        $this->cicantidad = $valor;
    }

    public function setMensajeOperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    // Cargar
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    $respuesta = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraitem->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    // Insertar
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem(idproducto, idcompra, cicantidad) VALUES(
            " . $this->getIdProducto() . ",
            " . $this->getIdCompra() . ",
            " . $this->getCiCantidad() . ");";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($id);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->insertar: " . $base->getError());
        }
        return $resp;
    }

    // Modificar
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET 
            idproducto=" . $this->getIdProducto() . ", 
            idcompra=" . $this->getIdCompra() . ", 
            cicantidad=" . $this->getCiCantidad() .
            " WHERE idcompraitem=" . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) >= 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->modificar: " . $base->getError());
        }
        return $resp;
    }

    // Eliminar
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem=" . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraitem->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraitem->eliminar: " . $base->getError());
        }
        return $resp;
    }

    // Listar
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";

        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraItem();
                    $obj->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("compraitem->listar: " . $base->getError());
        }

        return $arreglo;
    }
}
