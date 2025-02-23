<?php use Controllers\ProductoController;

$productos = ProductoController::getProductos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000000; /* Fondo negro */
            color: #fff; /* Texto blanco */
        }

        .producto {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .producto img {
            max-width: 100%;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .producto img:hover {
            transform: scale(1.05);
        }

        .producto h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .producto p {
            font-size: 1rem;
            color: #555;
        }

        .precio {
            font-size: 1.2rem;
            font-weight: bold;
            color: #B52BD8;
        }

        .form-group {
            margin-top: 15px;
        }

        .btn-carrito {
            background-color: #B52BD8;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-carrito:hover {
            background-color: #452BD8;
        }

        .productos-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <h1 class="text-center mb-5">Bienvenido a nuestra tienda</h1>
        <div class="productos-container">
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <img src="<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" class="img-fluid">
                    <h2><?= $producto['nombre'] ?></h2>
                    <p><?= $producto['descripcion'] ?></p>
                    <p class="precio"><?= $producto['precio'] ?>€</p>

                    <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCarrito">
                        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                        <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                        <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" value="1" min="1" max="<?= $producto['stock'] ?>" class="form-control">
                        </div>
                        <button type="submit" class="btn-carrito mt-3">Añadir al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS (necesario para los componentes interactivos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
