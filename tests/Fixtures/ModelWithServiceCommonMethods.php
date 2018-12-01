<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\{CommonMethods, ServiceMethods};

class ModelWithServiceCommonMethods extends Model
{
    use ServiceMethods;
    use CommonMethods;
}