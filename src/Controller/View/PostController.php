<?php

namespace App\Controller\View;

use App\Repository\PostRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    /** @var PostRepository */
    protected $postRepository;

    // https://www.yiiframework.com/doc/guide/2.0/en/concept-di-container
    public function __construct(
        $id,
        $module,
        PostRepository $postRepository,
        $config = []
    ) {
        $this->postRepository = $postRepository;

        parent::__construct($id, $module, $config);
    }

    public function actionView($id)
    {
        $model = $this->getRepository()->findOne((int) $id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function getRepository(): PostRepository
    {
        return $this->postRepository;
    }
}
