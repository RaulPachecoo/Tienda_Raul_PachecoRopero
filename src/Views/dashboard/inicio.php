<?php use Controllers\ProductoController;

$productos= ProductoController::getProductos();?>
<?php foreach ($productos as $producto):?>
    <div>
        <h2><?= $producto['nombre'] ?></h2>
        <p><?= $producto['descripcion'] ?></p>
        <?php 
            $imagenPath = BASE_URL . 'public/images/' . $producto['imagen'];
        ?>
        <img src="<?= $imagenPath ?>" alt="<?= $producto['nombre'] ?>" style="max-width: 200px; max-height: 200px;">
        <p><?= $producto['precio']?>€</p>

        <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCarrito">
            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
            <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
            <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
            <input type="number" name="cantidad" value="1" min="1" max="<?= $producto['stock'] ?>"> 
            <button type="submit">Añadir al carrito</button>
        </form>
    </div>
<?php endforeach; ?>