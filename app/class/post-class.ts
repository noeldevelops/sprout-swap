
export class Post {
	constructor (
		public postId: number,
		public postModeId: number,
		public postProfileId: number,
		public postContent: string,
		public postLocation: Point[],
		public postOffer: string,
		public postRequest: string,
		public postSummary: string,
		public postTimestamp: number
	){

	}
}