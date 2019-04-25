<?php

namespace App\Tests\Controller\View;

use App\ActiveRecord\Post;
use App\Controller\View\PostController;
use App\Repository\PostRepository;
use Mockery;
use PHPUnit\Framework\TestCase;
use yii\web\NotFoundHttpException;

class PostControllerTest extends TestCase
{
    protected function tearDown()
    {
        Mockery::close(); // https://github.com/mockery/mockery#method-call-expectations-
    }

    /**
     * @covers \App\Controller\PostController::actionView
     */
    public function testActionViewNotFound()
    {
        /** @var Mockery\Mock|PostRepository $repository */
        $repository = Mockery::mock(PostRepository::class);
        $repository->shouldReceive('findOne');

        $object = new PostController(
            null,
            null,
            $repository
        );
        $this->expectException(NotFoundHttpException::class);
        $object->actionView(0);
    }

    /**
     * @covers \App\Controller\PostController::actionView
     */
    public function testActionView()
    {
        $object = Mockery::mock(PostController::class);

        /** @var Mockery\Mock|PostRepository $repository */
        $repository = Mockery::mock(PostRepository::class);
        $repository->shouldReceive('findOne')->andReturn(new Post());
        $object->shouldAllowMockingProtectedMethods();
        $object->shouldReceive('getRepository')->andReturn($repository);
        $object->makePartial();

        $object->shouldReceive('render')->once();
        $object->actionView(1);
        $this->expectNotToPerformAssertions();
    }
}
