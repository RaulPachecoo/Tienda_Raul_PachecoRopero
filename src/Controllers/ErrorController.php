<?php

namespace Controllers; 

class ErrorController{
    public static function showError404(string $mensaje = "Recurso no encontrado.") {
        http_response_code(404);
        echo "<p>Error 404: $mensaje</p>";
        exit;
    }
    public static function accesoDenegado() {
        echo "<p>Acceso denegado. No tienes permiso para realizar esta acción.</p>";
    }

    public static function showError400(string $mensaje = "Solicitud incorrecta.") {
        http_response_code(400);
        echo "<p>Error 400: $mensaje</p>";
        exit;
    }

    public static function showError500(string $mensaje) {
        http_response_code(500);
        echo "<p>Error 500: $mensaje</p>";
        exit;
    }
}