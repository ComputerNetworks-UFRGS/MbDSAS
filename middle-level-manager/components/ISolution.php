<?php
/**
 * Description of Docker_driver
 *
 * @author Henrique Resende
 * @description The HTTPD server needs to be in the same group of Docker, so the command "docker" can be used
 */
namespace app\components;
 
use Yii;

interface ISolution {
	public function pull($source);
	public function run($id, $args);
	public function getResults();
	public function pullAndRun($source, $args);
	public function remove($id);
}