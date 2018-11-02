import { Component, OnInit, Input } from '@angular/core';
import { Team } from '../model/team';
import { TeamService } from '../team.service';
import { NotifierService } from 'angular-notifier';

@Component({
  selector: 'app-team',
  templateUrl: './team.component.html',
  styleUrls: ['./team.component.css']
})
export class TeamComponent implements OnInit {
  private readonly notifier: NotifierService;
	 @Input() team: Team;
   substitutesHidden: Boolean
   starterHidden: Boolean
   

  constructor(private teamService: TeamService,  notifierService: NotifierService) { 
    this.substitutesHidden = true
    this.starterHidden = true
    this.notifier = notifierService
  }

  ngOnInit() {}

  toggleSubstitutesHidden() {
    this.substitutesHidden = !this.substitutesHidden
  }

  toggleStarterHidden() {
    this.starterHidden = !this.starterHidden
  }

  updateName():void {
  	this.teamService.updateTeam(this.team["_id"]["$oid"], {name: this.team.name}).subscribe(payload => {
        var type = payload["success"] ? 'success': 'error';
        this.notifier.notify( type , payload["message"] );
    });  
  }



}
