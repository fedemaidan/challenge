import { Component, OnInit } from '@angular/core';
import { TEAMS } from '../mock-teams';
import { Team } from '../model/team';

@Component({
  selector: 'app-list-teams',
  templateUrl: './list-teams.component.html',
  styleUrls: ['./list-teams.component.css']
})
export class ListTeamsComponent implements OnInit {

	teams = TEAMS
	selectedTeam = null

	constructor() { }

	ngOnInit() {}

	onSelectTeam(team: Team): void {
		this.selectedTeam = team
	}

	createTeam(): void {

	}

}
