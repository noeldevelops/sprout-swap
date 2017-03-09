//this is the modal that pops up when "create new post" is clicked
import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {PostService} from "../service/post-service";

import {Observable} from "rxjs/Observable"
import {Post} from "../class/post-class";

import {Profile} from "../class/profile-class";
import {Mode} from "../class/mode-class";
import {Image} from "../class/image-class";
import {Point} from "../class/point-class";

import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/newpost-template.php"
})

export class NewPostComponent implements OnInit{
	status: Status = null;
	newpost: Post = new Post(0, 0, 0, "", [], "", "","", 0);
	constructor(

	)
	{
	}

}