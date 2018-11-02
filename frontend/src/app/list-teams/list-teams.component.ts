import { Component, OnInit } from '@angular/core';
import { NotifierService } from 'angular-notifier';
import { Team } from '../model/team';
import { TeamService } from '../team.service';

@Component({
  selector: 'app-list-teams',
  templateUrl: './list-teams.component.html',
  styleUrls: ['./list-teams.component.css']
})
export class ListTeamsComponent implements OnInit {
 	private readonly notifier: NotifierService;
	teams
	selectedTeam = null
	newTeam

	constructor(private teamService: TeamService,  notifierService: NotifierService) {
		this.notifier = notifierService
	}

	ngOnInit() {
		this.teamService.getTeams().subscribe(payload => {this.teams = payload["data"];});
	}

	onSelectTeam(team: Team): void {
		this.selectedTeam = team
	}

	createTeam(): void {
		this.teamService.createTeam(this.newTeam).subscribe(payload => {
			var type = payload["success"] ? 'success': 'error';
        	this.notifier.notify( type , payload["message"] );
			this.teamService.getTeams().subscribe(payload => {this.teams = payload["data"]});		
		});	
	}


	deleteTeam(team): void {
	   this.teamService.deleteTeam(team["_id"]["$oid"]).subscribe(payload => {
	   		if (this.selectedTeam == team)
	   			this.selectedTeam = null;
	   		var type = payload["success"] ? 'success': 'error';
        	this.notifier.notify( type , payload["message"] );
        	this.teamService.getTeams().subscribe(payload => {this.teams = payload["data"];});
	    });   
	  }
}
