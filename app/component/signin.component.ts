//this is the modal that pops up when "sign-in" is clicked

import{Component, ViewChild, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Profile} from "../class/profile-class";
import {Status} from "../class/status";
import {SignInService} from "../service/signin-service";
import {ProfileService} from "../service/profile-service";
declare var $: any;

@Component({
	templateUrl: "./templates/signin-template.php",
	selector: "signin-component"
})

export class SignInComponent implements OnInit {
	@ViewChild("signin-form") signInForm : any;

	profile: Profile = new Profile(0, 0, "", "", 0, "","", "", "");
	status: Status = null;
	constructor(private SignInService: SignInService, private profileService: ProfileService, private router: Router){}

	ngOnInit(): void {}

	signIn() : void {
		this.SignInService.postSignIn(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate(['main-app']);
					this.signInForm.reset()
					// this.SignInService.isLoggedIn = true;
					setTimeout(function() {
						$("#signin-modal").modal('hide');
					}, 1000);
				}
			});
	}
}