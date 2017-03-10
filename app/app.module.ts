import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {SignInService} from "./service/signin-service";
import {SignUpService} from "./service/signup-service";

const moduleDeclarations = [AppComponent];


@NgModule({
	imports: [BrowserModule, FormsModule, HttpModule, routing],
	//tells angular which componenents/ must declare every component, directive, and pipe
	declarations: [...allAppComponents],
	bootstrap: [AppComponent],
	providers: [appRoutingProviders, SignInService, SignUpService]
})

export class AppModule {}