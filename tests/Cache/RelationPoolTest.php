<?php
namespace Omgitslock\RelationParser\Test\Cache;

use PHPUnit\Framework\TestCase;
use Omgitslock\RelationParser\Cache\RelationPool;
use Omgitslock\RelationParser\Entities\RelationBag;
use Omgitslock\RelationParser\Test\Fixtures\RelationModel;
use Omgitslock\RelationParser\Exceptions\InvalidArgumentException;

class RelationPoolTest extends TestCase
{

    /**
     * @dataProvider models
     */
    public function testAllFunctionality($model)
    {
        $pool = new RelationPool();
        $item = new RelationBag(new RelationModel);

        $this->assertTrue($pool->isEmpty());

        $pool->add($item);

        $this->assertFalse($pool->isEmpty());

        $this->assertTrue($pool->exist($model));

        $bagFromPool = $pool->get($model);

        $this->assertEquals($item, $bagFromPool);

        $pool->remove($model);

        $this->assertTrue($pool->isEmpty());
    }


    public function testAddIncorrectTypeOfModel()
    {
        $pool = new RelationPool();

        $incorrectTypeOfItem =  1;

        $this->expectException(InvalidArgumentException::class);

        $pool->get($incorrectTypeOfItem);
    }

    public function models()
    {
        return [
            [new RelationModel()],
            [RelationModel::class],
        ];
    }
}