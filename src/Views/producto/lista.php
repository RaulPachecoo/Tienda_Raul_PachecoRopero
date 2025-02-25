<?php if (empty($productos)): ?>
    <div class="container text-center mt-5">
        <h2 class="text-light">No hay productos en esta categoría.</h2>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <h1 class="text-light text-center mb-4">Lista de Productos</h1>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card bg-dark text-light border-light shadow d-flex flex-column h-100" style="height: 100%;"> <!-- Altura uniforme -->
                        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column flex-grow-1" style="flex: 1 1 auto;"> <!-- Fixed height for card body -->
                            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                            <p class="card-text flex-grow-1"><?= $producto['descripcion'] ?></p> <!-- Descripción flexible -->
                            <h6 class="text-warning"><?= $producto['precio'] ?>€</h6>
                            <div class="mt-auto"> <!-- Mantiene el botón en la parte inferior -->
                                <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCarrito">
                                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                                    <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
                                    <div class="d-flex align-items-center">
                                        <input type="number" name="cantidad" class="form-control me-2" value="1" min="1" max="<?= $producto['stock'] ?>" style="width: 70px;">
                                        <button type="submit" class="btn btn-primary" disabled>Añadir al carrito</button>
                                    </div>
                                </form>
                                <?php if (!isset($_SESSION['login'])): ?>
                                    <p class="text-warning mt-2">Inicia sesión para poder comprar.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
