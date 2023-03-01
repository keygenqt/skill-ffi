<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use FFIMe;

class GenController extends Controller
{
    public function actionIndex(): int
    {
        $path = Yii::getAlias('@app');

        (new FFIMe\FFIMe("$path/../c_lib/build/libc_library.so"))
            ->include("$path/../c_lib/library.h")
            ->codeGen('app\\commands\\GenFII', 'commands/GenFII.php');

        return ExitCode::OK;
    }
}
