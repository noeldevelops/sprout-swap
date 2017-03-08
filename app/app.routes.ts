import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./component/home-component";
import {SignUpComponent} from "./component/signup-component";
import {ChatComponent} from "./component/chat-component";


export const allAppComponents = [ChatComponent, HomeComponent, SignUpComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "signup", component: SignUpComponent},
	{path: "chat", component: ChatComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);