import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Status} from "../class/status";

@Component({
	selector: 'main-nav',
	templateUrl: "./templates/navbar-template.php"
})

export class NavbarComponent implements OnInit {
	status: Status = null;
	constructor() {
	}

}