import {Component, OnInit} from '@angular/core';
import { FileUploader } from 'ng2-file-upload';

// const URL = '/api/';
const URL = './api/image/';

@Component({
	// selector: 'file-upload',
	templateUrl: './templates/file-upload-template.php'
})
export class FileUploadComponent implements OnInit {
	public uploader:FileUploader = new FileUploader({url: URL});
	public hasBaseDropZoneOver:boolean = false;
	public hasAnotherDropZoneOver:boolean = false;

	public fileOverBase(e:any):void {
		this.hasBaseDropZoneOver = e;
	}

	public fileOverAnother(e:any):void {
		this.hasAnotherDropZoneOver = e;
	}
	ngOnInit () : void {
		this.uploader.onSuccessItem = (item:any, response:string, status:number, headers:any)=>{
			console.log("re-Hi All!");
			console.log(response);
		};
	}
}