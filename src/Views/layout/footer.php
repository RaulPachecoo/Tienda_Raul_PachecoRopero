<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>

<body class="d-flex flex-column min-vh-100">
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>Sobre Nosotros</h5>
                    <p>Somos una tienda en línea comprometida con ofrecerte los mejores productos al mejor precio.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>" class="text-white text-decoration-none">Inicio</a></li>
                        <li><a href="<?= BASE_URL ?>Categoria/mostrarCategorias/" class="text-white text-decoration-none">Categorías</a></li>
                        <li><a href="<?= BASE_URL ?>Carrito/mostrarCarrito/" class="text-white text-decoration-none">Carrito</a></li>
                        <li><a href="<?= BASE_URL ?>Contacto/" class="text-white text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Redes Sociales</h5>
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <div class="mt-3">
                <p class="mb-0">&copy; <?= date("Y") ?> Tienda. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>

</html>