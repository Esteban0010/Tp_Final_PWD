<?php
include_once("../../configuracion.php");
include_once "../Estructura/Header.php";
$datos = data_submitted();
//verEstructura($datos);
$objAbmUsuario = new AbmUsuario();

$obj =NULL;
if (isset($datos['idusuario']) && $datos['idusuario'] <> -1){
    $listaTabla = $objAbmUsuario->buscar($datos);
    if (count($listaTabla)==1){
        $obj= $listaTabla[0];

        //$objAbmRol = new AbmRol();
        //$listaRol = $objAbmRol->buscar($datos);
        //$objRol= $listaRol[0];
    }
} else {
    echo "<div>no hay nada</div>";
}
/*
(esto es para verificar si el id de Session sigue activo y darme cuenta de otros detalles para utilizar, muy interesante!)

$objSession = new Session();
$res = $objSession->validar();
if($res){
    echo "<div>si session</div>";
} else {
    echo "<div>no session</div>";
}
verEstructura($objSession->getUsuario());*/
?>
    
    <div class="container d-flex justify-content-center align-items-center"  style="height: 79vh;">
        
        <!-- form -->
        <form method="POST" action="Action/actionActualizarLogin.php" class="bg-white p-4 rounded shadow" style="width: 100%; max-width: 600px;">

            <!-- input hidden -->
            <!-- id -->
            <input type="hidden" id="idusuario" name ="idusuario" value="<?php echo ($obj !=null) ? $obj->getId() : "-1"?>" readonly required>
            <!-- accion -->
            <input type="hidden" id="accion" name ="accion" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>">
            <!-- deshabilitado -->
            <input type="hidden" id="usdeshabilitado" name="usdeshabilitado" class="form-control" value="<?php echo $obj->getDeshabilitado(); ?>">

            <!-- nombre de usuario -->
            <div class="row mb-12">
                <div class="col-sm-12">
                    <div class="form-group has-feedback">
                        <label for="usnombre" class="control-label my-1">Nombre:</label>
                        <div class="input-group">
                            <input type="text" id="usnombre" name ="usnombre" class="form-control" value="<?php echo ($obj !=null) ? $obj->getNombre() : ""?>" required >
                        </div>
                    </div>
                </div>
            </div>

            <!-- uspass -->
            <div class="row mb-12">
                <div class="col-sm-12">
                    <div class="form-group has-feedback">
                        <label for="uspass" class="control-label my-1">Password:</label>
                        <div class="input-group">
                            <input type="password" id="uspass" name ="uspass" class="form-control" value="<?php echo ($obj !=null) ? $obj->getPassword() : ""?>" required >
                        </div>
                    </div>
                </div>
            </div>

            <!-- usmail -->
            <div class="row mb-12">
                <div class="col-sm-12">
                    <div class="form-group has-feedback">
                        <label for="usmail" class="control-label my-1">Mail:</label>
                        <div class="input-group">
                            <input type="email" id="usmail" name ="usmail" class="form-control" value="<?php echo ($obj !=null) ? $obj->getMail() : ""?>" required >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripcion del Rol-->
            <!-- <div class="row mb-12">
                <div class="col-sm-12">
                    <div class="form-group has-feedback">
                        <label for="nombre" class="control-label my-1">Rol:</label>
                        <div class="input-group">
                            <select class="form-select" id="rol" name="rol" >
                                <?php                               
                                    /*if ($objRol != null){
                                        echo '<option selected value="'.$objRol->getDescripcion().'">'.$objRol->getDescripcion().' </option>';  
                                        if($objRol->getDescripcion() == 'cliente'){
                                            echo '<option value="vendedor">vendedor</option>';
                                        } else {
                                            echo '<option value="cliente">cliente</option>';
                                        }                 
                                    } */
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div> -->
            
            <!-- input submit -->
            <input type="submit" class="btn btn-primary btn-block my-3 col-sm-12" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>">

            <div class="my-1"><a class="btn btn-secondary" role="button" href="listarUsuario.php?">Volver</a></div>

        </form>

    </div>

<?php
include_once "../Estructura/Footer.php";
?>