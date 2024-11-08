-- BD RÁPIDA

DROP DATABASE bdcarritocompras;

--
-- Base de datos: 'bdcarritocompras'
--
CREATE DATABASE bdcarritocompras;
USE bdcarritocompras;

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'usuario'
--
CREATE TABLE usuario (
  idusuario bigint(20) NOT NULL,
  usnombre varchar(50) NOT NULL,
  uspass varchar(50) NOT NULL,
  usmail varchar(50) NOT NULL,
  usdeshabilitado timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'usuario'
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- AUTO_INCREMENT de la tabla 'usuario'
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT;

-- Volcado de doatos par la tabla usuario
INSERT INTO usuario (idusuario, usnombre, uspass, usmail, usdeshabilitado) VALUES
('1', 'Moya', '81dc9bdb52d04dc20036dbd8313ed055', 'moya@gmail.com', '0000-00-00 00:00:00'),-- 1234
('2', 'Farias', '81b073de9370ea873f548e31b8adc081', 'farias@gmail.com', '0000-00-00 00:00:00'),-- 2345
('3', 'Lopez', 'def7924e3199be5e18060bb3e1d547a7', 'lopez@gmail.com', '0000-00-00 00:00:00'),-- 3456
('4', 'Ramirez', '6562c5c1f33db6e05a082a88cddab5ea', 'ramirez@gmail.com', '0000-00-00 00:00:00'), -- 4567
('5', 'Admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin@mail.com', '0000-00-00 00:00:00'),-- 1234
('6', 'Deposito', '81dc9bdb52d04dc20036dbd8313ed055', 'deposito@mail.com', '0000-00-00 00:00:00'),-- 1234
('7', 'Cliente', '81dc9bdb52d04dc20036dbd8313ed055', 'cliente@mail.com', '0000-00-00 00:00:00'),-- 1234
('8', 'Nicolas', '81dc9bdb52d04dc20036dbd8313ed055', 'nicolas@mail.com', '0000-00-00 00:00:00'),-- 1234
('9', 'AdminTotal', '81dc9bdb52d04dc20036dbd8313ed055', 'adminTotal@mail.com', '0000-00-00 00:00:00');-- 1234

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'rol'
--
CREATE TABLE rol (
  idrol bigint(20) NOT NULL,
  rodescripcion varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'rol'
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de la tabla 'rol'
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT;

-- Volcado de datos para la tabla rol
INSERT INTO rol (idrol, rodescripcion) VALUES
(1, 'Admin'),
(2, 'Deposito'),
(3, 'Cliente');

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'producto'
--
CREATE TABLE producto (
  idproducto bigint(20) NOT NULL,
  pronombre varchar(250) NOT NULL,
  prodetalle varchar(512) NOT NULL,
  procantstock int(11) NOT NULL,
  tipo varchar(20)  NOT NULL,
  imagenproducto varchar(512)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'producto'
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`);

--
-- AUTO_INCREMENT de la tabla 'producto'
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT;

-- Volcado de datos para la tabla producto
INSERT INTO producto (idproducto, pronombre, prodetalle, procantstock, tipo, imagenproducto) VALUES
(01,'Mate Termico Argentina','4900', 10,"Mates","../img/Productos/mates/mate1.png"),
(02,'Mate Pampa Negro Afa','17999', 10,"Mates","../img/Productos/mates/mate2.png"),
(03,'Mate De Madera Imperial','19800', 10,"Mates","../img/Productos/mates/mate3.png"),
/*yerbas*/
(04,'Yerba Mate De Campo La Merced','1665', 100,"Yerbas","../img/Productos/yerbas/yerba1.png"),
(05,'Yerba mate Canarias sabor tradicional','4222', 100,"Yerbas","../img/Productos/yerbas/yerba2.png"),
(06,'Yerba Mate Grapia Milenaria','2700', 100,"Yerbas","../img/Productos/yerbas/yerba3.png"),
/*bombillas*/
(08,'Bombilla Mate Pico De Loro Uruguaya Gruesa Original','3299', 110,"Bombillas","../img/Productos/bombillas/bombilla1.png"),
(09,'Bombilla Acero Inoxidable - Un Mate No Se Tapa','3997', 110,"Bombillas","../img/Productos/bombillas/bombilla2.png"),
(10,'Bombillon Torneado De Acero Inoxidable','7600', 80,"Bombillas","../img/Productos/bombillas/bombilla3.png"),
/*termoss*/
(11,'Termo Kushiro 1200ml Manija Y Pico Cebador 24hs Doble Capa Color Gris','22499', 50,"Termos","../img/Productos/termos/Termo1.png"),
(12,'Termo Stanley Original Mate System Classic 1.2 Litros','95863', 50,"Termos","../img/Productos/termos/Termo2.png"),
(13,'Termo Acero Inoxidable Discovery Antiderrame 500 Ml Color Azul','12900', 60,"Termos","../img/Productos/termos/Termo3.png"),
/*Sets*/
(14,'Set Matero Completo Termo Stanley Mate Calabaza Y Cuero','180199', 100,"SETS","../img/Productos/sets/set1.png"),
(15,'Set Matero Canasta + Mate + Bombilla + Yerbero + Azucarero','18242', 100,"SETS","../img/Productos/sets/set2.png"),
(16,'Set Matero Mate Térmico Acero Inox Sumate Latas Y Canasta','12927', 100,"SETS","../img/Productos/sets/set3.png"),
/*Mas mates*/
(17,'Mate basico madera','5000',5,"Mates","../img/Productos/mates/mate4.png"),
(18,'Mate de aluminio','4000',8,"Mates","../img/Productos/mates/mate5.png"),
(19,'Mate de plastico terere','3500',10,"Mates","../img/Productos/mates/mate6.png"),
/*Mas yerbas*/
(20,'Yerba Mate Playadito','2000',10,"Yerbas","../img/Productos/yerbas/yerba4.png"),
(21,'Yerba mate Amanda','3000', 5,"Yerbas","../img/Productos/yerbas/yerba5.png"),
(22,'Yerba Mate VerdeFlor','4000', 20,"Yerbas","../img/Productos/yerbas/yerba6.png"),
/*Mas Bombillas*/
(23,'Bombilla Mate Pico De Loro Sincelada','3500', 100,"Bombillas","../img/Productos/bombillas/bombilla4.png"),
(24,'Bombilla Stanley Acero Inoxidable','3000', 50,"Bombillas","../img/Productos/bombillas/bombilla5.png"),
(25,'Bombillon De Acero Inoxidable','8000', 80,"Bombillas","../img/Productos/bombillas/bombilla6.png"),
/*Mas Termos*/
(26,'Termo Media Manija Y Pico Cebador 24hs Color Gris','20000', 50,"Termos","../img/Productos/termos/Termo4.png"),
(27,'Termo 1lt Termolar Color Rosa','18000', 30,"Termos","../img/Productos/termos/Termo5.png"),
(28,'Termo Acero Inoxidable BOCA','30000', 60,"Termos","../img/Productos/termos/Termo6.png"),
/*Mas sets*/
(29,'Set Matero Bostero 0 DESCENSOS','26000', 11,"SETS","../img/Productos/sets/set4.png"),
(30,'Set Matero Campero Completo','19600', 20,"SETS","../img/Productos/sets/set5.png"),
(31,'Set Matero Campeones Del Mundo ','18120', 50,"SETS","../img/Productos/sets/set6.png");

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'compraestadotipo'
--
CREATE TABLE compraestadotipo (
  idcompraestadotipo int(11) NOT NULL,
  cetdescripcion varchar(50) NOT NULL,
  cetdetalle varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'compraestadotipo'
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Volcado de datos para la tabla 'compraestadotipo'
--
INSERT INTO compraestadotipo (idcompraestadotipo, cetdescripcion, cetdetalle) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1'),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado = 2'),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado = 1');

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'menu'
--
CREATE TABLE menu (
  idmenu bigint(20) NOT NULL,
  menombre varchar(100) NOT NULL COMMENT 'Nombre del item del menu',
  medescripcion varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  idpadre bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  medeshabilitado timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'menu'
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- AUTO_INCREMENT de la tabla 'menu'
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Volcado de datos para la tabla 'menu'
--
INSERT INTO menu (idmenu, menombre, medescripcion, idpadre, medeshabilitado) VALUES

(0, 'Invisible', '../Nada/', NULL, '0000-00-00 00:00:00'), -- Padre Invisible
(1, 'Home', '../Home/', NULL, '0000-00-00 00:00:00'), -- Padre Home
(2, 'Administrador', '../Administrador/', NULL, '0000-00-00 00:00:00'), -- Padre Administrador
(3, 'Deposito', '../Deposito/', NULL, '0000-00-00 00:00:00'), -- Padre Deposito
(4, 'Cliente', '../Cliente/', NULL, '0000-00-00 00:00:00'), -- Padre Cliente

(11, 'Inicio', 'home.php', 1, '0000-00-00 00:00:00'), -- Hijo Home (1)
(12, 'Crear Cuenta', 'crearCuenta.php', 1, '0000-00-00 00:00:00'), -- Hijo Home (1)
(13, 'Login', 'login.php', 1, '0000-00-00 00:00:00'), -- Hijo Home (1)

(21, 'Crear Usuarios', 'crearUsuarios.php', 2, '0000-00-00 00:00:00'), -- Hijo Administrador (2)
(22, 'Gestionar Usuarios', 'gestionarUsuarios.php', 2, '0000-00-00 00:00:00'), -- Hijo Administrador (2)
(23, 'Gestionar Roles', 'gestionarRoles.php', 2, '0000-00-00 00:00:00'), -- Hijo Administrador (2)
(24, 'Asignar Roles', 'asignarRoles.php', 0, '0000-00-00 00:00:00'), -- Hijo Nulo (0)
(25, 'Quitar Roles', 'quitarRol.php', 0, '0000-00-00 00:00:00'), -- Hijo Nulo (0)
(26, 'Actualizar Usuario', 'formActualizarUsuario.php', 0, '0000-00-00 00:00:00'), -- Hijo Nulo (0)
(27, 'Crear Rol', 'crearRol.php', 0, '0000-00-00 00:00:00'), -- Hijo Nulo (0)

(31, 'Crear Productos', 'crearProductos.php', 3, '0000-00-00 00:00:00'), -- Hijo Deposito (3)
(32, 'Gestionar Productos', 'gestionarProductos.php', 3, '0000-00-00 00:00:00'), -- Hijo Deposito (3)
(33, 'Gestionar Compras', 'gestionarCompras.php' , 3, '0000-00-00 00:00:00'), -- Hijo Deposito (3)
(34, 'Modificar Productos', 'modificarProductos.php' , 0, '0000-00-00 00:00:00'), -- Hijo Nulo (0)

(41, 'Productos', 'productos.php', 4, '0000-00-00 00:00:00'), -- Hijo Cliente (4)
(42, 'Mis Compras', 'misCompras.php', 4, '0000-00-00 00:00:00'), -- Hijo Cliente (4)
(43, 'Carrito', 'carrito.php', 4, '0000-00-00 00:00:00'), -- Hijo Cliente (4)
(44, 'Agregar Productos', 'agregarProductoAlCarrito.php', 0, '0000-00-00 00:00:00'); -- Hijo Nulo (0)

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'compra'
--
CREATE TABLE compra (
  idcompra bigint(20) NOT NULL,
  cofecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  idusuario bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'compra'
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- AUTO_INCREMENT de la tabla 'compra'
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Filtros para la tabla 'compra'
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

-- Volcado de datos de la tabla compra //cambiar los id compra y usuario
INSERT INTO compra (idcompra, cofecha, idusuario) VALUES
(1, '2021-11-19 02:43:15', 1),
(2, '2021-11-19 02:45:20', 1),
(3, '2021-11-19 02:53:10', 1),
(4, '2021-11-19 02:54:14', 1),
(5, '0000-00-00 00:00:00', 7); -- Compra test


-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'compraestado'
--
CREATE TABLE compraestado (
  idcompraestado bigint(20) UNSIGNED NOT NULL,
  idcompra bigint(11) NOT NULL,
  idcompraestadotipo int(11) NOT NULL,
  cefechaini timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  cefechafin timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'compraestado'
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- AUTO_INCREMENT de la tabla 'compraestado'
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Filtros para la tabla 'compraestado'
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

-- volcado de datos para la tabla compraestado //cambiar los id de compraestado, compra y compraestadotipo
INSERT INTO compraestado (idcompraestado, idcompra, idcompraestadotipo, cefechaini, cefechafin) VALUES
(1, 1, 1, '2021-11-19 02:43:16', '0000-00-00 00:00:00'),
(2, 2, 2, '2021-11-19 02:45:21', '0000-00-00 00:00:00'),
(3, 3, 3, '2021-11-19 02:53:12', '0000-00-00 00:00:00'),
(4, 4, 4, '2021-11-19 02:54:15', '0000-00-00 00:00:00');

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'compraitem'
--
CREATE TABLE compraitem (
  idcompraitem bigint(20) UNSIGNED NOT NULL,
  idproducto bigint(20) NOT NULL,
  idcompra bigint(20) NOT NULL,
  cicantidad int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'compraitem'
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- AUTO_INCREMENT de la tabla 'compraitem'
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Filtros para la tabla 'compraitem'
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

-- Volcado de datos para la tabla compraitem // cambiar los idproducto
INSERT INTO compraitem (idcompraitem, idproducto, idcompra, cicantidad) VALUES
(1, 01, 1, 1),
(2, 02, 2, 1),
(3, 03, 3, 1),
(4, 04, 4, 1);

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla 'menurol'
--
CREATE TABLE menurol (
  idmenu bigint(20) NOT NULL,
  idrol bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'menurol'
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

-- Volcado de datos para la tabla menurol
INSERT INTO menurol (idmenu, idrol) VALUES

(11, 1), -- Admin - Inicio (Home)
(21, 1), -- Admin - Crear Usuarios
(22, 1), -- Admin - Gestionar Usuarios
(23, 1), -- Admin - Gestionar Roles
(24, 1), -- Admin - Asignar Roles
(25, 1), -- Admin - Quitar Roles
(26, 1), -- Admin - Actualizar Usuario
(27, 1), -- Admin - Crear Rol

(11, 2), -- Deposito - Inicio (Home)
(31, 2), -- Deposito - Crear Productos
(32, 2), -- Deposito - Gestionar Productos
(33, 2), -- Deposito - Gestionar Compras
(34, 2), -- Deposito - Modificar productos

(11, 3), -- Cliente - Inicio (Home)
(41, 3), -- Cliente - Productos
(42, 3), -- Cliente - Mis Compras
(43, 3), -- Cliente - Carrito
(44, 3); -- Cliente - Ver Producto(Agregar Producto)

-- ----------------------------------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuariorol`
--
CREATE TABLE usuariorol (
  idusuario bigint(20) NOT NULL,
  idrol bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla 'usuariorol'
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

-- Índices para tablas volcadas
INSERT INTO usuariorol (idusuario, idrol) VALUES
(1,1), -- Admin
(2,2), -- Deposito
(3,3), -- Cliente
(4,3), -- Cliente;
(5,1), -- Admin (Admin/1234)
(6,2), -- Deposito (Deposito/1234)
(7,3), -- Cliente (Cliente/1234)
(8,3), -- Cliente (Nicolas/1234)
(9,1), -- Admin (AdminTotal/1234)
(9,2), -- Deposito (AdminTotal/1234)
(9,3); -- Cliente (AdminTotal/1234)

-- ----------------------------------------------------------------------------------

-- INFO datos truncados al ingresar fecha '0000-00-00 00:00:00' para timestamp

-- TIMESTAMP: Tiene un rango más limitado en comparación con DATETIME.
-- En MySQL, TIMESTAMP tiene un rango de '1970-01-01 00:00:01' UTC a '2038-01-19 03:14:07' UTC.
-- Esto se debe a que TIMESTAMP se almacena en un formato de timestamp de 32 bits.

-- DATETIME: Tiene un rango mucho más amplio, desde '1000-01-01 00:00:00' 
-- hasta '9999-12-31 23:59:59'. Se almacena en un formato de 64 bits.