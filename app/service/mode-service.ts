import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import {Mode} from "../class/mode-class";

@Injectable()
export class ModeService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private modeUrl = "api/mode/";

	getModeByModeId(modeId: number) : Observable<Mode> {
		return(this.http.get(this.modeUrl + modeId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getModeByModeName(modeName: string) : Observable<Status> {
		return(this.http.get(this.modeUrl + "?modeName=" + modeName)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllModes() : Observable<Mode[]> {
		return(this.http.get(this.modeUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}