<?php

namespace dwes\app\entity;


class Usuario implements IEntity
{
    private $id;
    private $username;
    private $password;
    private $role;
    private $imagen;

    const RUTA_IMAGENES_PERFIL = '/public/img/img_perfil/';

    public function __construct($username = "", $password = "", $role = "", $imagen = "")
    {
        $this->id = null;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->imagen = $imagen;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getUrlPerfil()
    {
        return self::RUTA_IMAGENES_PERFIL . $this->getImagen();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'role' => $this->role,
            'imagen' => $this->imagen,
        ];
    }
}
