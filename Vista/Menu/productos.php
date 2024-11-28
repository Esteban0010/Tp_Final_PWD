<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";

$objControl = new AbmProducto();
$List_Producto = $objControl->buscar(param: null);
?>
<style>
    .card-img-top {
        height: 200px;
        /* Ajusta según el tamaño deseado */
        object-fit: contain;
        /* Mantiene las proporciones de la imagen */

    }
</style>
<div class="container mt-5">
    <h1 class="text-center mb-5">Productos Disponibles</h1>

    <?php if (count($List_Producto) > 0): ?>
        <div class=" row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($List_Producto as $objProducto): ?>
                <div class="col">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                        <img src="<?= $objProducto->getProArchivo(); ?>" class="card-img-top" alt="Producto" style="border-radius: 12px 12px 0 0;">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 1.25rem; font-weight: 500;"><?= $objProducto->getProNombre(); ?></h5>
                            <p class="card-text text-muted mb-3"><?= $objProducto->getProDetalle(); ?></p>
                            <p class="card-text fw-bold" style="font-size: 1.1rem;">$<?= number_format($objProducto->getValor(), 2); ?></p>
                            <p class="card-text text-muted" style="font-size: 0.9rem;">Stock: <?= $objProducto->getProCantStock(); ?></p>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <select id="quantity-<?= $objProducto->getIdProducto(); ?>" class="form-select w-auto" style="border-radius: 8px; font-size: 0.9rem;">
                                    <?php for ($i = 1; $i <= $objProducto->getProCantStock(); $i++): ?>
                                        <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="btn btn-primary buy-button" data-id="<?= $objProducto->getIdProducto(); ?>" style="background: #6c63ff; border: none; border-radius: 8px; padding: 0.5rem 1.25rem; font-size: 0.9rem; font-weight: 500;">
                                    Comprar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-4">No hay productos cargados en el sistema.</div>
    <?php endif; ?>
</div>
<br> <br>
<script src="../Asets/js//productos.js">
</script>
<?php include_once "../Estructura/Footer.php"; ?>