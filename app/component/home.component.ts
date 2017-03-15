import{Component, OnInit, Input} from "@angular/core";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {ActivatedRoute} from "@angular/router";
import {Status} from "../class/status";


@Component({
	templateUrl: "./templates/home-template.php"
})

export class HomeComponent implements OnInit {
	@Input() posts: Post[] = [];
	post: Post = new Post(0, 0, 0, "", null, "", "", 0);
	status: Status = new Status(null, null, null);
	constructor(private postService: PostService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getAlmostAllPosts();
	}

	getAlmostAllPosts(): void {
		this.postService.getPostsByPostProfileId(1)
			.subscribe(posts => {
				this.posts = posts
			});
	}
}