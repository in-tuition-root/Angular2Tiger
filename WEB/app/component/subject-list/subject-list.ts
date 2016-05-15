/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy,ViewEncapsulation,Input, Pipe, PipeTransform} from '@angular/core';
import {GetClassesService} from "../../service/GetClassesService";

@Component({
    selector: 'in-tuition-subject-list',
    styleUrls: ['app/component/subject-list/subject-list.css'],
    templateUrl:'app/component/subject-list/subject-list.html',
    directives: [],
    providers: [GetClassesService],
    encapsulation: ViewEncapsulation.None
})

export class SubjectListComponent implements OnInit, OnDestroy{

    response: string;
    constructor(private _getClassesService: GetClassesService) {}

    ngOnInit() {
        this._getClassesService.getClasses()
            .subscribe(
                response => this.response = response,
                error => console.log(error)
            )
    }
    ngOnDestroy() {
        console.log('ngOnDestroy: SubjectListComponent');
    }
}