<?php
include_once "../Estructura/Header.php";
?>

    <div class="container d-flex justify-content-center align-items-center" id="container" style="height: 88vh;">        

        <form action="Action/actionRegistrar.php" method="POST" class="bg-white p-4 rounded shadow" style="width: 100%; max-width: 400px;">
            
            <h2 class="text-center mb-2">Registrarse</h2>
            
            <div class="mb-3">                 

                <!-- usnombre -->
                <label for="usnombre" class="form-label my-1">Nombre de Usuario:</label>
                <input type="text" id="usnombre" name="usnombre" class="form-control" placeholder="Ingrese un Nombre de Usuario..." required>

                <!-- usmail -->
                <label for="usmail" class="form-label my-1">Mail:</label>
                <input type="mail" id="usmail" name="usmail" class="form-control" placeholder="Ingrese un Mail: Mail@a.com..." required>

                <!-- rodescripcion -->
                <label for="rodescripcion" class="form-label my-1">Rol:</label>
                <select type="text" id="rodescripcion" name="rodescripcion" class="form-select" require>
                    <option value="">Seleccione un Rol...</option>
                    <option value="cliente">Cliente</option>
                    <option value="vendedor">Vendedor</option>
                </select>

                <!-- uspassword -->
                <label for="uspass" class="form-label my-1">Password:</label>
                <input type="uspass" id="uspass" name="uspass" class="form-control" placeholder="Ingrese un Password..." required>                               
                
                <!-- hidden usdeshabilitado -->
                <input type="hidden" id="usdeshabilitado" name="usdeshabilitado" class="form-control" value="<?php echo '0000-00-00 00:00:00'; ?>">
                <!-- date('Y-m-d H:i:s') -->
            </div>

            <button type="submit" class="btn btn-success w-100">Enviar</button>
            <div class="my-1"><a class="btn btn-primary w-100" role="button" href="iniciar_sesion.php">Volver</a></div>
            

        </form>

    </div>    


    <!-- js validacion formulario -->
    <!-- <script src="Asets/md5.js"></script> -->
    <?php
    include_once "../Estructura/Footer.php";
    ?>