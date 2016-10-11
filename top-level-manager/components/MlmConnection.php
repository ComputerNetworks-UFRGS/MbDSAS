<?php 
namespace app\components;
 
use Yii;
use app\components\Mycurl;
use app\models\Repository;
use app\models\Language;
use app\models\Script;
use app\models\Mlm;
use app\models\MdFilter;

class MlmConnection { 
    protected $mlms = [];
    protected $mds = [];
    protected $mdFilters = [];
    protected $mlm_mds = [];

    protected $owner;
    protected $community;
    protected $password;
    protected $solution;

    protected $activateBeginMbD = false;

    public function __construct($owner="mbdsas-manager", $community="adm", $password="secret", $solution="OSGi"){
        $this->owner = $owner;
        $this->community = $community;
        $this->password = $password;
        $this->solution = $solution;
    }

    public function dbSearch(){
        echo "Searching for MLMs...\n";
        $this->mlms = Mlm::find()->all();

        if(!empty($this->mlms)){
            echo count($this->mlms)." MLMs found\n";
            return true;
        }
        else{
            echo "No MLMs found\n";
            return false;
        }
    }

    public function getFromAll(){
        foreach($this->mlms as $mlm){
            //Begin MbD
            if($this->activateBeginMbD){
                $array = [
                        'owner' => $owner,
                        'community' => $community,
                        'password' => $password,
                        'solution' => $solution
                    ];
                $dataJson = json_encode($array);

                $curl = new Mycurl($mlm['url'].'/index.php/auth/beginmbd');
                $curl->setPost(['data' => $dataJson]);

                $curl->createCurl();
                $json = $curl->__tostring();
                $credentials = json_decode($json);
                //var_dump($credentials);die();
                if(!isset($credentials->sessionID)){
                    echo "Couldnt begin this mlm (".$mlm['url'].")\n";
                    break;
                }
                else{
                    \Yii::$app->session->open();
                    \Yii::$app->session['mbdsas-sessionid'] = $credentials->sessionID;
                }
            }

            $this->requestMds($mlm);
            $this->getMds();
            $this->mdsDiff();
            $this->getMdFilters();
 
            //Get MD Filters and try to match
            $filterCount = 0;
            foreach($this->mds as $md){
                foreach($this->mdFilters as $mdFilter){
                    $att = $mdFilter->attribute;
                    if($md->{$att} == $mdFilter->value){
                        $filterCount++;
                        $script = $mdFilter->getIdScript()->one();
                        $scriptMlm = $script->getMlms()->where(['url' => $mlm['url']])->one();

                        if($scriptMlm == NULL){
                            $repository = $script->getRepositories()->one();

                            $scriptName = $this->myUrlEncode($script['name']);

                            $data = ['url' => $repository['url']."/index.php/script/download?name=".$scriptName];
                            //$data['sessionID'] = \Yii::$app->session['mbdsas-sessionid'];

                            $curl = new Mycurl($mlm['url'].'/index.php/mbd/pullandrun');
                            $curl->setPost($data);
                            $curl->createCurl();
                            $content = $curl->__tostring();   

                            $return_json = json_decode($content);
                            if(isset($return_json->response)){
                                Yii::$app->db->createCommand()->insert('mlm_script',['mlm_id' => $mlm['id'], 'script_id' => $script['id']])->execute();
                                echo $md->sys_name." - Script pulled and run: ".$script['name']."\n";
                            }
                            else{
                                echo $md->sys_name." - Error: ".$return_json->error."\n";
                            }
                        }
                    }
                }
            }
            echo "Number of filters matched: ".$filterCount."\n";

        }
    }

    private function requestMds($mlm){
        echo "Requesting MLM: ".$mlm['label']."\n";
        $curl = new Mycurl($mlm['url'].'/index.php/mdlist/get');
        $curl->createCurl();
        $json = $curl->__tostring();
        $this->mlm_mds = json_decode($json);
    }

    private function getMds(){
        echo "Searching for MDs...\n";
        $this->mds = Md::find()->all();

        if(!empty($this->mds))
            return true;
        else
            return false;
    }

    private function mdsDiff(){
        $mds = [];

        foreach($this->mds as $md){
            unset($md['id']);
        }

        foreach($this->mlm_mds as $mlm_md){
            foreach($this->mds as $md){

            }
        }
    }

    private function getMdFilters(){
        echo "Searching for MD Filters...\n";
        $this->mdFilters = MdFilter::find()->all();

        if(!empty($this->mdFilters))
            return true;
        else
            return false;
    }

    private function object_to_array($data){
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = $this->object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

    private function myUrlEncode($string) {
        $entities = array('%25', '%20','%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F','%23', '%5B', '%5D');
        $replacements = array("%", ' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]");

        return str_replace($replacements, $entities, $string);
    }
} 
?> 