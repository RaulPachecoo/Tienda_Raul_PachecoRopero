<?php
if (empty($productos)): ?>
    <div class="container text-center mt-5">
        <h2 class="text-light">No hay productos en esta categoría.</h2>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <h1 class="text-light text-center mb-4">Lista de Productos</h1>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-light border-light shadow">
                        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                            <p class="card-text"><?= $producto['descripcion'] ?></p>
                            <h6 class="text-warning"><?= $producto['precio'] ?>€</h6>
                            <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCarrito">
                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                                <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
                                <div class="d-flex align-items-center mb-2">
                                    <input type="number" name="cantidad" class="form-control me-2" value="1" min="1" max="<?= $producto['stock'] ?>" style="width: 70px;">
                                    <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
