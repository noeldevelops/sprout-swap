import {Component, ViewChild} from "@angular/core";
import {SignInComponent} from "./component/signin.component";
import {SignInService} from "./service/signin-service";


@Component({
	selector: 'sproutswap-app',
	// templateUrl path to your public_html/templates directory.
	templateUrl: './templates/sproutswap-app.php'
})

export class AppComponent {
	constructor(
		private SignInService: SignInService
	){}
	@ViewChild(SignInComponent)
		private SignInComponent: SignInComponent;
		isSignedIn = false;
}

