<?php 
namespace app\components;
 
use Yii;
use app\components\Mycurl;
use app\models\Repository;
use app\models\Language;
use app\models\Script;
use app\models\Extension;
use app\models\MdFilter;

class RepositoryConnection { 
    protected $repositories = []; 

    public function dbSearch(){
        echo "Searching for repositories...\n";
        $this->repositories = Repository::find()->all();

        if(!empty($this->repositories))
            return true;
        else
            return false;
    }

    public function getFromAll(){
        foreach($this->repositories as $repository){
            echo "Requesting repository: ".$repository['label']."\n";
            $date = $repository['last_access'];
            echo "Last access: ".$date."\n";
            $date = str_replace(" ", "%20", $date);
            $curl = new Mycurl($repository['url']."/index.php/site/update?date=$date");
            $curl->createCurl();
            $json = $curl->__tostring();



            if($this->saveUpdatedScriptsInfo($json, $repository)){
                $repository['last_access'] = (new \DateTime())->format('Y-m-d H:i:s');
                $repository->save();
            }
        }
    }

    public function saveUpdatedScriptsInfo($json, $repository){

        $languages = json_decode($json);
        //var_dump($languages);die();

        if(!empty($languages)){
            $languages = $this->object_to_array($languages);
            echo "Inserting or updating language\n";
            foreach($languages as $key1 => $language){
                $scripts = $language['scripts'];
                $extensions = $language['extensions'];
                unset($language['scripts']);
                unset($language['extensions']);

                $languageRecord = Language::find()->where(['name' => $language['name']])->one();

                if($languageRecord == NULL){
                    $languageRecord = new Language();
                }

                $languageRecord->setAttributes($language);
                $languageRecord->save();

                if($languageRecord->id == NULL)
                    $languageId = Yii::$app->db->getLastInsertId();
                else
                    $languageId = $languageRecord->id;

                if(!empty($extensions)){
                    echo "Inserting or updating extensions\n";
                    foreach($extensions as $key3 => $extension){
                        $extensionsRecord = Extension::find()->where(['extension' => $extension['extension']])->one();

                        if($extensionsRecord == NULL){
                            $extensionsRecord = new Extension();
                        }

                        $extensionsRecord->setAttributes($extension);
                        $extensionsRecord->id_language = $languageId;
                        $extensionsRecord->save();
                    }
                }

                if(!empty($scripts)){
                    echo "Inserting or updating scripts\n";
                    foreach($scripts as $key2 => $script){
                        $scriptRecord = Script::find()->where(['code_identifier' => $script['code_identifier']])->one();

                        if($scriptRecord == NULL){
                            $scriptRecord = new Script();
                        }

                        $scriptRecord->setAttributes($script);
                        $scriptRecord->id_language = $languageId;
                        $scriptRecord->save();

                        if($scriptRecord->id == NULL)
                            $scriptId = Yii::$app->db->getLastInsertId();
                        else
                            $scriptId = $scriptRecord->id;


                        try{
                            \Yii::$app->db->createCommand()->insert('script_repository',['repository_id' => $repository['id'], 'script_id' => $scriptId])->execute();
                        }
                        catch(\Exception $e){
                            echo "Relation already inserted or an error has ocurred\n";
                        }

                        if(!empty($script['md_filters'])){
                            echo "Inserting or updating md_filters\n";
                            foreach ($script['md_filters'] as $key4 => $mdFilter) {
                                $mdfilterRecord = MdFilter::find()->where(['identifier' => $mdFilter['identifier']])->one();

                                if($mdfilterRecord == NULL){
                                    $mdfilterRecord = new MdFilter();
                                }

                                $mdfilterRecord->setAttributes($mdFilter);
                                $mdfilterRecord->id_script = $scriptId;
                                $mdfilterRecord->save();
                            }
                        }
                    }
                }

                unset($languages[$key1]['scripts']);
            }
        }

        return true;
    }

    private function myBatchInsert($table, $data){
        $headers = array_keys(array_values($data)[0]);
        $values = [];

        foreach($data as $item)
            $values[] = array_values($item);

        return Yii::$app->db->createCommand()->batchInsert($table, $headers, $values)->execute();  
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
} 
?> 