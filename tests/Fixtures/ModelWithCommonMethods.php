<?php
namespace Omgitslock\RelationParser\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Test\Fixtures\Traits\CommonMethods;

class ModelWithCommonMethods extends Model
{
    use CommonMethods;
}