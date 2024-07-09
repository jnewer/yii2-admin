<?php

namespace api\modules\v1\controllers;

use common\models\User;
use api\modules\v1\components\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = User::class;
}
