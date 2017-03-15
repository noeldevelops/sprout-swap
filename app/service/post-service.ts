import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Post} from "../class/post-class";
import {Status} from "../class/status";
import {PostImage} from "../class/postImage-class";

import DateTimeFormat = Intl.DateTimeFormat;

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postUrl = "api/post/";

	deletePost(id: number) : Observable<Status> {
		return(this.http.delete(this.postUrl + id)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	createPost(post: Post) : Observable<any> {
		return(this.http.post(this.postUrl, post)
			.map(this.extractTomWu)
			.catch(this.handleError));
	}

	editPost(post: Post) : Observable<Status> {
		return(this.http.put(this.postUrl + post.id, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getPostsByPostLocation(postLocation: any) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postLocation)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPost(id: number) : Observable<Post> {
		return(this.http.get(this.postUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostModeId(postModeId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + "?postModeId=" + postModeId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getPostsByPostProfileId(postProfileId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + "?postProfileId=" + postProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostContent(postContent: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postContent)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostOffer(postOffer: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postOffer)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostRequest(postRequest: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postRequest)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getPostsByPostTimestamp(postTimestamp: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postTimestamp)
			.map(this.extractData)
			.catch(this.handleError));
	}

	insertPostImage(postImage: PostImage) : Observable<any> {
		return(this.http.post(this.postUrl, postImage)
			.map(this.extractTomWu)
			.catch(this.handleError));
	}
}