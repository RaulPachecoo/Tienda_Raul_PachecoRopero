<?php

namespace Models;

use Lib\DBConnection;
use PDO;
use PDOException;


class Usuario
{
    private string|null $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $rol;
    private DBConnection $db;

    public function __construct(string|null $id, string $nombre, string $apellidos, string $email, string $password, string $rol)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->db = new DBConnection();
    }



    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    public static function fromArray(array $data)
    {
        return new Usuario(
            $data['id'] ?? null,
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['rol'] ?? '',
        );
    }

    public function desconecta()
    {
        $this->db->close();
    }

    public function createUsuario()
    {
        $id = null;
        $nombre = $this->nombre;
        $apellidos = $this->apellidos;
        $email = $this->email;
        $password = $this->password;
        $rol = $this->rol;

        try {
            $insert = $this->db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, rol) VALUES (:nombre, :apellidos, :email, :password, :rol)");

            $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $insert->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
            $insert->bindValue(':email', $email, PDO::PARAM_STR);
            $insert->bindValue(':password', $password, PDO::PARAM_STR);
            $insert->bindValue(':rol', $rol, PDO::PARAM_STR);

            $insert->execute();

            $result = true;
        } catch (PDOException $e) {
            $result = false;
        }

        $insert->closeCursor();
        $this->desconecta();
        return $result;
    }

    public function login(): mixed
    {
        try {
            $datosUsuario = $this->getByEmail($this->getEmail());
            if ($datosUsuario && password_verify($this->getPassword(), $datosUsuario->password)) {
                return $datosUsuario;
            }
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
        }
        return false;
    }

    public function getByEmail(string $email): mixed
    {
        try {
            $select = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
            $select->bindValue(':email', $email, PDO::PARAM_STR);
            $select->execute();
            return $select->rowCount() === 1 ? $select->fetch(PDO::FETCH_OBJ) : false;
        } catch (PDOException $e) {
            error_log("Error al buscar usuario por email: " . $e->getMessage());
            return false;
        }
    }

    public function validarDatosRegistro(): array|bool
    {
        $this->nombre = filter_var($this->nombre, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->apellidos = filter_var($this->apellidos, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->password = filter_var($this->password, FILTER_SANITIZE_SPECIAL_CHARS);

        $errores = [];

        if (empty($this->nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $this->nombre)) {
            $errores[] = "Nombre no válido: Solo letras y espacios.";
        }

        if (empty($this->apellidos) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $this->apellidos)) {
            $errores[] = "Apellidos no válidos: Solo letras y espacios.";
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Email no válido.";
        } elseif ($this->getByEmail($this->email) !== false) {
            $errores[] = "El email ya está registrado.";
        }

        if (empty($this->password)) {
            $errores[] = "La contraseña es obligatoria.";
        }

        return empty($errores) ? true : $errores;
    }

    public function validarDatosLogin(): array|bool
    {
        $errores = [];

        // Ver el valor del correo antes de la validación
        error_log('Email antes de la validación: ' . $this->email);

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Email no válido.";
        } elseif ($this->getByEmail($this->email) === false) {
            $errores[] = "Este email no está registrado.";
        }

        // Sanitizar el correo solo si es válido
        if (empty($errores)) {
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        }

        // Ver el valor del correo después de la sanitización
        error_log('Email después de la sanitización: ' . $this->email);

        if (empty($this->password)) {
            $errores[] = "La contraseña es obligatoria.";
        }

        return empty($errores) ? true : $errores;
    }
}
