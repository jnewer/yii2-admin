<?php

namespace api\modules\v1\controllers;

use common\models\User;
use api\controllers\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = User::class;
}
