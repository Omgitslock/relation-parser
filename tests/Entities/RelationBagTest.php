<?php

namespace Omgitslock\RelationParser\Test\Entities;

use Omgitslock\RelationParser\Entities\Relation;
use Omgitslock\RelationParser\Entities\RelationBag;
use Omgitslock\RelationParser\Enums\RelationType;
use Omgitslock\RelationParser\Test\Fixtures\RelationModel;
use PHPUnit\Framework\TestCase;

class RelationBagTest extends TestCase
{
    /**
     * @var RelationBag
     */
    protected $bag;

    public function setUp()
    {
        $this->bag = new RelationBag(new RelationModel);
    }

    public function tearDown()
    {
        $this->bag = null;
    }

    public function testAddRelation()
    {
        $relation1 = new Relation('method1', new RelationType('HasMany'));
        $relation2 = new Relation('method2', new RelationType('HasMany'));

        $this->bag
            ->add($relation1)
            ->add($relation2);

        $relations = $this->bag->getRelations();

        $this->assertSame([$relation1, $relation2], $relations);
    }

    public function testGetRelationNamesList()
    {
        $relation1 = new Relation('method1', new RelationType('HasMany'));
        $relation2 = new Relation('method2', new RelationType('HasMany'));

        $this->assertEquals([], $this->bag->getRelationNameList());

        $this->bag
            ->add($relation1)
            ->add($relation2);


        $expectedNameList = [$relation1->getType(), $relation2->getType()];
        $nameList = $this->bag->getRelationNameList();

        $this->assertSame($expectedNameList, $nameList);

    }

    public function testEmptyChecking()
    {
        $this->assertTrue($this->bag->isEmpty());

        $this->bag->add(new Relation('method1', new RelationType('HasMany')));

        $this->assertFalse($this->bag->isEmpty());
    }

    public function testGetModel()
    {
        $this->assertEquals(new RelationModel, $this->bag->getModel());
    }
}