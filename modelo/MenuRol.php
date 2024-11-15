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

   
    //metodos

    /**CREATE TABLE `menurol` (
        `idmenu` bigint(20) NOT NULL,
        `idrol` bigint(20) NOT NULL,
        PRIMARY KEY  (`idmenu`,`idrol`),
        FOREIGN KEY (`idmenu`) REFERENCES `menu`(`idmenu`) ON UPDATE CASCADE,
        FOREIGN KEY (`idrol`) REFERENCES `rol`(`idrol`) ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    */
    //cargar
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdmenu();
        $idrol = $this->getObjRol()->getId();

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

    //insertar
    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdmenu();
        $idrol = $this->getObjRol()->getId();

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


   //modificar
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdmenu();
        $idrol = $this->getObjRol()->getId();

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

   //eliminar
    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idmenu = $this->getObjMenu()->getIdmenu();
        $idrol = $this->getObjRol()->getId();

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

   //listar
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
                    $objRol->setId($row['idrol']);
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