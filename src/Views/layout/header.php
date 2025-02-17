<?php
use Controllers\CategoriaController;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css" type="text/css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= BASE_URL ?>">Tienda</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <?php if (!isset($_SESSION['login']) || $_SESSION['login'] == 'failed'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>Usuario/login">Identificarse</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>Usuario/registro/">Registrarse</a>
                            </li>
                        <?php else: ?>
                            <?php if ($_SESSION['login']->rol === "admin"): ?>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Pedido/mostrarPedidos/">Gestionar Pedidos</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Producto/gestionarProductos/">Gestionar Productos</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Producto/crearProducto/">Añadir Producto</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Categoria/mostrarCategorias/">Gestionar Categorías</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Categoria/crearCategoria/">Añadir Categoría</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Usuario/registro/">Registrar Usuario</a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Pedido/mostrarPedidos/">Mis Pedidos</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Carrito/mostrarCarrito/">Carrito</a></li>
                            <?php endif; ?>
                            <li class="nav-item"><a class="nav-link text-danger" href="<?= BASE_URL ?>Usuario/logout/">Cerrar Sesión</a></li>
                        <?php endif; ?>
                    </ul>

                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] != 'failed'): ?>
                        <span class="navbar-text text-light">
                            <?= $_SESSION['login']->nombre ?> <?= $_SESSION['login']->apellidos ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <?php $categorias = CategoriaController::getCategorias(); ?>

    <!-- Menú de Categorías -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategorias"
                aria-controls="navbarCategorias" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCategorias">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorías
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriasDropdown">
                            <?php foreach ($categorias as $categoria): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>Categoria/mostrarProductosCategoria/?id=<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS (necesario para los dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
