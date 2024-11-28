/* usuario */
INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) 
VALUES 
(1, 'pedro', 'c4ca4238a0b923820dcc509a6f75849b', 'pedro@gmail.com', '0000-00-00 00:00:00');
/* uspass = 1 */

/* rol */
INSERT INTO `rol` (`idrol`, `rodescripcion`) 
VALUES 
(1, 'administrador');

/* usuariorol */
INSERT INTO `usuariorol` (`idusuario`, `idrol`) 
VALUES 
(1, 1);

/* menu */
INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) 
VALUES 
(1, 'Hogar', 'menu.php', NULL, '0000-00-00 00:00:00'),
(2, 'Productos', 'productos.php', NULL, '0000-00-00 00:00:00'),
(3, 'Mi Perfil', 'perfilUser.php', NULL, '0000-00-00 00:00:00'),
(4, 'Carrito', 'carrito.php', NULL, '0000-00-00 00:00:00'),
(5, 'Cerrar Sesion', 'Action/actionVerificarLogin.php?accion=cerrar', NULL, '0000-00-00 00:00:00'),
(6, 'Gestionar Compra', 'gestionarCompra3.php', NULL, '0000-00-00 00:00:00'),
(7, 'Administrador', 'configurarAdmin.php', NULL, '0000-00-00 00:00:00');

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
