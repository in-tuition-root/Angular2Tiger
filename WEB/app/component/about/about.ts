/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy} from '@angular/core';

@Component({
    selector: 'in-tuition-about',
    styleUrls: ['app/component/about/about.css'],
    templateUrl:'app/component/about/about.html',
    directives: [],
    providers: []
})

export class AboutComponent implements OnInit, OnDestroy{

    constructor(){

    }

    ngOnInit() {
        console.log('ngOnInit');
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}