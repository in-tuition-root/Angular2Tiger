/**
 * Created by praghav on 5/14/2016.
 */

import { Injectable, EventEmitter } from '@angular/core';
import { Http, Headers } from '@angular/http';
import {User} from "../interface/userInterface";

@Injectable()

export class AuthService{

    private _userLoggedOut = new EventEmitter<any>();

    signupUser(user: User) {

    }

    signinUser(user: User) {
        
    }

    logout() {
        localStorage.removeItem('token');
        this._userLoggedOut.emit(null);
    }

    getLoggedOutEvent(): EventEmitter<any> {
        return this._userLoggedOut;
    }

    isAuthenticated(): boolean {
        return localStorage.getItem('token') !== null;
    }

}