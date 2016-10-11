<?php

/**
	Description Interface MD List
	@autor Henrique Resende
**/

namespace app\components;
 
use Yii;

class MDListLLDP {

	/**
	**	Get only the first entry from the interface
	**/
    public static function getRemEntry($sysBody){
        $remEntry = [];

    	foreach($sysBody['chassis'] as $sysName => $body){
	        $remEntry['port_id'] = $sysBody['port']['id']['value'];
	        $remEntry['port_id_subtype'] = $sysBody['port']['id']['type'];
	        $remEntry['port_desc'] = $sysBody['port']['descr'];
	        $remEntry['sys_name'] = $sysName;
	        $remEntry['sys_desc'] = $sysBody['chassis'][$sysName]['descr'];
	        $remEntry['chassis_id'] = $sysBody['chassis'][$sysName]['id']['value'];
	    	$remEntry['chassis_id_subtype'] = $sysBody['chassis'][$sysName]['id']['type'];
	    	$remEntry['man_addr_entry'] = isset($sysBody['chassis'][$sysName]['mgmt-ip']) ? $sysBody['chassis'][$sysName]['mgmt-ip'] : null;

	        $capabilityEnabled = "";
	        $capabilitySupported = "";

	        foreach($sysBody['chassis'][$sysName]['capability'] as $capability){
	        	if($capability['enabled'] == "true")
	        		$capabilityEnabled .= $capability['type']." ";
	        	else
	        		$capabilitySupported .= $capability['type']." ";
	        }

	        $remEntry['sys_cap_enabled'] = $capabilityEnabled;
	        $remEntry['sys_cap_supported'] = $capabilitySupported;

	        break;
    	}

        return $remEntry;
    }

    public function getRemEntries($json){

		$obj = json_decode($json);
		
		$array = $this->object_to_array($obj);
		$lldp = $array['lldp'];

        if(isset($lldp['interface'])){
    		$interfaces = $lldp['interface'];

    		$remEntries = [];
    		$count = 0;
    		foreach($interfaces as $key => $interface){
    			if(!isset($interface['chassis'])){
        			$interface = array_values($interface)[0];
    			}

    			$remEntry = MDListLLDP::getRemEntry($interface);
        		$remEntries[] = $remEntry;
        		$count++;	
    		}
    		
    		$array = $remEntries;
        }
        else
            $array = $lldp;
    	
    	return $array;
    }

    private function object_to_array($obj) {
        if(is_object($obj)) $obj = (array) $obj;
        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val) {
                $new[$key] = $this->object_to_array($val);
            }
        }
        else $new = $obj;
        return $new;       
    }

}