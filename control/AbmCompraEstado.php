<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AbmCompraEstado{

     /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjeto($param){
        //print_r($param);
        $obj = null;
        if(array_key_exists('idcompra',$param) and array_key_exists('idcompraestadotipo',$param) and array_key_exists('cefechaini',$param) and array_key_exists('cefechafin',$param)){
        
            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idcompra']);
            $objCompra->cargar();
            $objTipoEstado = new CompraEstadoTipo();
            $objTipoEstado->setIdCompraEstadoTipo($param['idcompraestadotipo']);
            $objTipoEstado->cargar();

            $obj = new CompraEstado();
            $obj->setear(null, $objCompra,$objTipoEstado,$param['cefechaini'],$param['cefechafin']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     *  que son claves
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if(isset($param['idcompraestado']) ){
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'],null,null,null,null);
        }
        return $obj;
    }


     /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idcompraestado']))
            $resp = true;
        return $resp;
    }


    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $unObjCompraEstado = $this->cargarObjeto($param);
        if ($unObjCompraEstado!=null && $unObjCompraEstado->insertar()){
            $resp = true;
        }
        return $resp;
        
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $unObjCompraEstado = $this->cargarObjetoConClave($param);
            if ($unObjCompraEstado!=null && $unObjCompraEstado->eliminar()){
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
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $unObjCompraEstado = $this->cargarObjeto($param);
            if($unObjCompraEstado!=null && $unObjCompraEstado->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
   /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = "true ";
        if ($param<>null){
            if (isset($param['idcompraestado']))
            $where .= " AND idcompraestado = '" . $param['idcompraestado'] . "'";
        if (isset($param['idcompra']))
            $where .= " AND idcompra = '" . $param['idcompra'] . "'";
        if (isset($param['idcompraestadotipo']))
            $where .= " AND idcompraestadotipo = '" . $param['idcompraestadotipo'] . "'";
        if (isset($param['cefechaini']))
            $where .= " AND cefechaini = '" . $param['cefechaini'] . "'";
        if (isset($param['cefechafin']))
            $where .= " AND cefechafin = '" . $param['cefechafin'] . "'";
        }
        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

   
    public function enviarCorreoEstadoCompra($compra, $nuevoEstado) {
        $mail = new PHPMailer(true);
    
        try {
        
            // Mapear estados a mensajes
            $estadosMensajes = [
                2 => 'Aceptada',
                3 => 'Enviada',
                4 => 'Cancelada'
            ];
    
            $asunto = "Estado de tu compra #" . $compra->getObjCompra()->getIdCompra();
            $mensaje = "Estimado/a Cliente,\n\n";
            $mensaje .= "El estado de tu compra #{$compra->getObjCompra()->getIdCompra()} ha sido actualizado a: {$estadosMensajes[$nuevoEstado]}.\n";
            
            // Configuración SMTP 
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'martin.paredes@est.fi.uncoma.edu.ar';
            $mail->Password   = 'ASDAS';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
    
            // Configurar correo
            $mail->setFrom('martin.paredes@est.fi.uncoma.edu.ar', 'TP_FINAL_PWD');
            $mail->addAddress('mdep171@gmail.com','Martin Paredes');
            $mail->addAddress('fran.canoeslalom@gmail.com','Francisco Pandolfi');
            $mail->addAddress('esteban.pilchuman@est.fi.uncoma.edu.ar','Esteban Pilchuman');
            $mail->addAddress('leonardoandrespacheco1998@gmail.com','Leonardo Pacheco');
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = nl2br($mensaje);
    
            // Enviar correo
            $mail->send();
            
            return true;
        } catch (Exception $e) {
            // Opcional: loguear el error
            error_log("Error enviando correo: " . $mail->ErrorInfo);
            return false;
        }
    }


    
}

?>