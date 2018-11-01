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
        if ($params["id"] ) {
            $id = $params["id"];
            $first_name = $params["first_name"];
            $last_name = $params["last_name"];
            $last_name = "carlos"; //TODO

            PlayerFactory::renamePlayer($id, $first_name, $last_name);die;
            echo $this->message(true, "Player renamed successfully" );
        }
        else {
            echo $this->message(false, "Id is required");
        }
    }
}

?>