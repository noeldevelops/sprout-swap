import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {MessageService} from "../service/message-service";
import {Observable} from "rxjs/Observable"
import {Message} from "../class/message-class";
import {Profile} from "../class/profile-class";
import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/newmessage-template.php",
	selector: 'new-message'
})

export class NewMessageComponent implements OnInit{
	// senderId: number =
	status: Status = null;
	newMessage: Message = new Message(0, 0, 0, 0, "", 0, 0);
	constructor(private MessageService: MessageService, private router: Router)
	{}
ngOnInit() : void {}

createMessage() : void {
		this.MessageService.createMessage(this.newMessage)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate(['']);
				}
			});
	}
}