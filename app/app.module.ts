import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {SigninService} from "./services/login-service";
import {SignUpService} from "./services/signup-service";
import {MessageComponent} from "./component/message.component";
import {NewMessageComponent} from "./component/newmessage.component";
import {SideNavComponent} from "./component/sidenav.component";


const moduleDeclarations = [AppComponent];


@NgModule({
	imports: [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [AppComponent, MessageComponent, NewMessageComponent, PostComponent, NewPostComponent, SideNavComponent, SignInComponent, SignUpComponent],
	bootstrap: [AppComponent],
	providers: [appRoutingProviders, SigninService, SignUpService]
})

export class AppModule {}