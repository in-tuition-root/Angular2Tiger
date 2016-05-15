/**
 * Created by praghav on 5/14/2016.
 */

import { Component, OnInit } from '@angular/core';
import { Routes, Router, ROUTER_DIRECTIVES } from '@angular/router';
import 'rxjs/add/operator/map';

import {AuthService} from "./service/AuthenticationService";
import {InTuitionCarousel} from "./component/carousel/carousel";
import {ContactComponent} from "./component/contact/contact";
import {AboutComponent} from "./component/about/about";
import {DashboardComponent} from "./component/dashboard/dashboard";
import SignUpSettingsComponent from "./component/signup-settings/signup-settings";
import {SignUpComponent} from "./component/signup/signup";
import {SignInComponent} from "./component/signin/signin";

@Component({
    selector: 'my-app',
    styleUrls: ['app/app.component.css'],
    templateUrl:'app/app.component.html',
    directives: [ROUTER_DIRECTIVES,SignUpSettingsComponent,InTuitionCarousel,DashboardComponent],
    providers: [],
    pipes: []
})

@Routes([
    { path: '/',  component: DashboardComponent},
    { path: '/About', component: AboutComponent},
    { path: '/Contact', component: ContactComponent}
])


export class AppComponent implements OnInit{

    constructor(private _router: Router, private _authService: AuthService) {}

    ngOnInit():any {
        this._authService.getLoggedOutEvent().subscribe(() => this._router.navigate(['/']));
    }
}