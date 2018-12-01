<?php

namespace Omgitslock\RelationParser\Cache;

use Illuminate\Database\Eloquent\Model;

use Omgitslock\RelationParser\Entities\RelationBag;
use Omgitslock\RelationParser\Exceptions\InvalidArgumentException;

/**
 * Реeстр хранит ключ -> значение,
 * где ключ - это всегда строка, значение - экземпляр RelationBag
 * Может принимать как строку так и экземпляр Eloquent Model
 *
 * Class RelationPool
 */
class RelationPool
{

    /**
     * Контейнер для наших связей модели
     * и её "отношений"
     *
     * @var array
     */
    protected static $relationBags = [];

    /**
     * @param RelationBag $relationBag
     *
     * @return RelationPool
     */
    public function add(RelationBag $relationBag) : self
    {
        $modelName = get_class($relationBag->getModel());

        self::$relationBags[$modelName] = $relationBag;

        return $this;
    }

    /**
     * @param $modelName
     *
     * @return $this
     */
    public function remove($model) : self
    {
        $modelName = $this->castToString($model);

        unset(self::$relationBags[$modelName]);

        return $this;
    }

    /**
     * @param $modelName
     *
     * @return bool
     */
    public function exist($model) : bool
    {
        $modelName = $this->castToString($model);

        return isset(self::$relationBags[$modelName]);
    }

    /**
     * @param $modelName
     *
     * @return RelationBag|null
     */
    public function get($model) : ?RelationBag
    {
        $modelName = $this->castToString($model);

        return self::$relationBags[$modelName] ?? null;
    }

    /**
     * Приводим переданный ключ к строке
     *
     * @param $model
     * @return string
     */
    protected function castToString($model)
    {
        if ($model instanceof Model) {
            return get_class($model);
        }

        if (is_string($model)){
            return $model;
        }

        throw new InvalidArgumentException('Передан неверный ключ');
    }

    /**
     * Проверяем пулл на пустоту
     *
     * @return bool
     */
    public function isEmpty()
    {
        if(self::$relationBags){
            return false;
        }

        return true;
    }
}