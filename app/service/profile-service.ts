import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import {Image} from "../class/image-class";
import {Profile} from "../class/profile-class";


@Injectable ()
export class ProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileUrl = "api/profile/";

	deleteProfile(id: number) : Observable<Status> {
		return(this.http.delete(this.profileUrl + id)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	createProfile(profile: Profile) : Observable<Status> {
		return(this.http.post(this.profileUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put(this.profileUrl + profile.id, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getProfile(id: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getProfileByProfileImageId(profileImageId: number) : Observable<Profile[]> {
		return(this.http.get(this.profileUrl + profileImageId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getProfileByProfileEmail(profileEmail: string) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileEmail)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getProfileByProfileHandle(profileHandle: string) :Observable<Profile> {
		return(this.http.get(this.profileUrl + profileHandle)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getProfileByProfileName(profileName: string) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileName)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getProfileByProfileSummary(profileSummary: string) : Observable<Profile[]> {
		return(this.http.get(this.profileUrl + profileSummary)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getAllProfiles(profile:Profile) : Observable<Profile[]> {
		return(this.http.get(this.profileUrl, profile)
			.map(this.extractData)
			.catch(this.handleError));
	}
}