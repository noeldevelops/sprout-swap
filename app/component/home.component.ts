import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../class/status";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {Point} from "../class/point-class";
import DateTimeFormat = Intl.DateTimeFormat;


@Component({
	templateUrl: "./templates/home-template.php"
})

export class HomeComponent implements OnInit{
	status: Status = null;
	post: Post = null;
	posts: Post[] = [];
	postLocation: Point = null;
	postId: number = null;
	postModeId: number = null;
	postProfileId: number = null;
	postContent: string = null;
	postOffer: string = null;
	postRequest: string = null;
	postTimestamp: number = null;

	constructor(private postService: PostService
	){}

	ngOnInit(): void{
			this.postService.getPostsByPostModeId(1)
			.subscribe(posts=>{this.posts = posts});
	}

	getPostByPostLocation(): void {
		this.postService.getPostsByPostLocation(this.postLocation)
			.subscribe(posts => {this.posts = posts});
	}

	getPost():void{
		this.postService.getPost(this.postId)
			.subscribe(post=>{this.post = post});
	}

	getPostsByPostModeId(): void{
		this.postService.getPostsByPostModeId(this.postModeId)
			.subscribe(posts=>{this.posts = posts});
	}

	getPostsByPostProfileId():void{
		this.postService.getPostsByPostProfileId(this.postProfileId)
			.subscribe(posts => {this.posts = posts});
	}

	getPostsByPostContent():void{
		this.postService.getPostsByPostContent(this.postContent)
			.subscribe(posts => {this.posts = posts});
	}

	getPostsByPostOffer(): void{
		this.postService.getPostsByPostOffer(this.postOffer)
			.subscribe(posts => {this.posts = posts});
	}

	getPostsByPostRequest(): void{
		this.postService.getPostsByPostRequest(this.postRequest)
			.subscribe(posts => {this.posts = posts});
	}

	getPostsByPostTimestamp(): void{
		this.postService.getPostsByPostTimestamp(this.postTimestamp)
			.subscribe(posts => {this.posts = posts});
	}


}