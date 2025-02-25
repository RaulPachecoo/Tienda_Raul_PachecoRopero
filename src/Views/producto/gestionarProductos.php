<div class="container mt-5">
    <h1 class="text-light text-center mb-4">Gestionar Productos</h1>
    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-light border-light shadow">
                    <img src="<?= $producto['imagen']?>" class="card-img-top" alt="<?= $producto['nombre'] ?>" style="max-height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= $producto['descripcion'] ?></p>
                        <h6 class="text-info">Precio: <?= $producto['precio'] ?>€</h6>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="<?= BASE_URL ?>Producto/modificarProducto?id=<?= $producto['id'] ?>" class="btn btn-warning">Modificar</a>
                            <a href="<?= BASE_URL ?>Producto/eliminarProducto?id=<?= $producto['id'] ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>