<?php
class Rol{

    private $idrol;
    private $roldescripcion;
    private $mensajeoperacion;

    public function __construct(){
        $this->idrol = "";
        $this->roldescripcion = "";
    }

    public function setear($id, $roldesc){
        $this->setIdRol($id);
        $this->setRolDescripcion($roldesc);
    }
    
    /* Medodos get y set para idrol*/ 
    public function getIdRol(){
        return $this->idrol;
    }
    public function setIdRol($valor){
        $this->idrol = $valor;
    }

    /* Medodos get y set para roldescripcion*/ 
    public function getRolDescripcion(){
        return $this->roldescripcion;
    }
    public function setRolDescripcion($valor){
        $this->roldescripcion = $valor;
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
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol WHERE idrol = '".$this->getIdRol()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $resp = true;
                    $row = $base->Registro();
                    $this->setear($row['idrol'], $row['rodescripcion']);
                }
            }
        } else {
            $this->setmensajeoperacion("Rol->listar: ".$base->getError());
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
        $base=new BaseDatos();
        $sql="INSERT INTO rol(idrol,rodescripcion) 
		 VALUES('".$this->getIdRol()."','".$this->getRolDescripcion()."');";
         
         if ($base->Iniciar()){

            if ($elId = $base->Ejecutar($sql)) {
              $this->setIdRol($elId);
              $resp = true;
            } else {
                $this->setMensajeoperacion("Rol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("Rol->insertar: ".$base->getError());
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
        $base=new BaseDatos();
        
        $sql = "UPDATE rol SET rodescripcion = '".$this->getRolDescripcion()
        ."' WHERE idrol = ".$this->getIdRol();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("Rol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("Rol->modificar: ".$base->getError());
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
        $sql = "DELETE FROM rol WHERE idrol = ".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("Rol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("Rol->eliminar: ".$base->getError());
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
        $base=new BaseDatos();
        $sql="SELECT * FROM rol ";
        if ($parametro!="") {
            $sql .= ' WHERE '.$parametro;
        }
        
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Rol();
                    $obj->setear($row['idrol'],$row['rodescripcion']);
                    array_push($arreglo, $obj);
                }  
            }
            
        } else {
            $this->setMensajeoperacion("Rol->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

    /**
     * Esta función lee todos los valores de todos los atributos del objeto y los devuelve
     * en un arreglo asociativo
     * 
     * @return array
     */
    public function __toString(){
	    return "id rol: ".$this->getIdRol()."\nDescripcion: ".$this->getRolDescripcion()."\n\n";
			
	}
}

?>