<?php
class MenuRol
{

    //ATRIBUTOS
    private $objMenu; //objeto menu
    private $objRol; //objeto rol
    private $mensajeoperacion;

    //CONSTRUCTOR
    /**
     * Devuelve un objeto MenuRol
     */
    public function __construct()
    {
        $this->objMenu = new Menu();
        $this->objRol = new Rol();
        $this->mensajeoperacion = "";
    }

    //SETEAR
    /**
     * Setea el objeto MenuRol
     * @param Menu $objMenu
     * @param Rol $objRol
     */
    public function setear($objMenu, $objRol)
    {
        $this->setObjMenu($objMenu);
        $this->setObjRol($objRol);
    }

    //MÉTODOS GET Y SET
    public function getObjMenu()
    {
        return $this->objMenu;
    }

    public function setObjMenu($objMenu)
    {
        $this->objMenu = $objMenu;
    }

    public function getObjRol()
    {
        return $this->objRol;
    }

    public function setObjRol($objRol)
    {
        $this->objRol = $objRol;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //MÉTODOS PROPIOS DE LA CLASE

    /**
     * Toma el atributo donde está cargado el id del objeto y lo utiliza para realizar
     * una consulta a la base de datos con el objetivo de actualizar el resto de los atributos del objeto.
     * Retora un booleano que indica el éxito o falla de la operación
     * 
     * @return boolean
     */
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdMenu();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "SELECT * FROM menurol WHERE idmenu = ".$idmenu." AND idrol = ".$idrol;

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {

                    $row = $base->Registro();

                    $objMenu = new Menu();
                    $objMenu->setIdMenu($row['idmenu']);
                    $objMenu->cargar();

                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();

                    $this->setear($objMenu, $objRol);

                }
            }
        } else {
            $this->setmensajeoperacion("MenuRol->listar: " . $base->getError());
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
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdMenu();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "INSERT INTO menurol (idmenu, idrol) VALUES (" . $idmenu . ", " . $idrol . ")";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {

                $resp = true;
            } else {
                $this->setmensajeoperacion("MenuRol->listar: " . $base->getError()[2]);
            }
        } else {
            $this->setmensajeoperacion("MenuRol->listar: " . $base->getError()[2]);
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
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdMenu();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "UPDATE menurol SET idrol = " . $idrol . " WHERE idmenu = " . $idmenu . "";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("MenuRol->listar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("MenuRol->listar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Esta función lee el id actual del objeto y si puede lo borra de la base de datos
     * Retorna un booleano que indica si le operación tuvo éxito
     * 
     * @return boolean
     */
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdMenu();
        $idrol = $this->getObjRol()->getIdRol();

        $sql = "DELETE FROM menurol WHERE idmenu= " . $idmenu . " AND idrol=" . $idrol . "";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("MenuRol->listar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("MenuRol->listar: " . $base->getError());
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
    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";
        if ($parametro != "") {
            $sql .= " WHERE " . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new MenuRol();

                    $objMenu = new Menu();
                    $objMenu->setIdmenu($row['idmenu']);
                    $objMenu->cargar();

                    $objRol = new Rol();
                    $objRol->setIdrol($row['idrol']);
                    $objRol->cargar();

                    $obj->setear($objMenu, $objRol);

                    array_push($arreglo, $obj);
                }
            }
        }

        return $arreglo;
    }

    /**
     * Verifica si tiene permisos para ver la pagina
     * @param int $idUsuario
     * @param $enlacePag
     * @return boolean
     */
    public function verificarPermiso($idUsuario, $enlacePag)
    {
        $resp = false;
        $base = new BaseDatos();

        /**Consulta a la base de datos si el usuario tiene el rol(permiso) para ver
         * la pagina.
         */

        $sql = "SELECT idusuario, menurol.idrol, menu.idmenu, medescripcion FROM menurol
        INNER JOIN usuariorol ON menurol.idrol = usuariorol.idrol
        INNER JOIN menu ON menu.idmenu = menurol.idmenu
        WHERE idusuario = " . $idUsuario . " AND medescripcion = '" . $enlacePag . "';";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($base->Registro()) {

                    $resp = true;

                }
            } else {
                $this->setMensajeOperacion("menurol->verificarPermiso: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->verificarPermiso: " . $base->getError());
        }

        return $resp;
    }
}
