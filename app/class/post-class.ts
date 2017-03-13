import {Point} from "./point-class";

export class Post {
	constructor (
		public id: number,
		public postModeId: number,
		public postProfileId: number,
		public postImageId:number,
		public postContent: string,
		public postLocation: Point[],
		public postOffer: string,
		public postRequest: string,
		public postTimestamp: number
	){
	}
}