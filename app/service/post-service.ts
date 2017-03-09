import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Post} from "../class/post-class";
import {Status} from "../class/status";
import DateTimeFormat = Intl.DateTimeFormat;

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postUrl = "api/post/";

	deletePost(postId: number) : Observable<Status> {
		return(this.http.delete(this.postUrl + postId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	createPost(post: Post) : Observable<Status> {
		return(this.http.post(this.postUrl, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editPost(post: Post) : Observable<Status> {
		return(this.http.put(this.postUrl + post.postId, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getPostsByPostLocation(postLocation: any) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postLocation)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPost(postId: number) : Observable<Post> {
		return(this.http.get(this.postUrl + postId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostModeId(postModeId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postModeId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getPostsByPostProfileId(postProfileId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postProfileId)
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
	getPostsByPostTimestamp(postTimestamp: DateTimeFormat) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postTimestamp)
			.map(this.extractData)
			.catch(this.handleError));
	}
}