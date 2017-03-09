import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import {Profile} from "../class/profile-class";
import {Signup} from "../class/signup-class";

@Injectable()
export class SignupService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signupUrl = "api/signup/";

	postSignup(profile:Profile) : Observable<Status> {
		return(this.http.post(this.signupUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}