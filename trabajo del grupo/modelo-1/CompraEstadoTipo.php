<?php
class CompraEstadoTipo{
    private $idcompraestadotipo;
    private $cetdescripcion;
    private $cetdetalle;
    private $mensajeoperacion;

    public function __construct()
 {
    $this->idcompraestadotipo="";
    $this->cetdescripcion="";
    $this->cetdetalle= "";
 }

 /* Medodos get y set para $idcompra*/ 
 public function getIdCompraEstadoTipo() {
    return $this->idcompraestadotipo;
   }
  
public function setIdCompraEstadoTipo($idCET){
    $this->idcompraestadotipo = $idCET;
   }
 
    /* Medodos get y set para $cofecha*/ 
public function getDescripcion(){
    return $this->cetdescripcion;
    }
public function setDescripcion($descripcion){
    $this->cetdescripcion = $descripcion;
}
  
   /* Medodos get y set para $objUsuario*/ 
 
public function getDetalle(){
    return $this->cetdetalle;
}
public function setDetalle($detalle){
    $this->cetdetalle = $detalle;
}

public function getMensajeOperacion(){
    return $this->mensajeoperacion;
  }
  public function setMensajeOperacion($valor){
    $this->mensajeoperacion = $valor;
  }

  public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle) {
    $this->setIdCompraEstadoTipo($idcompraestadotipo);
    $this->setDescripcion($cetdescripcion);
    $this->setDetalle($cetdetalle);
  }

    /**
	 * Recupera los datos del usuario por idusuario
	 * @param int $idusuario
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
	public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = '".$this->getIdCompraEstadoTipo()."'";
        if ($base->Iniciar()) {
          $res = $base->Ejecutar($sql);
          if ($res > -1) {
            if ($res > 0) {
              $row = $base->Registro();

     
              $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'],$row['cetdetalle']);
            }
          }
        } else {
          $this->setMensajeOperacion("CompraEstadoTipo->listar: ".$base->getError());
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

        $sql = "INSERT INTO compraestadotipo (idcompraestadotipo, cetdescripcion, cetdetalle) VALUES ('".$this->getIdCompraEstadoTipo()."', '".$this->getDescripcion()."','".$this->getDetalle()."')";
     
        if ($base->Iniciar()) {
          if ($elId = $base->Ejecutar($sql)) {
           // $this->setIdCompraEstadoTipo($elId);  Chuequear esto si algo falla
            $resp = true;
          } else {
            $this->setmensajeoperacion("CompraEstadoTipo->insertar: ".$base->getError()[2]);
          }
        } else {
          $this->setMensajeOperacion("CompraEstadoTipo->insertar: ".$base->getError()[2]);
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
        $sql = "UPDATE compraestadotipo SET idcompraestadotipo = '".$this->getIdCompraEstadoTipo()."', cetdescripcion = '".$this->getDescripcion()."','".$this->getDetalle()."' WHERE idcompraestadotipo = '".$this->getIdCompraEstadoTipo()."'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->modificar: ".$base->getError());
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

        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getIdCompraEstadoTipo()."";

        if ($base->Iniciar()) {
          if ($base->Ejecutar($sql)) {
            return true;
          } else {
            $this->setMensajeOperacion("CompraEstadoTipo->eliminar: ".$base->getError());
          }
        } else {
          $this->setMensajeOperacion("CompraEstadoTipo->eliminar: ".$base->getError());
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
    public function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
    
        $sql = "SELECT * FROM compraestadotipo ";
    
       if ($parametro != "") {
         $sql .= " WHERE .$parametro";
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
        }
            return $arreglo;
        }

        /**
     * Esta función lee todos los valores de todos los atributos del objeto y los devuelve
     * en un arreglo asociativo
     * 
     * @return array
     */
    public function obtenerInfo(){

        $info = [];
        $info['idcompraestadotipo'] = $this->getIdCompraEstadoTipo();
        $info['cetdescripcion'] = $this->getDescripcion();
        $info['cetdetalle'] =$this->getDetalle();
        return $info;
    }

}
?>