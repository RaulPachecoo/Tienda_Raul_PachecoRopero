<div class="container mt-5">
    <h1 class="text-light text-center mb-4">Gestionar Productos</h1>

    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errores)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errores as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-light border-light shadow h-100 d-flex flex-column">
                    <img src="<?= BASE_URL ?>public/imgs/<?= $producto['imagen']?>" class="card-img-top" alt="<?= $producto['nombre'] ?>" style="max-height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p class="card-text flex-grow-1"><?= $producto['descripcion'] ?></p>
                        <h6 class="text-info">Precio: <?= $producto['precio'] ?>€</h6>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>Producto/modificarProducto?id=<?= $producto['id'] ?>" class="btn btn-warning">Modificar</a>
                            <a href="<?= BASE_URL ?>Producto/eliminarProducto?id=<?= $producto['id'] ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
