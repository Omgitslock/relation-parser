<?php

namespace Omgitslock\RelationParser\Contracts;


interface FilterInterface
{
    /**
     * Фильтруем переданные методы,
     * для того чтобы получать отношения только с тех методов, которые нас могут заинтересовать
     *
     * @param array $methods
     *
     * @return null|array
     */
    public function filter(array $methods) : ?array ;
}