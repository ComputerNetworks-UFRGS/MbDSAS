<?php
/**
 * Description of Docker_driver
 *
 * @author Henrique Resende
 * @description The HTTPD server needs to be in the same group of Docker, so the command "docker" can be used
 */
namespace app\components;
 
use Yii;
use app\components\ISolution;

class Docker implements ISolution{

    public function pull($source){
        exec("docker pull $source", $output, $return_var);
    };

    public function run($id, $args){
        return exec("docker run -d $id $args", $output, $return_var);
    };

    public function pullAndRun($source, $args){
        return $this->run($source, $args);
    };

    public function remove($id){
        return exec("docker stop $id", $output, $return_var);
    };

    public function getResults();
}