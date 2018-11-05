<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Model\Factory\PlayerFactory;
use Model\Team;
use Model\Player;

final class PlayerCreationTests extends TestCase
{
    private $team;

    public function testSetName(): void
    {        
    	$player = PlayerFactory::createPlayer(true,80);
    	PlayerFactory::setName($player,"Peter", "Parker");

		$this->assertEquals("Peter Parker", $player->getName());
		
		$player2 = PlayerFactory::createPlayer(true,80);
    	$error = PlayerFactory::setName($player2,"Peter", "Parker");
		$this->assertEquals("Error", $error);
		$this->assertNotEquals("Peter Parker", $player2->getName());

    }

}