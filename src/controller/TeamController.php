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

class TeamController extends BaseController
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
            $id = $params["id"];
            $updates["name"] = $params["name"];
            $team = TeamFactory::updateTeam($id, $updates);
            echo $this->message(true, "Team updated successfully" ,$team);
        }
        else {
            echo $this->message(false, "Id is required", null);
        }
    }

    public function deleteAction($params)
    {
        if ($params["id"] ) {
            $id = $params["id"];
            TeamFactory::deleteTeam($id);
        }
        else {
            echo $this->message(false, "Id is required", null);
        }
    }
}

?>