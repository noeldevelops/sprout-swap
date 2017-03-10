import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {ProfileService} from "../service/profile-service";

import {Observable} from "rxjs/Observable"
import {Profile} from "../class/profile-class";

import {Image} from "../class/image-class";

import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/profile-template.php"
})

export class ProfileComponent {
	status: Status = null;
	profile: Profile = new Profile(0, 0, "", "", 0, "","", "", "");
	constructor(

	)
	{
	}

}