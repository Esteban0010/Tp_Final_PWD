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


<div class="item-container">
    <div class="item">
        <img src="../Asets/img/3.png" alt="Item 1">
        <span class="item-title">Disfruta Monster Original</span>
        <a href="./productos.php">Ver más</a>
    </div>
    <div class="item">
        <img src="../Asets/img/2.png" alt="Item 2">
        <span class="item-title">Energizaté ahora</span>
        <a href="./productos.php">Ver más</a>
    </div>
    <div class="item">
        <img src="../Asets/img/1.png" alt="Item 3">
        <span class="item-title">Disfruta Monster Fiesta</span>
        <a href="./productos.php">Ver más</a>
    </div>
</div>
<br>
<style>
    .item-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .item {
        width: 280px;
        height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: #fff;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.15);
    }

    .item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .item-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 10px 0;
    }

    .item a {
        text-decoration: none;
        color: #fff;
        background: #007bff;
        padding: 10px 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s;
    }

    .item a:hover {
        background: #0056b3;
    }
</style>
<?php
include_once "../Estructura/Footer.php";
?>