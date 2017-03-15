import{Component, OnInit} from "@angular/core";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {ActivatedRoute} from "@angular/router";



@Component({
	templateUrl: "./templates/home-template.php"
})

export class HomeComponent implements OnInit {
	posts: Post[] = [];
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
}