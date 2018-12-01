<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\{RelationMethods, ServiceMethods};

class ModelWithServiceRelationMethods extends Model
{
    use ServiceMethods;
    use RelationMethods;
}