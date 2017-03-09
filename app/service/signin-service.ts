import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import {Profile} from "../class/profile-class";
import {Signin} from "../class/signin-class";

@Injectable()
export class SigninService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signinUrl = "api/signin/";

	postSignin(profile:Profile) : Observable<Status> {
	return(this.http.post(this.signinUrl, profile)
		.map(this.extractMessage)
		.catch(this.handleError));
	}
}