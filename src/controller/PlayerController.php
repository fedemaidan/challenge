<?php

/**
 * Team Controller
 */
;

namespace Controller;

use Model\Team;
use Model\Factory\TeamFactory;
use Model\Player;
use Model\Factory\PlayerFactory;
use Services\DataSingleton;
use Services\RandomNames;
use Controller\BaseController;

class PlayerController extends BaseController
{
    
	public function createAction($params)
    {
    	$team = TeamFactory::createTeam($params["name"]);
        echo $this->message(true, "Team created!" , $team->toArray() );
    }

    public function getAction($params)
    {
        $id = null;
        if ($params["id"])
            $id=$params["id"];
        
        $teams = DataSingleton::Instance()->getTeams($id);
        echo $this->message(true, "" , $teams );
    }

    public function editAction($params)
    {
        if ($params["id"] ) {
            var_dump($params);
            var_dump("TO DO -> Edit team with id ".$params["id"]);
        }
        else {
            var_dump("Id required");
        }
    }

    public function deleteAction($params)
    {
    	var_dump($params);
    	var_dump("delete Teams with id".$params["id"]);
    }
}

?>