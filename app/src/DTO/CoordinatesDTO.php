<?php

namespace App\DTO;

/** DTO очки на карте (координаты) */
readonly class CoordinatesDTO
{
    /**
     * Конструктор DTO
     * @param float $latitude Широта
     * @param float $longitude Долгота
     */
    public function __construct(
        public float $latitude,
        public float $longitude,
    )
    {

    }
}