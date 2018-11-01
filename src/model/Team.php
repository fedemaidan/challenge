<?php

namespace Model;
use Model\Player;


class Team {
	private $players;
	private $name;

	const MAX_SCORE = 175;
	const STARTERS = 10;
	const SUBSTITUTE = 5;

	function __construct($name, $players)
	{
		$this->setName($name);
		$this->setPlayers($players);
	}

	public function setName(string $name) {
		$this->name = $name;
	}

	public function getName() : string {
		return $this->name;
	}

	public function setPlayers(array $players) {
		$this->validatePlayers($players);
		$this->players = $players;
		foreach ($players as $key => $player) {
			$player->setTeam($this);
		}
	}

	public function getPlayers()  
	{
		return $this->players;
	}

	public function toArray() {
		$array["name"] = $this->getName();
		$array["starters"] = [];
		$array["substitutes"] = [];

		foreach ($this->getPlayers() as $key => $player) {
			if ($player->isStarter())
				$array["starters"][] = $player->toArray();
			else
				$array["substitutes"][] = $player->toArray();
		}	

		return $array;
	}

	private function validatePlayers(array $players) {
		$countStarters = 0;
		$countSubstitute = 0;
		$totalAttributeScore = 0;

		foreach ($players as $key => $player) {
			if ($player->isStarter())
				$countStarters++;
			else
				$countSubstitute++;

			$totalAttributeScore += $player->getTotalAtrributeScore();
		}

		if ($countStarters != self::STARTERS or $countSubstitute != self::SUBSTITUTE ) {
			throw new \Exception("Amount of starter or substite is wrong. You have $countStarters starters and $countSubstitute substitutes", 1);
		}

		if ($totalAttributeScore > self::MAX_SCORE) {
			throw new \Exception("Team can't exceed 175 points. This have $totalAttributeScore", 1);
		}
	}

}

?>