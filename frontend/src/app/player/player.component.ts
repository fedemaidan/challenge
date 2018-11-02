import { Component, OnInit , Input} from '@angular/core';
import { TeamService } from '../team.service';
import { NotifierService } from 'angular-notifier';

@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.css']
})
export class PlayerComponent implements OnInit {
	@Input() player: Object;
  private readonly notifier: NotifierService;

  constructor(private teamService: TeamService,  notifierService: NotifierService) {
      this.notifier = notifierService;
   }

  ngOnInit() {}

  updatePlayer(player):void {
    this.teamService.updatePlayer(player.id, {first_name: player.first_name,last_name: player.last_name}).subscribe(payload => {
      var type = payload["success"] ? 'success': 'error';
      this.notifier.notify( type , payload["message"] );

    });  
  }

}
