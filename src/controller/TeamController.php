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

class TeamController
{
    
	public function createAction($params)
    {
    	$team = TeamFactory::createTeam($params["name"]);
    	echo $team->toJson();
    }

    public function getAction($params)
    {
    	var_dump($params);
    	var_dump("get Teams");
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