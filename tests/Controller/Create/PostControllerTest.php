<?php

namespace App\Tests\Controller\Create;

use App\ActiveRecord\Post;
use App\Controller\Create\PostController;
use Mockery;
use PHPUnit\Framework\TestCase;
use yii\web\Request;

class PostControllerTest extends TestCase
{
    /** @var Mockery\Mock|PostController */
    private $object;

    protected function setUp()
    {
        parent::setUp();

        $this->object = Mockery::mock(PostController::class);
    }

    protected function tearDown()
    {
        Mockery::close(); // https://github.com/mockery/mockery#method-call-expectations-
    }

    /**
     * @covers \App\Controller\PostController::actionCreate
     */
    public function testActionCreateEmpty()
    {
        /** @var Mockery\Mock|Request $request */
        $request = Mockery::mock(Request::class)->makePartial();
        /** @var Mockery\Mock|Post $model */
        $model = Mockery::mock(Post::class)->makePartial();
        $this->object->shouldAllowMockingProtectedMethods();
        $this->object->shouldReceive('getRequest')->andReturn($request);
        $this->object->shouldReceive('getModel')->andReturn($model);
        $this->object->makePartial();

        $this->object->shouldReceive('render')->once();
        $this->object->actionCreate();
        $this->expectNotToPerformAssertions();
    }

    /**
     * @covers \App\Controller\PostController::actionCreate
     */
    public function testActionCreateRedirect()
    {
        /** @var Mockery\Mock|Request $request */
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('post')->andReturn([]);
        /** @var Mockery\Mock|Post $model */
        $model = Mockery::mock(Post::class);
        $model->shouldReceive('attributes')->andReturn(['id', 'text']);
        $model->shouldReceive('load')->andReturn(true);
        $model->shouldReceive('save')->andReturn(true);
        $model->makePartial();
        $this->object->shouldAllowMockingProtectedMethods();
        $this->object->shouldReceive('getRequest')->andReturn($request);
        $this->object->shouldReceive('getModel')->andReturn($model);
        $this->object->makePartial();

        $this->object->shouldReceive('render')->never();
        $this->object->shouldReceive('redirect')->once();
        $this->object->actionCreate();
        $this->expectNotToPerformAssertions();
    }
}
