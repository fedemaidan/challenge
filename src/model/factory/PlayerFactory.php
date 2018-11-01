<?php

/**
 * This factory has the responsability to create/update/delete teams
 */
;

namespace Model\Factory;

use Model\Player;
use Services\DataSingleton;
use Services\RandomNames;


class PlayerFactory
{
    public static function createPlayer($starter,$pointsToPlayer) {
    	$id = DataSingleton::Instance()->getUniquePlayerId();
    	$first_name = RandomNames::getFirstName();
    	$last_name = RandomNames::getLastName();
        $minPointToAttr = 2;
        $strength = rand($minPointToAttr, ($pointsToPlayer - ($minPointToAttr * 2)));
        $speed = rand($minPointToAttr, ($pointsToPlayer -  $strength - $minPointToAttr));
        $agility = rand($minPointToAttr, ($pointsToPlayer -  $strength - $speed));
        $player = new Player($id,$speed, $strength, $agility, $first_name, $last_name, $starter);
        if (DataSingleton::Instance()->canAddPlayer($player))
            DataSingleton::Instance()->addPlayer($player);
        return $player;
    }

    public static function setName($player, $first_name, $last_name) {
        $name = $first_name." ".$last_name;
        if (DataSingleton::Instance()->canRenamePlayer($player, $name)) {
            return DataSingleton::Instance()->renamePlayer($player, $first_name, $last_name);
        } else {
            return "Error";
        }
        
    }

}

?>