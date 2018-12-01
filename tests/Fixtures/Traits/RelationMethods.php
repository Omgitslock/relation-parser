<?php

namespace Omgitslock\RelationParser\Test\Fixtures\Traits;

use Omgitslock\RelationParser\Test\Fixtures\RelationModel;

trait RelationMethods
{
    public function relationPublicMethod()
    {
        return $this->hasMany(RelationModel::class);
    }

    protected function relationProtectedMethod()
    {
        return $this->hasMany(RelationModel::class);
    }

    private function relationPrivateMethod()
    {
        return $this->hasMany(RelationModel::class);
    }

    public function relationPublicMethodWithDefaultArgs($test = 'We are ignoring u')
    {
        return $this->hasMany(RelationModel::class);
    }

    public function relationPublicMethodWithoutDefaultArgs($test)
    {
        return $this->hasMany(RelationModel::class);
    }

}