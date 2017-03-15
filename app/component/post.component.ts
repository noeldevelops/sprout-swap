import{Component, OnInit, Input} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {Status} from "../class/status";

@Component({
	selector: 'post',
	templateUrl: "./templates/post-template.php"
})

export class PostComponent implements OnInit{
	posts: Post[] = [];
	status: Status = null;
	post: Post = new Post(0, 0, 0, "", null, "", "", 0);
	constructor(private postService: PostService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.getAlmostAllPosts();
	}

	getAlmostAllPosts() : void {
		this.postService.getPostsByPostModeId (2)
			.subscribe(posts=>{this.posts = posts});
	}

	getPost(): void {
		this.route.params
			.switchMap((params: Params) => this.postService.getPost(+params["id"]))
			.subscribe(reply => this.post = reply);
	}
}