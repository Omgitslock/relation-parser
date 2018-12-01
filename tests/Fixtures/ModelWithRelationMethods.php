<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\RelationMethods;

class ModelWithRelationMethods extends Model
{
    use RelationMethods;
}