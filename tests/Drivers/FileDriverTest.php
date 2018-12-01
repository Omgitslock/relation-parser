<?php
namespace Omgitslock\RelationParser\Test\Drivers;

use Omgitslock\RelationParser\Cache\FilePool;
use Omgitslock\RelationParser\Entities\Relation;
use Omgitslock\RelationParser\Enums\RelationType;
use Omgitslock\RelationParser\Drivers\FileDriver;
use Omgitslock\RelationParser\Test\Fixtures\ModelWithServiceCommonRelationMethods;

class FileDriverTest extends AbstractDriverTest
{
    /**
     * @var FileDriver
     */
    protected $driver;

    public function setUp()
    {
        $this->driver = new FileDriver(new FilePool());
    }

    /**
     * Мы можем получить relation у метода, который принимает параметры
     * (стоит выпилить эту возможность)
     */
    public function testGetRelationFromMethodWithoutDefaultArgs()
    {
        $relation = $this->driver->getRelation(new ModelWithServiceCommonRelationMethods, 'relationPublicMethodWithoutDefaultArgs');

        $expectedRelation = new Relation('relationPublicMethodWithoutDefaultArgs', new RelationType('HasMany'));

        $this->assertEquals($expectedRelation, $relation);
    }

}