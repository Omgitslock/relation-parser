<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\ServiceMethods;

class ModelWithServiceMethods extends Model
{
    use ServiceMethods;
}