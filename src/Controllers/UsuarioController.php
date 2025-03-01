<?php

namespace Controllers;

use Models\Usuario;
use Lib\Pages;
use Utils\Utils;
use Controllers\ErrorController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class UsuarioController
{
    private Pages $pages;

    // Constructor que inicializa la clase Pages y carga las variables de entorno
    public function __construct()
    {
        $this->pages = new Pages();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../config');
        $dotenv->safeLoad(); // Use safeLoad to avoid exceptions if the file is not found
    }

    // Método para manejar el registro de usuarios
    public function registro(): void
    {
        $registrado = null;
        $errores = null;

        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['data'])) {
                $registrado = $_POST['data'];
                $usuario = Usuario::fromArray($registrado); // Crear un objeto Usuario con los datos enviados
                $validacion = $usuario->validarDatosRegistro(); // Validar los datos del registro

                if ($validacion === true) {
                    $usuario->setPassword(password_hash($registrado['password'], PASSWORD_BCRYPT, ['cost' => 4])); // Cifrar la contraseña
                    $save = $usuario->createUsuario(); // Guardar el nuevo usuario en la base de datos
                    if ($save) {
                        $_SESSION['register'] = "complete"; // Registro exitoso
                        $this->sendConfirmationEmail($usuario); // Enviar un correo de confirmación
                    } else {
                        $_SESSION['register'] = "failed"; // Si hay un error al guardar
                    }
                } else {
                    $errores = $validacion; // Si la validación falla, se guardan los errores
                    $_SESSION['register'] = "failed";
                }
            } else {
                $_SESSION['register'] = "failed"; // Si no se reciben datos, se marca el registro como fallido
            }
        }

        // Renderiza la vista del registro sin el header ni el footer
        $this->pages->render('usuario/registro', ['datos' => $registrado, 'errores' => $errores], false, false);
    }

    // Método privado para enviar un correo de confirmación tras el registro
    private function sendConfirmationEmail(Usuario $usuario): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER']; // Usuario SMTP desde el archivo .env
            $mail->Password = $_ENV['SMTP_PASS']; // Contraseña SMTP desde el archivo .env
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Configuración del correo
            $mail->setFrom($_ENV['SMTP_USER'], 'Car Shop');
            $mail->addAddress($usuario->getEmail(), $usuario->getNombre());

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Registro exitoso en Car Shop';
            $mail->Body = '<h3>Bienvenido a Car Shop, ' . htmlspecialchars($usuario->getNombre()) . '!</h3>
                           <p>Gracias por registrarte en nuestra tienda. Ahora puedes iniciar sesión y comenzar a comprar.</p>
                           <p><strong>¡Esperamos verte pronto!</strong></p>';

            $mail->send(); // Enviar el correo
        } catch (Exception $e) {
            error_log("Error al enviar el correo de confirmación: " . $e->getMessage()); // Si hay error, se guarda en el log
        }
    }

    // Método para manejar el inicio de sesión de los usuarios
    public function login(): void
    {
        // Verifica que la solicitud sea POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar que los datos de login estén presentes
            if (isset($_POST['data'])) {
                $login = $_POST['data'];  // Datos recibidos del formulario

                // Asegúrate de que los datos de login estén completos
                if (!empty($login['email']) && !empty($login['password'])) {

                    // Crear el objeto usuario
                    $usuario = Usuario::fromArray($login);

                    // Validar los datos del usuario
                    $validacion = $usuario->validarDatosLogin();
                    if ($validacion === true) {
                        // Intentar iniciar sesión
                        $verify = $usuario->login();
                        if ($verify !== false) {
                            // Guardar los datos del usuario en la sesión
                            $_SESSION['login'] = $verify;

                            // Manejar la funcionalidad de "recordarme"
                            if (isset($login['remember']) && $login['remember'] === 'on') {
                                setcookie('user_email', $verify->email, time() + (7 * 24 * 60 * 60), "/");
                            }

                            // Redirigir al usuario a la página principal
                            header('Location: ' . BASE_URL);
                            exit;  // Detener la ejecución del código después de la redirección
                        } else {
                            // Si la autenticación falla
                            $_SESSION['login'] = "failed";
                            $errores = ["Usuario o contraseña incorrectos."]; // Error en caso de fallar login
                        }
                    } else {
                        // Si la validación falla, guardar los errores
                        $_SESSION['login'] = "failed";
                        $errores = $validacion;  // Guarda los errores de validación
                    }
                } else {
                    $_SESSION['login'] = "failed";
                    $errores = ["Por favor, complete todos los campos."]; // Error si faltan datos
                }
            } else {
                $_SESSION['login'] = "failed";
                $errores = ["Datos de login no recibidos."]; // Error si no se reciben datos
            }
        }

        // Si no hay verificación (no se ha iniciado sesión), renderiza la página de login
        if (!isset($verify) || !$verify) {
            // Si hay errores, pasarlos a la vista
            if (isset($errores)) {
                $this->pages->render('usuario/login', ['datos' => $login, 'errores' => $errores], false, false);
            } else {
                // Si no hay datos previos, solo renderizar el login
                $this->pages->render('usuario/login', ['datos' => $login ?? []], false, false);
            }
        }
    }

    // Método para manejar el cierre de sesión de los usuarios
    public function logout()
    {
        // Verificar si la sesión está activa
        if (!isset($_SESSION['login'])) {
            return ErrorController::accesoDenegado(); // Acceso denegado si no está logueado
        }

        Utils::deleteSession('login'); // Eliminar la sesión del usuario

        // Limpiar la cookie de usuario
        setcookie('user_email', '', time() - 3600, "/");

        // Redirigir al usuario a la página principal
        if (headers_sent()) {
            echo "<script>location.href='" . BASE_URL . "';</script>";
        } else {
            header("Location:" . BASE_URL);
            exit();  // Detener la ejecución del script después de la redirección
        }
    }

    // Método para modificar los datos de un usuario
    public function modificarDatos(int $usuarioId): void
    {
        // Verifica si el usuario está logueado
        if (!isset($_SESSION['login'])) {
            ErrorController::accesoDenegado(); // Acceso denegado si no está logueado
            return;
        }

        // Crear una instancia de la clase Usuario
        $usuario = new Usuario(null, '', '', '', '', ''); // Puede ser cualquier usuario genérico para acceder a los métodos

        // Obtener los datos del usuario usando el método getById
        $usuarioDatos = $usuario->getById($usuarioId);

        // Verifica si el usuario existe
        if (!$usuarioDatos) {
            $_SESSION['errores'] = "Usuario no encontrado.";
            header('Location: ' . BASE_URL); // Redirigir si el usuario no existe
            exit;
        }

        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['data'])) {
                $datos = $_POST['data']; // Obtiene los datos del formulario

                // Verificar si el usuario tiene permisos para modificar sus datos
                if ($_SESSION['login']->rol === 'user' && $_SESSION['login']->id == $usuarioId) {
                    // Si es un usuario normal, solo puede modificar nombre, apellidos y email
                    $usuario = new Usuario(null, $datos['nombre'], $datos['apellidos'], $datos['email'], '', ''); // Crear instancia sin el rol
                    $actualizado = $usuario->modificarDatosUsuario($usuarioId, $datos);
                } elseif ($_SESSION['login']->rol === 'admin') {
                    // Si es un admin, puede modificar todos los campos, incluyendo el rol
                    $usuario = new Usuario(null, $datos['nombre'], $datos['apellidos'], $datos['email'], '', $datos['rol']); // Crear instancia con todos los datos
                    $actualizado = $usuario->modificarDatosAdmin($usuarioId, $datos);
                } else {
                    $_SESSION['errores'] = "No tienes permisos para modificar estos datos.";
                    header('Location: ' . BASE_URL . 'usuario/perfil');
                    exit;
                }

                // Si los datos se han actualizado correctamente
                if ($actualizado) {
                    $_SESSION['mensaje'] = "Los datos se han actualizado correctamente.";
                    // Actualizar los datos de la sesión
                    $_SESSION['login']->nombre = $datos['nombre'];
                    $_SESSION['login']->apellidos = $datos['apellidos'];
                    // Asegurarse de que no haya salida antes de esta línea
                    if (!headers_sent()) {
                        header('Location: ' . BASE_URL . 'Usuario/modificarDatos?id=' . $usuarioId); // Recargar la página
                        exit;
                    } else {
                        echo "<script>location.href='" . BASE_URL . "Usuario/modificarDatos?id=" . $usuarioId . "';</script>";
                        exit;
                    }
                } else {
                    $_SESSION['errores'] = "Hubo un error al actualizar los datos."; // Error si no se pudieron actualizar los datos
                }
            } else {
                $_SESSION['errores'] = "No se enviaron datos para actualizar."; // Error si no se enviaron datos
            }
        }

        // Si no es un POST, renderiza la página de modificación
        // Aquí se pasan los datos actuales para que el usuario los pueda modificar
        $this->pages->render('usuario/modificarDatos', ['usuario' => $usuarioDatos, 'usuarioId' => $usuarioId, 'errores' => $_SESSION['errores'] ?? null]);
    }
}
?>