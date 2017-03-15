import{Component, OnInit, Input} from "@angular/core";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {ActivatedRoute} from "@angular/router";
import {Status} from "../class/status";
import {ImageService} from "../service/image-service";


@Component({
	templateUrl: "./templates/home-template.php"
})

export class HomeComponent implements OnInit {
	@Input() posts: Post[] = [];
	imageMap : any = {};
	post: Post = new Post(0, 0, 0, "", null, "", "", 0);
	status: Status = new Status(null, null, null);
	constructor(private imageService: ImageService, private postService: PostService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getAlmostAllPosts();
		this.setImageIsEverything();
	}

	getAlmostAllPosts(): void {
		this.postService.getPostsByPostProfileId(53)
			.subscribe(posts => {
				this.posts = posts
			});
	}

	setImageIsEverything() : void {
		this.imageService.getImageByProfileId(53)
			.subscribe(imageMap => this.imageMap = imageMap);
	}
}