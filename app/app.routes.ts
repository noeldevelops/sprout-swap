import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./component/home-component";
import {SignUpComponent} from "./component/signup-component";
import {ProfileComponent} from "./component/profile.component";


export const allAppComponents = [HomeComponent, SignUpComponent, ProfileComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "profile", component: ProfileComponent},
	{path: "message", component: MessageComponent},
	{path: "post", component: PostComponent},
	{path: "**", component: NotFound}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);