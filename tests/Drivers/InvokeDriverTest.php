<?php
namespace Omgitslock\RelationParser\Test\Drivers;

use Omgitslock\RelationParser\Test\Helpers;
use Omgitslock\RelationParser\Drivers\InvokeDriver;
use Omgitslock\RelationParser\Test\Fixtures\ModelWithServiceCommonRelationMethods;

class InvokeDriverTest extends AbstractDriverTest
{
    use Helpers;

    /**
     * @var InvokeDriver
     */
    protected $driver;


    public function setUp()
    {
        $this->driver = new InvokeDriver();
        $this->createConnection();
    }

    /**
     * Мы не можем сделать invoke метода, который принимает какие-либо аргументы
     */
    public function testGetRelationFromMethodWithoutDefaultArgs()
    {
        $relation = $this->driver->getRelation(new ModelWithServiceCommonRelationMethods(), 'publicMethodWithRelationAndWithoutDefaultArgs');

        $this->assertNull($relation);
    }

}