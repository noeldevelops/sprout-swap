import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {SignInService} from "./service/signin-service";
import {SignUpService} from "./service/signup-service";
import {ProfileService} from "./service/profile-service";
import {PostService} from "./service/post-service";
import {ModeService} from "./service/mode-service";
import {ImageService} from "./service/image-service";
import {BaseService} from "./service/base-service";
import {MessageService} from "./service/message-service";
import {SignOutService} from "./service/signout-service";

const moduleDeclarations = [AppComponent];


@NgModule({
	imports: [BrowserModule, FormsModule, HttpModule, routing],
	//tells angular which components/ must declare every component, directive, and pipe
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap: [AppComponent],
	providers: [appRoutingProviders, SignInService, SignUpService, SignOutService, ProfileService, PostService, ModeService, ImageService, MessageService]
})

export class AppModule {}