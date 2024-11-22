<?php

class UsuarioRol{

    private $objIdUsuario; // Foreign Key and Primary Key
    private $objIdRol;     // Foreign Key and Primary Key
    private $mensajeoperacion;

    public function __construct()
    {
        $this->objIdUsuario = new Usuario();
        $this->objIdRol = new Rol();
        $this->mensajeoperacion = "";
    }

    public function setear($objIdUsuario, $objIdRol)
    {
        $this->setObjIdUsuario($objIdUsuario); // Objeto
        $this->setObjIdRol($objIdRol);         // Objeto
    }

     /* Get */
    public function getObjIdUsuario()
    {
        return $this->objIdUsuario;
    }

    public function getObjIdRol()
    {
        return $this->objIdRol;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    
    /* Set */
    public function setObjIdUsuario($valor)
    {
        $this->objIdUsuario = $valor;
    }

    public function setObjIdRol($valor)
    {
        $this->objIdRol = $valor;
    }
    
    public function setMensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }


    /*
        El id de rol no tiene que ser autoincremento sino van haber mucho ids para un tipo de rol y pienso 
        que es beuno si fuese solo 1 para identifcar pero si el de usuario deberia tener muchos por cada una
    */


    /* Funciones */
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getObjIdUsuario()->getId() . "AND idrol =" . $this->getObjIdRol()->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro(); 
                    
                    $usuario = new Usuario();
                    $rol = new Rol();

                    $idUsuario = $usuario->setId($row['idusuario']);
                    $idRol = $rol->setId($row['idrol']);

                    if($usuario->cargar() && $rol->cargar()){
                        $this->setear($idUsuario, $idRol);
                        $respuesta = true;
                    } else {
                        $this->setMensajeoperacion("usuariorol->cargar: No se pudo cargar el Usuario y Rol.");
                    }
                    
                }
            }
        } else {
            $this->setMensajeoperacion("usuariorol->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol(idusuario, idrol) VALUES(
            " . $this->getObjIdUsuario()->getId() . ",
            " . $this->getObjIdRol()->getId() . ");";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("usuariorol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("usuariorol->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {        
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuariorol SET idrol=" . $this->getObjIdRol()->getId() . 
            " WHERE idUsuario=" . $this->getobjIdUsuario()->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("usuariorol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("usuariorol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario=" . $this->getObjIdUsuario()->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeoperacion("usuariorol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("usuariorol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }

        //echo "<div>" . $sql . "</div>";

        $res = $base->Ejecutar($sql);
        
        if ($res > -1) {
            
            if ($res > 0) {
                while ($row = $base->Registro()) {  

                    $objUsuario = new Usuario(); 
                    $objUsuario->setId($row['idusuario']); 
                    $objUsuario->cargar();

                    $objRol = new Rol(); 
                    $objRol->setId($row['idrol']); 
                    $objRol->cargar();

                    $obj = new UsuarioRol();
                    $obj->setear($objUsuario, $objRol);                        
                    array_push($arreglo, $obj);

                }                
            }  

        } else {
            throw new Exception("usuariorol->listar: " . $base->getError());
        }
        //verEstructura($arreglo);
        return $arreglo;
    }

}
?>