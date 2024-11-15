<?php

class CompraEstadoTipo
{
    private $idcompraestadotipo;
    private $cetdescripcion;
    private $cetdetalle;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompraestadotipo = "";
        $this->cetdescripcion = "";
        $this->cetdetalle = "";
        $this->mensajeoperacion = "";
    }

    public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle)
    {
        $this->setIdCompraEstadoTipo($idcompraestadotipo);
        $this->setCetDescripcion($cetdescripcion);
        $this->setCetDetalle($cetdetalle);
    }

    public function getIdCompraEstadoTipo()
    {
        return $this->idcompraestadotipo;
    }

    public function getCetDescripcion()
    {
        return $this->cetdescripcion;
    }

    public function getCetDetalle()
    {
        return $this->cetdetalle;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdCompraEstadoTipo($valor)
    {
        $this->idcompraestadotipo = $valor;
    }

    public function setCetDescripcion($valor)
    {
        $this->cetdescripcion = $valor;
    }

    public function setCetDetalle($valor)
    {
        $this->cetdetalle = $valor;
    }

    public function setMensajeOperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    /**CREATE TABLE `compraestadotipo` (  yo, fran, le agregue AUTO_INCREMENT al `idcompraestadotipo` para simplificar el trabajo
        `idcompraestadotipo` int(11) NOT NULL AUTO_INCREMENT,
        `cetdescripcion` varchar(50) NOT NULL,
        `cetdetalle` varchar(256) NOT NULL,
        PRIMARY KEY (`idcompraestadotipo`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
    */
    
    //cargar
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    $respuesta = true;
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    //insertar
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestadotipo(cetdescripcion, cetdetalle) VALUES(
            '" . $this->getCetDescripcion() . "',
            '" . $this->getCetDetalle() . "');";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdCompraEstadoTipo($id);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->insertar: " . $base->getError());
        }
        return $resp;
    }

    //modificar
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestadotipo SET cetdescripcion='" . $this->getCetDescripcion() . 
            "', cetdetalle='" . $this->getCetDetalle() . 
            "' WHERE idcompraestadotipo=" . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) >= 0) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->modificar: " . $base->getError());
        }
        return $resp;
    }

    //eliminar
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo=" . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->eliminar: " . $base->getError());
        }
        return $resp;
    }

    //listar

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraEstadoTipo();
                    $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("compraestadotipo->listar: " . $base->getError());
        }

        return $arreglo;
    }
}

?>
