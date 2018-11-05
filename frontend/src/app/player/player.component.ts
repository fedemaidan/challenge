import { Component, OnInit , Input} from '@angular/core';
import { TeamService } from '../team.service';
import { NotifierService } from 'angular-notifier';
import { Player } from '../model/player';

@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.css']
})
export class PlayerComponent implements OnInit {
	@Input() player: Player;
  private readonly notifier: NotifierService;

  constructor(private teamService: TeamService,  notifierService: NotifierService) {
      this.notifier = notifierService;
   }

  ngOnInit() {}

  updatePlayer(player):void {
    console.log(player);
    this.teamService.updatePlayer(player.id, {...player} ).subscribe(payload => {
      var type = payload["success"] ? 'success': 'error';
      this.notifier.notify( type , payload["message"] );

    });  
  }

}
