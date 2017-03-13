//this is the modal that pops up when "sign-in" is clicked

import{Component, } from "@angular/core";

import {Router} from "@angular/router";

import {Status} from "../class/status";
import {SignOutService} from "../service/signout-service";
import {SignInService} from "../service/signin-service";
declare var $: any;

@Component({
	templateUrl: "./templates/signout-template.php",
	selector: "signOut"
})

export class SignOutComponent {

	status: Status = null;

	constructor(private SignOutService: SignOutService, private SignInService: SignInService, private  router: Router){}

	isSignedIn = false;

	ngOnChanges (): void{
		this.isSignedIn = this.SignInService.isSignedIn;

	}

	signIn() : void {
		this.SignOutService.getSignOut()
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.router.navigate([""]);
					this.SignInService.isSignedIn = false;
				}
			});
	}
}