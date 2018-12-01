<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\{CommonMethods, RelationMethods, ServiceMethods};

class ModelWithServiceCommonRelationMethods extends Model
{
    use CommonMethods;
    use ServiceMethods;
    use RelationMethods;
}