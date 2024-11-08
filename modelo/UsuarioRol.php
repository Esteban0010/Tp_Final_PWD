<?php

class UsuarioRol {

    //ATRIBUTOS
    private $objUsuario;
    private $objRol;
    private $mensajeoperacion;

    //CONSTRUCTOR
    /**
     * Crea un objeto de tipo UsuarioRol
     */
    public function __construct(){

        $this->objUsuario = null;
        $this->objRol = null;
        $this->mensajeoperacion = "";
    }

    /**
     * Actualiza los atributos del objeto por los recibidos por parámetro
     * 
     * @param Usuario $objUsuario
     * @param Rol $objRol
     */
    public function setear($objUsuario, $objRol){

        $this->setObjUsuario($objUsuario);
        $this->setObjRol($objRol);
    }
    
    //OBSERVADORES Y MODIFICADORES

    /**
     * @return Usuario
     */
    public function getObjUsuario(){
        return $this->objUsuario;
    }
    public function setObjUsuario($valor){
        $this->objUsuario = $valor;
    }

    /**
     * @return Rol
     */
    public function getObjRol(){
        return $this->objRol;
    }
    public function setObjRol($valor){
        $this->objRol = $valor;
    }

    /**
     * @return string
     */
    public function getMensajeoperacion(){
        return $this->mensajeoperacion;
    }
    public function setMensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    //PROPIOS DE LA CLASE

    /**
     * Toma el atributo donde está cargado el id del objeto y lo utiliza para realizar
     * una consulta a la base de datos con el objetivo de actualizar el resto de los atributos del objeto. 
     * Retora un booleano que indica el éxito o falla de la operación
     * 
     * @return boolean
     */
	public function cargar(){
        $resp = false;
        $base = new BaseDatos();

        $idusuario = $this->getObjUsuario()->getIdUsuario();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "SELECT * FROM usuariorol WHERE idusuario = ".$idusuario." AND idrol = ".$idrol;

        //Verifica si esta activa la base de datos
        if ($base->Iniciar()) {

            //Ejercuta la consulta (en este caso es un select, debe devolver un arreglo de registros)
            $res = $base->Ejecutar($sql);

            //Si $res es mayor a -1 quiere decir que la consulta se ejecuto con éxito
            if($res >- 1){

                //Si $res es mayor a 0 quiere decir que la consulta genero al menos 1 registro
                if($res > 0){

                    /*Guardo en el arreglo $row el resultado del primer registro obtenido y seteo   
                    esos valores al objeto actual*/
                    $row = $base->Registro();

                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->cargar();

                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();

                    $this->setear($objUsuario, $objRol);
                }
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->listar: ".$base->getError());
        }
        return $resp;      
    }

    /**
     * Esta función lee los valores actuales de los atributos del objeto e inserta un nuevo
     * registro en la base de datos a partir de ellos. Retorna un booleano que indica 
     * si la operación tuvo éxito
     * 
     * @return boolean
     */
    public function insertar(){
        $resp = false;
        $base = new BaseDatos();

        $idusuario = $this->getObjUsuario()->getIdUsuario();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "INSERT INTO usuariorol (idusuario, idrol) VALUES ("
            .$idusuario .", "
            .$idrol. ");";

        echo $sql ."<br>";

        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;

            } else {
                $this->setMensajeoperacion("UsuarioRol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("UsuarioRol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    /**
     * Esta función lee los valores actuales de los atributos del objeto y los actualiza en la
     * base de datos. Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();

        $idusuario = $this->getObjUsuario()->getIdUsuario();
        $idrol = $this->getObjRol()->getIdRol();
        
        $sql = "UPDATE usuariorol SET 
        idrol = ".$idrol.
        " WHERE  idusuario = ".$idusuario;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("UsuarioRol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("UsuarioRol->modificar: ".$base->getError());
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

        $idusuario = $this->getObjUsuario()->getIdUsuario();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "DELETE FROM usuariorol WHERE idusuario = ".$idusuario." AND idrol = ".$idrol;
        //echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("UsuarioRol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("UsuarioRol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    /**
     * Esta función recibe condiciones de busqueda en forma de consulta sql para obtener
     * los registros requeridos,
     * si por parámetro se envía el valor "" se devolveran todos los registros de la tabla
     * La función devuelve un arreglo compuesto por todos los objetos que cumplen la condición indicada
     * por parámetro
     * 
     * @return array
     */
	public function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();

        $sql = "SELECT * FROM usuariorol ";
        if ($parametro!="") {
            $sql .= ' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {

                    $objUsuario = null;
                    $objRol = null;

                    if ($row['idrol'] != null) {
                        $objRol = new Rol();
                        $objRol->setIdRol($row['idrol']);
                        $objRol->cargar();
                    }

                    if ($row['idusuario'] != null) {
                        $objUsuario = new Usuario();
                        $objUsuario->setIdUsuario($row['idusuario']);
                        $objUsuario->cargar();
                    }
                    $obj = new UsuarioRol();
                    $obj->setear($objUsuario, $objRol);
                    array_push($arreglo, $obj);
                }
            }   
        } else {
            $this->setMensajeoperacion("UsuarioRol->listar: ".$base->getError());
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
	    return "id usuario: ".$this->getObjUsuario()->getIdUsuario()."\n id rol: ".$this->getObjRol()->getIdRol()."\n\n";	
	}
}
?>