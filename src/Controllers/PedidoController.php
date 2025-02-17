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
    private $pages; 
    private $pedido; 
    private $carrito; 

    public function __construct(){
        $this->pages = new Pages(); 
        $this->pedido = new Pedido(); 
        $this->carrito = new CarritoController(); 
    }

    public function createPedido() {
        $this->carrito->comprobarLogin(); 

        if (empty($_SESSION['carrito'])) {
            return ErrorController::showError500("El carrito está vacío.");
        }

        if (empty($_POST['provincia']) || empty($_POST['localidad']) || empty($_POST['direccion'])) {
            return ErrorController::showError500("Hay campos requeridos vacíos.");
        }

        $usuario_id = $_SESSION['login']->id; 
        $provincia = $_POST['provincia'];
        $localidad = $_POST['localidad'];
        $direccion = $_POST['direccion'];
        $precioTotal = 0;
        $productosPedido = [];

        foreach ($_SESSION['carrito'] as $producto) {
            $precioTotal += $producto['precio'] * $producto['cantidad']; 
            $idProducto = $producto['producto_id'];
            $cantidad = $producto['cantidad']; 

            $productoModel = new Producto();
            $stock = $productoModel->getStockById($idProducto); 

            if ($stock < $cantidad) {
                return ErrorController::showError500("No hay stock suficiente para el producto: {$producto['nombre']}.");
            }

            $nuevoStock = $stock - $cantidad; 
            $productoModel->updateStock($idProducto, $nuevoStock); 

            $productosPedido[] = [
                'nombre' => $producto['nombre'],
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'costo_total' => $producto['precio'] * $producto['cantidad']
            ];
        }

        $estado = 'Pendiente'; 
        $result = $this->pedido->createPedido($usuario_id, $provincia, $localidad, $direccion, $precioTotal, $estado);

        if (!$result) {
            return ErrorController::showError500("Error al crear el pedido.");
        }

        unset($_SESSION['carrito']);
        header("Location: " . BASE_URL . "Pedido/mostrarPedidos");
        exit;
    }

    public function completarPedido(int $id) {
        $this->carrito->comprobarLogin(); 

        $productosPedido = $this->pedido->getProductosPedidoFromSession(); 

        if (!$productosPedido) {
            return ErrorController::showError404();
        }

        $estado = 'Enviado'; 
        $updated = $this->pedido->updateEstadoPedido($id, $estado);

        if (!$updated) {
            return ErrorController::showError500("Error al completar el pedido.");
        }

        $this->sendConfirmationEmail($id, $productosPedido);

        header("Location: " . BASE_URL . "Pedido/mostrarPedidos");
        exit;
    }

    private function sendConfirmationEmail(int $pedidoId, $productos) {
        $this->carrito->comprobarLogin(); 

        $mail = new PHPMailer(true); 

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('raulpachecoropero555@gmail.com', 'La tienda de Raúl'); 
            $mail->addAddress($_SESSION['login']->email, $_SESSION['login']->nombre); 

            // Construcción del cuerpo del correo
            $body = '<h3>Gracias por comprar en nuestra tienda</h3>';
            $body .= '<p>Detalles del pedido (ID: ' . $pedidoId . '):</p>';
            $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Costo total</th>
                        </tr>';

            foreach ($productos as $producto) {
                $body .= '<tr>
                            <td>' . htmlspecialchars($producto['nombre']) . '</td>
                            <td>' . htmlspecialchars($producto['cantidad']) . '</td>
                            <td>$' . number_format($producto['precio'], 2) . '</td>
                            <td>$' . number_format($producto['costo_total'], 2) . '</td>
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
            return ErrorController::showError500("Error al enviar el correo: " . $e->getMessage());
        }
    }

    public function showPedidos() {
        $this->carrito->comprobarLogin(); 

        if (!isset($_SESSION['login'])) {
            return ErrorController::showError500("Usuario no autenticado.");
        }

        $usuarioId = $_SESSION['login']->id; 
        $esAdministrador = $_SESSION['login']->rol === 'Admin';

        $pedidos = $esAdministrador ? $this->pedido->getAll() : $this->pedido->getPedidosByUsuario($usuarioId);

        $this->pages->render('pedidos/mostrarPedidos', ['pedidos' => $pedidos]);
    }
}