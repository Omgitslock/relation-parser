<?php
namespace Omgitslock\RelationParser\Services;

use Omgitslock\RelationParser\Test\Fixtures\{
    Traits\CommonMethods,
    Traits\RelationMethods,

    ModelWithoutMethods,

    ModelWithCommonMethods,
    ModelWithServiceMethods,
    ModelWithRelationMethods,

    ModelWithServiceCommonMethods,
    ModelWithCommonRelationMethods,
    ModelWithServiceRelationMethods,

    ModelWithServiceCommonRelationMethods
};
use PHPUnit\Framework\TestCase;

class EloquentMethodFilterServiceTest extends TestCase
{
    /**
     * @var EloquentMethodFilterService
     */
    protected $filterService;

    protected $commonMethod = 'commonMethod';

    public function setUp()
    {
        $this->filterService = new EloquentMethodFilterService();
    }

    public function tearDown()
    {
        $this->filterService = null;
    }

    public function testIsAccessor()
    {
        $accessor = 'getFooAttribute';

        $result = $this->filterService->isAccessor($accessor);

        $this->assertTrue($result);

        $result = $this->filterService->isAccessor($this->commonMethod);

        $this->assertFalse($result);

        return $accessor;
    }

    public function testIsMutator()
    {
        $mutator = 'setFooAttribute';

        $result = $this->filterService->isMutator($mutator);

        $this->assertTrue($result);

        $result = $this->filterService->isMutator($this->commonMethod);

        $this->assertFalse($result);

        return $mutator;
    }

    public function testIsScope()
    {
        $scope = 'scopeFoo';

        $result = $this->filterService->isScope($scope);

        $this->assertTrue($result);

        $result = $this->filterService->isScope($this->commonMethod);

        $this->assertFalse($result);

        return $scope;
    }

    /**
     * @depends testIsAccessor
     * @depends testIsMutator
     * @depends testIsScope
     */
    public function testIsServiceMethod($accessor, $mutator, $scope)
    {
        $result = $this->filterService->isServiceMethod($accessor);

        $this->assertTrue($result);

        $result = $this->filterService->isServiceMethod($mutator);

        $this->assertTrue($result);

        $result = $this->filterService->isServiceMethod($scope);

        $this->assertTrue($result);

        $result = $this->filterService->isServiceMethod($this->commonMethod);

        $this->assertFalse($result);
    }

    /**
     * @dataProvider modelProvider
     */
    public function testFilter($model, $expected)
    {
        $methods = get_class_methods($model);

        $result = $this->filterService->filter($methods);

        $this->assertEquals(sort($expected), sort($result));
    }

    public function modelProvider()
    {
        $relationMethods = get_class_methods(RelationMethods::class);
        $commonMethods = get_class_methods(CommonMethods::class);

        return [
            [
                ModelWithoutMethods::class,
                []
            ],
            [
                ModelWithServiceMethods::class,
                []
            ],
            [
                ModelWithRelationMethods::class,
                $relationMethods
            ],
            [
                ModelWithCommonMethods::class,
                $commonMethods
            ],
            [
                ModelWithServiceRelationMethods::class,
                $relationMethods
            ],
            [
                ModelWithServiceCommonMethods::class,
                $commonMethods
            ],
            [
                ModelWithCommonRelationMethods::class,
                array_merge($relationMethods, $commonMethods)
            ],
            [
                ModelWithServiceCommonRelationMethods::class,
                array_merge($relationMethods, $commonMethods)
            ],
        ];
    }

    public function testSetParentModel()
    {
        $parentModel = new ModelWithoutMethods;

        $this->filterService->setParentModel($parentModel);

        $this->assertSame(get_class($parentModel),  $this->filterService->getParentModel());
    }

}