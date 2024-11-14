<?php

class AbmUsuario
{

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idusuario', $param) and
            array_key_exists('usnombre', $param) and
            array_key_exists('uspass', $param) and
            array_key_exists('usmail', $param) and
            array_key_exists('usdeshabilitado', $param)
        ) {

            $obj = new Usuario();
            $obj->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     *  que son claves
     * @param array $param
     * @return Usuario
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            $obj = new Usuario();
            $obj->setear($param['idusuario'], null, null, null, null);
            $obj->cargar();
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idusuario']))
            $resp = true;
        return $resp;
    }

    /**
     * Esta función carga la información de un objeto a la base de datos
     * 
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $objUsuario = $this->cargarObjeto($param);
        if ($objUsuario != null && $objUsuario->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $unObjUsuario = $this->cargarObjeto($param);
            if ($unObjUsuario != null && $unObjUsuario->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificar($param){

        $respuesta = false;
        if ($this->seteadosCamposClaves($param)) {

            $objUsuario = $this->cargarObjeto($param);
            
            if ($objUsuario != null and $objUsuario->modificar()) {
                $respuesta = true;
            }
        }
        return $respuesta;
    }

    /**
     * Devuelve una lista con los roles de un usuario, espera
     * $param['idusuario'], retorna un
     * arreglo de objetos Rol.
     * 
     * @return array
     */
    public function buscarRoles($param)
    {
        $where = " true ";
        $arregloRol = [];
        if ($param <> null) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            /*if (isset($param['idrol']))
                $where .= " and idrol =" . $param['idrol'];*/
        }
        $obj = new UsuarioRol();
        $arregloUsuarioRol = $obj->listar($where);

        for ($i=0; $i < count($arregloUsuarioRol); $i++ ){
            $arregloRol[] = $arregloUsuarioRol[$i]->getObjRol();
        }
        return $arregloRol;
    }

    /**
     * Borra UN rol del usuario
     */
    public function borrarRol()
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $objTabla = new UsuarioRol();
            $objTabla->setear($param['idusuario'], $param['idrol']);
            $resp = $objTabla->eliminar();
        }
        return $resp;
    }

    /* permite actualizar la fecha de baja del usuario */
    public function borradoLogico($param){
        $resp=false;
        if($this->seteadosCamposClaves($param)){
            $objUsuario= $this->cargarObjetoConClave($param);
            if ($objUsuario->deshabilitar()){
                $resp= true;
                $objUsuario->cargar();
            }
        }
        return $resp;
    }

    /**
     * Permite buscar un objeto según distintos criterios.
     * Recibe un arreglo indexado que contiene los criterios de busqueda.
     * Retorna un arreglo compuesto por los objetos que cumplen el criterio indicado.
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true";
        if ($param <> null) {
            if (isset($param['idusuario']))
                $where .= " and idusuario = " . $param['idusuario'];
            if (isset($param['usnombre']))
                $where .= " and usnombre = '" . $param['usnombre'] . "'";
            if (isset($param['uspass']))
                $where .= " and uspass = '" . $param['uspass'] . "'";
            if (isset($param['usmail']))
                $where .= " and usmail = '" . $param['usmail'] . "'";
            if (isset($param['usdeshabilitado']))
                $where .= " and usdeshabilitado = '" . $param['usdeshabilitado'] . "'";
        }

        $obj = new Usuario();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * Recibe un arreglo indexado que contiene los criterios de busqueda
     * Devuelve un arreglo con la información de todos los objetos que cumplan la condición
     * recibida por parámetro
     * 
     * @param array $param
     * @return array
     */
    public function buscarColInfo($param)
    {

        $colInfo = array();
        $arregloObj = $this->buscar($param);

        if (count($arregloObj) > 0) {

            for ($i = 0; $i < count($arregloObj); $i++) {
                $colInfo[$i] = $arregloObj[$i]->obtenerInfo();
            }
        }

        return $colInfo;
    }

    /**
     * Revisa si un mail o nombre ya se encuentran en la base de datos.
     */
    public function existen($param){
        $resp = false;
        $objUsuario = new AbmUsuario();
        $datos['usnombre']=$param['usnombre'];
        $datos['usmail']=$param['usmail'];
        $busqueda = $objUsuario->buscar($datos);
        if(count($busqueda)>0){
            $resp = true;
        }
        return $resp;
    }

    public function crearUsuarioAdmin($datos){
        $resp = false;
        // Extraigo datos necesarios para la creación de usuario
        $usuario = $datos['usnombre'];
        $email = $datos['usmail'];
        $passEncriptada = md5($datos['uspass']);
        //creo los objetos Usuario y objeto UsuarioRol
        $objUsuario = new AbmUsuario();
        //Guardo los parametros del Usuario
        $paramUsuario['idusuario'] = 0;
        $paramUsuario['usnombre'] = $usuario;
        $paramUsuario['uspass'] = $passEncriptada;
        $paramUsuario['usmail'] = $email;
        $paramUsuario['usdeshabilitado'] = "'0000-00-00 00:00:00'";

        //Lo cargo a la base de datos
        $exito = $objUsuario->alta($paramUsuario);
        if($exito){
            $objUsuarioRol = new AbmUsuarioRol();

            $paramUsuario2['usnombre'] = $usuario;
            $nuevoUsuario = $objUsuario->buscar($paramUsuario2);
            $idUsuario = $nuevoUsuario[0]->getIdUsuario();
            $paramUsuarioRol['idusuario'] = $idUsuario;
            //echo $idUsuario."<br>";
            if(array_key_exists('Cliente', $datos)){
                //echo "Entro a Cliente <br>";
                $paramUsuarioRol['idrol'] = 3;
                //verEstructura($paramUsuarioRol);
                $objUsuarioRol->alta($paramUsuarioRol);
            }
            if(array_key_exists('Deposito', $datos)){
                $paramUsuarioRol['idrol'] = 2;
                $objUsuarioRol->alta($paramUsuarioRol);
            }
            if(array_key_exists('Admin', $datos)){
                $paramUsuarioRol['idrol'] = 1;
                $objUsuarioRol->alta($paramUsuarioRol);
            }
            $nuevaCompra = new AbmCompra();
            $aux['idcompra'] = 0;
            $aux['cofecha'] = null;
            $aux['idusuario'] = $idUsuario;
            $nuevaCompra->alta($aux);
            $resp = true;
            
        }
        return $resp;
    }

    public function crearUsuario($datos){
        $resp = false;
        $usnombre = $datos['usnombre'];
        $usmail = $datos['usmail'];

        $param['usnombre'] = $usnombre;
        $param['usmail'] = $usmail;
        $param['idusuario'] = 0;
        $param['uspass'] = md5(123456);
        $param['usdeshabilitado'] = NULL;

        $objUsuario = new AbmUsuario();
        $resultado = $objUsuario->alta($param);// poner el resulstado de crear al usuario (true o false)
        if($resultado){
            $buscarNuevoUsuario = $objUsuario->buscar($datos);
            $idusuario = $buscarNuevoUsuario[0]->getIdUsuario();
            $nuevaCompra = new AbmCompra();
            $aux['idcompra'] = 0;
            $aux['cofecha'] = null;
            $aux['idusuario'] = $idusuario;
            $nuevaCompra->alta($aux);
            $resp = true;
        }
        return $resp;
    }
}

?>