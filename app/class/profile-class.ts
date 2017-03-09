import {Image} from "./image-class";

export class Profile{
	constructor(
		public id: number,
		public profileImageId: number,
		public profileEmail: string,
		public profileHandle: string,
		public profileTimestamp: number,
		public profileName: string,
		public profilePassword: string,
		public profileConfirmPassword: string,
		public profileSummary: string
	){
	}
}