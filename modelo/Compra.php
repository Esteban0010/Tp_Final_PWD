<?php

class Compra
{
    private $idcompra;
    private $cofecha;
    private $ObjUsuario; // Instancia de Usuario

    private $costoTotal;
    private $mensajeoperacion;


    public function __construct() {
        $this->idcompra = null;
        $this->cofecha = null;
        $this->costoTotal = 0;
        $this->ObjUsuario = new Usuario();
        $this->mensajeOperacion = "";
    }

    public function setear($idcompra, $cofecha, $costoTotal, $ObjUsuario) {
        $this->idcompra = $idcompra;
        $this->cofecha = $cofecha;
        $this->costoTotal = $costoTotal;
        $this->ObjUsuario = $ObjUsuario;
    }

    public function getIdcompra()
    {
        return $this->idcompra;
    }

    public function getCostoTotal()
    {
        return $this->costoTotal;
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
    public function setCostoTotal($costoTotal)
    {
         $this->costoTotal =$costoTotal ;
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

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->idcompra;
        if ($base->Iniciar()) {
            if ($res = $base->Ejecutar($sql)) {
                if ($row = $base->Registro()) {
                    $usuario = new Usuario();
                    $usuario->setId($row['idusuario']);
                    $usuario->cargar();

                    $this->setear(
                        $row['idcompra'],
                        $row['cofecha'],
                        $row['costoTotal'],
                        $usuario
                    );
                    $resp = true;
                }
            } else {
                $this->mensajeOperacion = "Error al ejecutar la consulta: " . $base->getError();
            }
        } else {
            $this->mensajeOperacion = "Error al iniciar la base de datos: " . $base->getError();
        }
        return $resp;
    }


    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra (cofecha, costoTotal, idusuario) VALUES ('" . $this->cofecha . "', " . $this->costoTotal . ", " . $this->getObjUsuario()->getIdusuario() . ")";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdcompra($id);
                $resp = true;
            } else {
                $this->mensajeOperacion = "Error al insertar la compra: " . $base->getError();
            }
        } else {
            $this->mensajeOperacion = "Error al iniciar la base de datos: " . $base->getError();
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha = '" . $this->cofecha . "', costoTotal = " . $this->costoTotal . ", idusuario = " . $this->ObjUsuario->getIdusuario() . " WHERE idcompra = " . $this->idcompra;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->mensajeOperacion = "Error al modificar la compra: " . $base->getError();
            }
        } else {
            $this->mensajeOperacion = "Error al iniciar la base de datos: " . $base->getError();
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

    public static function listar($condicion = "") {
        $arreglo = [];
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra";
        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        if ($base->Iniciar()) {
            if ($res = $base->Ejecutar($sql)) {
                while ($row = $base->Registro()) {
                    $compra = new Compra();
                    $usuario = new Usuario();
                    $usuario->setId($row['idusuario']);
                    $usuario->cargar();

                    $compra->setear(
                        $row['idcompra'],
                        $row['cofecha'],
                        $row['costoTotal'],
                        $usuario
                    );
                    $arreglo[] = $compra;
                }
            } else {
                echo "Error al listar compras: " . $base->getError();
            }
        } else {
            echo "Error al iniciar la base de datos: " . $base->getError();
        }
        return $arreglo;
    }
}
?>