<?php

class Usuario{

    private $id;
    private $nombre;
    private $password;
    private $mail;
    private $deshabilitado; 
    private $mensajeoperacion;

    public function __construct()
    {
        $this->id = "";
        $this->nombre = "";
        $this->password = "";
        $this->mail;
        $this->deshabilitado = "";
        $this->mensajeoperacion = "";
    }

    public function setear($id, $nombre, $password, $mail, $deshabilitado)
    {
        $this->setId($id);
        $this->setNombre($nombre);       
        $this->setPassword($password);
        $this->setMail($mail);
        $this->setDeshabilitado($deshabilitado);        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getDeshabilitado()
    {
        return $this->deshabilitado;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    

    public function setId($valor)
    {
        $this->id = $valor;
    }

    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }
    public function setPassword($valor)
    {
        $this->password = $valor;
    }

    public function setMail($valor)
    {
        $this->mail = $valor;
    }

    public function setDeshabilitado($valor)
    {
        $this->deshabilitado = $valor;
    }
    
    public function setMensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();     
                    $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    $respuesta = true;
                }
            }
        } else {
            $this->setMensajeoperacion("usuario->cargar: " . $base->getError());
        }
        return $respuesta;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario(usnombre, uspass, usmail, usdeshabilitado) VALUES(
            '" . $this->getNombre() . "',
            '" . $this->getPassword() . "',
            '" . $this->getMail() . "',
            '" . $this->getDeshabilitado() . "');";
        //echo "<div>vamos a ver el sql: " . $sql . "</div>";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setId($id);
                $resp = true;
            } else {
                $this->setMensajeoperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {        
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usnombre='" . $this->getNombre() . 
            "', uspass='" . $this->getPassword() .
            "', usmail='" . $this->getMail() .
            "', usdeshabilitado='" . $this->getDeshabilitado() .
            "' WHERE idusuario=" . $this->getId();
        echo "<div>" . $sql . "</div>";    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql) >= 0) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeoperacion("usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {           
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        //echo "<div>" .  $sql . "</div>";

        $res = $base->Ejecutar($sql);
        
        if ($res > -1) {
            
            if ($res > 0) {
                while ($row = $base->Registro()) {       

                        $obj = new Usuario();

                        $obj->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                        
                        array_push($arreglo, $obj);

                }                
            }  

        } else {
            throw new Exception("usuario->listar: " . $base->getError());
        }

        return $arreglo;
    }

}
?>