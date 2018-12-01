<?php
namespace Omgitslock\RelationParser;


use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Cache\RelationPool;
use Omgitslock\RelationParser\Contracts\FilterInterface;
use Omgitslock\RelationParser\Entities\RelationBag;
use Omgitslock\RelationParser\Contracts\DriverInterface;


class Parser
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var FilterInterface
     */
    protected $filterService;

    /**
     * @var RelationPool
     */
    protected $pool;


    public function __construct(RelationPool $pool, DriverInterface $driver, FilterInterface $filterService)
    {
        $this->pool = $pool;

        $this->driver = $driver;

        $this->filterService = $filterService;
    }

    /**
     *
     *
     * @param Model $model
     *
     * @return RelationBag
     */
    public function parse(Model $model) : ?RelationBag
    {
        if($this->pool->exist($model)){;
            return $this->pool->get($model);

        }

        $relationBag = $this->fillRelationBag($model);

        return $relationBag;
    }


    /**
     * @param Model $model
     * @return RelationBag
     */
    protected function fillRelationBag(Model $model) : ?RelationBag
    {
        $relationBag = new RelationBag($model);

        $methods = get_class_methods($model);

        $methods = $this->filterService->filter($methods);

        if(!$methods){
            return $relationBag;
        }

        foreach ($methods as $method) {
            $relation = $this->driver->getRelation($model, $method);

            if(!$relation) continue;

            $relationBag->add($relation);
        }

        return $relationBag;
    }

}