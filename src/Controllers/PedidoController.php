<?php

namespace Controllers; 

use Lib\Pages; 
use Utils\Utils; 
use Models\Pedido; 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP; 
use Controllers\CarritoController; 
use Models\Producto;

class PedidoController{
    private $pages; // Instancia de la clase Pages para renderizar vistas
    private $pedido; // Instancia de la clase Pedido para interactuar con la base de datos de pedidos
    private $carrito; // Instancia de la clase CarritoController para manejar el carrito de compras

    // Constructor para inicializar las instancias necesarias
    public function __construct(){
        $this->pages = new Pages(); 
        $this->pedido = new Pedido(); 
        $this->carrito = new CarritoController(); 
    }

    // Método para crear un nuevo pedido
    public function createPedido() {
        $this->carrito->comprobarLogin(); // Verifica que el usuario esté logueado

        // Si la solicitud es de tipo GET, se muestra el formulario de pago
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->pages->render('pedidos/formularioPago');
            return;
        }

        // Verifica que el carrito no esté vacío
        if (empty($_SESSION['carrito'])) {
            return ErrorController::showError500("El carrito está vacío.");
        }

        // Verifica que los campos requeridos no estén vacíos
        if (empty($_POST['provincia']) || empty($_POST['localidad']) || empty($_POST['direccion'])) {
            return ErrorController::showError500("Hay campos requeridos vacíos.");
        }

        // Recupera los datos del pedido y del carrito
        $usuario_id = $_SESSION['login']->id; 
        $provincia = $_POST['provincia'];
        $localidad = $_POST['localidad'];
        $direccion = $_POST['direccion'];
        $precioTotal = 0;
        $productosPedido = [];

        // Itera sobre los productos del carrito para calcular el precio total y verificar el stock
        foreach ($_SESSION['carrito'] as $producto) {
            $precioTotal += $producto['precio'] * $producto['cantidad']; 
            $idProducto = $producto['producto_id'];
            $cantidad = $producto['cantidad']; 

            $productoModel = new Producto();
            $stockData = $productoModel->getStockById($idProducto); 
            $stock = $stockData['stock']; // Extrae el valor del stock

            // Si no hay suficiente stock, muestra un error
            if ($stock < $cantidad) {
                return ErrorController::showError500("No hay stock suficiente para el producto: {$producto['nombre']}.");
            }

            $nuevoStock = $stock - $cantidad; 
            $productoModel->updateStock($idProducto, $nuevoStock); // Actualiza el stock del producto

            // Añade el producto al arreglo de productos del pedido
            $productosPedido[] = [
                'producto_id' => $idProducto,
                'nombre' => $producto['nombre'],
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'costo_total' => $producto['precio'] * $producto['cantidad']
            ];
        }

        // Establece el estado del pedido como "Pendiente"
        $estado = 'Pendiente'; 
        $result = $this->pedido->createPedido($usuario_id, $provincia, $localidad, $direccion, $precioTotal, $estado);

        // Si el pedido fue creado correctamente, crea las líneas del pedido y destruye la cookie del carrito
        if ($result) {
            $pedidoId = $this->pedido->getId(); // Obtiene el ID del pedido creado

            foreach ($productosPedido as $producto) {
                $this->pedido->createLineaPedido($pedidoId, $producto['producto_id'], $producto['cantidad']);
            }

            setcookie('carrito', '', time() - 3600, '/'); // Destruye la cookie del carrito
        }

        // Si hubo un error al crear el pedido, muestra un error
        if (!$result) {
            return ErrorController::showError500("Error al crear el pedido.");
        }

        // Muestra la página de pedidos
        $this->showPedidos();
    }

    // Método para completar un pedido (cambiar su estado a "Enviado")
    public function completarPedido(int $id) {
        $this->carrito->comprobarLogin(); // Verifica que el usuario esté logueado

        // Obtiene los productos del pedido desde la sesión
        $productosPedido = $this->pedido->getProductosPedidoFromSession(); 

        // Si no hay productos en el pedido, muestra un error 404
        if (!$productosPedido) {
            return ErrorController::showError404();
        }

        // Cambia el estado del pedido a "Enviado"
        $estado = 'Enviado'; 
        $updated = $this->pedido->updateEstadoPedido($id, $estado);

        // Si hubo un error al actualizar el estado, muestra un error
        if (!$updated) {
            $pedidos = $this->pedido->getAll();
            foreach ($pedidos as &$pedido) {
                if ($pedido['id'] == $id) {
                    $pedido['error'] = "Error al completar el pedido.";
                    break;
                }
            }
            $this->pages->render('pedidos/mostrarPedidos', ['pedidos' => $pedidos]);
            return;
        }

        // Envia el correo de confirmación al usuario
        $this->sendConfirmationEmail($id, $productosPedido);
        $usuarioId = $_SESSION['login']->id; 
        $esAdministrador = $_SESSION['login']->rol === 'admin';
        
        // Si el usuario es administrador, obtiene todos los pedidos; si no, obtiene solo los pedidos del usuario
        $pedidos = $esAdministrador ? $this->pedido->getAll() : $this->pedido->getPedidosByUsuario($usuarioId);

        // Vacía el carrito de la sesión
        $_SESSION['carrito'] = [];
        // Muestra la página con los pedidos
        $this->pages->render('pedidos/mostrarPedidos', ['pedidos' => $pedidos]);

        exit;
    }

    // Método privado para enviar un correo de confirmación de pedido
    private function sendConfirmationEmail(int $pedidoId, $productos) {
        $this->carrito->comprobarLogin(); // Verifica que el usuario esté logueado

        // Obtiene los detalles del pedido
        $pedido = $this->pedido->getPedidoById($pedidoId);

        // Si no se encuentra el pedido, muestra un error
        if (!$pedido) {
            return ErrorController::showError500("Pedido no encontrado.");
        }

        // Recupera el correo y el nombre del usuario que realizó el pedido
        $usuarioEmail = $pedido['email'];
        $usuarioNombre = $pedido['nombre'];

        // Configura PHPMailer para enviar el correo
        $mail = new PHPMailer(true); 

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'raulpachecoropero555@gmail.com';
            $mail->Password = 'mbmhjooikomdahdo';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Configura el remitente y destinatario
            $mail->setFrom('raulpachecoropero555@gmail.com', 'Car Shop'); 
            $mail->addAddress($usuarioEmail, $usuarioNombre); 

            // Construcción del cuerpo del correo
            $body = '<h3>Gracias por comprar en nuestra tienda</h3>';
            $body .= '<p>Detalles del pedido (ID: ' . $pedidoId . '):</p>';
            $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
            $body .= '<tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Costo total</th>
                    </tr>';

            foreach ($productos as $producto) {
                $body .= '<tr>
                            <td>' . htmlspecialchars($producto['nombre']) . '</td>
                            <td>' . htmlspecialchars($producto['cantidad']) . '</td>
                            <td>' . number_format($producto['precio'], 2) . '€</td>
                            <td>' . number_format($producto['costo_total'], 2) . '€</td>
                        </tr>';
            }

            $body .= '</table>';
            $body .= '<p><strong>¡Esperamos verte pronto!</strong></p>'; 

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Confirmación del pedido #' . $pedidoId;
            $mail->Body = $body;
            $mail->send();
        } catch (Exception $e) {
            // Si ocurre un error al enviar el correo, muestra un error
            return ErrorController::showError500("Error al enviar el correo: " . $e->getMessage());
        }
    }

    // Método para mostrar todos los pedidos del usuario o administrador
    public function showPedidos() {
        $this->carrito->comprobarLogin(); // Verifica que el usuario esté logueado

        // Si no hay usuario autenticado, muestra un error
        if (!isset($_SESSION['login'])) {
            return ErrorController::showError500("Usuario no autenticado.");
        }

        // Obtiene los pedidos del usuario o todos los pedidos si es administrador
        $usuarioId = $_SESSION['login']->id; 
        $esAdministrador = $_SESSION['login']->rol === 'admin';

        $pedidos = $esAdministrador ? $this->pedido->getAll() : $this->pedido->getPedidosByUsuario($usuarioId);

        // Renderiza la página con los pedidos
        $this->pages->render('pedidos/mostrarPedidos', ['pedidos' => $pedidos]);
    }
}
