/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy} from '@angular/core';

@Component({
    selector: 'in-tuition-contact',
    styleUrls: ['app/component/contact/contact.css'],
    templateUrl:'app/component/contact/contact.html',
    directives: [],
    providers: []
})

export class ContactComponent implements OnInit, OnDestroy{

    constructor(){

    }

    ngOnInit() {
        console.log('ngOnInit');
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}