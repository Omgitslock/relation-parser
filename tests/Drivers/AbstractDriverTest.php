<?php
namespace Omgitslock\RelationParser\Test\Drivers;


use PHPUnit\Framework\TestCase;
use Omgitslock\RelationParser\Entities\Relation;
use Omgitslock\RelationParser\Enums\RelationType;
use Omgitslock\RelationParser\Contracts\DriverInterface;
use Omgitslock\RelationParser\Test\Fixtures\ModelWithServiceCommonRelationMethods;

abstract class AbstractDriverTest extends TestCase
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @dataProvider modelAndMethodProvider
     */
    public function testGetRelation($model, $method, $expectedRelation)
    {
        $relation = $this->driver->getRelation($model, $method);

        $this->assertEquals($expectedRelation, $relation);
    }


    public function modelAndMethodProvider()
    {
        return [
            [
                new ModelWithServiceCommonRelationMethods,
                'nonexistentMethod',
                null
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'commonPublicMethod',
                null
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'commonProtectedMethod',
                null
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'commonPrivateMethod',
                null
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'relationProtectedMethod',
                null
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'relationPrivateMethod',
                null
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'relationPublicMethod',
                new Relation('relationPublicMethod', new RelationType('HasMany'))
            ],
            [
                new ModelWithServiceCommonRelationMethods,
                'relationPublicMethodWithDefaultArgs',
                new Relation('relationPublicMethodWithDefaultArgs', new RelationType('HasMany'))
            ],
        ];
    }
}