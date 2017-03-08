import DateTimeFormat = Intl.DateTimeFormat;

export class Message{
	constructor(
		public messageId: number,
		public messagePostId: number,
		public messageReceiverProfileId: number,
		public messageSenderId: number,
		public messageContent: string,
		public messageStatus: number,
		public messageTimestamp: number
	)
	{

	}
}