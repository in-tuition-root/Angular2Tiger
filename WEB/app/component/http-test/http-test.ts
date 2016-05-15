/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy,ViewEncapsulation,Input, Pipe, PipeTransform} from '@angular/core';
import {GetClassesService} from "../../service/GetClassesService";
import {InTuitionCarousel} from "../carousel/carousel";

@Component({
    selector: 'in-tuition-http-test',
    styleUrls: ['app/component/http-test/http-test.css'],
    templateUrl:'app/component/http-test/http-test.html',
    directives: [InTuitionCarousel],
    providers: [GetClassesService],
    encapsulation: ViewEncapsulation.None
})

export class HttpTestComponent implements OnInit, OnDestroy{

    response: string;
    constructor(private _getClassesService: GetClassesService) {}

    ngOnInit() {
        this._getClassesService.getClasses()
            .subscribe(
                response => this.response = response.data.result,
                error => console.log(error)
            )
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}