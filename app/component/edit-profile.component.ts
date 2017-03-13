import{Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../service/profile-service";
import {Profile} from "../class/profile-class";
import {Status} from "../class/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/editprofile-template.php",
	selector: "profile-edit"
})

export class ProfileComponent implements OnInit {
	status: Status = null;
	profile: Profile = new Profile(0, 0, "", "", 0, "", "", "", "");

	constructor(private profileService: ProfileService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.editProfile();
	}

	editProfile(): void {
		this.route.params
			.switchMap((params: Params) => this.profileService.getProfile(+params["id"]))
			.subscribe(reply => this.profile = reply);
	}
}