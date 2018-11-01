<?php

/**
 * This factory has the responsability to create/update/delete teams
 */
;

namespace Model\Factory;

use Model\Team;
use Model\Player;
use Model\Factory\PlayerFactory;
use Services\DataSingleton;
use Services\RandomNames;


class TeamFactory
{
    CONST minPointsReservedToPlayer = 6;

    public static function createTeam($name)
    {
        $max            = self::maxAssignablePoints(Team::MAX_SCORE, Team::SUBSTITUTE );
        $pointsStarters = rand( (Team::STARTERS + 1 ) * self::minPointsReservedToPlayer, $max);
    	$starters       = self::createRandomPlayers(Team::STARTERS,true, $pointsStarters);
    	$substitutes    = self::createRandomPlayers(Team::SUBSTITUTE,false, (Team::MAX_SCORE - $pointsStarters));
    	$players = array_merge($starters, $substitutes);
        return new Team($name,$players);
    }

    private static function createRandomPlayers($size, $starter, $points) {
        $players = [];

        for ($i=0; $i < $size; $i++) {
            $maxAssignablePoints = self::maxAssignablePoints($points, ($size - $i - 1));
            $pointsToPlayer = rand(self::minPointsReservedToPlayer, min(100,$maxAssignablePoints));
            $player = PlayerFactory::createPlayer($starter,$pointsToPlayer);
    		$players[] = $player;
            $points -= ($player->getAgility() +  $player->getSpeed() + $player->getStrength());
    	}    

        return $players;
    }

    private static function maxAssignablePoints($total, $numberPlayersToLoad) {
        return $total - (($numberPlayersToLoad ) * self::minPointsReservedToPlayer);
    }
}

?>