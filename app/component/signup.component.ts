//this is the modal that pops up when "sign-up" is clicked

import{Component, ViewChild, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Profile} from "../class/profile-class";
import {Status} from "../class/status";
import {SignUpService} from "../service/signup-service";
declare var $: any;

@Component({
	templateUrl: "./templates/signup-template.php",
	selector: "signup-component"
})

export class SignUpComponent implements OnInit{
	@ViewChild("signup-form") signUpForm : any;
	profile: Profile = new Profile(0, 0, "", "", 0, "","", "", "");
	status: Status = null;

	constructor(private SignUpService: SignUpService, private router: Router){}

	ngOnInit(): void {
	}

	createProfile() : void {

		this.SignUpService.postSignUp(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.signUpForm.reset()
					alert("Please check your email and click the link to activate your account. Thanks!");
					setTimeout(function(){$("#signup-modal").modal('hide');},1000);
				}
			});
	}
}