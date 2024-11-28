
var url;

// almacena un nuevo (alta)
function newProducto() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Producto');
    $('#fm').form('clear');
    url = 'Action/usuarioAdmin/alta_Producto.php';
}

// edita (modificacion)
function editProducto() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Producto');
        $('#fm').form('load', row);
        url = 'Action/usuarioAdmin/edit_Producto.php?idproducto=' + row.idproducto;
        //console.log(row.idproducto); // Imprime el valor de url en la consola                
    }
}

// actualiza (ultimo paso)
function saveProducto() {
    //alert("Accion");
    $('#fm').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
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
        $.messager.confirm('Confirm', 'Seguro que desea eliminar el Producto?', function (r) {
            if (r) {
                $.post('Action/usuarioAdmin/eliminar_Producto.php?idproducto=' + row.idproducto, {
                    idproducto: row.id
                },
                    function (result) {

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



///-----------usuario-----------------------------------

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
        url = 'Action/usuarioAdmin/edit_Usuario.php?idusuario=' + row.idusuario;
        //console.log(row.idusuario); // Imprime el valor de url en la consola                
    }
}

// actualiza (ultimo paso)
function saveUsuario() {
    //alert("Accion");
    $('#fm-usuario').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
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
                $('#dg-usuario').datagrid('reload'); // reload usaurio
                $('#dg-rol').datagrid('reload'); // reload rol                                            
                $('#dg-menu').datagrid('reload'); // reload menu
            }
        }
    });
}

// elimina
function destroyUsuario() {
    var row = $('#dg-usuario').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Seguro que desea eliminar el Producto?', function (r) {
            if (r) {
                $.post('Action/usuarioAdmin/eliminar_Usuario.php?idusuario=' + row.idusuario, {
                    idusuario: row.id
                },
                    function (result) {

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

function deshabilitarUsuario() {
    var row = $('#dg-usuario').datagrid('getSelected');
    if (row) {
        console.log(row);
        $.messager.confirm('Confirmar', '¿Está seguro de deshabilitar el usuario?', function (r) {
            if (r) {
                $.post('Action/usuarioAdmin/eliminarDeshabilitado_Usuario.php?idusuario=' + row.idusuario + '&usnombre=' + row.usnombre + '&uspass=' + row.uspass + '&usmail=' + row.usmail + '&usdeshabilitado=' + row.usdeshabilitado, function (result) {
                    if (result.respuesta) {
                        $('#dg-usuario').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'JSON');
            }
        });
    }
}

//habilitar_Menu.php
function habilitarUsuario() {
    var row = $('#dg-usuario').datagrid('getSelected');
    if (row) {
        console.log(row);
        $.messager.confirm('Confirmar', '¿Está seguro de habilitar el usuario?', function (r) {
            if (r) {
                $.post('Action/usuarioAdmin/habilitar_Usuario.php?idusuario=' + row.idusuario + '&usnombre=' + row.usnombre + '&uspass=' + row.uspass + '&usmail=' + row.usmail + '&usdeshabilitado=' + row.usdeshabilitado, function (result) {
                    if (result.respuesta) {
                        $('#dg-usuario').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'JSON');
            }
        });
    }
}


///-----------rol-----------------------------------

// edita (modificacion)
function editRol() {
    var row = $('#dg-rol').datagrid('getSelected');
    if (row) {
        $('#dlg-rol').dialog('open').dialog('center').dialog('setTitle', 'Editar Rol');
        $('#fm-rol').form('load', row);
        //url = 'Action//usuarioAdmin/edit_Usuario.php?idusuario=' + row.idusuario + '&rodescripcion=' + row.rodescripcion;
        url = 'Action/usuarioAdmin/edit_Rol.php?idrol=' + row.idrol;
        //console.log(row.idusuario); // Imprime el valor de url en la consola                
    }
}

// actualiza (ultimo paso)
function saveRol() {
    //alert("Accion");
    $('#fm-rol').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
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

                $('#dlg-rol').dialog('close'); // close the dialog
                $('#dg-rol').datagrid('reload'); // reload 
            }
        }
    });
}



///-----------menu-----------------------------------

// funciono !!!!
function editMenu() {
    var row = $('#dg-menu').datagrid('getSelected');
    if (row) {
        $('#dlg-menu').dialog('open').dialog('center').dialog('setTitle', 'Editar Menú');
        $('#fm-menu').form('load', row);

        // Recarga las opciones y luego establece el valor
        // $('#idpadre').combobox('reload', 'Action/usuarioAdmin/listar_Submenus.php').combobox('setValue', row.idpadre ); // || ''

        $('#idpadre').combobox({
            url: 'Action/usuarioAdmin/listar_Submenus.php',
            valueField: 'id',
            textField: 'text',
            onLoadSuccess: function () {
                if (row.idpadre) {
                    $(this).combobox('setValue', row.idpadre);
                }
            }
        });


        url = 'Action/usuarioAdmin/edit_Menu.php?medeshabilitado=' + row.medeshabilitado + '&idmenu=' + row.idmenu;
    }
}

function saveMenu() {
    $('#fm-menu').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = JSON.parse(result);
            if (!result.respuesta) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#dlg-menu').dialog('close');
                $('#dg-menu').datagrid('reload');
            }
        }
    });
}

function deshabilitarMenu() {
    var row = $('#dg-menu').datagrid('getSelected');
    if (row) {
        console.log(row);
        $.messager.confirm('Confirmar', '¿Está seguro de deshabilitar el menú?', function (r) {
            if (r) {
                $.post('Action/usuarioAdmin/eliminarDeshabilitado_Menu.php?idmenu=' + row.idmenu + '&menombre=' + row.menombre + '&medescripcion=' + row.medescripcion + '&idpadre=' + row.idpadre + '&medeshabilitado=' + row.medeshabilitado, function (result) {
                    if (result.respuesta) {
                        $('#dg-menu').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'JSON');
            }
        });
    }
}

function habilitarMenu() {
    var row = $('#dg-menu').datagrid('getSelected');
    if (row) {
        console.log(row);
        $.messager.confirm('Confirmar', '¿Está seguro de habilitar el menú?', function (r) {
            if (r) {
                $.post('Action/usuarioAdmin/habilitar_Menu.php?idmenu=' + row.idmenu + '&menombre=' + row.menombre + '&medescripcion=' + row.medescripcion + '&idpadre=' + row.idpadre + '&medeshabilitado=' + row.medeshabilitado, function (result) {
                    if (result.respuesta) {
                        $('#dg-menu').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'JSON');
            }
        });
    }
}

