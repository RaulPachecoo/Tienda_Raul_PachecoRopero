<?php

namespace Utils;

class Utils {
    public static function deleteSession(string $name): void {
        if (!empty($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}
