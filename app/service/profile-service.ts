import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Profile} from "../class/profile-class";
import {Status} from "../class/status";

@Injectable ()
export class ProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileUrl = "api/profile/";
}