import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {Observable} from "rxjs/Observable"

import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/navbar-template.php"
})

export class NavBarComponent implements OnInit{
	status: Status = null;
	constructor(

	)
	{
	}

}