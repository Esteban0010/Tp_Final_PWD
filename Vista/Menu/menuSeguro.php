<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
?>
<br>
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel" style="max-width: 100%; height: 440px;">
    <!-- Indicadores -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>

    <!-- Imágenes del carrusel -->
    <div class="carousel-inner" style="height: 440px;">
        <div class="carousel-item active">
            <img src="../Asets/img/Img 4.png" class="d-block w-100" alt="img 4" style="object-fit: cover; height: 440px;">
        </div>
        <div class="carousel-item">
            <img src="../Asets/img/Img 1.png" class="d-block w-100" alt="img 1" style="object-fit: cover; height: 440px;">
        </div>
        <div class="carousel-item">
            <img src="../Asets/img/Img 2.png" class="d-block w-100" alt="img 2" style="object-fit: cover; height: 440px;">
        </div>
        <div class="carousel-item">
            <img src="../Asets/img/Img 3.png" class="d-block w-100" alt="img 3" style="object-fit: cover; height: 440px;">
        </div>
    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>
<br>
<div style="display: flex; gap: 10px; border: 1px solid black">
    <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>Item 1</span></div>
    <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 2</span></div>
    <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 3</span></div>
    <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 4</span></div>
</div>
<br>
<?php
include_once "../Estructura/Footer.php";
?>