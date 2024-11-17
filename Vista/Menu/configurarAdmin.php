<?php
include_once("../../configuracion.php");
include_once "../Estructura/Header.php";
$objControl = new AbmProducto();
$List_Producto = $objControl->buscar(null);
//verEstructura($List_Producto);
?>

    <h1>Productos</h1>

    <table id="dg" title="Administrador de item menu" class="easyui-datagrid" style="width:1000px;height:450px" url="Action/listar_Producto.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true"> 
        <thead>
            <tr>
                <th field="idproducto" width="60">ID</th>
                <th field="pronombre" width="60">Nombre</th>
                <th field="prodetalle" width="60">Detalle</th>
                <th field="procantstock" width="60">Cantidad de Stock</th>
                <th field="valor" width="60">Valor</th>
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
        <form id="fm" method="POST" novalidate style="margin:0;padding:20px 50px">

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
    </script>
<?php
include_once "../Estructura/Footer.php";
?>