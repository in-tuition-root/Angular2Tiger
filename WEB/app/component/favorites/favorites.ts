/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy} from '@angular/core';

@Component({
    selector: 'in-tuition-favorites',
    styleUrls: ['app/components/favorites.css'],
    templateUrl:'app/components/favorites.html',
    directives: [],
    providers: []
})

export class FavoritesComponent implements OnInit, OnDestroy{

    constructor(){

    }

    ngOnInit() {
        console.log('ngOnInit');
    }
    ngOnDestroy() {
        console.log('ngOnDestroy');
    }
}