import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {Observable} from "rxjs/Observable"

import {Status} from "../class/status";
import {SignOutService} from "../service/signout-service";

@Component({
	templateUrl: "./templates/sidenav-template.php",
	selector: 'sidenav'
})

export class SideNavComponent implements OnInit{
	status: Status = null;
	constructor(private SignOutService: SignOutService, private router: Router) {}

	ngOnInit() : void {}

	signOut() : void {
		this.SignOutService.getSignOut()
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate(['']);
				}
			});
	}
}