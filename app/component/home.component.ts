import{Component, OnInit, Input} from "@angular/core";
import {PostService} from "../service/post-service";
import {Post} from "../class/post-class";
import {ActivatedRoute} from "@angular/router";
import {Status} from "../class/status";
import {ImageService} from "../service/image-service";
import {ModeService} from "../service/mode-service";
import {Mode} from "../class/mode-class";


@Component({
	templateUrl: "./templates/home-template.php"
})

export class HomeComponent implements OnInit {
	@Input() posts: Post[] = [];
	imageMap : any = {};
	modes : Mode[] = [];
	post: Post = new Post(0, 0, 0, "", null, "", "", 0);
	status: Status = new Status(null, null, null);
	constructor(private imageService: ImageService, private modeService: ModeService, private postService: PostService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getAlmostAllPosts();
		this.setImageIsEverything();
		this.getAllModes();
	}

	getAlmostAllPosts(): void {
		this.postService.getPostsByPostProfileId(53)
			.subscribe(posts => {
				this.posts = posts
			});
	}

	getAllModes() : void {
		this.modeService.getAllModes()
			.subscribe(modes => this.modes = modes);
	}

	getModeNameFromArray(modeId : number) {
		return(this.modes.filter(mode => mode.modeId === modeId)[0].modeName);
	}

	setImageIsEverything() : void {
		this.imageService.getImageByProfileId(53)
			.subscribe(imageMap => this.imageMap = imageMap);
	}
}