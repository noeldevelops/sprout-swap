import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {ImageService} from "../service/image-service";

import {Observable} from "rxjs/Observable"
import {Image} from "../class/image-class";

import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/image-template.php"
})

export class ImageComponent implements OnInit{
	status: Status = null;
	image: Image = new Image(0, "");
	constructor(
	)
	{
	}

}