/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy} from '@angular/core';

@Component({
    selector: 'in-tuition-template',
    styleUrls: ['app/component/template/template.css'],
    templateUrl:'app/component/template/template.html',
    directives: [],
    providers: []
})

export class TemplateComponent implements OnInit, OnDestroy{

    constructor(){

    }

    ngOnInit() {
        console.log('ngOnInit');
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}