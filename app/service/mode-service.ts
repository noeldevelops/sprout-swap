import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";

@Injectable()
export class ModeService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private modeUrl = "api/mode/";

	getModeByModeId(modeId: number) : Observable<Status> {
		return(this.http.get(this.modeUrl + modeId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getModeByModeName(modeName: string) : Observable<Status> {
		return(this.http.get(this.modeUrl + "?modeName=" + modeName)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllModes() : Observable<Status> {
		return(this.http.get(this.modeUrl)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}