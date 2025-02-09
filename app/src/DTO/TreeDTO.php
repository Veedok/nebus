<?php

namespace App\DTO;

/** DTO для формирования списка организаций с ограниченной вложенностью */
final class TreeDTO
{
    /**
     * @param int $id Идентификатор вида деятельности
     * @param int|null $count Не обязательный параметр отвечающий ща то насколько глубоко по вложенности смотреть
     */
    public function __construct(
        public int $id,
        public ?int $count = null,
    )
    {
    }
}