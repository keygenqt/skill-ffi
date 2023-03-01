<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class RunController extends Controller
{
    public function actionIndex(): int
    {
        $lib = new GenFII();

        echo "| Run c methods
| -----------------------------------------------------
| getRandom(0, 9): {$lib->getRandom(0, 9)}
| generateUUID():  {$lib->generateUUID()->toString()}
| -----------------------------------------------------
";

        return ExitCode::OK;
    }
}
