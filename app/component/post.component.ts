import{Component, OnInit, Input} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {PostService} from "../service/post-service";

import {Observable} from "rxjs/Observable"
import {Post} from "../class/post-class";

import {Profile} from "../class/profile-class";
import {Mode} from "../class/mode-class";
import {Image} from "../class/image-class";
import {Point} from "../class/point-class";

import {Status} from "../class/status";

@Component({
	selector: 'post',
	templateUrl: "./templates/post-template.php"
})

export class PostComponent implements OnInit{
	@Input() postInfo : Post;
	allPosts: Post[] = [];
	status: Status = null;
	post: Post = new Post(0, 0, 0, 0, "", [], "", "","", 0);
	constructor(private postService: PostService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.getPost();
	}

	getPost(): void {
		this.route.params
			.switchMap((params: Params) => this.postService.getPost(+params["id"]))
			.subscribe(reply => this.post = reply);
	}
}