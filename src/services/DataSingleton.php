<?php

/**
 * This singleton has the responsability to manage data
 *
 */

namespace Services;

use Services\MongoManager;

class DataSingleton
{

    private $characters;
    private $ids;
    private $playersNames = [];
    private $teams = [];


    /**
     * Call this method to get singleton
     *
     * @return DataSingleton
     */

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DataSingleton();
        }
        return $inst;
    }

    private function __construct()
    {
    	$this->characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $this->ids = array();
    }

    public function getUniquePlayerId() {
    	$id =  $this->randomString(6);
    	if (in_array($id, $this->ids)) {
    		$this->getUniquePlayerId();
    	}
    	else {
    		$ids[$id] = "reserved";
    	    return $id;
    	}
    }

    public function addPlayer($player) {
        if ( $this->canAddPlayer($player)) {
            $this->playersNames[$player->getName()] = $player->getId();    
            $this->ids[$player->getId()] = $player;
        } else {
            return "Error";
        }
    }

    public function canAddPlayer($player) {
        return  $this->ids[$player->getId()] == "reserved" && !array_key_exists($player->getName(),$this->playersNames);
    }

    public function addTeam($team) {
        $this->teams[$team->getName()] = $team;

        MongoManager::Instance()->insert("team", $team->toArray());
    }

    public function getTeams($id) {
        return MongoManager::Instance()->get("team");
        $teams = [];
        if ($id)
            return $teams[$id] = $this->teams[$id];
        else
            return $this->teams;
    }

    public function canRenamePlayer($player, $name) {
        return  !array_key_exists($name,$this->playersNames);
    }

    public function renamePlayer($player, $first_name, $last_name) {
        if ($this->canRenamePlayer($player, $name)) {
            $player->setName($first_name,$last_name);
            $this->playersNames[$player->getName()] = $player->getId();    
            $this->ids[$player->getId()] = $player;  
        }else {
            return "Error";
        }
        
    }

    private function randomString($length = 6) {
		$str = "";
		$max = count($this->characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $this->characters[$rand];
		}
		return $str;
	}
}

?>