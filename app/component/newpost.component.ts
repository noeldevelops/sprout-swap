//this is the modal that pops up when "create new post" is clicked
import{Component, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {PostService} from "../service/post-service";

import {Observable} from "rxjs/Observable"
import {Post} from "../class/post-class";

import {Profile} from "../class/profile-class";
import {Mode} from "../class/mode-class";
import {Image} from "../class/image-class";
import {Point} from "../class/point-class";

import {Status} from "../class/status";
import {ImageService} from "../service/image-service";
declare var $: any;

@Component({
	templateUrl: "./templates/newpost-template.php",
	selector: "newPost"
})

export class NewPostComponent {
	@ViewChild("newPostForm") newPostForm : any;
	status: Status = null;
	newpost: Post = new Post(0, 0, 0, 0, "", [], "", "", 0);

	constructor(private PostService: PostService, private ImageService: ImageService, private router: Router) {}

	createPost() : void {
		this.PostService.createPost(this.newpost)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate([""]);
					this.newPostForm.reset();
					setTimeout(function(){$("#newPostModal").modal('hide');},1000);
				}
			});
	}
}