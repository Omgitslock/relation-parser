<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\{CommonMethods, RelationMethods};

class ModelWithCommonRelationMethods extends Model
{
    use CommonMethods;
    use RelationMethods;
}