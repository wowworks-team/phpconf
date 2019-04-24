<?php
namespace app\controllers;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Console;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property bool $is_published
 */
class Post extends ActiveRecord
{

}

// https://www.yiiframework.com/doc/guide/2.0/en/structure-controllers
class PostController extends Controller
{

    /** @var PostService */
    protected $postService;

    public function __construct(
        $id,
        $module,
        PostService $postService,
        $config = []
    ) {
        $this->postService = $postService;

        parent::__construct($id, $module, $config);
    }

    public function actionView($id)
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Post;

        $model->is_published = false;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateConsole($title, $content)
    {
        $model = new Post;

        $model->title = $title;
        $model->content = $content;
        $model->is_published = false;
        if ($model->save()) {
            Console::output(sprintf('Post %d created', $model->id));
        } else {
            Console::error(sprintf('Post not created'));
        }
    }

    public function actionCreateService($title, $content)
    {
        $service = $this->getPostService();
        $model = new Post;

        $model->title = $title;
        $model->content = $content;
        if ($service->createPost($model)) {
            Console::output(sprintf('Post %d created', $model->id));
        } else {
            Console::error(sprintf('Post not created'));
        }
    }

    protected function getPostService(): PostService
    {
        return $this->postService;
    }
}

class PostService
{
    public function createPost(Post $model)
    {
        $model->is_published = false;

        return $model->save();
    }
}


class NotificationService
{
    public function send(string $text): bool
    {
        // send some notification
        return true;
    }
}

class PostService2
{
    /** @var NotificationService */
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function createPost(Post $model): bool
    {
        $model->is_published = false;
        $result = $model->save();
        if ($result) {
            $this->notificationService->send('New post created');
        }

        return $result;
    }
}

class VkService {}
class InstagramService {}
class StatisticsService {}

class PostService3
{
    /** @var NotificationService */
    private $notificationService;

    /** @var VkService */
    private $vkService;

    /** @var InstagramService */
    private $instagramService;

    /** @var StatisticsService */
    private $statisticsService;

    public function __construct(
        NotificationService $notificationService,
        VkService $vkService,
        InstagramService $instagramService,
        StatisticsService $statisticsService
    ) {
        $this->notificationService = $notificationService;
        $this->vkService = $vkService;
        $this->instagramService = $instagramService;
        $this->statisticsService = $statisticsService;
    }

    public function createPost(Post $model): bool
    {
        $model->is_published = false;
        $result = $model->save();
        if ($result) {
            $this->notificationService->send('New post created');
            // and new extra logic
        }

        return $result;
    }
}

/**
 * Class User
 *
 * @property int $id
 */
class User extends ActiveRecord
{

}

class PostRepository
{
    public function getPostsQuery(User $user): ActiveQuery
    {
        return Post::find()->where(['user_id' => $user->id]);
    }
}

$notificationService = new NotificationService(/* with some settings */);
$vkService = new VkService(/* with API key*/);
$instagramService = new InstagramService(/* with API key*/);
$statisticsService = new StatisticsService(/* with settings */);

new PostService3($notificationService, $vkService, $instagramService, $statisticsService);
