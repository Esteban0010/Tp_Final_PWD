<?php
include_once("../../../configuracion.php");

include_once("../../Estructura/HeaderSeguro.php");


?>


<div class="container" style="margin-top: 100px;">
        <div class="card card-info">
            <form class="" action='../Action/alta_Producto.php' novalidate id="formularioCrearProducto" name="formularioCrearProducto" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="pronombre" class="form-label">Nombre Producto</label>
                    <input class='form-control' id='pronombre' name='pronombre' type='text' placeholder='Nombre Producto' required>
                </div>
                <div class="mb-3">
                    <label for="prodetalle" class="form-label">Detalle Producto</label>
                    <input type='text' class='form-control' id='prodetalle' name='prodetalle' placeholder='Detalle del producto' required>
                </div>
                <div class="mb-3">
                    <label for="procantstock" class="form-label">Stock</label>
                    <input class='form-control' id='procantstock' name='procantstock' type='number' placeholder='Stock Producto' required>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Precio</label>
                    <input class='form-control' id='valor' name='valor' type='number' placeholder='Precio Producto' required>
                </div>
                <div class="mb-3">
                    <label for="productoImagen" class="form-label">Imagen</label>
                    <input class='form-control' id='productoImagen' name='productoImagen' type='file' accept="image/png, .jpeg, .jpg, image/gif" required>
                </div>
                <div class="mb-3">
                    <p id="invalido"></p>
                </div>
                <button type="submit" id="submitButton" class="btn btn-primary">Crear Producto</button>
            </form>
            <div id="validaciones"></div>
        </div>
    </div>

    <script src="Aca irian las validaciones"></script>
<?php

include_once '../../Estructura/Footer.php';
?>