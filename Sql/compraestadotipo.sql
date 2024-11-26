INSERT INTO
    `compraestadotipo` (
        `idcompraestadotipo`,
        `cetdescripcion`,
        `cetdetalle`
    )
VALUES (
        1,
        'ingresada',
        'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'
    ),
    (
        2,
        'confirmada',
        'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '
    ),
    (
        3,
        'cancelada',
        'cuando el usuario administrador envia a uno de las compras en estado =2 '
    ),
    (
        4,
        'enviada a destino',
        'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 '
    );