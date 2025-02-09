<?php

namespace App\DTO;

/** DTO Идентификатора любой сущности */
final class IdDTO
{
    /**
     * Конструктор DTO
     * @param int $id Идентификатор
     */
    public function __construct(
        public int $id,
    )
    {

    }
}