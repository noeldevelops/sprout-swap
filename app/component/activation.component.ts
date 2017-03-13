import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Status} from "../class/status";
import {ActivationService} from "../service/activation-service";

@Component({
	templateUrl: "./templates/home-template.php",
	selector: "activation"
})

export class ActivationComponent implements OnInit{
	status: Status = null;

	constructor(private activationService: ActivationService, private route: ActivatedRoute){}

	ngOnInit(): void {
		this.route.params
			.switchMap((params: Params) => this.activationService.getActivation(params['activation']))
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					alert("Thank you for activating your account. You can now login.")
				}
			});

	}
}