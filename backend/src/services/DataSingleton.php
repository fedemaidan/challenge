<?php

/**
 * This singleton has the responsability to manage data
 *
 */

namespace Services;

use Services\MongoManager;
use Model\Team;
use Model\Player;
use Model\Factory\PlayerFactory;
use Services\RandomNames;;

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
        return MongoManager::Instance()->insert(Team::COLLECTION, $team->toArray());
    }

    public function getTeams($id) {
        $filter = $id ? ["_id" => new \MongoDB\BSON\ObjectId($id) ] : [];
        return MongoManager::Instance()->get(Team::COLLECTION, $filter);
    }

    public function getTeamOfPlayer($id) {
        $filterStarters =  ["starters.id" => $id ];
        $filterSubstitutes =  ["substitutes.id" => $id ];
        $teams1 = MongoManager::Instance()->get(Team::COLLECTION, $filterStarters);
        $teams2 = MongoManager::Instance()->get(Team::COLLECTION, $filterSubstitutes);
        $team = array_merge($teams2,$teams1)[0];
        $playersObj = array_merge($team->substitutes,$team->starters);
        
        $players = [];
        foreach ($team->substitutes as $key => $value) {
            $players[] = new Player($value->id, $value->speed, $value->strength,  $value->agility, $value->first_name, $value->last_name,  false);
        }

        foreach ($team->starters as $key => $value) {
            $players[] = new Player($value->id, $value->speed, $value->strength,  $value->agility, $value->first_name, $value->last_name, true);
        }

        return new Team($team->name, $players);
    }


    public function getPlayer($id) {

        $filterStarters =  ["starters.id" => $id ];
        $filterSubstitutes =  ["substitutes.id" => $id ];
        $teams1 = MongoManager::Instance()->get(Team::COLLECTION, $filterStarters);
        $teams2 = MongoManager::Instance()->get(Team::COLLECTION, $filterSubstitutes);
        $team = array_merge($teams2,$teams1)[0];

        $playersObj = array_merge($team->substitutes,$team->starters);
        

        foreach ($team->substitutes as $key => $value) {
            if ($value->id == $id){
                    $value->isStarter = false;
                    return $value;
                }
        }

        foreach ($team->starters as $key => $value) {
            if ($value->id == $id){
                    $value->isStarter = true;
                    return $value;
                }
        }

        return null;
        
    }


    public function renamePlayer($id, $first_name, $last_name) {
        $player = $this->getPlayer($id);
        $first_name = $first_name ? $first_name : $player->first_name;
        $last_name = $last_name ? $last_name : $player->last_name;

        if ($this->canAddPlayerName($first_name,$last_name,$id )) {
            $field = $player->isStarter ? "starters" : "substitutes";
            $filter = [$field.".id" => $id];
            $update = [$field.".$.first_name" => $first_name, $field.".$.last_name" => $last_name];
            MongoManager::Instance()->update(Team::COLLECTION, $filter,$update);
            $player = $this->getPlayer($id);
            return $player;
        }
        else {
            throw new \Exception("Can't rename player because is other one with the same name", 1);
        }
    }

    public function updatePointsPlayer($id, $agility, $speed, $strength) {
        $player = $this->getPlayer($id);
        $field = $player->isStarter ? "starters" : "substitutes";
        $update = [$field.".$.agility" => $agility, $field.".$.speed" => $speed, $field.".$.strength" => $strength];
        $filter = [$field.".id" => $id];
        MongoManager::Instance()->update(Team::COLLECTION, $filter,$update);
        $player = $this->getPlayer($id);
        return $player;
    }

    public function updateTeam($id,$params) {
        $filter = ["_id" => new \MongoDB\BSON\ObjectId($id) ];
        MongoManager::Instance()->update(Team::COLLECTION, $filter,$params);
        return $this->getTeams($id);
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

    public function canAddPlayerId($id) {
        $countIdStartersLike = count(MongoManager::Instance()->get("team", ["starters.id" => $id]));
        $countIdSubstitutesLike = count(MongoManager::Instance()->get("team", ["substitutes.id" => $id]));
        return $countIdSubstitutesLike + $countIdStartersLike == 0;
    }

    public function canAddPlayerName($first_name, $last_name, $id = "") {
        $players = [];

        $teamStarters = MongoManager::Instance()->get("team", ["starters.first_name" => $first_name, "starters.last_name" => $last_name]);
        
        $teamSubstitutes = MongoManager::Instance()->get("team", ["substitutes.first_name" => $first_name, "substitutes.last_name" => $last_name]);
        
        $count = 0;

        foreach ($teamStarters as $key => $team) {
            $players = array_merge($team->starters,$players);
        }
        
        foreach ($teamSubstitutes as $key => $team) {
            $players = array_merge($team->substitutes,$players);
        }

        for ($i=0; $i < count($players); $i++) { 
            if ($players[$i]->id != $id && $players[$i]->first_name == $first_name && $players[$i]->last_name == $last_name ){
                            $count++;}
        }
        
        return $count == 0;
    }
}

?>