import {Component, OnInit} from '@angular/core';
import { FileUploader } from 'ng2-file-upload';
import {Cookie} from "ng2-cookies";
import {Observable} from "rxjs";


// const URL = '/api/';
const URL = './api/image/';

@Component({
	selector: 'file-upload',
	templateUrl: './templates/file-upload-template.php'
})
export class FileUploadComponent implements OnInit {
	public uploader: FileUploader = new FileUploader({url: URL, headers: [{name: "X-XSRF-TOKEN", value: Cookie.get("XSRF-TOKEN")}]});
	public hasBaseDropZoneOver:boolean = false;
	public hasAnotherDropZoneOver:boolean = false;
	public imageId: number = null;
	public imageIdObservable: Observable<number> = Observable.if(() => this.imageId !== null, Observable.response(this.imageId));


	public fileOverBase(e:any):void {
		this.hasBaseDropZoneOver = e;
	}

	public fileOverAnother(e:any):void {
		this.hasAnotherDropZoneOver = e;
	}
	ngOnInit () : void {
		this.uploader.onSuccessItem = (item:any, response:string, status:number, headers:any)=>{
			let reply = JSON.parse(response);
			this.imageId = reply.data;
			console.log("Daniel couldn't prevent our success: " + this.imageId);
		};
	}
}