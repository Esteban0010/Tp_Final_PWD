<?php
class CompraItem
{
    private $idCompraItem;
    private $objProducto;
    private $objCompra;
    private $cantidad;
    private $mensajeFuncion;


    
    public function setIdCompraItem($idCompraItem)
    {
        $this->idCompraItem = $idCompraItem;
    }

    
    public function setObjProducto($objProducto)
    {
        $this->objProducto = $objProducto;
    }

    
    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }

   
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

   
    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

  
    public function getIdCompraItem()
    {
        return $this->idCompraItem;
    }

   
    public function getObjProducto()
    {
        return $this->objProducto;
    }

    
    public function getObjCompra()
    {
        return $this->objCompra;
    }

   
    public function getCantidad()
    {
        return $this->cantidad;
    }

   
    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }

   
    /************* Metodos *************/
    

    public function __construct()
    {
        $this->idCompraItem = "";
        $this->objProducto = new Producto;
        $this->objCompra = new Compra;
        $this->cantidad = ""; 
    }

    public function setear($idCompraItem, $idProducto, $idCompra, $cantidad)
    {
        $this->objProducto->setIdProducto($idProducto);
        $this->objCompra->setIdCompra($idCompra);
        $this->setIdCompraItem($idCompraItem);
        $this->setCantidad($cantidad);
        $this->objProducto->cargar();
        $this->objCompra->cargar();
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) VALUES (
		'" . $this->getObjProducto()->getIdProducto() . "',
		'" . $this->getObjCompra()->getIdCompra() . "',
		'" . $this->getCantidad() . "')";
        if ($base->Iniciar()) {
            if ($id=$base->Ejecutar($consulta)) {
                $this->setIdCompraItem($id);
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consulta = "UPDATE compraitem
        SET 
        idproducto = {$this->getObjProducto()->getIdProducto()},
        idcompra = {$this->getObjCompra()->getIdCompra()},
        cicantidad = {$this->getCantidad()}
        WHERE idcompraitem = {$this->getIdCompraItem()}";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        if($this->getIdCompraItem()!=''){
            $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idcompraItem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion = "")
    {
        $arregloCompraitem = null;
        $base = new BaseDatos();
        $consultaCompraItem = "SELECT * FROM compraitem ";
        if ($condicion != "") {
            $consultaCompraItem = $consultaCompraItem . ' WHERE ' . $condicion;
        }
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaCompraItem)) {
                $arregloCompraitem = array();
                while ($compraItem = $base->Registro()) {
                    $objCompraItem = new CompraItem();
                    $objCompraItem->setear($compraItem["idcompraitem"], $compraItem["idproducto"], $compraItem["idcompra"], $compraItem["cicantidad"]);
                    array_push($arregloCompraitem, $objCompraItem);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloCompraitem;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }
}