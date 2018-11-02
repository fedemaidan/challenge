import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { Team } from './model/team';


const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'multipart/form-data',
  })
};

@Injectable({
  providedIn: 'root',
})
export class TeamService {

	private teamUrl = 'http://localhost:9000/index.php/'; 
	  constructor(
	    private http: HttpClient) { }

	  getTeams (): Observable<Team[]> {
	    return this.http.get<Team[]>(this.teamUrl+"team")
	      .pipe(
	        tap(_ => console.log("get teams ok"))
	      );
	  }

	  createTeam (name): Observable<Team> {
	    return this.http.post<Team>(this.teamUrl+"team", {name: name},httpOptions)
	      .pipe(
	        tap(_ => console.log("team created"))
	      );
	  }

	  updateTeam (id, updates): Observable<Team> {
		return this.http.put<Team>(this.teamUrl+"team/"+id, updates ,httpOptions)
	      .pipe(
	        tap(_ => console.log("team updated"))
	      );
	  }

	  deleteTeam(id): Observable<Team> {
		return this.http.delete<Team>(this.teamUrl+"team/"+id,httpOptions)
	      .pipe(
	        tap(_ => console.log("team deleted"))
	      );
	  }

	  updatePlayer(id, updates):  Observable<Object> {
		return this.http.put<Object>(this.teamUrl+"player/"+id, updates ,httpOptions)
	      .pipe(
	        tap(_ => console.log("player updated"))
	      );
	  }
}