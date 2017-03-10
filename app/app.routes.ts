import {RouterModule, Routes} from "@angular/router";
import {SignUpComponent} from "./component/signup.component";
import {ProfileComponent} from "./component/profile.component";
import {MessageComponent} from "./component/message.component";
import {PostComponent} from "./component/newpost.component";


export const allAppComponents = [SignUpComponent, ProfileComponent, MessageComponent, PostComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "profile", component: ProfileComponent},
	{path: "message", component: MessageComponent},
	{path: "post", component: PostComponent},
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);