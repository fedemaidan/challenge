<?php

namespace Model;

use Model\Team;

class Player 
{	
	const MAX_SCORE = 100;
	private $id;
	private $speed = 0;
	private $strength = 0;
	private $agility = 0;
	private $team;
	private $first_name;
	private $last_name;
	private $isStarter = false;

	function __construct($id,$speed, $strength, $agility, $first_name, $last_name, $isStarter)
	{
		$this->id = $id;
		$this->setName($first_name, $last_name);
		$this->setSpeed($speed);
		$this->setStrength($strength);
		$this->setAgility($agility);
		$this->setIsStarter($isStarter);
	}

	public function getId() {
		return $this->id;
	}

	public function setName(string $first_name, string $last_name) {
		$this->first_name = $first_name;
		$this->last_name = $last_name;
	}

	public function getName() : string {
		return $this->first_name." ".$this->last_name;
	}

	public function getFirstName() : string {
		return $this->first_name;
	}

	public function getLastName() : string {
		return $this->last_name;
	}

	public function setSpeed(int $speed) {
		$this->validateTotalAttributeScore($this->getStrength(), $this->getAgility(), $speed);
		$this->validateScore($speed);
		$this->speed = $speed;
	}

	public function getSpeed() : int {
		return $this->speed;
	}

	public function setStrength(int $strength) {
		$this->validateTotalAttributeScore($this->getAgility(), $this->getSpeed(), $strength);
		$this->validateScore($strength);
		$this->strength = $strength;
		
	}

	public function getStrength() : int {
		return $this->strength;
	}

	public function toJson() {
		return json_encode($this->toArray());
	}

	public function toArray() {
		$array = [];
		$array["id"] = $this->getId();
		$array["first_name"] = $this->getFirstName();
		$array["last_name"] = $this->getLastName();
		$array["speed"] = $this->getSpeed();
		$array["strength"] = $this->getStrength();
		$array["agility"] = $this->getAgility();
		$array["is_starter"] = $this->isStarter();
		return $array;
	}


	public function setAgility(int $agility) {
		$this->validateTotalAttributeScore($this->getStrength(), $this->getSpeed(), $agility);
		$this->validateScore($agility);
		
		$this->agility = $agility;
	}

	public function getAgility() : int {
		return $this->agility;
	}

	public function setTeam(Team $team) {
		$this->team = $team;
	}

	public function getTeam() : Team {
		return $this->team;
	}

	public function getTotalAtrributeScore() {
		return $this->getAgility() + $this->getSpeed() + $this->getStrength();
	}

	public function setIsStarter(bool $isStarter) {
		$this->isStarter = $isStarter;
	}

	public function isStarter() : bool {
		return $this->isStarter;
	}

	private function validateTotalAttributeScore($score1, $score2, $score3) {
		$total = $score1+$score2+$score3;
		if (($total) > self::MAX_SCORE) {
			throw new \Exception("The Total Attribute Score can't be greater than 100. This player have $total", 1);
		}
	}

	private function validateScore($score) {
		if($score <= 1) {
			throw new \Exception("It has to be greater than 1", 1);
		}
	}

}
?>