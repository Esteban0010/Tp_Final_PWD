<?php 
class CompraEstado{
private $idcompraestado;
private $objCompra;
private $objCompraEstadoTipo;
private $cefechaini;
private $cefechafin;
private $mensajeoperacion;

public function __construct()
{
    $this->idcompraestado="";
    $this->objCompra=new Compra();
    $this->objCompraEstadoTipo=new CompraEstadoTipo();
    $this->cefechaini="";
    $this->cefechafin="";
}

 /* Medodos get y set para $idcompraestado*/ 

public function getIdCompraEstado(){
return $this->idcompraestado;
}
public function setIdCompraEstado($idcompraestado){
$this->idcompraestado = $idcompraestado;
}

 /* Medodos get y set para $objCompra*/ 
 public function getObjCompra(){
return $this->objCompra;
}
public function setObjCompra($objCompra){
$this->objCompra = $objCompra;
}

/* Medodos get y set para $objCompraEstadoTipo*/ 
public function getObjCompraEstadoTipo(){
return $this->objCompraEstadoTipo;
}
public function setObjCompraEstadoTipo($objCompraEstadoTipo){
$this->objCompraEstadoTipo = $objCompraEstadoTipo;
}

/* Medodos get y set para $cefechaini*/ 
public function getCeFechaIni(){
return $this->cefechaini;
}
public function setCeFechaIni($cefechaini){
$this->cefechaini = $cefechaini;
}

/* Medodos get y set para $cefechafin*/ 
public function getCeFechaFin(){
return $this->cefechafin;
}
public function setCeFechaFin($cefechafin){
$this->cefechafin = $cefechafin;
}

 /* Medodos get y set para mensajeoperacion*/ 
 public function getMensajeOperacion(){
    return $this->mensajeoperacion;
 }
 public function setMensajeOperacion($valor){
    $this->mensajeoperacion = $valor;
 }

 public function setear($idcompraestado, $objCompra, $objCompraEstadoTipo, $cefechaini, $cefechafin){
    $this->setIdCompraEstado($idcompraestado);
    $this->setObjCompra($objCompra);
    $this->setObjCompraEstadoTipo($objCompraEstadoTipo);
    $this->setCeFechaIni($cefechaini);
    $this->setCeFechaFin($cefechafin);
}

  /**
	 * Recupera los datos del usuario por $idcompraestado
	 * @param int $idcompraestado
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
	public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = '".$this->getIdCompraEstado()."'";
        if ($base->Iniciar()) {
          $res = $base->Ejecutar($sql);
          if ($res > -1) {
            if ($res > 0) {
              $row = $base->Registro();

              $objCompra = new Compra();
              $objCompra->setIdCompra($row['idcompra']);
              $objCompra->cargar();
    
              $objCompraEstadoTipo = new CompraEstadoTipo();
              $objCompraEstadoTipo->setIdCompraEstadoTipo($row['compraestadotipo']);
              $objCompraEstadoTipo->cargar();
    
              $this->setear($row['idcompraestado'], $objCompra, $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
            }
          }
        } else {
          $this->setMensajeOperacion("CompraEstado->listar: ".$base->getError());
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

        $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini, cefechafin) VALUES ('".$this->getObjCompra()->getIdCompra()."','". $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo().
        "','".$this->getCeFechaIni()."','". $this->getCeFechaFin()."')";

        if ($base->Iniciar()) {
          if ($id = $base->Ejecutar($sql)) {
            $this->setIdCompraEstado($id);
            $resp = true;
          } else {
            $this->setmensajeoperacion("CompraEstado->insertar: ".$base->getError());
          }
        } else {
          $this->setMensajeOperacion("CompraEstado->insertar: ".$base->getError());
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
        $sql = "UPDATE compraestado SET 
        idcompra = ".$this->getObjCompra()->getIdCompra().",
        idcompraestadotipo = ".$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo().",
        cefechaini = '".$this->getCeFechaIni()."',
        cefechafin = '" .$this->getCeFechaFin(). "'
        WHERE idcompraestado = ".$this->getIdCompraEstado();

        //echo $sql."<br>";
    
      if ($base->Iniciar()) {
   
        if ($base->Ejecutar($sql)) {
          $resp = true;
        } else {
      
          $this->setMensajeOperacion("CompraEstado->modificar: ".$base->getError());
        }
      } else {
  
        $this->setMensajeOperacion("CompraEstado->modificar: ".$base->getError());
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

      $sql = "DELETE FROM compraestado WHERE idcompraestado = ".$this->getIdCompraEstado()."";
      
      if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
          return true;
        } else {
          $this->setMensajeOperacion("compraestado->eliminar: ".$base->getError());
        }
      } else {
        $this->setMensajeOperacion("compraestado->eliminar: ".$base->getError());
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
        $sql = "SELECT * FROM compraestado ";
        if ($parametro != "") {
          $sql .= " WHERE ".$parametro;
        }
     
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
          if ($res > 0) {
            while ($row = $base->Registro()) {
              $obj = new CompraEstado();
    
              $objCompra = new Compra();
              $objCompra->setIdCompra($row['idcompra']);
              $objCompra->cargar();
    
              $objCompraEstTipo = new CompraEstadoTipo();
              $objCompraEstTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
              $objCompraEstTipo->cargar();
    
              $obj->setear($row['idcompraestado'], $objCompra, $objCompraEstTipo, $row['cefechaini'], $row['cefechafin']);
    
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
        $info['idcompraestado'] = $this->getidcompraestado();
        $info['idcompra'] = $this->getObjCompra()->getIdCompra();
        $info['idcompraestadotipo'] =$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $info['cefechaini'] = $this->getcefechaini();
        $info['cefechafin'] =$this->getcefechafin();
        return $info;
    }
    }


