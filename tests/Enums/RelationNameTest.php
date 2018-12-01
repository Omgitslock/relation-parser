<?php
namespace Omgitslock\RelationParser\Test\Enums;

use Omgitslock\RelationParser\Enums\RelationType;
use PHPUnit\Framework\TestCase;

class RelationNameTest extends TestCase
{

    public function testGetValuesString()
    {
        $expectedString = 'HasMany, HasManyThrough, BelongsToMany, HasOne, BelongsTo, MorphOne, MorphTo, MorphMany, MorphToMany, MorphedByMany';

        $string = RelationType::getValuesString();

        $this->assertSame($expectedString, $string);
    }

}