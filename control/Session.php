<?php

/*  
    Implementar dentro de la capa de Control la clase Session con los siguientes métodos:
    
    __construct(). Constructor que. Inicia la sesión.
    
    iniciar($nombreUsuario,$psw). Actualiza las variables de sesión con los valores ingresados.
    
    validar(). Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
    
    activa(). Devuelve true o false si la sesión está activa o no.
    
    getUsuario().Devuelve el usuario logeado.
    
    getRol(). Devuelve el rol del usuario logeado.
    
    cerrar(). Cierra la sesión actual.
*/

class Session
{

    public function __construct()
    {
        session_start();
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados.
     */

    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $obj = new AbmUsuario();

        // Buscar al usuario por nombre
        $param['usnombre'] = $nombreUsuario;
        $param['uspass'] = $psw;
        $param['usdeshabilitado'] = '0000-00-00 00:00:00'; // Verifica que el usuario no esté deshabilitado
        $objUsuario = $obj->buscar($param);
        if (count($objUsuario) > 0) {
            $usuario = $objUsuario[0];
            //verEstructura($objUsuario); 
            $this->getRol();
            //verEstructura($this->getRol());           
            $_SESSION['idusuario'] = $usuario->getId();
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }




    /**
     * Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar()
    {
        $resp = false;
        if ($this->activa() && isset($_SESSION['idusuario']))
            $resp = true;
        return $resp;
    }

    /**
     *Devuelve true o false si la sesión está activa o no.
     */
    public function activa()
    {
        $resp = false;
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                /*
                    session_status() devuelve el estado de la sesión:
                        -PHP_SESSION_NONE: no hay sesión activa.
                        -PHP_SESSION_ACTIVE: ya hay una sesión activa.
                */
                $resp = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                $resp = session_id() === '' ? FALSE : TRUE;
            }
        }
        return $resp;
    }

    /**
     * Devuelve el usuario logeado.
     */
    public function getUsuario()
    {
        $usuario = null;
        if ($this->validar()) {
            $obj = new AbmUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $usuario = $resultado[0];
            }
        }
        return $usuario;
    }

    /**
     * Devuelve el rol del usuario logeado.
     */
    public function getRol()
    {
        $list_rol = null;
        if ($this->validar()) {
            //$objUsuario = new AbmUsuario();
            //$param['id'] = $_SESSION['idusuario'];
            //$resultado = $objUsuario->buscar($param);
            $objRol = new Abmrol();            
            $parametro['idrol'] = $_SESSION['idusuario'];
            //echo "<div>". $_SESSION['idusuario'] . "</div>";

            $objRol = $objRol->buscar($parametro);
            //verEstructura($objRol[0]);                    
            if (count($objRol) > 0) {
                $list_rol = $objRol[0];
            }
        }
        return $list_rol;
    }

    /**
     *Cierra la sesión actual.
     */
    public function cerrar()
    {
        $resp = true;
        session_destroy();
        // $_SESSION['idusuario']=null;
        return $resp;
    }
}
