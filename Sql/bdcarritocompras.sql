CREATE TABLE `menu` (
    `idmenu` bigint(20) NOT NULL  AUTO_INCREMENT,
    `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
    `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
    `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
    `medeshabilitado` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez',
    PRIMARY KEY (`idmenu`),
    FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `rol` (
    `idrol` bigint(20) NOT NULL AUTO_INCREMENT,
    `rodescripcion` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `menurol` (
    `idmenu` bigint(20) NOT NULL,
    `idrol` bigint(20) NOT NULL,
    PRIMARY KEY  (`idmenu`,`idrol`),
    FOREIGN KEY (`idmenu`) REFERENCES `menu`(`idmenu`) ON UPDATE CASCADE,
    FOREIGN KEY (`idrol`) REFERENCES `rol`(`idrol`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `usuario` (
    `idusuario` bigint(20) NOT NULL AUTO_INCREMENT,
    `usnombre` VARCHAR(50) NOT NULL,
    `uspass` VARCHAR(32) NOT NULL,
    `usmail` VARCHAR(50) NOT NULL,
    `usdeshabilitado` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `usuariorol` (
    `idusuario` bigint(20) NOT NULL,
    `idrol` bigint(20) NOT NULL,
    PRIMARY KEY (`idusuario`, `idrol`),
    FOREIGN KEY (`idusuario`) REFERENCES `usuario`(`idusuario`) ON UPDATE CASCADE,
    FOREIGN KEY (`idrol`) REFERENCES `rol`(`idrol`) ON UPDATE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `compra` (
    `idcompra` bigint(20) NOT NULL AUTO_INCREMENT,
    `cofecha` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `idusuario` bigint(20) NOT NULL,
    PRIMARY KEY (`idcompra`),
    FOREIGN KEY (`idusuario`) REFERENCES `usuario`(`idusuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `compraestadotipo` ( /* yo, fran, le agregue AUTO_INCREMENT al `idcompraestadotipo` para simplificar el trabajo*/    
    `idcompraestadotipo` int(11) NOT NULL AUTO_INCREMENT,
    `cetdescripcion` varchar(50) NOT NULL,
    `cetdetalle` varchar(256) NOT NULL,
    PRIMARY KEY (`idcompraestadotipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `compraestado` (
    `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `idcompra` bigint(20) NOT NULL,
    `idcompraestadotipo` int(11) NOT NULL,
    `cefechaini` timestamp DEFAULT CURRENT_TIMESTAMP,
    `cefechafin` timestamp NULL,
    PRIMARY KEY (`idcompraestado`),
    FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
    FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `producto` (
    `idproducto` bigint(20) NOT NULL AUTO_INCREMENT,
    `pronombre` int(11) NOT NULL,
    `prodetalle` varchar(512) NOT NULL,
    `procantstock` int(11) NOT NULL,
    PRIMARY KEY (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `compraitem` (
    `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `idproducto` bigint(20) NOT NULL,
    `idcompra` bigint(20) NOT NULL,
    `cicantidad` int(11) NOT NULL,
    PRIMARY KEY (`idcompraitem`),
    FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
    FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;