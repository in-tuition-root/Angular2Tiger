/**
 * Created by praghav on 5/14/2016.
 */
import {Component,OnInit, OnDestroy} from '@angular/core';

@Component({
    selector: 'in-tuition-start',
    styleUrls: ['app/component/start/start.css'],
    templateUrl:'app/component/start/start.html',
    directives: [],
    providers: []
})

export class StartComponent implements OnInit, OnDestroy{

    constructor(){}

    ngOnInit() {
        console.log('ngOnInit');
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}