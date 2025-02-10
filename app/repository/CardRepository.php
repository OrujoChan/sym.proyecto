<?php

namespace dwes\app\repository;

use dwes\app\database\QueryBuilder;

class CardRepository extends QueryBuilder
{
    /**
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table = 'cartas', string $classEntity = 'dwes\app\entity\Imagen')
    {
        parent::__construct($table, $classEntity);
    }
}
