<?php
namespace Omgitslock\RelationParser\Drivers;


use Omgitslock\RelationParser\Enums\RelationType;
use ReflectionMethod;
use ReflectionException;
use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Entities\Relation;
use Omgitslock\RelationParser\Contracts\DriverInterface;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;

/**
 * Class InvokeDriver
 *
 * @package Omgitslock\RelationParser\Drivers
 */
class InvokeDriver implements DriverInterface
{

    /**
     * {@inheritDoc}
     */
    public function getRelation(Model $model, string $method) : ?Relation
    {
        try {
            $relation = $this->invokeRelation($model, $method);

            if(!$relation || !($relation instanceof EloquentRelation) ){
                return null;
            }
            $relationName = class_basename($relation);

            $relationName = new RelationType($relationName);
        }
        catch(ReflectionException $e) {
            return null;
        }


        return new Relation($method, $relationName);
    }

    /**
     * Вызываем relation по имени метода
     *
     * @param Model $model
     * @param string $method
     *
     * @return mixed|void
     * @throws ReflectionException
     */
    protected function invokeRelation(Model $model, string $method)
    {
        $reflectionMethod = new ReflectionMethod($model, $method);

        if(!$reflectionMethod->isPublic()){
            return null;
        }

        $params = $reflectionMethod->getParameters();

        if(!empty($params)){
            return $this->tryInvokeWithDefaultArgs($model, $reflectionMethod, $params);
        }

        return $reflectionMethod->invoke($model);
    }

    //todo naming
    //todo подумать нужно ли это вообще делать ?

    /**
     * Пытаемся вызвать метод, передав в него дефолтные параметры
     * если дефолтных нет не вызываем
     *
     * @param Model $model
     * @param ReflectionMethod $reflectionMethod
     * @param $params
     *
     * @return mixed|null
     */
    protected function tryInvokeWithDefaultArgs(Model $model, ReflectionMethod $reflectionMethod, array $params)
    {
        $defaultParams =[];

        foreach($params as $param){
            //если параметры метода не имеют дефолтных значений,
            //мы не сможем вызвать метод и поэтому возвращаем null
            if(!$param->isOptional()){
                return null;
            }

            if($param){
                $defaultParams[] = $param->getDefaultValue();
            }

        }

        $relation = $reflectionMethod->invokeArgs($model, $defaultParams);

        return $relation;
    }


}