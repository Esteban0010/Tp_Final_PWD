<?php
 class CompraItem extends BaseDatos{
    private $idcompraitem;
    private $objProducto;
    private $objCompra;
    private $cicantidad;
    private $mensajeoperacion;
    
    public function __construct(){
    $this->idcompraitem="";
    $this->objProducto=new Producto();
    $this->objCompra=new Compra();
    $this->cicantidad="";
    }

 /* Medodos get y set para $idcompraitem*/ 
    public function getIdCompraItem(){
        return $this->idcompraitem;
    }
    public function setIdCompraItem($idcompraitem){
        $this->idcompraitem = $idcompraitem;
    }

 /* Medodos get y set para $objProducto*/ 
   public function getObjProducto(){
       return $this->objProducto;
   }
   public function setObjProducto($objProducto){
       $this->objProducto = $objProducto;
   }

 /* Medodos get y set para $objCompra*/ 
   public function getObjCompra(){
       return $this->objCompra;
   }
   public function setObjCompra($objCompra){
       $this->objCompra = $objCompra;
   }

 /* Medodos get y set para $cicantidad*/ 
  public function getCiCantidad(){
     return $this->cicantidad;
  }
  public function setCiCantidad($cicantidad){
     $this->cicantidad = $cicantidad;
  }

 /* Medodos get y set para mensajeoperacion*/ 
   public function getMensajeOperacion(){
    return $this->mensajeoperacion;
  }
  public function setMensajeOperacion($valor){
    $this->mensajeoperacion = $valor;
  }

  public function setear($idcompraitem, $objProducto, $objCompra, $cicantidad) {
    $this->setIdCompraItem($idcompraitem);
    $this->setObjProducto($objProducto);
    $this->setObjCompra($objCompra);
    $this->setCiCantidad($cicantidad);
 }

   /**
	 * Recupera los datos de compraitem por IDcompraitem
	 * @param int $idcompraitem 
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
	public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = '".$this->getIdCompraItem()."'";
        if ($base->Iniciar()) {
          $res = $base->Ejecutar($sql);
          if ($res > -1) {
            if ($res > 0) {
              $row = $base->Registro();
    
              $objProducto = new Producto();
              $objProducto->setIdProducto($row['idproducto']);
              $objProducto->cargar();
    
              $objCompra = new Compra;
              $objCompra->setIdCompra($row['idcompra']);
              $objCompra->cargar();
    
              $this->setear($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
            }
          }
        } else {
          $this->setMensajeOperacion("CompraItem->listar:  ".$base->getError());
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

        $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) VALUES
         ('".$this->getObjProducto()->getIdProducto()."', '".$this->getObjCompra()->getIdCompra()."','". $this->getCiCantidad()."')";
    
        if ($base->Iniciar()) {
          if ($elId = $base->Ejecutar($sql)) {
            $this->setIdCompraItem($elId);
    
            $resp = true;
          } else {
            $this->setMensajeOperacion("CompraItem->listar: ".$base->getError());
          }
        } else {
          $this->setMensajeOperacion("CompraItem->listar: ".$base->getError());
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
        $sql = "UPDATE compraitem SET idproducto = '".$this->getObjProducto()->getIdProducto()."', idcompra = '".$this->getObjCompra()->getIdCompra().
        "', cicantidad = '".$this->getCiCantidad()."' WHERE idcompraitem = '".$this->getIdCompraItem()."' ";
        if ($base->Iniciar()) {
          if ($base->Ejecutar($sql)) {
            $resp = true;
          } else {
                $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
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

        $sql = "DELETE FROM compraitem WHERE idcompraitem= ".$this->getIdCompraItem()."";
        
        if ($base->Iniciar()) {
          if ($base->Ejecutar($sql)) {
            return true;
          } else {
            $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
          }
        } else {
          $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
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
    
        $sql = "SELECT * FROM compraitem ";
    
       if ($parametro != "") {
         $sql .= " WHERE $parametro";
        }
        //echo $sql."<br>";
       $res = $base->Ejecutar($sql);
       if ($res > -1) {
         if ($res > 0) {
           while ($row = $base->Registro()) {
            
            $obj = new CompraItem();
    
            $objCompra = new Compra();
            $objCompra->setIdCompra($row['idcompra']);
            $objCompra->cargar();
  
            $objProducto = new Producto();
            $objProducto->setIdProducto($row['idproducto']);
            $objProducto->cargar();
  
            $obj->setear($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
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
        $info['idcompraitem'] = $this->getIdCompraItem();
        $info['idproducto'] = $this->getObjProducto()->getIdProducto();
        $info['idcompra'] = $this->getObjCompra()->getIdCompra();
        $info['cicantidad'] =$this->getCiCantidad();
        return $info;
    }

}