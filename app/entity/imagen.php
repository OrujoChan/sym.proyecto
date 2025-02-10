<?php

namespace dwes\app\entity;

use dwes\app\entity\IEntity;

class imagen implements IEntity
{


    private $id;
    private $nombre;
    private $descripcion;
    private $categoria;
    private $precio;
    private $imagen;
    private $fecha_adicion;

    public function __construct(string $nombre = "", string $descripcion = "", string $categoria = "", int $precio = 0, string $imagen = "", $fecha_adicion = "")
    {
        $this->id = null;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->imagen = $imagen;
        $this->fecha_adicion = $fecha_adicion;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): imagen
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): Imagen
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): Imagen
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getPrecio(): int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): Imagen
    {
        $this->precio = $precio;
        return $this;
    }

    public function setImagen(string $imagen): Imagen
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getFechaAdicion(): String
    {
        return $this->fecha_adicion;
    }

    public function __toString()
    {
        return $this->descripcion;
    }

    const RUTA_IMAGENES_CARTAS = 'public/img/cartas/';

    public  function getUrlCartas()
    {
        return self::RUTA_IMAGENES_CARTAS;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'categoria' => $this->getCategoria(),
            'precio' => $this->getPrecio(),
            'imagen' => $this->getImagen(),
            'fecha_adicion' => $this->getFechaAdicion(),
        ];
    }
}
