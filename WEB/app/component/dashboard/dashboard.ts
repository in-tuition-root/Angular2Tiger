/**
 * Created by praghav on 5/14/2016.
 */

import {Component,OnInit, OnDestroy} from '@angular/core';
import { Routes, Router, ROUTER_DIRECTIVES } from '@angular/router';
import {InTuitionCarousel} from "../carousel/carousel";
import {SubjectListComponent} from "../subject-list/subject-list";

@Component({
    selector: 'in-tuition-dashboard',
    styleUrls: ['app/component/dashboard/dashboard.css'],
    templateUrl:'app/component/dashboard/dashboard.html',
    directives: [ROUTER_DIRECTIVES,InTuitionCarousel,SubjectListComponent],
    providers: []
})

export class DashboardComponent{


}
