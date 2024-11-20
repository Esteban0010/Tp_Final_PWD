<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
$objControl = new AbmProducto();
$List_Producto = $objControl->buscar(null);
//verEstructura($List_Producto);
$objControlUsuario = new AbmUsuario();
$List_Usuario = $objControlUsuario->buscar(null);
//verEstructura($List_Usuario);
?>

    <h1>Productos</h1>

    <table id="dg" title="Administrador de Productos" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/listar_Producto.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true"> 
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




























<!-- ======================================================================================== -->
    <!-- usuarios -->

    <h1>Usuarios</h1>

    <table id="dg-usuario" title="Administrador de Usuarios" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/usuarioAdmin/listar_Usuario.php" toolbar="#toolbar-usuario" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true"> 
        <thead>
            <tr>
                <th field="idusuario" width="60">ID</th>
                <th field="usnombre" width="60">Nombre</th>
                <th field="uspass" width="100">Contraseña</th>
                <th field="usmail" width="60">Mail</th>
                <!-- <th field="rodescripcion" width="60">Descripcion</th> -->
                <th field="usdeshabilitado" width="60">Deshabilitado</th>
            </tr>
        </thead>
    </table>

    <!-- opciones para hacer ABM en la tabla -->
    <div id="toolbar-usuario">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUsuario()">Nuevo Usuario </a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUsuario()">Editar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUsuario()">Eliminar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deshabilitarUsuario()">Deshabilitar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="habilitarUsuario()">Habilitar Usuario</a>
    </div>

    <!-- Modal -->
    <div id="dlg-usuario" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-usuario'">
    <!-- <div id="dlg-usuario" class="easyui-dialog" style="width:50%;height:auto;" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'"> -->
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



















    <!-- ======================================================================================== -->
    <!-- roles -->

    <h1>Roles</h1>

    <table id="dg-roles" title="Administrador de Roles" class="easyui-datagrid" style="width:1200px;height:450px" url="Action/usuarioAdmin/listar_Usuario.php" toolbar="#toolbar-rol" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true"> 
        <thead>
            <tr>
                <th field="idusuario" width="60">ID de Usuario</th>
                <th field="idrol" width="60">ID de Rol</th>
            </tr>
        </thead>
    </table>

    <!-- opciones para hacer ABM en la tabla -->
    <div id="toolbar-rol">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUsuario()">Nuevo Usuario </a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUsuario()">Editar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUsuario()">Eliminar Usuario</a>
    </div>

    <!-- Modal -->
    <div id="dlg-rol" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-rol'">
    <!-- <div id="dlg-usuario" class="easyui-dialog" style="width:50%;height:auto;" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'"> -->
        <!-- formulario -->
        <form id="fm-rol" method="POST" style="margin:0;padding:20px 50px" novalidate>

            <!-- Cuando hacen click en nuevo menu o editar menu, aparece este formulario -->
            <h3>Informacion Del Usuario:</h3>

            <!-- idusuario -->
            <div style="margin-bottom:10px">
                <label for="idusuario">Id del usuario:</label>
                <input type="number" name="idusuario" id="idusuario" class="easyui-textbox" style="width:100%" required="true">
            </div>

            <!-- idrol -->
            <div style="margin-bottom:10px">
                <label for="uspass">Id del rol:</label>
                <input type="number" name="idrol" id="idrol" class="easyui-textbox" style="width:100%" required="true">
            </div>

        </form>

    </div>
    <!-- Fin Modal -->

    <!-- botones del formulario -->
    <div id="dlg-buttons-usuario">

        <!-- boton Aceptar del formulario -->
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuario()" style="width:90px">Aceptar</a>

        <!-- boton Cancelar del formulario -->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-rol').dialog('close')" style="width:90px">Cancelar</a>

    </div>
    <!-- Fin botones del formulario -->

    <br>






























    <script type="text/javascript">
        var url;
        
        // almacena un nuevo (alta)
        function newProducto() {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Producto');
            $('#fm').form('clear');
            url = 'Action/alta_Producto.php';
        }

         // edita (modificacion)
        function editProducto() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Producto');
                $('#fm').form('load', row);
                url = 'Action/edit_Producto.php?idproducto=' + row.idproducto;
                //console.log(row.idproducto); // Imprime el valor de url en la consola                
            }
        }

        // actualiza (ultimo paso)
        function saveProducto() {
            //alert("Accion");
            $('#fm').form('submit', {
                url: url,                
                onSubmit: function() {
                    return $(this).form('validate');
                },                
                success: function(result) {
                    var result = eval('(' + result + ')');
                    //console.log(result); // Imprime el contenido de $data en la consola
                    //var result = JSON.parse(result); // Si necesitas usar la respuesta como JSON

                    //alert("Volvio Serviodr");
                    if (!result.respuesta) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {

                        $('#dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload 
                    }
                }
            });
        }

        // elimina
        function destroyProducto() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar el Producto?', function(r) {
                    if (r) {   
                        $.post('Action/eliminar_Producto.php?idproducto=' + row.idproducto, {
                            idproducto: row.id
                            },
                            function(result) {
                                
                                if (result.respuesta) {
                                    $('#dg').datagrid('reload'); // reload the  data
                                } else {
                                    $.messager.show({ // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                    }
                });
            }
        }






















        ///----------------------------------------------



         // almacena un nuevo (alta)
        function newUsuario() {
            $('#dlg-usuario').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Usuario');
            $('#fm-usuario').form('clear');
            url = 'Action/usuarioAdmin/alta_Usuario.php';
        }

         // edita (modificacion)
        function editUsuario() {
            var row = $('#dg-usuario').datagrid('getSelected');
            if (row) {
                $('#dlg-usuario').dialog('open').dialog('center').dialog('setTitle', 'Editar Usuario');
                $('#fm-usuario').form('load', row);
                //url = 'Action//usuarioAdmin/edit_Usuario.php?idusuario=' + row.idusuario + '&rodescripcion=' + row.rodescripcion;
                url = 'Action//usuarioAdmin/edit_Usuario.php?idusuario=' + row.idusuario;
                //console.log(row.idusuario); // Imprime el valor de url en la consola                
            }
        }

        // actualiza (ultimo paso)
        function saveUsuario() {
            //alert("Accion");
            $('#fm-usuario').form('submit', {
                url: url,                
                onSubmit: function() {
                    return $(this).form('validate');
                },                
                success: function(result) {
                    var result = eval('(' + result + ')');
                    //console.log(result); // Imprime el contenido de $data en la consola
                    //var result = JSON.parse(result); // Si necesitas usar la respuesta como JSON

                    //alert("Volvio Serviodr");
                    if (!result.respuesta) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {

                        $('#dlg-usuario').dialog('close'); // close the dialog
                        $('#dg-usuario').datagrid('reload'); // reload 
                    }
                }
            });
        }

        // elimina
        function destroyUsuario() {
            var row = $('#dg-usuario').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar el Producto?', function(r) {
                    if (r) {   
                        $.post('Action//usuarioAdmin/eliminar_Usuario.php?idusuario=' + row.idusuario, {
                            idusuario: row.id
                            },
                            function(result) {
                                
                                if (result.respuesta) {
                                    $('#dg-usuario').datagrid('reload'); // reload the  data
                                } else {
                                    $.messager.show({ // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                    }
                });
            }
        }
    </script>
<?php
include_once "../Estructura/Footer.php";
?>