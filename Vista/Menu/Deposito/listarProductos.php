<?php
include_once("../../../configuracion.php");
include_once("../../Estructura/HeaderSeguro.php");

$objProducto = new AbmProducto();
$arrayProductos = $objProducto->buscar(NULL);
?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <h2 class="text-center mb-4">Listado de Productos</h2>
    <div class="text-end mb-3">
        <a href="crearProducto.php" class="btn btn-primary">Agregar Producto</a>
    </div>

    <?php if (count($arrayProductos) > 0) { ?>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Cantidad de Stock</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arrayProductos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto->getIdProducto(); ?></td>
                        <td><?php echo $producto->getProNombre(); ?></td>
                        <td><?php echo $producto->getProDetalle(); ?></td>
                        <td><?php echo $producto->getProCantStock(); ?></td>
                        <td><?php echo $producto->getValor(); ?></td>
                        <td><?php echo $producto->getProArchivo(); ?></td>
                        <td>
                            <a href="#editarProductoModal" 
                               data-bs-toggle="modal" 
                               class="btn btn-sm btn-warning edit"
                               data-id="<?php echo $producto->getIdProducto(); ?>"
                               data-nombre="<?php echo $producto->getProNombre(); ?>"
                               data-detalle="<?php echo $producto->getProDetalle(); ?>"
                               data-stock="<?php echo $producto->getProCantStock(); ?>"
                               data-precio="<?php echo $producto->getValor(); ?>">
                               Editar
                            </a>
                            <a href="eliminarProducto.php?id=<?php echo $producto->getIdProducto(); ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center text-muted">No hay productos registrados.</p>
    <?php } ?>
</div>

<!-- Modal para editar producto -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form id="formEditarProducto" action="accion/actualizarProducto.php" method="post">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="idProducto" id="idProducto">
            <div class="mb-3">
                <label for="proNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="proNombre" id="proNombre" required>
            </div>
            <div class="mb-3">
                <label for="proDetalle" class="form-label">Detalle</label>
                <input type="text" class="form-control" name="proDetalle" id="proDetalle" required>
            </div>
            <div class="mb-3">
                <label for="proCantStock" class="form-label">Cantidad de Stock</label>
                <input type="number" class="form-control" name="proCantStock" id="proCantStock" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Precio</label>
                <input type="number" class="form-control" name="valor" id="valor" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>
    </div>
</div>
<script src="js/eliminarProducto.js"></script>
<script src="js/editarProducto.js"></script>

<?php
include_once("../../Estructura/Footer.php");
?>
