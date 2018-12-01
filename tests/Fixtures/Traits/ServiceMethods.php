<?php
namespace Omgitslock\RelationParser\Test\Fixtures\Traits;

trait ServiceMethods
{
    public function getFooAttribute()
{
    return 'this is accessor';
}

    public function setFooAttribute()
    {
        return 'this is mutator';
    }

    public function scopeFoo()
    {
        return 'this is a scope';
    }
}