1. How long did you spend on the code challenge? What would you add to your solution if you had
more time? If you didn't spend much time on the code challenge then use this as an opportunity
to explain what you would add.

I spended 20 hours. I would like to define different types of Exception to model's errors.

2. What was the most useful feature that was added to the latest version of a language you used?
Please include a snippet of code that shows how you've used it.

The most useful feature that was added to PHP 7 is that functions can declare what type returns
I used it to model entities, for example in Player.php line 38:

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

3. How would you track down a performance issue in production? Have you ever had to do this?

If it is possible I first clone the environment to not affects production. Then I work to know which enpoints have the issue. I stress them and looks how it impacts in CPU, memory and I/O "value":s of work.  

With this information I work to found a "coding" solution, that could be some loop, a innecessary call,  changing a call syncronous to asyncronous, etc. If it don't have something like that, I look for a solution scaling vertically or horizontally.

Finally, I stress it again and be sure to have benefits of that.

4. Please describe yourself using JSON.

{
	"name": "Federico Maidan",
	"date_of_bith": "1991-05-31",
	"studies": "Studing Software Engineer, finishing that at December 2018",
	"other_likes": [
		"Soccer", 
		"Music"],
	"specialties": [
	 "Group coordination",
	 "Business vision",
	 "Customer-oriented", 
	 "Backend", 
	 "NoSql",
	 "Flexibility"],
	"tecnical_skills": [
			{"name":"PHP" , "value": "9"},
			{"name":"Symfony2" , "value": "9"},
			{"name":"Node" , "value": "7"},
			{"name":"Docker" , "value": "8"},
			{"name":"DockerSwarm" , "value": "8"},
			{"name":"Angular" , "value": "6"},
			{"name":"ELK (ElasticSearch-Logstash-Kibana" , "value": "7"},
			{"name":"RabbitMQ" , "value": "7"},
			{"name":"MySql" , "value": "8"},
			{"name":"Postgresql" , "value": "7"},
			{"name":"Mongodb" , "value": "7"},
			{"name":"Redis" , "value": "6"},
			{"name":"Cassandra" , "value": "5"},
			{"name":"Ansible" , "value": "6"},
			{"name":"Automate deploy" , "value": "5"},
			{"name":"HTML" , "value": "7"},
			{"name":"CSS" , "value": "7"}
	]
}