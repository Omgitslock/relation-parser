<?php
namespace Omgitslock\RelationParser\Test\Cache;

use SplFileObject;
use PHPUnit\Framework\TestCase;

use Omgitslock\RelationParser\Test\Helpers;
use Omgitslock\RelationParser\Cache\FilePool;

class FilePoolTest extends TestCase
{
    use Helpers;

    public function testAllFunctionality()
    {
        $pool = new FilePool();
        $fileName = __DIR__ . '/../Fixtures/ModelWithCommonMethods.php';
        $item = new SplFileObject($fileName);

        $this->assertTrue($pool->isEmpty());

        $pool->add($item);

        $this->assertFalse($pool->isEmpty());

        $this->assertTrue($pool->exist($fileName));

        $fileFromPool = $pool->get($fileName);

        $this->assertSplFilesEquals($item, $fileFromPool);

        $pool->remove($fileName);

        $this->assertTrue($pool->isEmpty());
    }

    public function testUnexistentFileName()
    {
        $pool = new FilePool();

        $result = $pool->getOrCreate('unexistentFile');

        $this->assertNull($result);
    }
}

