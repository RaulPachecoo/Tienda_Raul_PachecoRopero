<?php

namespace Controllers;

use Models\Usuario;
use Lib\Pages;
use Utils\Utils;
use Controllers\ErrorController;

class UsuarioController
{
    private Pages $pages;

    public function __construct()
    {
        $this->pages = new Pages();
    }

    public function registro(): void
    {
        $registrado = null;
        $errores = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['data'])) {
                $registrado = $_POST['data'];
                $usuario = Usuario::fromArray($registrado);
                $validacion = $usuario->validarDatosRegistro();

                if ($validacion === true) {
                    $usuario->setPassword(password_hash($registrado['password'], PASSWORD_BCRYPT, ['cost' => 4]));
                    $save = $usuario->createUsuario();
                    if ($save) {
                        $_SESSION['register'] = "complete";
                    } else {
                        $_SESSION['register'] = "failed";
                    }
                } else {
                    $errores = $validacion;
                    $_SESSION['register'] = "failed";
                }
            } else {
                $_SESSION['register'] = "failed";
            }
        }

        // Renderizamos la vista sin el header ni el footer
        $this->pages->render('usuario/registro', ['datos' => $registrado, 'errores' => $errores], false, false);
    }


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

                            // Redirigir al usuario a la página principal
                            header('Location: ' . BASE_URL);
                            exit;  // Detener la ejecución del código después de la redirección
                        } else {
                            // Si la autenticación falla
                            $_SESSION['login'] = "failed";
                        }
                    } else {
                        // Si la validación falla, guardar los errores
                        $_SESSION['login'] = "failed";
                        $errores = $validacion;  // Guarda los errores de validación
                    }
                } else {
                    $_SESSION['login'] = "failed";
                    $errores = "Por favor, complete todos los campos.";
                }
            } else {
                $_SESSION['login'] = "failed";
            }
        }

        // Si no hay verificación (no se ha iniciado sesión), renderiza la página de login
        if (!isset($verify) || !$verify) {
            // Si hay errores, pasarlos a la vista
            if (isset($errores)) {
                $this->pages->render('Usuario/login', ['datos' => $login, 'errores' => $errores], false, false);
            } else {
                // Si no hay datos previos, solo renderizar el login
                $this->pages->render('Usuario/login', ['datos' => $login ?? []], false, false);
            }
        }
    }




    public function logout()
    {

        if (!isset($_SESSION['login'])) {
            return ErrorController::accesoDenegado();
        }

        Utils::deleteSession('login');

        // Asegúrate de que no haya salida antes de llamar a header()
        if (headers_sent()) {
            echo "<script>location.href='" . BASE_URL . "';</script>";
        } else {
            header("Location:" . BASE_URL);
            exit();  // Detener la ejecución del script después de la redirección
        }
    }

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
            header('Location: ' . BASE_URL);
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
                    // Update session data
                    $_SESSION['login']->nombre = $datos['nombre'];
                    $_SESSION['login']->apellidos = $datos['apellidos'];
                    // Ensure no output before this line
                    if (!headers_sent()) {
                        header('Location: ' . BASE_URL . 'Usuario/modificarDatos?id=' . $usuarioId); // Recargar la página
                        exit;
                    } else {
                        echo "<script>location.href='" . BASE_URL . "Usuario/modificarDatos?id=" . $usuarioId . "';</script>";
                        exit;
                    }
                } else {
                    $_SESSION['errores'] = "Hubo un error al actualizar los datos.";
                }
            } else {
                $_SESSION['errores'] = "No se enviaron datos para actualizar.";
            }
        }

        // Si no es un POST, renderiza la página de modificación
        // Aquí se pasan los datos actuales para que el usuario los pueda modificar
        $this->pages->render('usuario/modificarDatos', ['usuario' => $usuarioDatos, 'usuarioId' => $usuarioId, 'errores' => $_SESSION['errores'] ?? null]);
    }
}
