<?php

namespace Omgitslock\RelationParser\Test;

use PHPUnit\Framework\TestCase;

use Omgitslock\RelationParser\Parser;
use Omgitslock\RelationParser\Entities\Relation;
use Omgitslock\RelationParser\Enums\RelationType;
use Omgitslock\RelationParser\Cache\RelationPool;
use Omgitslock\RelationParser\Entities\RelationBag;
use Omgitslock\RelationParser\Contracts\FilterInterface;
use Omgitslock\RelationParser\Contracts\DriverInterface;
use Omgitslock\RelationParser\Test\Fixtures\ModelWithoutMethods;
use Omgitslock\RelationParser\Test\Fixtures\ModelWithRelationMethods;



class ParserTest extends TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    private $relationPool;

    private $filterService;

    private $driver;

    public function setUp()
    {
        $this->relationPool = $this->createMock(RelationPool::class);

        $this->driver = $this->createMock(DriverInterface::class);

        $this->filterService = $this->createMock(FilterInterface::class);

        $this->parser = new Parser($this->relationPool, $this->driver, $this->filterService);
    }

    public function tearDown()
    {
        $this->parser = null;
    }

    public function testAlreadyExistentRelationBag()
    {
        $model = new ModelWithoutMethods;

        $bag = new RelationBag($model);

        $this->relationPool
            ->method('exist')
            ->willReturn(true);

        $this->relationPool
            ->method('get')
            ->willReturn($bag);

        //не имеет значения какую модель мы передаём здесь
        $this->assertEquals($bag, $this->parser->parse($model));

    }

    public function testFilterAllMethods()
    {
        $model = new ModelWithoutMethods;

        $bag = new RelationBag($model);

        $this->filterService
            ->method('filter')
            ->willReturn(null);

        //не имеет значения какую модель мы передаём здесь
        $this->assertEquals($bag, $this->parser->parse($model));
    }

    public function testFillRelationBag()
    {
        $model = new ModelWithRelationMethods;

        $bag = new RelationBag($model);

        $method = 'relationPublicMethod';

        $this->filterService
            ->method('filter')
            ->willReturn([$method]);

        $relation = new Relation($method, new RelationType('HasMany'));

        $this->driver
            ->method('getRelation')
            ->willReturn($relation);

        $bag->add($relation);

        $this->assertEquals($bag, $this->parser->parse($model));
    }


}