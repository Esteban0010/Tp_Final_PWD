
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
                        $('#dg-rol').datagrid('reload'); // reload 
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

















         ///-----------rol-----------------------------------



         // almacena un nuevo (alta)
        function newrol() {
            $('#dlg-rol').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Rol');
            $('#fm-rol').form('clear');
            url = 'Action/usuarioAdmin/alta_Rol.php';
        }

         // edita (modificacion)
        function editRol() {
            var row = $('#dg-rol').datagrid('getSelected');
            if (row) {
                $('#dlg-rol').dialog('open').dialog('center').dialog('setTitle', 'Editar Rol');
                $('#fm-rol').form('load', row);
                //url = 'Action//usuarioAdmin/edit_Usuario.php?idusuario=' + row.idusuario + '&rodescripcion=' + row.rodescripcion;
                url = 'Action//usuarioAdmin/edit_Rol.php?idrol=' + row.idrol ;
                //console.log(row.idusuario); // Imprime el valor de url en la consola                
            }
        }

        // actualiza (ultimo paso)
        function saveRol() {
            //alert("Accion");
            $('#fm-rol').form('submit', {
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

                        $('#dlg-rol').dialog('close'); // close the dialog
                        $('#dg-rol').datagrid('reload'); // reload 
                    }
                }
            });
        }

        // elimina
        function destroyRol() {
            var row = $('#dg-rol').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar el Rol?', function(r) {
                    if (r) {   
                        $.post('Action//usuarioAdmin/eliminar_Rol.php?idrol=' + row.idrol, {
                            idrol: row.id
                            },
                            function(result) {
                                
                                if (result.respuesta) {
                                    $('#dg-rol').datagrid('reload'); // reload the  data
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




























             ///-----------menu-----------------------------------



         // almacena un nuevo (alta)
        function newMenu() {
            $('#dlg-menu').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Menu');
            $('#fm-menu').form('clear');
            url = 'Action/usuarioAdmin/alta_Menu.php';
        }

         // edita (modificacion)
        function editMenu() {
            var row = $('#dg-menu').datagrid('getSelected');
            if (row) {
                $('#dlg-menu').dialog('open').dialog('center').dialog('setTitle', 'Editar Menu');
                $('#fm-menu').form('load', row);
                //url = 'Action//usuarioAdmin/edit_Usuario.php?idusuario=' + row.idusuario + '&rodescripcion=' + row.rodescripcion;
                url = 'Action//usuarioAdmin/edit_Menu.php?idmenu=' + row.idmenu ;
                //console.log(row.idusuario); // Imprime el valor de url en la consola                
            }
        }

        // actualiza (ultimo paso)
        function saveMenu() {
            //alert("Accion");
            $('#fm-menu').form('submit', {
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

                        $('#dlg-menu').dialog('close'); // close the dialog
                        $('#dg-menu').datagrid('reload'); // reload 
                    }
                }
            });
        }

        // elimina
        function destroyMenu() {
            var row = $('#dg-menu').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar el Menu?', function(r) {
                    if (r) {   
                        $.post('Action//usuarioAdmin/eliminar_Menu.php?idMenu=' + row.idmenu, {
                            idmenu: row.id
                            },
                            function(result) {
                                
                                if (result.respuesta) {
                                    $('#dg-rol').datagrid('reload'); // reload the  data
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


