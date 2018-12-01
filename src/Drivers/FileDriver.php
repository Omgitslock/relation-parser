<?php

namespace Omgitslock\RelationParser\Drivers;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Cache\FilePool;
use Omgitslock\RelationParser\Entities\Relation;
use Omgitslock\RelationParser\Enums\RelationType;
use Omgitslock\RelationParser\Contracts\DriverInterface;

/**
 * Class FileDriver
 *
 * @package RelationParser\Drivers
 */
class FileDriver implements DriverInterface
{

    /**
     * Пул файлов
     * доступ по имени класса
     *
     * @var FilePool
     */
    protected $filePool;

    public function __construct(FilePool $filePool)
    {
        $this->filePool = $filePool;
    }

    /**
     * Методы с помощью, которых мы описываем отношения
     *
     * @var array
     */
    protected $relationMethods = [
        'hasMany',
        'hasManyThrough',
        'belongsToMany',
        'hasOne',
        'belongsTo',
        'morphOne',
        'morphTo',
        'morphMany',
        'morphToMany',
        'morphedByMany'
    ];


    /**
     * {@inheritDoc}
     */
    public function getRelation(Model $model, string $method) : ?Relation
    {
        $code = $this->getMethodCode($model, $method);

        if(!$code){
            return null;
        }

        $relationMethod = $this->detectRelationMethod($code);

        if(!$relationMethod){
            return null;
        }

        $relationName = $this->getRelationName($relationMethod);

        return new Relation($method, $relationName);
    }

    /**
     * Получить исходный код для метода
     *
     * @param Model $model
     * @param string $method
     *
     * @return string
     */
    protected function getMethodCode(Model $model, string $method) : ?string
    {
        //todo выпилить reflection
        try {
            $reflectionMethod = new \ReflectionMethod($model, $method);
        }catch(\ReflectionException $reflectionException){
            return null;
        }

        if(!$reflectionMethod->isPublic()){
            return null;
        }

        $file = $this->filePool->getOrCreate($reflectionMethod->getFileName());

        $file->seek($reflectionMethod->getStartLine() - 1);
        $code = '';
        while ($file->key() < $reflectionMethod->getEndLine()) {
            $code .= $file->current();
            $file->next();
        }

        $code = trim(preg_replace('/\s\s+/', '', $code));

        return $code;
    }

    /**
     * Определяем, вид relation(BelongsTo, BelongsToMany etc.),
     * который был описан в методе
     *
     * @param string $code
     *
     * @return mixed|null
     */
    protected function detectRelationMethod(string $code) : ?string
    {
        foreach ($this->relationMethods as $relationMethod) {
            $search = '$this->' . $relationMethod . '(';
            $pos = stripos($code, $search);

            if($pos !== false) {
                return $relationMethod;
            }
        }

        return null;
    }

    /**
     * Получаем имя отношения по названию метода
     *
     * @param string $relationMethod
     *
     * @return RelationType
     */
    protected function getRelationName(string $relationMethod) : RelationType
    {
        $relationName =  ucfirst($relationMethod);

        return new RelationType($relationName);
    }
}