<?php

namespace app\commands;

use yii\console\Controller;
use app\components\MDListLLDP;
use app\components\OSGi;
use app\models\Md;

class DaemonController extends Controller {

    public function actionIndex($json){
        $lldp = new MDListLLDP();

        $entries = $lldp->getRemEntries($json);

        $mdlist = Md::find()->all();
        
        foreach ($entries as $key1 => $entry) {
        	if(($md1 = Md::find()->where($entry)->one()) == NULL){
        		$md1 = new Md();
        		$entry['connect_time'] = (new \DateTime())->format('Y-m-d H:i:s');
        		$md1->setAttributes($entry);
        		if($md1->save())
        			echo "A new device was found in the network\n";

        	}
        	else
        		foreach($mdlist as $key2 => $md2)
        			if($md1->equals($md2))
        				unset($mdlist[$key2]);
        }

        foreach($mdlist as $md){
        	if($md->delete())
        		echo "Device left the network\n";
        }
    }

}
