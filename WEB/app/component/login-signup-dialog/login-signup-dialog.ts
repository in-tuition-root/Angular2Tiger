/**
 * Created by nejindal on 5/13/2016.
 */
import {Component, OnInit, ViewChild} from '@angular/core';
import {Http, HTTP_PROVIDERS} from '@angular/http';
import LoginComponent from "../login/login";
import {SignUpComponent} from "../signup/signup";


@Component({
    selector: 'login-signup-dialog',
    styleUrls: ['app/component/login-signup-dialog/login-signup-dialog.css'],
    templateUrl:'app/component/login-signup-dialog/login-signup-dialog.html',
    directives: [LoginComponent,SignUpComponent],
    viewProviders: [HTTP_PROVIDERS]
})

export class LoginSignUpComponent  implements OnInit{
    isLogin:boolean;
    tabIndex:number;
    constructor (){
        this.tabIndex = 0;
    }

    @ViewChild(SignUpComponent) signupComponent: SignUpComponent
    onLogin(){
        this.isLogin = true;
        this.tabIndex =  0;
    }

    onSignup(){
        this.isLogin = false;
        this.tabIndex =  1;
    }
    
    ngOnInit() {
        this.isLogin = true;
    }
}

