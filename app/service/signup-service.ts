import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import {Profile} from "../class/profile-class";

@Injectable()
export class SignUpService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signUpUrl = "api/signup/";

	postSignup(profile:Profile) : Observable<Status> {
		return(this.http.post(this.signUpUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}