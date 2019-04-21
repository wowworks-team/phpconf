<?php

namespace App\Controller;

use App\ActiveRecord\Post;
use App\Repository\PostRepository;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    /** @var Post */
    protected $post;

    /** @var PostRepository */
    protected $postRepository;

    // https://www.yiiframework.com/doc/guide/2.0/en/concept-di-container
    public function __construct(
        $id,
        $module,
        Post $post,
        PostRepository $postRepository,
        $config = []
    ) {
        $this->post = $post;
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
        return $this->postRepository;
    }

    protected function getModel(): Post
    {
        return $this->post;
    }

    /**
     * @return \yii\console\Request|\yii\web\Request
     */
    protected function getRequest()
    {
        return Yii::$app->request;
    }
}
