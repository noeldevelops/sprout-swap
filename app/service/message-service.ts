import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../class/status";
import DateTimeFormat = Intl.DateTimeFormat;
import {Message} from "../class/message-class";
import {Profile} from "../class/profile-class";

@Injectable()
export class MessageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private messageUrl = "api/message/";

	createMessage(message: Message): Observable<Status> {
		return (this.http.post(this.messageUrl, message)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editMessage(message: Message): Observable<Status> {
		return (this.http.put(this.messageUrl + message.messageId, message)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getMessage(messageId: number): Observable<Message> {
		return (this.http.get(this.messageUrl + messageId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByMessageReceiverProfileId(messageReceiverProfileId: number): Observable<Message[]> {
		return (this.http.get(this.messageUrl + messageReceiverProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByMessageSenderProfileId(messageSenderProfileId: number): Observable<Message[]> {
		return (this.http.get(this.messageUrl + messageSenderProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessagesByMessagePostId(messagePostId: number): Observable<Message[]> {
		return (this.http.get(this.messageUrl + messagePostId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMessageByMessageContent(messageContent: string): Observable<Message[]> {
		return (this.http.get(this.messageUrl + messageContent)
			.map(this.extractData)
			.catch(this.handleError));
	}
}