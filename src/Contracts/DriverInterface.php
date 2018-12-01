<?php

namespace Omgitslock\RelationParser\Contracts;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Entities\Relation;

/**
 * Interface DriverInterface
 *
 * @package RelationParser\Drivers
 */
interface DriverInterface
{
    /**
     * Получение метадаты по отношению для переданной модели
     * Упаковываем эти данные в класс Relation
     *
     * @param Model $model
     * @param string $method
     *
     * @return null|Relation
     */
    public function getRelation(Model $model, string $method): ?Relation;

}