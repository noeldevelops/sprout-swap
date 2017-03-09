import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Image} from "../class/image-class";
import {Status} from "../class/status";

@Injectable()
export class ImageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private imageUrl = "api/image/";


	createImage(image: Image): Observable<Status> {
		return (this.http.post(this.imageUrl, image)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getImageByImageid(imageId: number): Observable<Image[]> {
		return (this.http.get(this.imageUrl + imageId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getImageByCloudinary(imageCloudinaryId: string): Observable<Image> {
		return (this.http.get(this.imageUrl + "?imageCloudinaryId=" + imageCloudinaryId)
			.map(this.extractData)
			.catch(this.handleError));
	}
}
