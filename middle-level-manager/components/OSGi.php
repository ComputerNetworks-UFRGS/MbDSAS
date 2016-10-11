<?php
/**
 * Description of OSGi_Driver
 *
 * @author marcelo
 * @enhancedby Henrique Resende
 */
namespace app\components;
 
use Yii;

class OSGi {
	private $connected = false;
	private $connection;
	private $host;
	private $port;
	private $timeout;

	public function __construct($host = "localhost", $port = 6666, $timeout = 30){
		$this->host = $host;
		$this->port = $port;
		$this->timeout = $timeout;
	}

	private function connect(){
        if(!$this->connected){
            $this->connection = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
            if (!$this->connection) {
                return false;
            } 
            else
            	$this->connected = true;

            $this->read_to();
        }

        return true;
    }

    private function read_to(){
        $return="";
        $last = fgetc($this->connection);
        while(strcmp("!", ($result = fgetc($this->connection))) != 0){
            $return.= $last;
            $last = $result;
        }
        return $return;
    }

    private function command($command){
        fwrite($this->connection, "$command\xA");

        return $this->read_to();
    }

    public function installscript($url){
    	if($this->connect()){
    		$id = $this->command("felix:install ".$url);

    		return trim(preg_replace('/[a-zA-Z: ]*/', "", $id));
    	}
    }

    public function removescript($id){
        if($this->connect()){
            return $this->command("felix:uninstall ".$id);
        }
    }

    public function runscript($id){
    	if($this->connect()){
    		return $this->command("felix:start ".$id);
    	}
    }

    public function stopscript($id){
        if($this->connect()){
            return $this->command("felix:stop ".$id);
        }
    }

    public function listbundles(){
    	if($this->connect()){
    		return $this->command("felix:lb");
    	}
    }

    public function listbundlestoarray(){
        $raw = $this->listbundles();

        $mark1 = "\r\n";
        $mark2 = "|";

        //Separating lines
        $lines = explode($mark1, $raw);

        //Removing information line
        unset($lines[0]);
        //Removing header line
        unset($lines[1]);

        $array = [];
        foreach($lines as $line){
            $attributes = explode($mark2, $line);

            if(count($attributes) == 4){
                $array[] = [
                    'id' => intval($attributes[0]),
                    'state' => trim($attributes[1]),
                    'level' => intval($attributes[2]),
                    'name' => trim($attributes[3])
                ];
            }
        }

        return $array;
    }
}