<?php

/**
 * Player Controller
 */
;

namespace Controller;

use Model\Player;
use Model\Factory\PlayerFactory;
use Services\DataSingleton;
use Services\RandomNames;
use Controller\BaseController;

class PlayerController extends BaseController
{

    public function editAction($params)
    {
        try {
            if ($params["id"] ) {
                $id = $params["id"];
                if ($params["first_name"] || $params["last_name"]) {
                    $first_name = $params["first_name"];
                    $last_name = $params["last_name"];
                    $player = PlayerFactory::renamePlayer($id, $first_name, $last_name);
                }
                if ($params["agility"] || $params["speed"] || $params["strength"]) {
                    $speed = $params["speed"];
                    $agility = $params["agility"];
                    $strength = $params["strength"];
                    $player = PlayerFactory::updatePointsPlayer($id, $agility, $speed, $strength);   
                }


                echo $this->message(true, "Player updated successfully", $player);
            }
            else {
                echo $this->message(false, "Id is required",null);
            }
        }
        catch(\Exception $e) {
            echo $this->message(false, $e->getMessage(),null);
        }
    }
}

?>