//this is the modal that pops up when "sign-up" is clicked

import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Profile} from "../class/profile-class";
import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/signup-template.php"
})

export class SignUpComponent {
	status: Status = null;
	constructor(

	)
	{
	}

}