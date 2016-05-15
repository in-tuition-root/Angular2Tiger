/**
 * Created by praghav on 5/14/2016.
 */


import {Component,OnInit, OnDestroy} from '@angular/core';
import {ROUTER_PROVIDERS} from '@angular/router-deprecated';
import {RouteConfig} from '@angular/router-deprecated';

@Component({
    selector: 'in-tuition-home',
    styleUrls: ['app/components/home.css'],
    templateUrl:'app/components/home.html',
    directives: [],
    providers: [ROUTER_PROVIDERS]
})

export class HomeComponent implements OnInit, OnDestroy{

    constructor(){

    }

    ngOnInit() {
        console.log('ngOnInit');
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}