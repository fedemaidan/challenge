<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Model\Factory\PlayerFactory;
use Model\Factory\TeamFactory;
use Model\Team;
use Model\Player;

final class PlayerCreationTests extends TestCase
{
    public function testSetName(): void
    {        
    	$team = TeamFactory::createTeam("Test Name3");
        $player = $team->getPlayers()[0];
        $player2 = $team->getPlayers()[1];
    	
        $player = PlayerFactory::renamePlayer($player->getId(),"Peter", "Parker");

		$this->assertEquals("Peter Parker", $player->first_name.' '.$player->last_name);
		
		try {
            PlayerFactory::renamePlayer($player2->getId(),"Peter", "Parker");    
        } catch (\Exception $e) {
            $this->assertEquals("Can't rename player because is other one with the same name", $e->getMessage());    
            $this->assertNotEquals('Peter Parker',  $player2->getFirstName().' '.$player2->getLastName());
        }

        $player = PlayerFactory::renamePlayer($player->id,$player->id, $player->id);
    }
}