<?php
/**
 * Created by PhpStorm.
 * User: bdim
 * Date: 15.03.2018
 * Time: 12:18
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // добавляем разрешение "deletePost"
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete post';
        $auth->add($deletePost);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $deletePost);
        $auth->addChild($admin, $author);

        $auth->assign($admin, 1);




// add the rule
        $rule = new \common\components\rbac\AuthorRule;
        $auth->add($rule);

// добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

// "updateOwnPost" будет использоваться из "updatePost"
        $updatePost = $auth->getPermission('updatePost');
        $auth->addChild($updateOwnPost, $updatePost);

// разрешаем "автору" обновлять его посты
        $author = $auth->getRole('author');
        $auth->addChild($author, $updateOwnPost);
    }
}