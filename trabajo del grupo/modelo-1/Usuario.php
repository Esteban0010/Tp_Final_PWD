<?php

class Usuario {
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;
    private $mensajeoperacion;

    public function __construct(){
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
    }

    public function setear($id, $nom, $pass, $mail, $des){
        $this->setIdUsuario($id);
        $this->setUsNombre($nom);
        $this->setUsPass($pass);
        $this->setUsMail($mail);
        $this->setUsDeshabilitado($des);
    }
     
    /* Medodos get y set para idusuario*/

    /**
     * Devuelve el id de usuario
     */
    public function getIdUsuario(){
        return $this->idusuario;
    }
    public function setIdUsuario($valor){
        $this->idusuario = $valor;
    }

   /* Medodos get y set para usnombre*/ 
    public function getUsNombre(){
        return $this->usnombre;
    }
    public function setUsNombre($valor){
        $this->usnombre = $valor;
    }

    /* Medodos get y set para uspass */ 
    public function getUsPass(){
        return $this->uspass;
    }
    public function setUsPass($valor){
        $this->uspass = $valor;
    }

    /* Medodos get y set para usmail*/ 
    public function getUsMail(){
        return $this->usmail;
    }
    public function setUsMail($valor){
        $this->usmail = $valor;
    }

    
    /* Medodos get y set para usdeshabilitado*/
    public function getUsDeshabilitado(){
        return $this->usdeshabilitado;
    }
    public function setUsDeshabilitado($valor){
        $this->usdeshabilitado = $valor;
    } 

    /* Medodos get y set para mensajeoperacion*/
    public function getMensajeoperacion(){
        return $this->mensajeoperacion;
    }
    public function setMensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    /**
	 * Recupera los datos del usuario por idusuario
	 * @param int $idusuario
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
	public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM usuario WHERE idusuario = ".$this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Usuario->listar: ".$base->getError());
        }
        return $resp;
      
    }

    /**
     * Esta función lee los valores actuales de los atributos del objeto e inserta un nuevo
     * registro en la base de datos a partir de ellos.
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function insertar(){

        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) 
        VALUES('".$this->getUsNombre()."','".$this->getUsPass()."','".$this->getUsMail()."', '0000-00-00 00:00:00');";

        if ($base->Iniciar()){
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdUsuario($id);
                $resp = true;
            } else {
                $this->setMensajeoperacion("Usuario->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("Usuario->insertar: ".$base->getError());
        }
        return $resp;
    }

    /**
     * Esta función lee los valores actuales de los atributos del objeto y los actualiza en la
     * base de datos.
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();

        $sql = "UPDATE usuario SET usnombre = '".$this->getUsNombre()."', uspass = '".$this->getUsPass()
        ."', usmail = '".$this->getUsMail()."', usdeshabilitado='".$this->getUsDeshabilitado()
        ."' WHERE idusuario = ".$this->getIdUsuario();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("Usuario->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("Usuario->modificar: ".$base->getError());
        }
        return $resp;
    }

    /**
     * Esta función lee el id actual del objeto y si puede lo borra de la base de datos
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario = ".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeoperacion("Usuario->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("Usuario->eliminar: ".$base->getError());
        }
        return $resp;
    }
   

    /**
     * Esta función recibe condiciones de busqueda en forma de consulta sql para obtener
     * los registros requeridos.
     * Si por parámetro se envía el valor "" se devolveran todos los registros de la tabla
     * 
     * La función devuelve un arreglo compuesto por todos los objetos que cumplen la condición indicada
     * por parámetro
     * 
     * @return array
     */
    public function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();

        $sql = "SELECT * FROM usuario ";

        if ($parametro!="") {
            $sql .= " WHERE ".$parametro;
        }
      
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Usuario();
                    $obj->setear($row['idusuario'],$row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }               
            }
            
        } else {
            $this->setMensajeoperacion("Usuario->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
 
    /**
     * Funcion desabilitar
     * Esta función Actualiza el valor de usdeshabilitado por un string fecha actual
     *
     */
    public function deshabilitar(){
        $resp = false;
        $base = new BaseDatos();

        $fechaBaja = date('Y-m-d H:i:s');
        
        // Actualiza el valor de usdeshabilitado
        $sql = "UPDATE usuario SET usdeshabilitado = '".$fechaBaja."' WHERE idusuario = " . $this->getIdUsuario();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeoperacion("Usuario->desabilitar: " . $base->getError());
            }
        } else {
            $this->setMensajeoperacion("Usuario->desabilitar: " . $base->getError());
        }
        
        return $resp;
    }
       
    /**
     * Esta función lee todos los valores de todos los atributos del objeto y los devuelve
     * en un arreglo asociativo
     * 
     * @return array
     */
    public function __toString(){
	    return "IdUsuario: ".$this->getIdUsuario()."\nNombre: ".$this->getUsNombre()."\nPass: ".$this->getUsPass().
        "\nMail: ".$this->getUsMail()."\nDeshabilitado: ".$this->getUsDeshabilitado()."\n\n";		
	}

    /**
     * Esta función lee todos los valores de todos los atributos del objeto y los devuelve
     * en un arreglo asociativo
     * 
     * @return array
     */
    public function obtenerInfo(){

        $info = [];
        $info['idusuario'] = $this->getIdUsuario();
        $info['usnombre'] = $this->getUsNombre();
        $info['uspass'] = $this->getUsPass();
        $info['usmail'] = $this->getUsMail();

        return $info;
    }

}

?>