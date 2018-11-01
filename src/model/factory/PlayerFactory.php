<?php

/**
 * This factory has the responsability to create/update/delete teams
 */
;

namespace Model\Factory;

use Model\Player;
use Services\DataSingleton;


class PlayerFactory
{
    public static function createPlayer($starter,$pointsToPlayer) {
    	$id = DataSingleton::Instance()->getUniquePlayerId();
        $name = DataSingleton::Instance()->getUniquePlayerName();
        $first_name = $name[0];
        $last_name = $name[1];
        $minPointToAttr = 2;
        $strength = rand($minPointToAttr, ($pointsToPlayer - ($minPointToAttr * 2)));
        $speed = rand($minPointToAttr, ($pointsToPlayer -  $strength - $minPointToAttr));
        $agility = rand($minPointToAttr, ($pointsToPlayer -  $strength - $speed));
        $player = new Player($id,$speed, $strength, $agility, $first_name, $last_name, $starter);
        if (DataSingleton::Instance()->canAddPlayer($player))
            return $player;
        else
            return null;   
    }

}

?>