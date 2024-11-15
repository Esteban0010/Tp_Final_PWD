<?php

class Compra
{
    private $idcompra;
    private $cofecha;
    private $ObjUsuario; // Instancia de Usuario
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->ObjUsuario = null; // Crear una nueva instancia de Usuario
        $this->mensajeoperacion = "";
    }

    public function setear($idcompra, $cofecha, $ObjUsuario)
    {
        $this->setIdcompra($idcompra);
        $this->setCofecha($cofecha);
        $this->setObjUsuario($ObjUsuario);
    }

    public function getIdcompra()
    {
        return $this->idcompra;
    }

    public function getCofecha()
    {
        return $this->cofecha;
    }

    public function getObjUsuario()
    {
        return $this->ObjUsuario;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdcompra($valor)
    {
        $this->idcompra = $valor;
    }

    public function setCofecha($valor)
    {
        $this->cofecha = $valor;
    }

    public function setObjUsuario($ObjUsuario)
    {
        $this->ObjUsuario = $ObjUsuario;
    }

    public function setMensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdcompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $ObjUsuario = new Usuario();
                    $ObjUsuario->cargar($row['idusuario']); // Cargar datos del usuario
                    $this->setear($row['idcompra'], $row['cofecha'], $ObjUsuario);
                    $respuesta = true;
                }
            }
        } else {
            $this->setMensajeoperacion("compra->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra(cofecha, idusuario) VALUES(
            '" . $this->getCofecha() . "',
            '" . $this->getObjUsuario()->getId() . "');";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdcompra($id);
                $resp = true;
            } else {
                $this->setMensajeoperacion("compra->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("compra->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha='" . $this->getCofecha() .
            "', idusuario='" . $this->getObjUsuario()->getId() .
            "' WHERE idcompra=" . $this->getIdcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) >= 0) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra=" . $this->getIdcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("compra->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Compra();
                    $ObjUsuario = new Usuario();
                    $ObjUsuario->cargar($row['idusuario']); // Cargar datos del usuario
                    $obj->setear($row['idcompra'], $row['cofecha'], $ObjUsuario);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("compra->listar: " . $base->getError());
        }

        return $arreglo;
    }
}

?>