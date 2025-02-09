<?php

namespace App\DTO;

class CoordinatesDTO
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    )
    {

    }
}