<?php

namespace Omgitslock\RelationParser\Entities;

use Omgitslock\RelationParser\Enums\RelationType;

/**
 * Сущность, хранящая метаданные по "отношению"
 *
 * Class Relation
 *
 * @package RelationParser
 */
class Relation
{

    /**
     * Имя метода, которому соответствует переданное отношение
     *
     * @var string
     */
    protected $method;

    /**
     * Имя отношения
     *
     * @var RelationType
     */
    protected $type;


    public function __construct(string $method, RelationType $type)
    {
        $this->method = $method;

        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getType() : string
    {
        return $this->type;
    }

}