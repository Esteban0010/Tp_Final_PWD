/* usuario */
INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) 
VALUES 
(1, 'pedro', 'c4ca4238a0b923820dcc509a6f75849b', 'pedro@gmail.com', NULL);
/* uspass = 1 */

/* rol */
INSERT INTO `rol` (`idrol`, `rodescripcion`) 
VALUES 
(1, 'administrador');

/* usuariorol */
INSERT INTO `usuariorol`(`idusuario`, `idrol`) VALUES (1,1);

/* menu */
INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) 
VALUES 
(1, 'Hogar', 'menu.php', NULL, NULL),
(2, 'Productos', 'productos.php', NULL, NULL),
(3, 'Mi Perfil', 'perfilUser.php', NULL, NULL),
(4, 'Carrito', 'carrito.php', NULL, NULL),
(5, 'Cerrar Sesion', 'Action/actionVerificarLogin.php?accion=cerrar', NULL, NULL),
(6, 'Gestionar Compra', 'gestionarCompra3.php', NULL, NULL),
(7, 'Administrador', 'configurarAdmin.php', NULL, NULL);

/* menurol */
INSERT INTO `menurol` (`idmenu`, `idrol`) 
VALUES 
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1);
