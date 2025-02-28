<h1 class="text-light text-center mt-5">Carrito de Compras</h1>

<?php
if (isset($_COOKIE['carrito'])) {
    $_SESSION['carrito'] = json_decode($_COOKIE['carrito'], true);
}
?>

<?php if (!empty($_SESSION['carrito'])): ?>
    <div class="container mt-4">
        <div class="row">
            <?php
            $totalCarrito = 0;
            foreach ($_SESSION['carrito'] as $productoId => $producto): 
                // Aseguramos que el stock esté disponible
                $stockDisponible = isset($producto['stock']) ? (int) $producto['stock'] : 0;
                $cantidadEnCarrito = (int) $producto['cantidad'];
                $stockInsuficiente = $cantidadEnCarrito >= $stockDisponible;
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-light border-light shadow">
                        <img src="<?= BASE_URL ?>public/imgs/<?= $producto['imagen'] ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>" 
                             style="max-height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></h5>
                            <p class="card-text">Cantidad: <?= $cantidadEnCarrito ?></p>
                            <h6 class="text-warning">Subtotal: <?= $producto['precio'] * $cantidadEnCarrito ?>€</h6>

                            <?php if ($stockDisponible > 0 && $cantidadEnCarrito < $stockDisponible): ?>
                                <p class="text-success mt-2">Stock disponible: <?= $stockDisponible ?></p>
                            <?php else: ?>
                                <p class="text-danger mt-2">No hay más stock disponible.</p>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between mt-3">
                                <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCantidad">
                                    <input type="hidden" name="producto_id" value="<?= $productoId ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-success" <?= $stockInsuficiente ? 'disabled' : '' ?>>+</button>
                                </form>
                                <form method="POST" action="<?= BASE_URL ?>Carrito/eliminarCantidad">
                                    <input type="hidden" name="producto_id" value="<?= $productoId ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-warning">-</button>
                                </form>
                                <form method="POST" action="<?= BASE_URL ?>Carrito/eliminarProducto">
                                    <input type="hidden" name="producto_id" value="<?= $productoId ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $totalCarrito += $producto['precio'] * $cantidadEnCarrito;
            endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <h3 class="text-light">Total del carrito: <?= $totalCarrito ?>€</h3>
            <form method="POST" action="<?= BASE_URL ?>Carrito/vaciarCarrito" class="d-inline">
                <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
            </form>
            <a href="<?= BASE_URL ?>Pedido/crearPedido" class="btn btn-primary">Hacer pedido</a>
        </div>
    </div>
<?php else: ?>
    <div class="container text-center mt-5">
        <h2 class="text-light">El carrito está vacío.</h2>
    </div>
<?php endif; ?>
