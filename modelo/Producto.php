<?php

class Producto
{
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idproducto = "";
        $this->pronombre = "";
        $this->prodetalle = "";
        $this->procantstock = 0;
        $this->mensajeoperacion = "";
    }

    public function setear($idproducto, $pronombre, $prodetalle, $procantstock)
    {
        $this->setIdProducto($idproducto);
        $this->setProNombre($pronombre);
        $this->setProDetalle($prodetalle);
        $this->setProCantStock($procantstock);
    }

    public function getIdProducto()
    {
        return $this->idproducto;
    }

    public function getProNombre()
    {
        return $this->pronombre;
    }

    public function getProDetalle()
    {
        return $this->prodetalle;
    }

    public function getProCantStock()
    {
        return $this->procantstock;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdProducto($valor)
    {
        $this->idproducto = $valor;
    }

    public function setProNombre($valor)
    {
        $this->pronombre = $valor;
    }

    public function setProDetalle($valor)
    {
        $this->prodetalle = $valor;
    }

    public function setProCantStock($valor)
    {
        $this->procantstock = $valor;
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
        $sql = "SELECT * FROM producto WHERE idproducto = " . $this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                    $respuesta = true;
                }
            }
        } else {
            $this->setMensajeOperacion("producto->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    // Insertar
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO producto(pronombre, prodetalle, procantstock) VALUES(
            '" . $this->getProNombre() . "',
            '" . $this->getProDetalle() . "',
            " . $this->getProCantStock() . ");";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdProducto($id);
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->insertar: " . $base->getError());
        }
        return $resp;
    }

    // Modificar
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET 
            pronombre='" . $this->getProNombre() . "', 
            prodetalle='" . $this->getProDetalle() . "', 
            procantstock=" . $this->getProCantStock() .
            " WHERE idproducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) >= 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    // Eliminar
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->eliminar: " . $base->getError());
        }
        return $resp;
    }

    // Listar
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";

        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("producto->listar: " . $base->getError());
        }

        return $arreglo;
    }
}
