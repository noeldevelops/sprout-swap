import {RouterModule, Routes} from "@angular/router";
import {SignUpComponent} from "./component/signup.component";
import {ProfileComponent} from "./component/profile.component";
import {MessageComponent} from "./component/message.component";
import {NewPostComponent} from "./component/newpost.component";
import {SignInComponent} from "./component/signin.component";
import {SideNavComponent} from "./component/sidenav.component";

import {NewMessageComponent} from "./component/newmessage.component";
import {PostComponent} from "./component/post.component";
import {HomeComponent} from "./component/home.component";
import {ActivationComponent} from "./component/activation.component";


export const allAppComponents = [SignUpComponent, ProfileComponent, MessageComponent, PostComponent, NewPostComponent, SignInComponent, SideNavComponent, NewMessageComponent, HomeComponent, ActivationComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "profile", component: ProfileComponent},
	{path: "message", component: MessageComponent},
	{path: "post", component: PostComponent},
	{path: "activation/:activation", component: ActivationComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);