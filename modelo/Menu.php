<?php
class Menu {

    private $idmenu;
    private $menombre ;
    private $medescripcion;
    private $menuPadre;//guarda un objeto Menu con el cual se llama al idmenu que es el idpadre
    private $medeshabilitado;
    private $mensajeoperacion;

    public function __construct(){
        $this->idmenu="";
        $this->menombre="" ;
        $this->medescripcion="";
        $this->menuPadre = null;
        $this->medeshabilitado = "";
        $this->mensajeoperacion ="";     
    }

    public function setear($idmenu,$menombre,$medescripcion,$menuPadre,$medeshabilitado){
        $this->setIdMenu($idmenu);
        $this->setMeNombre($menombre);
        $this->setMeDescripcion($medescripcion);
        $this->setMenuPadre($menuPadre);
        $this->setMeDeshabilitado($medeshabilitado);
    }

    /* Medodos get y set para $idmenu*/ 
    public function getIdMenu(){
        return $this->idmenu;
    }
    public function setIdMenu($idmenu){
        $this->idmenu = $idmenu;
    }

    /* Medodos get y set para $menombre*/
    public function getMeNombre(){
        return $this->menombre;
    }
    public function setMeNombre($menombre){
        $this->menombre = $menombre;
    }

     /* Medodos get y set para $medescripcion*/
    public function getMeDescripcion(){
        return $this->medescripcion;
    }
    public function setMeDescripcion($medescripcion){
        $this->medescripcion = $medescripcion;
    }

    /* Medodos get y set para $menuPadre*/
    public function getMenuPadre(){
        return $this->menuPadre;
    }
    public function setMenuPadre($menuPadre){
        $this->menuPadre = $menuPadre;
    }

    /* Medodos get y set para $medeshabilitado*/
    public function getMeDeshabilitado(){
        return $this->medeshabilitado;
    }
    public function setMeDeshabilitado($medeshabilitado){
        $this->medeshabilitado = $medeshabilitado;
    }

     /* Medodos get y set para mensajeoperacion*/ 
    public function getMensajeOperacion(){
       return $this->mensajeoperacion;
    }
    public function setMensajeOperacion($valor){
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
        $sql="SELECT * FROM menu WHERE idmenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
          $res = $base->Ejecutar($sql);
          if ($res > -1) {
            if ($res > 0) {
                $row = $base->Registro();
                $objMenuPadre =null;
                if ($row['idpadre']!=null or $row['idpadre']!= '' ){
                    $objMenuPadre = new Menu();
                    $objMenuPadre->setIdMenu($row['idpadre']);
                    $objMenuPadre->cargar();
                }
                $this->setear($row['idmenu'], $row['menombre'],$row['medescripcion'],$objMenuPadre,$row['medeshabilitado']); 
          }
        } else {
          $this->setMensajeOperacion("Menu->listar: ".$base->getError());
        }
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

        $idPadre[0] = ",";
        $idPadre[1] = ",";
        /**Si el menu padre es distinto de nulo y menu padre es distinto de "" */
        if($this->getMenuPadre() != null && $this->getMenuPadre()->getIdMenu() != ""){
            $idPadre[0] = ",idpadre,";
            $idPadre[1] = ",idpadre = '". $this->getMenuPadre()->getIdMenu() . "',";
        }


        $sql = "INSERT INTO menu(menombre, medescripcion". $idPadre[0] ."medeshabilitado)
        VALUES ('" . $this->getMeNombre() . "', '". $this->getMeDescripcion() ."'". $idPadre[1] ."
        '". $this->getMeDeshabilitado() ."');";
       
       if ($base->Iniciar()) {
         if ($elid = $base->Ejecutar($sql)) {
            $this->setIdMenu($elid);
            $resp = true;
        } else {
            $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
        }
        } else {
        $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
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
        

        $deshabilitado = "'".$this->getMeDeshabilitado()."'";
        if ($this->getMeDeshabilitado() == null){
            $deshabilitado = 'NULL';
        }

        $sql = "UPDATE menu SET menombre= '".$this->getMeNombre()."', medescripcion = '".$this->getMeDescripcion()."' 
        ,idpadre = '".$this->getMenuPadre()->getIdMenu()."',medeshabilitado = ".$deshabilitado." WHERE idmenu = ".$this->getIdMenu()."";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
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

        $sql="DELETE FROM menu WHERE idmenu =".$this->getIdMenu();
     
         if ($base->Iniciar()) {
             if ($base->Ejecutar($sql)) {
                 $resp = true;
             } else {
                 $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
             }
         } else {
             $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
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
    
        $sql="SELECT * FROM menu ";
        
        if ($parametro!="") {
            $sql.=' WHERE '.$parametro;
            
        }
        $res = $base->Ejecutar($sql);

        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj = new Menu();
                    $objMenuPadre =null;
                    if ($row['idpadre']!=null){
                        $objMenuPadre = new Menu();
                        $objMenuPadre->setIdMenu($row['idpadre']);
                        $objMenuPadre->cargar();
                    }
                    $obj->setear($row['idmenu'], $row['menombre'],$row['medescripcion'],$objMenuPadre,$row['medeshabilitado']); 
                    array_push($arreglo, $obj);
                }     
            }   
        } 
        return $arreglo;
        }

     /**
      * Funcion desabilitar
      * Esta función Actualiza el valor de medeshabilitado por un string fecha actual
      *
     **/
     public function deshabilitar(){
        $resp = false;
        $base = new BaseDatos();

       $fechaBaja= date('Y-m-d H:i:s');
    
        // Actualiza el valor de usdeshabilitado
        $sql = "UPDATE menu SET medeshabilitado = '".$fechaBaja."' WHERE idmenu = ".$this->getIdMenu();
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("menu->deshabilitar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->deshabilitar: " . $base->getError());
        }
    
        return $resp;
    }

      /**
     * Esta función lee todos los valores de todos los atributos del objeto y los devuelve
     * en un arreglo asociativo
     * 
     * @return array
     */
    public function obtenerInfo(){
        $info = [];
        $info['idmenu'] = $this->getMenuPadre()->getIdMenu();
        $info['menombre'] = $this->getMeNombre();
        $info['medescripcion'] =$this->getMeDescripcion();
        $info['medeshabilitado'] =$this->getMeDeshabilitado();
        return $info;
    }

}
?>