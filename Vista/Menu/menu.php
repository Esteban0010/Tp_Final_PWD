<?php
    include_once("../../configuracion.php");
    include_once "../Estructura/Header.php";
?>
    <br>
    <div class="easyui-swiper" data-options="autoplay:true" style="width:auto;height:440px;">
        <div style="background:red;color:#fff;font-size: 100px;text-align: center;line-height: 440px;">Esteban</div>
        <div style="background:orange;color:#fff;font-size: 100px;text-align: center;line-height: 440px;">Francisco</div>
        <div style="background:blue;color:#fff;font-size: 100px;text-align: center;line-height: 440px;">Leonardo</div>
        <div style="background:green;color:#fff;font-size: 100px;text-align: center;line-height: 440px;">Martin</div>            
    </div>
    <br>
    <div style="display: flex; gap: 10px; border: 1px solid black">
        <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 1</span></div>
        <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 2</span></div>
        <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 3</span></div>
        <div style="margin: 10px; border: 1px solid black; width: 300px; height: 300px;"><span>item 4</span></div>    
    </div>
    <br>
<?php
    include_once "../Estructura/Footer.php";
?>