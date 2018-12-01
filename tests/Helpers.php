<?php
namespace Omgitslock\RelationParser\Test;

use SplFileObject;

use Illuminate\Database\Capsule\Manager as Capsule;

trait Helpers
{

    /**
     * @var Capsule
     */
    protected $capsule;

    /**
     * Сравниваем 2 SplFileObject
     *
     * На текущий момент Phpunit не предоставляет из коробки корректное сравнение SplFileObject
     * (возможно я просто не понимаю как правильно сравнивать)
     * поэтому пока просто сверяем пути
     *
     * @todo написать issue
     *
     * @param SplFileObject $expected
     * @param SplFileObject $actual
     *
     * @return mixed
     */
    public function assertSplFilesEquals(SplFileObject $expected, SplFileObject $actual)
    {
        $expectedPath = $expected->getRealPath();
        $actualPath = $actual->getRealPath();

        return $this->assertEquals($expectedPath, $actualPath);
    }

    /**
     * При вызове relation, eloquent запусает QueryBuilder
     * который начинает строить запрос, для этого необходимо в eloquent model
     * явно задать connectionResolver, например с помощью Model::setConnectionResolver($resolver)
     * И проще всего это сделать через Capsule, для упрощения можно считать его ConnectionManager(это не совсем так)
     *
     * @return $this
     */
    protected function createConnection()
    {
        $this->capsule = new Capsule;

        $this->capsule->addConnection([
            'driver'   => 'sqlite',
            'database' => '',
        ]);

        $this->capsule->bootEloquent();

        return $this;
    }
}