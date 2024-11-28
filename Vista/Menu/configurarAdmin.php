<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";

if(!$resp) {
    header("Location: menu.php");   
}
$objRol = $objTrans->getRol();
$descripcionRol = $objRol->getDescripcion();
if ($descripcionRol == 'administrador') {
    
} else {
    header("Location: menu.php");
}

?>

<!-- ================================== productos ========================================== -->
<h1>Productos</h1>

<table id="dg" title="Administrador de Productos" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/listar_Producto.php" toolbar="#toolbar"  fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="idproducto" width="60">ID</th>
            <th field="pronombre" width="60">Nombre</th>
            <th field="prodetalle" width="60">Detalle</th>
            <th field="procantstock" width="60">Cantidad de Stock</th>
            <th field="valor" width="60">Valor</th>
            <th field="proarchivo" width="100">URL Imagen</th>
        </tr>
    </thead>
</table>

<!-- opciones para hacer ABM en la tabla -->
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProducto()">Nuevo Producto </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProducto()">Editar Producto</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyProducto()">Eliminar Producto</a>
</div>

<!-- Modal -->
<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">

    <!-- formulario -->
    <form id="fm" method="POST" style="margin:0;padding:20px 50px" novalidate>

        <!-- Cuando hacen click en nuevo menu o editar menu, aparece este formulario -->
        <h3>Informacion Del Producto:</h3>

        <!-- pronombre -->
        <div style="margin-bottom:10px">
            <label for="pronombre">Nombre:</label>
            <input type="text" name="pronombre" id="pronombre" class="easyui-textbox" style="width:100%" required="true">
        </div>

        <!-- prodetalle -->
        <div style="margin-bottom:10px">
            <label for="prodetalle">Detalle:</label>
            <input type="text" name="prodetalle" id="prodetalle" class="easyui-textbox" style="width:100%" required="true">
        </div>

        <!-- cantidad -->
        <div style="margin-bottom:10px">
            <label for="procantstock">Cantidad:</label>
            <input type="number" name="procantstock" id="procantstock" class="easyui-numberbox" style="width:100%" required="true">
        </div>

        <!-- valor -->
        <div style="margin-bottom:10px">
            <label for="valor">Valor por Unidad:</label>
            <input type="number" name="valor" id="valor" class="easyui-numberbox" style="width:100%" required="true">
        </div>

        <!-- imagen -->
        <div style="margin-bottom:10px">
            <label for="proarchivo">URL Imagen del Producto:</label>
            <input type="text" name="proarchivo" id="proarchivo" class="easyui-textbox" style="width:100%" required="true">

        </div>

    </form>

</div>
<!-- Fin Modal -->

<!-- botones del formulario -->
<div id="dlg-buttons">

    <!-- boton Aceptar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProducto()" style="width:90px">Aceptar</a>

    <!-- boton Cancelar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>

</div>
<!-- Fin botones del formulario -->

<br>

<!-- =============================== usuarios ========================================== -->


<h1>Usuarios</h1>

<table id="dg-usuario" title="Administrador de Usuarios" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/usuarioAdmin/listar_Usuario.php" toolbar="#toolbar-usuario" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="idusuario" width="60">ID</th>
            <th field="usnombre" width="60">Nombre</th>
            <th field="uspass" width="100">Contraseña</th>
            <th field="usmail" width="60">Mail</th>
            <th field="usdeshabilitado" width="60">Deshabilitado</th>
        </tr>
    </thead>
</table>

<!-- opciones para hacer ABM en la tabla -->
<div id="toolbar-usuario">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUsuario()">Nuevo Usuario </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUsuario()">Editar Usuario</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deshabilitarUsuario()">Deshabilitar Usuario</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="habilitarUsuario()">Habilitar Usuario</a>
</div>

<!-- Modal -->
<div id="dlg-usuario" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-usuario'">
    <!-- formulario -->
    <form id="fm-usuario" method="POST" style="margin:0;padding:20px 50px" novalidate>

        <!-- Cuando hacen click en nuevo menu o editar menu, aparece este formulario -->
        <h3>Informacion Del Usuario:</h3>

        <!-- usnombre -->
        <div style="margin-bottom:10px">
            <label for="usnombre">Nombre:</label>
            <input type="text" name="usnombre" id="usnombre" class="easyui-textbox" style="width:100%" required="true">
        </div>

        <!-- uspass -->
        <div style="margin-bottom:10px">
            <label for="uspass">Contraseña:</label>
            <input type="text" name="uspass" id="uspass" class="easyui-textbox" style="width:100%" required="true">
        </div>

        <!-- usmail -->
        <div style="margin-bottom:10px">
            <label for="usmail">Mail:</label>
            <input type="text" name="usmail" id="usmail" class="easyui-textbox" style="width:100%" required="true">
        </div>

        <!-- rodescripcion -->
        <div style="margin-bottom:10px">
            <select type="text" id="rodescripcion" name="rodescripcion" class="easyui-combobox" data-options="panelHeight:'auto'" style="width:100%" require>
                <!-- <option value="">Seleccione un Rol...</option> -->
                <option value="cliente">Cliente</option>
                <option value="deposito">Deposito</option>
            </select>
        </div>

        <!-- usdeshabilitado hidden -->
        <div style="margin-bottom:10px">
            <input type="hidden" name="usdeshabilitado" id="usdeshabilitado" style="width:100%" value="<?php echo '0000-00-00 00:00:00'; ?>">
        </div>

    </form>

</div>
<!-- Fin Modal -->

<!-- botones del formulario -->
<div id="dlg-buttons-usuario">

    <!-- boton Aceptar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuario()" style="width:90px">Aceptar</a>

    <!-- boton Cancelar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-usuario').dialog('close')" style="width:90px">Cancelar</a>

</div>
<!-- Fin botones del formulario -->

<br>

<!-- ================================== roles ========================================== -->

<h1>Roles</h1>

<table id="dg-rol" title="Administrador de Roles" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/usuarioAdmin/listar_Rol.php" toolbar="#toolbar-rol" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="idrol" width="60">ID</th>
            <th field="rodescripcion" width="60">Descripcion</th>
        </tr>
    </thead>
</table>

<!-- opciones para hacer ABM en la tabla -->
<div id="toolbar-rol">
    <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newrol()">Nuevo Rol</a> -->
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRol()">Editar Rol</a>
    <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyRol()">Eliminar Rol</a> -->
</div>

<!-- Modal -->
<div id="dlg-rol" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-rol'">
    <!-- formulario -->
    <form id="fm-rol" method="POST" style="margin:0;padding:20px 50px" novalidate>

        <!-- Cuando hacen click en nuevo menu o editar menu, aparece este formulario -->
        <h3>Informacion Del Rol:</h3>

        <!-- rodescripcion -->
        <div style="margin-bottom:10px">
            <select type="text" id="rodescripcion" name="rodescripcion" class="easyui-combobox" data-options="panelHeight:'auto'" style="width:100%" require>
                <!-- <option value="">Seleccione un Rol...</option> -->
                <option value="cliente">Cliente</option>
                <option value="deposito">Deposito</option>
            </select>
        </div>

    </form>

</div>
<!-- Fin Modal -->

<!-- botones del formulario -->
<div id="dlg-buttons-rol">

    <!-- boton Aceptar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRol()" style="width:90px">Aceptar</a>

    <!-- boton Cancelar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-rol').dialog('close')" style="width:90px">Cancelar</a>

</div>
<!-- Fin botones del formulario -->

<br>

<!-- =================================== menu ========================================== -->
<h1>Menu</h1>

<table id="dg-menu" title="Administrador de Menu" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/usuarioAdmin/listar_Menu.php" toolbar="#toolbar-menu" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="idmenu" width="60">ID</th>
            <th field="menombre" width="60">Nombre</th>
            <th field="medescripcion" width="60">Descripcion</th>
            <th field="idpadre" width="60">ID de Sub Menu</th>
            <th field="medeshabilitado" width="60">Deshabilitado</th>
        </tr>
    </thead>
</table>

<!-- opciones para hacer ABM en la tabla -->
<div id="toolbar-menu">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Editar Menu</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deshabilitarMenu()">Deshabilitar Menu</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="habilitarMenu()">Habilitar Menu</a>

</div>

<!-- Modal -->
<div id="dlg-menu" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-menu'">
    <!-- formulario -->
    <form id="fm-menu" method="POST" style="margin:0;padding:20px 50px" novalidate>

        <!-- Cuando hacen click en nuevo menu o editar menu, aparece este formulario -->
        <h3>Informacion Del Menu:</h3>

        <!-- Nombre -->
        <div style="margin-bottom:10px">
            <input name="menombre" id="menombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
        </div>

        <!-- Descripción -->
        <div style="margin-bottom:10px">
            <input name="medescripcion" id="medescripcion" class="easyui-textbox" required="true" label="Descripción:" style="width:100%">
        </div>      

        <!-- idpadre -->
        <div style="margin-bottom:10px">
            <input name="idpadre" id="idpadre" class="easyui-combobox" label="Submenú De:" style="width:100%">
        </div>

        <!-- usdeshabilitado hidden -->
        <div style="margin-bottom:10px">
            <input type="hidden" name="medeshabilitado" id="medeshabilitado" style="width:100%" value="<?php echo '0000-00-00 00:00:00'; ?>">
        </div>

    </form>

</div>

<!-- botones del formulario -->
<div id="dlg-buttons-menu">

    <!-- boton Aceptar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>

    <!-- boton Cancelar del formulario -->
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-menu').dialog('close')" style="width:90px">Cancelar</a>

</div>
<!-- Fin botones del formulario -->

<br>

<script src="../Asets/js/configurarAdmin.js"></script>

<?php
include_once "../Estructura/Footer.php";
?>