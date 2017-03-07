
import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {PostService} from "../service/post-service";

import {Observable} from "rxjs/Observable"
import {Post} from "../class/post-class";

// import {Profile} from "../classes/profile";
// import {Mode} from "../class/mode";
// import {Image} from "../class/image";
// import {Point} from "../class/point";

import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/post-template.php"
})

export class PostComponent implements OnInit{

	post: new Post(0, 0, 0, "", "", "", "point", "", "", 0);
	selectedPost: Post


}