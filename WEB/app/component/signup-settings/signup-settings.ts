/**
 * Created by nejindal on 5/14/2016.
 */
import { Component, OnInit } from '@angular/core';
import { Routes, Router, ROUTER_DIRECTIVES } from '@angular/router';
import 'rxjs/add/operator/map';

import {SignUpComponent} from "../signup/signup";
import {SignInComponent} from "../signin/signin";


@Component({
    selector: 'in-tuition-signup-settings',
    styleUrls: ['app/component/signup-settings/signup-settings.css'],
    templateUrl:'app/component/signup-settings/signup-settings.html',
    directives: [ROUTER_DIRECTIVES,SignInComponent,SignUpComponent],
    providers: []
})


@Routes([
    { path: '/LogIn', component: SignInComponent},
    { path: '/SignUp', component: SignUpComponent},
])

export default class SignUpSettingsComponent {

}

