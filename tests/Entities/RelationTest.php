<?php

namespace Omgitslock\RelationParser\Test\Entities;

use PHPUnit\Framework\TestCase;
use Omgitslock\RelationParser\Enums\RelationType;
use Omgitslock\RelationParser\Entities\Relation;


class RelationTest extends TestCase
{

    public function testGetter()
    {
        $method = 'method';
        $relationName =  new RelationType('HasMany');

        $relation = new Relation($method,$relationName);

        $this->assertEquals($method, $relation->getMethod());
        $this->assertEquals($relationName, $relation->getType());
    }

}