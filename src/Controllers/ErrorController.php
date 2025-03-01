<?php

namespace Controllers; 

class ErrorController{
    
    // Método estático para mostrar el error 404 (Recurso no encontrado)
    // Acepta un mensaje personalizado, o usa el predeterminado "Recurso no encontrado"
    public static function showError404(string $mensaje = "Recurso no encontrado.") {
        http_response_code(404);  // Establece el código de estado HTTP a 404
        echo "<p>Error 404: $mensaje</p>";  // Muestra el mensaje de error en la página
        exit;  // Detiene la ejecución del script después de mostrar el error
    }

    // Método estático para mostrar un mensaje de acceso denegado
    public static function accesoDenegado() {
        echo "<p>Acceso denegado. No tienes permiso para realizar esta acción.</p>";  // Muestra el mensaje de acceso denegado
    }

    // Método estático para mostrar el error 400 (Solicitud incorrecta)
    // Acepta un mensaje personalizado, o usa el predeterminado "Solicitud incorrecta"
    public static function showError400(string $mensaje = "Solicitud incorrecta.") {
        http_response_code(400);  // Establece el código de estado HTTP a 400
        echo "<p>Error 400: $mensaje</p>";  // Muestra el mensaje de error en la página
        exit;  // Detiene la ejecución del script después de mostrar el error
    }

    // Método estático para mostrar el error 500 (Error interno del servidor)
    public static function showError500(string $mensaje) {
        http_response_code(500);  // Establece el código de estado HTTP a 500
        echo "<p>Error 500: $mensaje</p>";  // Muestra el mensaje de error en la página
        exit;  // Detiene la ejecución del script después de mostrar el error
    }
}
