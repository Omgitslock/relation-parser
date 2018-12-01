<?php

namespace Omgitslock\RelationParser\Test\Fixtures\Traits;

trait CommonMethods
{
    public function commonPublicMethod()
    {
        return 'I am public';
    }

    protected function commonProtectedMethod()
    {
        return 'I am protected';
    }

    private function commonPrivateMethod()
    {
        return 'I am private';
    }
}