<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Mlm;
use app\models\Repository;
use app\components\Mycurl;
use app\components\RepositoryConnection;
use app\components\MlmConnection;

class DaemonController extends Controller
{
    public function actionIndex($owner="mbdsas-manager", $community="adm", $password="secret", $solution="OSGi")
    {
    	echo "----------------------- Daemon Controller ----------------------\n";
        $repoConnection = new RepositoryConnection();
        $mlmConnection = new MlmConnection();

        $repoConnection->dbSearch();
        $repoConnection->getFromAll();

        $mlmConnection->dbSearch();
        $mlmConnection->getFromAll();
        
    }

}
