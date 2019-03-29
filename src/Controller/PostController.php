<?php

namespace App\Controller;

use App\ActiveRecord\Post;
use App\Repository\PostRepository;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
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

    // hard example, use SPA and REST API instead ;) Logic move to service
    public function actionCreate()
    {
        $model = $this->getModel();

        if ($model->load($this->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    protected function getRepository(): PostRepository
    {
        /** @var PostRepository $service */
        $service = Yii::createObject(PostRepository::class);

        return $service;
    }

    protected function getModel(): Post
    {
        /** @var Post $object */
        $object = Yii::createObject(Post::class);

        return $object;
    }

    /**
     * @return \yii\console\Request|\yii\web\Request
     */
    protected function getRequest()
    {
        return Yii::$app->request;
    }
}
