import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./component/home-component";
import {SignUpComponent} from "./component/signup-component";
import {ProfileComponent} from "./component/profile.component";
import {MessageComponent} from "./component/message.component";
import {PostComponent} from "./component/newpost.component";


export const allAppComponents = [HomeComponent, SignUpComponent, ProfileComponent, MessageComponent, PostComponent, NotFoundComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "profile", component: ProfileComponent},
	{path: "message", component: MessageComponent},
	{path: "post", component: PostComponent},
	{path: "**", component: NotFoundComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);