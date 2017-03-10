import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {MessageService} from "../service/message-service";

import {Observable} from "rxjs/Observable"
import {Message} from "../class/message-class";

import {Status} from "../class/status";

@Component({
	templateUrl: "./templates/message-template.php"
})

export class MessageComponent {
	status: Status = null;
	message: Message = new Message(0, 0, 0, 0, "", 0, 0);
	constructor(

	)
	{
	}

}