<?php

/**
 * This factory has the responsability to create/update/delete players
 */
;

namespace Model\Factory;

use Model\Player;
use Model\Team;
use Services\DataSingleton;


class PlayerFactory
{
    public static function createPlayerRandom($starter,$pointsToPlayer) {
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

    public static function matchPlayer($id, $first_name, $last_name, $strength, $speed, $agility, $starter) {
        $player = new Player($id,$speed, $strength, $agility, $first_name, $last_name, $starter);
        if (DataSingleton::Instance()->canAddPlayer($player))
            return $player;
        else
            throw new \Exception("This player cannot be matched", 1);
    }

    public static function renamePlayer($id, $first_name, $last_name) {
        return DataSingleton::Instance()->renamePlayer($id, $first_name, $last_name);
    }

    public static function updatePointsPlayer($id, $agility, $speed, $strength) {
            /* Create player to validate points */
            $player = new Player($id,$speed, $strength, $agility, "", "", true);
            /* Create team to validate points */
            $team = DataSingleton::Instance()->getTeamOfPlayer($id);
            $players = $team->getPlayers();
            foreach ($players as $key => $p) {
                if ($p->getId() == $id) {
                    $p->setSpeed($speed);
                    $p->setAgility($agility);
                    $p->setStrength($strength);
                }
            }

            $team->setPlayers($players);
            
            return DataSingleton::Instance()->updatePointsPlayer($id, $agility, $speed, $strength);    
        
    }
}

?>