<?php 

namespace Controllers; 
use Models\Usuario; 
use Lib\Pages; 
use Utils\Utils; 
use Controllers\ErrorController; 

class UsuarioController{
    private Pages $pages; 

    public function __construct(){
        $this->pages = new Pages(); 
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data'])) {
            $registrado = $_POST['data'];
            $usuario = Usuario::fromArray($registrado);
            $validacion = $usuario->validarDatosRegistro();
    
            if ($validacion === true) {
                $usuario->setPassword(password_hash($registrado['password'], PASSWORD_BCRYPT, ['cost' => 4]));
                $save = $usuario->createUsuario();
                $_SESSION['registrado'] = $save ? "complete" : "failed";
            } else {
                $_SESSION['registrado'] = "failed";
                $errores = $validacion;
            }
        } else {
            return ErrorController::showError404(); 
        }
    
        $this->pages->render('/usuario/registro', $errores ?? [] ? ['datos' => $registrado ?? [], 'errores' => $errores] : []);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data'])) {
            $login = $_POST['data'];
            $usuario = Usuario::fromArray($login);
            $validacion = $usuario->validarDatosLogin();
    
            if ($validacion === true) {
                $verify = $usuario->login();
    
                if ($verify) {
                    $_SESSION['login'] = $verify;
                    header('Location: ' . BASE_URL . '/');
                    exit;
                } else {
                    $_SESSION['login'] = "failed";
                }
            } else {
                $_SESSION['login'] = "failed";
                $errores = $validacion;
            }
        } else {
            return ErrorController::showError404(); 
        }
    
        if (!isset($verify) || !$verify) {
            $params = ['datos' => $login ?? []];
            if (isset($errores)) {
                $params['errores'] = $errores;
            }
            $this->pages->render('/usuario/login', $params);
        }
    }

    public function logout(){

        if(!isset($_SESSION['login'])){
            return ErrorController::accesoDenegado(); 
        }

        Utils::deleteSession('login'); 

        header("Location:".BASE_URL); 
    }
    
}