<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Model\Factory\TeamFactory;
use Model\Team;
use Model\Player;

final class TeamCreationTests extends TestCase
{
    private $team;
    /**
     * @before
     */
    public function setupCreateTeam() : void
    {
        $this->team = TeamFactory::createTeam("Test Name");
    }

    public function testAmountPlayers(): void
    {
        $this->assertEquals(count($this->team->getPlayers()),Team::STARTERS+Team::SUBSTITUTE);
        $substitutes = 0;
        $starters = 0;

        foreach ($this->team->getPlayers() as $key => $player) {
            if ($player->isStarter())
                $starters++;
            else
                $substitutes++;
        }

        $this->assertEquals($starters,Team::STARTERS);
        $this->assertEquals($substitutes,Team::SUBSTITUTE);
    }

    public function testTeamPointsPlayers(): void
    {
        $points = 0;

        foreach ($this->team->getPlayers() as $key => $player) {
            $points += $player->getAgility() +  $player->getSpeed() + $player->getStrength();
        }

        $this->assertLessThanOrEqual(Team::MAX_SCORE,$points);
    }


    public function testPlayersPointsPlayers(): void
    {
        $points = 0;

        foreach ($this->team->getPlayers() as $key => $player) {
            $points += $player->getAgility() +  $player->getSpeed() + $player->getStrength();
            $this->assertGreaterThan(1,$player->getAgility());
            $this->assertGreaterThan(1,$player->getSpeed());
            $this->assertGreaterThan(1,$player->getStrength());
        }
    }
}