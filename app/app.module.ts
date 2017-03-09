import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {SigninService} from "./services/login-service";
import {SignUpService} from "./services/signup-service";


const moduleDeclarations = [AppComponent];


@NgModule({
	imports: [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap: [AppComponent],
	providers: [appRoutingProviders, SigninService, SignUpService]
})

export class AppModule {}