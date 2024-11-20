<?php

class Rol{

    private $id;
    private $descripcion; 
    private $mensajeoperacion;

    public function __construct()
    {
        $this->id = "";
        $this->descripcion = "";
        $this->mensajeoperacion = "";
    }

    public function setear($id, $descripcion)
    {
        $this->setId($id);
        $this->setDescripcion($descripcion);      
    }

     /* Get */
    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    
    /* Set */
    public function setId($valor)
    {
        $this->id = $valor;
    }

    public function setDescripcion($valor)
    {
        $this->descripcion = $valor;
    }
    
    public function setMensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    /* Funciones */
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol WHERE idrol = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();     
                        $this->setear($row['idrol'], $row['rodescripcion']);
                        $respuesta = true;
                }
            }
        } else {
            $this->setMensajeoperacion("rol->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO rol(rodescripcion) VALUES(
            '" . $this->getDescripcion() . "');";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setId($id);
                $resp = true;
            } else {
                $this->setMensajeoperacion("rol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("rol->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {        
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE rol SET rodescripcion='" . $this->getDescripcion() . 
            "' WHERE idrol=" . $this->getId();
        //echo "<script>console.log(" . json_encode($sql) . ");</script>";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("rol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("rol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeoperacion("rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("rol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol ";
        
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        
        if ($res > -1) {
            
            if ($res > 0) {
                while ($row = $base->Registro()) {       

                        $obj = new Rol();

                        $obj->setear($row['idrol'], $row['rodescripcion']);
                        
                        array_push($arreglo, $obj);

                }                
            }  

        } else {
            throw new Exception("rol->listar: " . $base->getError());
        }

        return $arreglo;
    }

}
?>