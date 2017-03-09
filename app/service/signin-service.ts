import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import {SignIn} from "../class/signin-class";

@Injectable()
export class SignInService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signInUrl = "api/signin/";

	postSignIn(signIn:SignIn) : Observable<Status> {
	return(this.http.post(this.signInUrl, signIn)
		.map(this.extractMessage)
		.catch(this.handleError));
	}
}