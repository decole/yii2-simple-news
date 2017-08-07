<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

//        // добавляем разрешение "createPost"
//        $createPost = $auth->createPermission('createPost');
//        $createPost->description = 'Create a post';
//        $auth->add($createPost);
//
//        // добавляем разрешение "updatePost"
//        $updatePost = $auth->createPermission('updatePost');
//        $updatePost->description = 'Update post';
//        $auth->add($updatePost);

        $guest = $auth->createRole('guest');
        $auth->add($guest);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $guest);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($manager, 2);
        $auth->assign($admin, 1);
        $auth->assign($user, 3);
    }
}