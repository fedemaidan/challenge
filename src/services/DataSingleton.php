<?php

/**
 * This singleton has the responsability to manage data
 *
 */

namespace Services;

use Services\MongoManager;
use Model\Team;
use Services\RandomNames;

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

    public function addTeam($team) {
        $this->teams[$team->getName()] = $team;
        MongoManager::Instance()->insert(Team::COLLECTION, $team->toArray());
    }

    public function getTeams($id) {
        $filter = $id ? ["_id" => new \MongoDB\BSON\ObjectId($id) ] : [];
        return MongoManager::Instance()->get(Team::COLLECTION, $filter);
    }

    public function updateTeam($id,$params) {
        $filter = ["_id" => new \MongoDB\BSON\ObjectId($id) ];
        $team = MongoManager::Instance()->update(Team::COLLECTION, $filter,$params);
    }

    public function deleteTeam($id) {
        $filter = ["_id" => new \MongoDB\BSON\ObjectId($id) ];
        $team = MongoManager::Instance()->delete(Team::COLLECTION, $filter);
    }

    public function getUniquePlayerId() {
    	$id =  $this->randomString(6);
        $mongoValidateId = $this->canAddPlayerId($id);

    	if (in_array($id, $this->ids) || !$mongoValidateId) {
    		return $this->getUniquePlayerId();
    	}
    	else {
    		$ids[] = $id;
    	    return $id;
    	}
    }

    public function getUniquePlayerName() {
        $first_name = RandomNames::getFirstName();
        $last_name = RandomNames::getLastName();
        $mongoValidateName = $this->canAddPlayerName($first_name, $last_name);
        $str = $first_name.",".$last_name;
        
        if (in_array($str, $this->playersNames) || !$mongoValidateName) {
            return $this->getUniquePlayerName();
        }
        else {
            $this->playersNames[] = $first_name.",".$last_name;
            return [$first_name, $last_name];
        }
    }

    public function canAddPlayer($player) {
        return  $this->canAddPlayerId($player->getId()) && $this->canAddPlayerName($player->getFirstName(), $player->getLastName());
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

    private function canAddPlayerId($id) {
        $countIdStartersLike = count(MongoManager::Instance()->get("team", ["starters.id" => $id]));
        $countIdSubstitutesLike = count(MongoManager::Instance()->get("team", ["substitutes.id" => $id]));
        return $countIdSubstitutesLike + $countIdStartersLike == 0;
    }

    private function canAddPlayerName($first_name, $last_name) {
        $countNameStartersLike = count(MongoManager::Instance()->get("team", ["starters.first_name" => $first_name, "starters.last_name" => $last_name]));
        
        $countNameSubstitutesLike = count(MongoManager::Instance()->get("team", ["substitutes.first_name" => $first_name, "substitutes.last_name" => $last_name]));
        return $countNameStartersLike + $countNameSubstitutesLike == 0;
    }
}

?>