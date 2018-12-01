<?php

namespace Omgitslock\RelationParser\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Класс содержит в себе метаданные по отношениям
 * (типизация для массива)
 *
 * @package Omgitslock\RelationParser
 */
class RelationBag
{

    /**
     * Список объектов "отношений"
     *
     * @var Relation[]
     */
    protected $relations = [];

    /**
     * Имя модели для которой получили отношения
     *
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * Добавляет отношение в список
     *
     * @param Relation $relation
     * @return RelationBag
     */
    public function add(Relation $relation) : RelationBag
    {
        $this->relations[] = $relation;

        return $this;
    }

    /**
     * @return Relation[]
     */
    public function getRelations() : array
    {
        return $this->relations;
    }

    /**
     * Возвращает список названий всех отношений
     *
     * @return array
     */
    public function getRelationNameList() : array
    {
        $list = [];

        if($this->isEmpty()){
            return [];
        }

        foreach($this->relations as $relation){
            $list[] = $relation->getType();
        }

        return $list;
    }

    /**
     * Заполнен ли массив relations
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return $this->relations === [];
    }

    /**
     * @return string
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}