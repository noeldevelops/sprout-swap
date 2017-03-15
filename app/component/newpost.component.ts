//this is the modal that pops up when "create new post" is clicked
import{Component, ViewChild, OnInit, Output} from "@angular/core";
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
import {PostImage} from "../class/postImage-class";

declare var $: any;

@Component({
	templateUrl: "./templates/newpost-template.php",
	selector: "newPost"
})

export class NewPostComponent implements OnInit{
	@ViewChild("newPostForm") newPostForm: any;
	status: Status = null;
	newpoint: Point = new Point(0, 0);
	newpost: Post = new Post(0, 0, 0, "", this.newpoint, "", "", 0);
	newimage: Image = new Image(null, "");
	newpostimage: PostImage = new PostImage (null, null);
	@Output() pointLat: number;
	@Output() pointLong: number;

	constructor(private PostService: PostService, private ImageService: ImageService, private router: Router) {
	}

	ngOnInit() {
		this.setCurrentPosition();
	}

	private setCurrentPosition(){
		if("geolocation" in navigator) {
			navigator.geolocation.getCurrentPosition((position) => {
				this.newpoint.pointLat = position.coords.latitude;
				this.newpoint.pointLong = position.coords.longitude;
			});
		}
	}

	createPost(): void {
		this.ImageService.createImage(this.newimage)
			.subscribe((reply : any) => {
			if(reply.status === 200) {
				this.newimage.imageId = reply.data;
				this.newpostimage.postImageImageId = reply.data;
			}
		});

		this.PostService.createPost(this.newpost)
			.subscribe((reply : any) => {
				if(reply.status === 200) {
					this.newpostimage.postImagePostId = reply.data;
					this.PostService.insertPostImage(this.newpostimage);
					this.router.navigate([""]);
					this.newPostForm.reset();
					setTimeout(function() {
						$("#newPostModal").modal('hide');
					}, 1000);
				}
			});
	}
}