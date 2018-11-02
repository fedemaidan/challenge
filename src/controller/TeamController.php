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
        try {
            $team = TeamFactory::createTeam($params["name"]);
            echo $this->message(true, "Team created!" , $team->toArray() );
        } catch(\Exception $e) {
            echo $this->message(true, $e->getMessage(), null);   
        }
    }

    public function getAction($params)
    {
        try {
            $id = null;
            if ($params["id"])
                $id=$params["id"];
            
            $teams = DataSingleton::Instance()->getTeams($id);
            echo $this->message(true, "" , $teams );
        } catch(\Exception $e) {
            echo $this->message(true, $e->getMessage(), null);      
        }
    }

    public function editAction($params)
    {
        try {
            if ($params["id"] ) {
                $id = $params["id"];
                $updates["name"] = $params["name"];
                $team = TeamFactory::updateTeam($id, $updates);
                echo $this->message(true, "Team updated successfully" ,$team);
            }
            else {
                echo $this->message(false, "Id is required", null);
            }
        } catch(\Exception $e) {
            echo $this->message(true, $e->getMessage(), null);      
        }
    }

    public function deleteAction($params)
    {
        try {
            if ($params["id"] ) {
                $id = $params["id"];
                TeamFactory::deleteTeam($id);
            }
            else {
                echo $this->message(false, "Id is required", null);
            }   
        } catch (Exception $e) {
            echo $this->message(true, $e->getMessage(), null);         
        }
    }
}

?>