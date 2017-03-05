import DateTimeFormat = Intl.DateTimeFormat;

export class Post {
	constructor (
		public postId: number,
		public postModeId: number,
		public postProfileId: number,
		public postBrowser: string,
		public postContent: string,
		public postIpAddress: string,
		public postLocation: any,
		public postOffer: string,
		public postRequest: string,
		public postSummary: string,
		public postTimestamp: DateTimeFormat
	){

	}
}