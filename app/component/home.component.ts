import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../class/status";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {Point} from "../class/point-class";

@Component({
	templateUrl: "./templates/home-template.php"
})

export class HomeComponent {
	status: Status = null;
	post: Post = null;
	posts: Post[] = [];
	postLocation: Point = null;
	postId: number = null;

	constructor(private postService: PostService
	){}

	getPostByPostLocation(): void {
		this.postService.getPostsByPostLocation(this.postLocation)
		.subscribe(posts => {this.posts = posts});
	}

	getPost():void{
		this.postService.getPost(this.postId)
			.subscribe(post=>{this.post = post});
	}


}